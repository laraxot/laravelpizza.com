<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Pages;

use Filament\Pages\Dashboard;
use Modules\Chart\Filament\Widgets\Samples as WidgetsSamples;

class DashboardV2 extends Dashboard
{
    // protected static ?string $navigationIcon = 'heroicon-o-home';

    // protected static string $view = 'chart::filament.pages.dashboard';

    protected static string $routePath = 'v2';

    /*
    public function mount(): void {
        $user = auth()->user();
        if(!$user->hasRole('super-admin')){
            redirect('/admin');
        }
    }
    */

    public function getWidgets(): array
    {
        return [
            // WidgetsSamples\OverlookWidget::make(),
            // WidgetsSamples\Doughnut01Chart::make(),
            // WidgetsSamples\Sample01Chart::make(),
            WidgetsSamples\Bar01Chart::make(),
        ];
    }
}
