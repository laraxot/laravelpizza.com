<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Mov01k5.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $mo1tip
 * @property string|null $mo1cod
 * @property string|null $mo1aa
 * @property string|null $mo1mm
 * @property string|null $mo1gg
 * @property string|null $mo1qta
 * @property string|null $mo1tmo
 * @property string|null $mo1all
 * @property string|null $mo1qtv
 * @property string|null $mo1um
 * @property string|null $mo1oi
 * @property string|null $mo1of
 * @property string|null $mo1ann
 * @property string|null $mov2kn
 * @property string|null $mov2kz
 * @property string|null $mov001
 * @property string|null $mov002
 * @property string|null $mov003
 * @property string|null $mov004
 * @property string|null $mov005
 *
 * @method static Builder|Mov01k5 newModelQuery()
 * @method static Builder|Mov01k5 newQuery()
 * @method static Builder|Mov01k5 query()
 * @method static Builder|Mov01k5 whereEnte($value)
 * @method static Builder|Mov01k5 whereId($value)
 * @method static Builder|Mov01k5 whereMatr($value)
 * @method static Builder|Mov01k5 whereMo1aa($value)
 * @method static Builder|Mov01k5 whereMo1all($value)
 * @method static Builder|Mov01k5 whereMo1ann($value)
 * @method static Builder|Mov01k5 whereMo1cod($value)
 * @method static Builder|Mov01k5 whereMo1gg($value)
 * @method static Builder|Mov01k5 whereMo1mm($value)
 * @method static Builder|Mov01k5 whereMo1of($value)
 * @method static Builder|Mov01k5 whereMo1oi($value)
 * @method static Builder|Mov01k5 whereMo1qta($value)
 * @method static Builder|Mov01k5 whereMo1qtv($value)
 * @method static Builder|Mov01k5 whereMo1tip($value)
 * @method static Builder|Mov01k5 whereMo1tmo($value)
 * @method static Builder|Mov01k5 whereMo1um($value)
 * @method static Builder|Mov01k5 whereMov001($value)
 * @method static Builder|Mov01k5 whereMov002($value)
 * @method static Builder|Mov01k5 whereMov003($value)
 * @method static Builder|Mov01k5 whereMov004($value)
 * @method static Builder|Mov01k5 whereMov005($value)
 * @method static Builder|Mov01k5 whereMov2kn($value)
 * @method static Builder|Mov01k5 whereMov2kz($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Mov01k5Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Mov01k5 extends BaseModel
{
    protected $table = 'mov01k5';
}
