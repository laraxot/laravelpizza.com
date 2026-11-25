<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Tables\Columns;

use Filament\Tables\Columns\ViewColumn as FilamentViewColumn;
use Modules\Xot\Actions\View\GetViewByClassAction;

/**
 * Base class for view columns.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 * This class wraps Filament's ViewColumn to provide a XotBase layer.
 *
 * NOTE: Filament\Tables\Columns\Column::__construct() is final — do not
 * override it here. Subclasses set their own `protected string $view` as
 * usual (see Modules\Notify\Filament\Tables\Columns\ContactColumn).
 *
 * @method static static make(string $name) Create a new instance of the column
 */
abstract class XotBaseViewColumn extends FilamentViewColumn
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->view = app(GetViewByClassAction::class)->execute(static::class);
    }
}
