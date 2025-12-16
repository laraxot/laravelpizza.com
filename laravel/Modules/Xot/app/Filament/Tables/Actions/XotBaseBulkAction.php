<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Tables\Actions;

use Filament\Actions\BulkAction;
use Illuminate\Database\Eloquent\Model;

/**
 * @property ?Model $record
 *
 * @method ?Model getRecord()
 */
abstract class XotBaseBulkAction extends BulkAction {}
