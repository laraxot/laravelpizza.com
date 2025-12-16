<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Widgets\Widget;

/**
 * Widget di test per verificare la registrazione Livewire.
 */
class TestWidget extends Widget
{
    protected string $view = 'xot::filament.widgets.test';

    protected int|string|array $columnSpan = 'full';

    /**
     * Determina se il widget deve essere visibile.
     */
    public static function canView(): bool
    {
        return true;
    }
}
