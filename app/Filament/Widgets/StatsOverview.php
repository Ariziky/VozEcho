<?php

namespace App\Filament\Widgets;

use App\Models\Enregistrement;
use App\Models\Listening;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Carbon;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getCards(): array
    {
        return [
//            Fieldset::make('test')
//                ->schema([
            Card::make('Nbre total d\'enregistrements', $this->getTodayRecords())
//                ->description('32k increase')
//                ->descriptionIcon('heroicon-s-trending-up')
                ->color('primary'),

            Card::make('Nbre total de lectures', $this->getTodayListening())
//                ->description('32k increase')
//                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
//                ]),

            Card::make('Nbre total d\'enregistrements', $this->getCurrentMonthRecords())
//                ->description('32k increase')
//                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),

            Card::make('Nbre total de lectures', $this->getCurrentMonthListenings())
//                ->description('32k increase')
//                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
        ];
    }

    protected function getTodayRecords(): int
    {
        return Enregistrement::query()
            ->whereDate('created_at', today())
            ->count();
    }

    protected function getTodayListening(): int
    {
        return Listening::query()
            ->whereDate('created_at', today())
            ->count();
    }

    protected function getCurrentMonthRecords(): int
    {
        return Enregistrement::query()
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
    }

    protected function getCurrentMonthListenings(): int
    {
        return Listening::query()
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
    }
}
