<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * @property object $status
 *
 * @phpstan-require-extends Model
 */
interface WithStateStatusContract
{
}
