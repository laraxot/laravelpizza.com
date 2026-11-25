<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Forms\Components;

use Filament\Forms\Components\Repeater as FilamentRepeater;

/**
 * Base class for Repeater.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 * This class wraps Filament's Repeater to provide a XotBase layer.
 */
abstract class XotBaseRepeater extends FilamentRepeater {}
