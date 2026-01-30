<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Xot\Contracts\PivotContract.
 *
 * @property string|null $title
 * @property string|null $subtitle
 * @property int|null $status
 *
 * @method mixed update($params)
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface PivotContract {}
