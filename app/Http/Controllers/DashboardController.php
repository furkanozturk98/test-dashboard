<?php

namespace App\Http\Controllers;

use App\Models\TestRun;
use App\Repositories\TestRunDetailRepository;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private TestRunDetailRepository $testRunDetailRepository;

    public function __construct(TestRunDetailRepository $testRunDetailRepository)
    {
        $this->testRunDetailRepository = $testRunDetailRepository;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $testRunCount = TestRun::query()->count();

        return view('index', [
            'testRunCount' => $testRunCount,
        ]);
    }

    /**
     * @param TestRun $testRun
     *
     * @return View
     *
     * @throws \Exception
     */
    public function details(TestRun $testRun): View
    {
        $status = $this->testRunDetailRepository->getStatus($testRun->id);

        return view('details', [
            'status'  => $status,
            'testRun' => $testRun,
        ]);
    }

    /**
     * @return View
     */
    public function list(): View
    {
        return view('list');
    }
}
