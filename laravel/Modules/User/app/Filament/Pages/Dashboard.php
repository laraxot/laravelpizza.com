<?php

/**
 * @see https://medium.com/@laravelprotips/filament-streamline-multiple-widgets-with-one-dynamic-livewire-filter-ed05c978a97f
 */

declare(strict_types=1);

namespace Modules\User\Filament\Pages;

use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;
use Modules\User\Filament\Widgets\RecentLoginsWidget;
use Modules\User\Filament\Widgets\UsersChartWidget;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    // protected static string $routePath = 'finance';
    // protected static ?string $title = 'Finance dashboard';
    // protected static ?int $navigationSort = 15;

    // protected static string $view = 'user::filament.pages.dashboard';

    /**
     * @return array<class-string<Widget>|WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        return [
            UsersChartWidget::make(['chart_id' => 'bb']),
            // Widgets\UsersChartWidget::make(['chart_id' => 'aa']),
            RecentLoginsWidget::class,
        ];
    }
}
