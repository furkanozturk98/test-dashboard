<?php

namespace App\Repositories;

use App\Models\TestRunDetail;

class DashboardRepository
{
    /**
     * @return array
     *
     * @throws \Exception
     */
    public function history()
    {
        $output = $this->generateOutputStructure();

        $testRunDetails = cache()->remember('history:' . now()->subWeek()->format('Y-m-d'), now()->addMonth(), function() {
            return TestRunDetail::query()
                ->selectRaw('date_format(created_at,"%Y-%m-%d") date, count(status) as status')
                ->where('created_at', '>=', now()->subWeek()->format('Y-m-d') . ' 00:00:00')
                ->groupBy('status')
                ->groupBy('date')
                ->get();
        });

        $items = $testRunDetails->groupBy('date')->toArray();

        foreach ($items as $item) {
            if (isset($item[0]['date'])) {
                $output[$item[0]['date']] = [
                    'success' => (int)$item[0]['status'] ?? 0,
                    'fail'    => isset($item[1]['status']) ? (int)$item[1]['status'] : 0,
                    'error'   => isset($item[2]['status']) ? (int)$item[2]['status'] : 0,
                ];
            }
        }

        return $output;
    }

    public function generateOutputStructure(): array
    {
        $startDate = now()->subWeek();
        $endDate   = now();

        $dates = [];

        while ($startDate <= $endDate) {
            $dates[$startDate->format('Y-m-d')] = [
                'success' => 0,
                'fail'    => 0,
                'error'   => 0,
            ];
            $startDate->addDay();
        }

        return $dates;
    }
}
