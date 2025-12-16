<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\State;

/**
 * @property State $status
 *
 * @phpstan-require-extends Model
 */
interface WithStateStatusContract {}
