<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn as FilamentTextColumn;

/**
 * Base class for text columns.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 * This class wraps Filament's TextColumn to provide a XotBase layer.
 *
 * @method static static make(string $name) Create a new instance of the column
 */
abstract class XotBaseTextColumn extends FilamentTextColumn {}
