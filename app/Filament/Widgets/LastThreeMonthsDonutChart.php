<?php

namespace App\Filament\Widgets;

use App\Models\Enregistrement;
use App\Models\Listening;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class LastThreeMonthsDonutChart extends ApexChartWidget
{
    protected static string $chartId = 'lastThreeMonthsLineChart';

    protected static ?string $heading = 'Activité durant les 3 derniers mois';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 1;

    protected function getOptions(): array
    {
        $recordsData = Enregistrement::query()
            ->whereMonth('created_at', '>', today()->subMonths(2))
            ->count();

        $listeningsData = Listening::query()
            ->whereMonth('created_at', '>', today()->subMonths(2))
            ->count();

        $visitsData = 260;

        return [
            'chart' => [
                'type' => 'donut',
                'height' => 300,
            ],
            'series' => [$recordsData, $listeningsData, $visitsData],
            'labels' => [
                'Total enregistrements',
                'Total lectures',
                'Total visites',
            ],
            'colors' => ['#132775', '#ED8223', '#2F2525'],
            'dataLabels' => [
                'style' => [
                    'fontSize' => '11px',
                    'fontWeight' => '500',
                ],
            ],
            'legend' => [
                'labels' => [
                    'colors' => '#464545FF',
                    'fontWeight' => 700,
                ],
                'position' => 'bottom'
            ],
        ];
    }
}
