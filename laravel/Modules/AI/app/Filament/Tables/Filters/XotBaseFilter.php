<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Tables\Filters;

use Filament\Tables\Filters\Filter as FilamentFilter;

/**
 * Base class for Filter.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 * This class wraps Filament's Filter to provide a XotBase layer.
 */
abstract class XotBaseFilter extends FilamentFilter {}
