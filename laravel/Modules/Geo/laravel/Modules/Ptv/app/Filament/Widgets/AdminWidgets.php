<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class AdminWidgets extends BaseWidget
{
    protected function getCards(): array
    {
        // $a = new ChartWidget('5');
        // dddx($a->render()->toHtml());

        return [
            // Card::make('Total Users', User::count()),
            // Card::make('Users Registered Today', User::whereDate('created_at', today())->count()),
            // ChartWidget::make('5'),
            // new ChartWidget('5'),
        ];
    }

    // public static function canView(): bool
    // {
    //    return auth()->user()->is_admin;
    // }
}
