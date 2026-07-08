<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Mov04l1.
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
 * @method static Builder|Mov04l1 newModelQuery()
 * @method static Builder|Mov04l1 newQuery()
 * @method static Builder|Mov04l1 query()
 * @method static Builder|Mov04l1 whereEnte($value)
 * @method static Builder|Mov04l1 whereId($value)
 * @method static Builder|Mov04l1 whereMatr($value)
 * @method static Builder|Mov04l1 whereMo1aa($value)
 * @method static Builder|Mov04l1 whereMo1all($value)
 * @method static Builder|Mov04l1 whereMo1ann($value)
 * @method static Builder|Mov04l1 whereMo1cod($value)
 * @method static Builder|Mov04l1 whereMo1gg($value)
 * @method static Builder|Mov04l1 whereMo1mm($value)
 * @method static Builder|Mov04l1 whereMo1of($value)
 * @method static Builder|Mov04l1 whereMo1oi($value)
 * @method static Builder|Mov04l1 whereMo1qta($value)
 * @method static Builder|Mov04l1 whereMo1qtv($value)
 * @method static Builder|Mov04l1 whereMo1tip($value)
 * @method static Builder|Mov04l1 whereMo1tmo($value)
 * @method static Builder|Mov04l1 whereMo1um($value)
 * @method static Builder|Mov04l1 whereMov001($value)
 * @method static Builder|Mov04l1 whereMov002($value)
 * @method static Builder|Mov04l1 whereMov003($value)
 * @method static Builder|Mov04l1 whereMov004($value)
 * @method static Builder|Mov04l1 whereMov005($value)
 * @method static Builder|Mov04l1 whereMov2kn($value)
 * @method static Builder|Mov04l1 whereMov2kz($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Mov04l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Mov04l1 extends BaseModel
{
    protected $table = 'mov04l1';
}
