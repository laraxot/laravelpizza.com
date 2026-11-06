<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Forms\Components;

use Filament\Infolists\Components\TextEntry;

/**
 * Base class for read-only form display components.
 *
 * Filament v5: {@see Placeholder} è deprecato — usiamo {@see TextEntry} con `state()`.
 *
 * @method static static make(string $name)
 */
class XotBasePlaceholder extends TextEntry
{
    // Logica comune futura per i placeholder Xot
}
