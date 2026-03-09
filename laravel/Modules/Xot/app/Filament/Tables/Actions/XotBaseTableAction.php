<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Tables\Actions;

use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;

/**
 * @property ?Model $record
 *
 * @method ?Model getRecord()
 */
abstract class XotBaseTableAction extends Action
{
    public function getRecord(bool $withDefault = true): ?Model
    {
        if ($record instanceof \Closure)
            return null;
        }

        return $record;
    }
}
