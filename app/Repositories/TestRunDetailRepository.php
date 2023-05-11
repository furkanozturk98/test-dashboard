<?php

namespace App\Repositories;

use App\Models\TestRun;
use App\Models\TestRunDetail;
use App\TestStatus;
use Illuminate\Http\Request;

class TestRunDetailRepository
{
    /**
     * @param Request $attributes
     * @param TestRun $testRun
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedData(Request $attributes, TestRun $testRun)
    {
        $columns = ['status', 'file', 'method', 'time'];

        $sortValue = $attributes->input('sort');

        $sortColumn    = in_array($sortValue, $columns) ? $sortValue : 'time';
        $sortDirection = $attributes->input('dir', 'DESC') === 'DESC' ? 'DESC' : 'ASC';

        return $testRun->details()
            ->orderBy($sortColumn, $sortDirection)
            ->paginate($attributes->input('per_page'));
    }

    /**
     * @param int $testRunId
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getDetails(int $testRunId)
    {
        return cache()->rememberForever(
            'testrun:' . $testRunId,
            fn() => TestRunDetail::query()
                ->where('test_run_id', $testRunId)
                ->get()
        );
    }

    /**
     * @param int $Id
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getStatus(int $Id)
    {
        $testRunDetails = $this->getDetails($Id);

        $data = $testRunDetails->groupBy('status')
            ->map(function($item) {
                return count($item);
            });

        return [
            'success' => $data[TestStatus::SUCCESS] ?? 0,
            'fail'    => $data[TestStatus::FAILURE] ?? 0,
            'error'   => $data[TestStatus::ERROR] ?? 0,
        ];
    }

    /**
     * @param string $Id
     *
     * @return array
     */
    public function getTestCountsByDuration(string $Id)
    {
        $data = [
            '0-100'   => 0,
            '100-200' => 0,
            '200-300' => 0,
            '300-500' => 0,
            '> 500'   => 0,
        ];

        /** @var array $durations */
        $durations = TestRunDetail::query()->where('test_run_id', $Id)->pluck('time');

        foreach ($durations as $duration) {
            $key = $this->calculateIndex((int)$duration);
            $data[$key]++;
        }

        return $data;
    }

    /**
     * @param int $time
     *
     * @return string
     */
    private function calculateIndex(int $time)
    {
        if ($time <= 100) {
            return '0-100';
        }

        if ($time <= 200) {
            return '100-200';
        }

        if ($time <= 300) {
            return '200-300';
        }

        if ($time <= 500) {
            return '300-500';
        }

        return '> 500';
    }
}
