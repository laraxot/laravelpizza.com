<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

class Test extends XotBasePage
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'modules.xot.filament.pages.test';
}
