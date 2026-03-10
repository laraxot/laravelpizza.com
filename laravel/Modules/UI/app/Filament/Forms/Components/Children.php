<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms\Components\ViewField;

// use Filament\Support\Components\ViewComponent;

final class Children extends ViewField
{
    protected string $view = 'ui::filament.forms.components.navigation-builder';

    /*
     * public static function make($livewire): static
     * {
     * $result = app(static::class, ['livewire' => $livewire]);
     * $result->configure();
     * return $result;
     * }
     */
}
