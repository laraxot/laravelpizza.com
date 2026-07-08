<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Pages;

use Illuminate\Contracts\Support\Htmlable;
use Modules\Ptv\Filament\Widgets\AdminWidgets;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    // protected static string $view = 'ptv::filament.pages.dashboard';
    public function getSubheading(): string|Htmlable|null
    {
        // if (auth()->user()->is_admin) {
        //    return '--';
        // }

        return 'Here you will see an overview of your tasks.';
    }

    /**
     * @return array<string, mixed>
     */
    public function getWidgets(): array
    {
        return [
            'admin' => AdminWidgets::class,
        ];
    }
}
