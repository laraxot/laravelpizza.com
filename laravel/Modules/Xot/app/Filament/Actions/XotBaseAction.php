<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Actions;

use Filament\Actions\Action as FilamentAction;
use Illuminate\Database\Eloquent\Model;

/**
 * Base class for Filament actions.
 *
 * @property ?Model $record The associated record for this action
 *
 * @method static static make(?string $name = null) Create a new instance of the action
 */
abstract class XotBaseAction extends FilamentAction {}
