<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components\Field;

use Filament\Forms\Components\Field;

final class QrReader extends Field
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
