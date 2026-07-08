<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Turn02lx.
 *
 * @property int $id
 * @property string|null $t2annu
 * @property int|null $enteap
 * @property string|null $t2codi
 * @property int|null $t2stor
 * @property int|null $t2sequ
 * @property string|null $t2ripp
 * @property string|null $t2com1
 * @property string|null $t2com2
 *
 * @method static Builder|Turn02lx newModelQuery()
 * @method static Builder|Turn02lx newQuery()
 * @method static Builder|Turn02lx query()
 * @method static Builder|Turn02lx whereEnteap($value)
 * @method static Builder|Turn02lx whereId($value)
 * @method static Builder|Turn02lx whereT2annu($value)
 * @method static Builder|Turn02lx whereT2codi($value)
 * @method static Builder|Turn02lx whereT2com1($value)
 * @method static Builder|Turn02lx whereT2com2($value)
 * @method static Builder|Turn02lx whereT2ripp($value)
 * @method static Builder|Turn02lx whereT2sequ($value)
 * @method static Builder|Turn02lx whereT2stor($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Turn02lxFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Turn02lx extends BaseModel
{
    protected $table = 'turn02lx';
}
