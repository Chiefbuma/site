<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Illuminate\Support\Facades\DB;

class TotalPatientsDonutChart extends ApexChartWidget
{
    protected static ?string $chartId = 'totalPatientsDonutChart';
    protected static ?string $heading = 'Total Patients';

    protected array $tableData = [];

    protected function getOptions(): array
    {
        $totalPatients = DB::table('patient')
            ->whereNull('patient.deleted_at')
            ->distinct('patient.patient_id')
            ->count('patient.patient_id');

        $series = [$totalPatients];
        $labels = ['Total Patients'];

        $this->tableData = [
            [
                'label' => 'Total Patients',
                'count' => $totalPatients,
            ]
        ];

        if ($totalPatients === 0) {
            $series = [0];
            $labels = ['No Data'];
            $this->tableData = [
                [
                    'label' => 'No Data',
                    'count' => 0,
                ]
            ];
        }

        return [
            'chart' => [
                'type' => 'donut',
                'height' => 300,
                'background' => '#18181b',
            ],
            'series' => $series,
            'labels' => $labels,
            'legend' => [
                'labels' => [
                    'colors' => ['#9ca3af'],
                    'fontWeight' => 600,
                ],
            ],
        ];
    }

    protected function getFooter(): ?string
    {
        $rows = '';
        foreach ($this->tableData as $row) {
            $rows .= '<tr style="border-top:1px solid #27272a;">
                        <td style="padding:0.5rem;">' . htmlspecialchars($row['label']) . '</td>
                        <td style="padding:0.5rem; text-align:right;">' . htmlspecialchars($row['count']) . '</td>
                      </tr>';
        }

        return <<<HTML
        <div style="background:#18181b; border-radius:1rem; padding:1.5rem; color:#fff; margin-top:1.5rem;">
            <table style="width:100%; border-collapse:collapse; color:#fff;">
                <thead>
                    <tr style="background:#27272a;">
                        <th style="text-align:left; padding:0.5rem;">Label</th>
                        <th style="text-align:right; padding:0.5rem;">Count</th>
                    </tr>
                </thead>
                <tbody>
                    {$rows}
                </tbody>
            </table>
        </div>
        HTML;
    }
}