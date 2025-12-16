<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;

class EnvPage extends XotBasePage
{
    use NavigationLabelTrait;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home';

    protected string $view = 'xot::filament.pages.dashboard';
}
