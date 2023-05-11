<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestRunFormRequest;
use App\Http\Resources\TestRunResource;
use App\Models\TestRun;
use App\Repositories\TestRunRepository;
use Illuminate\Http\Request;

class TestRunController extends Controller
{
    private TestRunRepository $testRunRepository;

    public function __construct(TestRunRepository $testRunRepository)
    {
        $this->testRunRepository = $testRunRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Exception
     */
    public function index()
    {
        $data = $this->testRunRepository->getPaginatedData(request('page'));

        return TestRunResource::collection($data);
    }

    /**
     * @param TestRun $testRun
     *
     * @return TestRunResource
     */
    public function show(TestRun $testRun)
    {
        return new TestRunResource($testRun);
    }

    /**
     * @param TestRunFormRequest $request
     *
     * @return TestRunResource
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(TestRunFormRequest $request)
    {
        $testRun = $this->testRunRepository->create($request);

        return new TestRunResource($testRun);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function getStatuses(Request $request)
    {
        $statuses = $this->testRunRepository->getStatuses($request);

        return response()->json([
            'data' => $statuses,
        ]);
    }
}
