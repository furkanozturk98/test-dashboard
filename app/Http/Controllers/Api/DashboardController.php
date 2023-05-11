<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\DashboardRepository;

class DashboardController extends Controller
{
    protected DashboardRepository $dashboardRepository;

    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function history()
    {
        $data = $this->dashboardRepository->history();

        return response()->json([
            'data' => $data,
        ]);
    }
}
