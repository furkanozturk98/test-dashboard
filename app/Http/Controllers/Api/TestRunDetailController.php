<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestRunDetailResource;
use App\Models\TestRun;
use App\Repositories\TestRunDetailRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TestRunDetailController extends Controller
{
    private TestRunDetailRepository $testRunDetailRepository;

    public function __construct(TestRunDetailRepository $testRunDetailRepository)
    {
        $this->testRunDetailRepository = $testRunDetailRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param TestRun $testRun
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request, TestRun $testRun)
    {
        $data = $this->testRunDetailRepository->getPaginatedData($request, $testRun);

        return TestRunDetailResource::collection($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $Id
     *
     * @return JsonResponse
     */
    public function getTestCountsByDuration(string $Id)
    {
        $data = $this->testRunDetailRepository->getTestCountsByDuration($Id);

        return response()->json([
            'data' => $data,
        ]);
    }
}
