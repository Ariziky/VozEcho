<?php

namespace App\Filament\Widgets;

use App\Models\Enregistrement;
use App\Models\Listening;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class LastThreeMonthsChart extends ApexChartWidget
{
    protected static string $chartId = 'lastThreeMonthsChart';

    protected static ?string $heading = 'Activité des 3 derniers mois';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 1;

    protected function getOptions(): array
    {
        $recordsData = Trend::model(Enregistrement::class)
            ->between(
                start: now()->subMonths(2),
                end: now(),
            )
            ->perMonth()
            ->count();

        $listeningsData = Trend::model(Listening::class)
            ->between(
                start: now()->subMonths(2),
                end: now(),
            )
            ->perMonth()
            ->count();

//        dd($listeningsData, $recordsData);

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Total enregistrements',
                    'data' => $recordsData->map(fn(TrendValue $value) => $value->aggregate),
                ],
                [
                    'name' => 'Total lectures',
                    'data' => $listeningsData->map(fn(TrendValue $value) => $value->aggregate),
                ],

            ],
            'xaxis' => [
                'categories' => $recordsData->map(fn(TrendValue $value) => Carbon::parse($value->date)->monthName),
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'colors' => ['#132775', '#ED8223'],
            'stroke' => [
                'show' => true,
                'width' => 2,
                'colors' => ['transparent'],
            ],
            'grid' => [
                'borderColor' => '#e7e7e7',
                'row' => [
                    'colors' => ['#f3f3f3', 'transparent'],
                    'opacity' => 0.5,
                ],
            ],
            'dropShadow' => [
                'enabled' => true,
                'color' => '#000',
                'top' => 18,
                'left' => 7,
                'blur' => 10,
                'opacity' => 0.2,
            ],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                ],
            ],
        ];
    }
//    protected function getOptions(): array
//    {
//        return [
//            'chart' => [
//                'type' => 'bar',
//                'height' => 300,
//            ],
//            'series' => [
//                [
//                    'name' => 'Total enregistrements',
//                    'data' => [55, 85, 115],
//                ],
//                [
//                    'name' => 'Total lectures',
//                    'data' => [150, 120, 225],
//                ],
//            ],
//            'xaxis' => [
//                'categories' => ['Mai', 'Juin', 'Juillet'],
//                'labels' => [
//                    'style' => [
//                        'colors' => '#9ca3af',
//                        'fontWeight' => 600,
//                    ],
//                ],
//            ],
//            'yaxis' => [
//                'labels' => [
//                    'style' => [
//                        'colors' => '#9ca3af',
//                        'fontWeight' => 600,
//                    ],
//                ],
//            ],
//            'colors' => ['#132775', '#ED8223'],
//            'stroke' => [
//                'show' => true,
//                'width' => 2,
//                'colors' => ['transparent'],
//            ],
//            'grid' => [
//                'borderColor' => '#e7e7e7',
//                'row' => [
//                    'colors' => ['#f3f3f3', 'transparent'],
//                    'opacity' => 0.5,
//                ],
//            ],
//            'dropShadow' => [
//                'enabled' => true,
//                'color' => '#000',
//                'top' => 18,
//                'left' => 7,
//                'blur' => 10,
//                'opacity' => 0.2,
//            ],
//            'plotOptions' => [
//                'bar' => [
//                    'borderRadius' => 3,
//                ],
//            ],
//        ];
//    }
}
