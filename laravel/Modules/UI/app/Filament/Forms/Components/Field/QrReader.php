<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components\Field;

use Modules\Xot\Filament\Forms\Components\XotBaseField;

final class QrReader extends XotBaseField
{
    protected string $view = 'ui::filament.forms.components.field.qr-reader';

    /*
     * public static function make($livewire): static
     * {
     * $result = app(static::class, ['livewire' => $livewire]);
     * $result->configure();
     * return $result;
     * }
     */
}
