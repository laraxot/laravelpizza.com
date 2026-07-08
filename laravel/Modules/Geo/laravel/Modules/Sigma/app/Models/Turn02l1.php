<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Turn02l1.
 *
 * @property int $id
 * @property string|null $T2ANNU
 * @property string|null $ENTEAP
 * @property string|null $T2CODI
 * @property string|null $T2STOR
 * @property string|null $T2SEQU
 * @property string|null $T2RIPP
 * @property string|null $T2COM1
 * @property string|null $T2COM2
 *
 * @method static Builder|Turn02l1 newModelQuery()
 * @method static Builder|Turn02l1 newQuery()
 * @method static Builder|Turn02l1 query()
 * @method static Builder|Turn02l1 whereENTEAP($value)
 * @method static Builder|Turn02l1 whereId($value)
 * @method static Builder|Turn02l1 whereT2ANNU($value)
 * @method static Builder|Turn02l1 whereT2CODI($value)
 * @method static Builder|Turn02l1 whereT2COM1($value)
 * @method static Builder|Turn02l1 whereT2COM2($value)
 * @method static Builder|Turn02l1 whereT2RIPP($value)
 * @method static Builder|Turn02l1 whereT2SEQU($value)
 * @method static Builder|Turn02l1 whereT2STOR($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Turn02l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Turn02l1 extends BaseModel
{
    protected $table = 'turn02l1';
}
