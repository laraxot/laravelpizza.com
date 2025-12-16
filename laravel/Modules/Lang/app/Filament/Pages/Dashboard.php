<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'lang::filament.pages.dashboard';
}
