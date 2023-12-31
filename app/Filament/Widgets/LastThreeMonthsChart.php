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

    protected static ?string $heading = 'Activité durant les 3 derniers mois';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 1;

    protected function getOptions(): array
    {
        $recordsData = Trend::model(Enregistrement::class)
            ->between(
                start: now()->subMonths(2),
                end: now(),
//                start: Carbon::parse($this->filterFormData['date_start']),
//                end: Carbon::parse($this->filterFormData['date_end']),
            )
            ->perMonth()
            ->count();

        $listeningsData = Trend::model(Listening::class)
            ->between(
                start: now()->subMonths(2),
                end: now(),
//                start: Carbon::parse($this->filterFormData['date_start']),
//                end: Carbon::parse($this->filterFormData['date_end']),
            )
            ->perMonth()
            ->count();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 252,
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

//    protected function getFormSchema(): array
//    {
//        return [
//            DatePicker::make('date_start')
//                ->default(now()->subMonths(2))
//                ->closeOnDateSelection(),
//
//            DatePicker::make('date_end')
//                ->default(now())
//                ->closeOnDateSelection(),
//        ];
//    }
}
