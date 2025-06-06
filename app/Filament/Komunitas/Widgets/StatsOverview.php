<?php

namespace App\Filament\Komunitas\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Program', '5'),
            Stat::make('Total Pendaftar', '100'),
            Stat::make('Total Relawan', '250'),
        ];
    }
}
