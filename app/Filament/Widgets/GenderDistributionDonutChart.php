<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Illuminate\Support\Facades\DB;

class GenderDistributionDonutChart extends ApexChartWidget
{
    protected static ?string $chartId = 'genderDistributionDonutChart';
    protected static ?string $heading = 'Gender Distribution';
    protected static ?int $contentHeight = 400; // Fixed height for consistency

    protected function getOptions(): array
    {
        $results = DB::table('patient')
            ->whereNull('patient.deleted_at')
            ->selectRaw('COALESCE(patient.gender, "Unknown") as label, COUNT(*) as count')
            ->groupBy('patient.gender')
            ->get();

        // Convert to simple arrays that Livewire can handle
        $labels = $results->pluck('label')->map(fn($item) => $item ?? 'Unknown')->toArray();
        $series = $results->pluck('count')->toArray();

        if (empty($series)) {
            $labels = ['No Data'];
            $series = [0];
        }

        return [
            'chart' => [
                'type' => 'donut',
                'height' => 300,
                'toolbar' => ['show' => false],
            ],
            'series' => $series,
            'labels' => $labels,
            'colors' => ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
            'legend' => [
                'position' => 'bottom',
                'labels' => [
                    'colors' => '#6b7280',
                    'fontWeight' => 600,
                ],
            ],
            'plotOptions' => [
                'pie' => [
                    'donut' => [
                        'size' => '65%',
                        'labels' => [
                            'show' => true,
                            'total' => [
                                'show' => true,
                                'label' => 'Total',
                                'color' => '#6b7280',
                            ]
                        ]
                    ]
                ]
            ],
            'dataLabels' => [
                'enabled' => true,
                'style' => [
                    'colors' => ['#fff']
                ],
            ],
        ];
    }

    protected function getFooter(): ?string
    {
        $results = DB::table('patient')
            ->whereNull('patient.deleted_at')
            ->selectRaw('COALESCE(patient.gender, "Unknown") as label, COUNT(*) as count')
            ->groupBy('patient.gender')
            ->orderBy('count', 'desc')
            ->get();

        if ($results->isEmpty()) {
            $results = collect([(object)['label' => 'No Data', 'count' => 0]]);
        }

        $rows = $results->map(function ($item) {
            $label = $item->label ?? 'Unknown';
            return "<tr class='border-t border-gray-200 dark:border-gray-700'>
                    <td class='px-4 py-2 text-gray-600 dark:text-gray-300'>".htmlspecialchars($label)."</td>
                    <td class='px-4 py-2 text-right font-medium text-gray-900 dark:text-white'>".htmlspecialchars($item->count)."</td>
                </tr>";
        })->implode('');

        return <<<HTML
        <div class="mt-6 p-4 bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Gender</th>
                            <th class="px-4 py-2 text-right text-gray-600 dark:text-gray-300">Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        {$rows}
                    </tbody>
                </table>
            </div>
        </div>
        HTML;
    }
}