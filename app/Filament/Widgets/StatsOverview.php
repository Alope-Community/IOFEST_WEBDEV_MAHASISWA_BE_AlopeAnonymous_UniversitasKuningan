<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;
    protected function getStats(): array
    {
        return [
            Stat::make('Akun Aktif', '100'),
            Stat::make('Total Akun', '300'),
            Stat::make('Total Program', '450'),
        ];
    }
}
