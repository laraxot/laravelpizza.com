<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Modules\Xot\Filament\Traits\NavigationPageLabelTrait;

class Test extends XotBasePage
{
    use NavigationPageLabelTrait;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'modules.xot.filament.pages.test';
}
