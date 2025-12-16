<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Tables\Columns;

use Filament\Tables\Columns\ColumnGroup as FilamentColumnGroup;

/**
 * Base class for column groups.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 *
 * @method static static make(string $name) Create a new instance of the column group
 */
abstract class XotBaseColumnGroup extends FilamentColumnGroup {}
