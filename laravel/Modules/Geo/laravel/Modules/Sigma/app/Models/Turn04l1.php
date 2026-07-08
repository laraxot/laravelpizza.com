<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Turn04l1.
 *
 * @property int $id
 * @property string|null $T4ANNU
 * @property string|null $ENTEAP
 * @property string|null $T4CODI
 * @property string|null $T4STOR
 * @property string|null $T4SEQU
 * @property string|null $T4RIPP
 * @property string|null $T4COM1
 * @property string|null $T4COM2
 *
 * @method static Builder|Turn04l1 newModelQuery()
 * @method static Builder|Turn04l1 newQuery()
 * @method static Builder|Turn04l1 query()
 * @method static Builder|Turn04l1 whereENTEAP($value)
 * @method static Builder|Turn04l1 whereId($value)
 * @method static Builder|Turn04l1 whereT4ANNU($value)
 * @method static Builder|Turn04l1 whereT4CODI($value)
 * @method static Builder|Turn04l1 whereT4COM1($value)
 * @method static Builder|Turn04l1 whereT4COM2($value)
 * @method static Builder|Turn04l1 whereT4RIPP($value)
 * @method static Builder|Turn04l1 whereT4SEQU($value)
 * @method static Builder|Turn04l1 whereT4STOR($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Turn04l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Turn04l1 extends BaseModel
{
    protected $table = 'turn04l1';
}
