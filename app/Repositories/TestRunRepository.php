<?php

namespace App\Repositories;

use App\Models\TestRun;
use App\Models\TestRunDetail;
use App\TestStatus;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleXMLElement;

class TestRunRepository
{
    /**
     * @param string $page
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \Exception
     */
    public function getPaginatedData($page = '1')
    {
        return cache()->remember('testRunsIndex:' . $page, now()->addMonth(), function() {
            return TestRun::query()->latest()->paginate(10);
        });
    }

    /**
     * @param Request $attributes
     *
     * @return TestRun
     *
     * @throws FileNotFoundException
     */
    public function create(Request $attributes)
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $attributes->file('file');

        $data = [
            'originalName' => $uploadedFile->getClientOriginalName(),
            'fileName'     => (string)$uploadedFile->store('test-runs'),
        ];

        $xml = $this->readFile($data['fileName']);

        return $this->save($attributes, $xml, $data);
    }

    /**
     * @param string $path
     *
     * @return SimpleXMLElement|false
     *r
     *
     * @throws FileNotFoundException
     */
    public function readFile(string $path)
    {
        $data = Storage::get($path);

        return simplexml_load_string($data);
    }

    /**
     * @param Request                $attributes
     * @param SimpleXMLElement|false $fileData
     * @param array                  $data
     *
     * @return TestRun
     *
     * @throws \Exception
     */
    public function save($attributes, $fileData, $data)
    {
        /** @var string $fileName */
        $fileName = str_replace(['junit-', '.xml'], '', $data['originalName']);

        $testRun = TestRun::query()->create([
            'title'      => $attributes->title ?? Carbon::createFromFormat('Ymd_His', $fileName),
            'created_by' => auth()->id(),
            'file'       => str_replace('test-runs/', '', $data['fileName']),
            'tests'      => isset($fileData->testsuite) ? $fileData->testsuite['tests'] : '',
            'assertions' => isset($fileData->testsuite) ? $fileData->testsuite['assertions'] : '',
            'time'       => isset($fileData->testsuite) ? number_format((float)$fileData->testsuite['time'], 2, '.', '') : '',
        ]);

        $testRunId = $testRun->id;

        $testCases = [];

        if (isset($fileData->testsuite)) {
            $now = now();

            $testSuites = Str::contains($fileData->testsuite->testsuite['name'], 'Browser')
                ? $fileData->testsuite->testsuite->testsuite
                : $fileData->testsuite->testsuite;

            foreach ($testSuites as $testSuite) {
                foreach ($testSuite as $testCase) {
                    $status = TestStatus::SUCCESS;

                    if ($testCase->failure) {
                        $status = TestStatus::FAILURE;
                    }

                    if ($testCase->error) {
                        $status = TestStatus::ERROR;
                    }

                    $time = $testCase['time'] * 1000;

                    $testCases[] = [
                        'test_run_id' => $testRunId,
                        'file'        => str_replace('/file', '', $testCase['file']),
                        'method'      => $testCase['name'],
                        'time'        => number_format((float)$time, 2, '.', ''),
                        'status'      => $status,
                        'created_at'  => $now,
                        'updated_at'  => $now,
                    ];
                }
            }
        }

        /** @var TestRunDetail[] $testCases */
        TestRunDetail::insert($testCases);

        cache()->forget('getStatuses');
        cache()->forget('testRunsIndex:1');
        cache()->forget('history:' . now()->subWeek()->format('Y-m-d'));


        return $testRun;
    }

    /**
     * @param Request $request
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getStatuses(Request $request)
    {
        $cacheName = 'getStatuses';
        if ($request->input('test_run_id')) {
            $cacheName .= $request->input('test_run_id');
        }
        if ($request->input('from')) {
            $cacheName .= $request->input('from') . $request->input('to');
        }
        $testRunDetails = cache()->remember($cacheName, now()->addMonth(), function() use ($request) {
            return TestRunDetail::query()
                ->when($request->input('test_run_id'), fn($query, $values) => $query->where('test_run_id', $values))
                ->when($request->filled('from') && $request->input('to'), fn($query) => $query->whereBetween('test_run_id', [$request->input('from'), $request->input('to')]))
                ->select(
                    'test_run_id',
                    DB::raw('COUNT(status) as status')
                )
                ->groupBy('test_run_id')
                ->groupBy('status')
                ->orderByRaw('MAX(created_at) desc')
                ->orderByRaw('status desc')
                ->get();
        });

        $grouped = $testRunDetails->groupBy('test_run_id')->toArray();

        $output = [];

        foreach ($grouped as $item) {
            $output[$item[0]['test_run_id']] = [
                'success' => (int)$item[0]['status'] ?? 0,
                'fail'    => isset($item[1]['status']) ? (int)$item[1]['status'] : 0,
                'error'   => isset($item[2]['status']) ? (int)$item[2]['status'] : 0,
            ];
        }

        return $output;
    }
}
