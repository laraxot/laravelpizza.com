<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Tables\Actions;

use Filament\Actions\BulkAction as FilamentBulkAction;
use Illuminate\Database\Eloquent\Model;

/**
 * @property ?Model $record
 *
 * @method ?Model getRecord()
 */
abstract class XotBaseBulkAction extends FilamentBulkAction {
    /**
     * Nome di default dell'action.
     *
     * Questo nome viene utilizzato come chiave nell'array delle actions
     * e per la generazione automatica delle traduzioni tramite LangServiceProvider.
     *
     * @return string|null
     */
    public static function getDefaultName(): ?string
    {
        return class_basename(static::class);
    }
}
