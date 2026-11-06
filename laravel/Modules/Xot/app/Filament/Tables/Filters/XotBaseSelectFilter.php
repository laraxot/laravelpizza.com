<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Tables\Filters;

use Filament\Tables\Filters\SelectFilter as FilamentSelectFilter;

/**
 * Base class for SelectFilter.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 * This class wraps Filament's SelectFilter to provide a XotBase layer.
 */
abstract class XotBaseSelectFilter extends FilamentSelectFilter {}
