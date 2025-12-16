<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Tables\Columns;

use Filament\Tables\Columns\IconColumn as FilamentIconColumn;

/**
 * Base class for icon columns.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 * This class wraps Filament's IconColumn to provide a XotBase layer.
 *
 * @method static static make(string $name) Create a new instance of the column
 */
abstract class XotBaseIconColumn extends FilamentIconColumn {}
