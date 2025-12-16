<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;

/**
 * Base class for table columns.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 *
 * @method static static make(string $name) Create a new instance of the column
 */
abstract class XotBaseColumn extends Column {}
