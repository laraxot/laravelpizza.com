<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

// ----------traits ---
/**
 * Modules\Sigma\Models\Mov01f.
 *
 * @property int $id
 * @property int $ente
 * @property int $matr
 * @property int $mo1tip
 * @property int $mo1cod
 * @property int $mo1aa
 * @property int $mo1mm
 * @property int $mo1gg
 * @property int $mo1qta
 * @property string $mo1tmo
 * @property string $mo1all
 * @property string $mo1qtv
 * @property string $mo1um
 * @property string $mo1oi
 * @property string $mo1of
 * @property string $mo1ann
 * @property int $mov2kn
 * @property int $mov2kz
 * @property int $mov001
 * @property string $mov002
 * @property string $mov003
 * @property int $mov004
 * @property int $mov005
 *
 * @method static Builder|Mov01f newModelQuery()
 * @method static Builder|Mov01f newQuery()
 * @method static Builder|Mov01f query()
 * @method static Builder|Mov01f whereEnte($value)
 * @method static Builder|Mov01f whereId($value)
 * @method static Builder|Mov01f whereMatr($value)
 * @method static Builder|Mov01f whereMo1aa($value)
 * @method static Builder|Mov01f whereMo1all($value)
 * @method static Builder|Mov01f whereMo1ann($value)
 * @method static Builder|Mov01f whereMo1cod($value)
 * @method static Builder|Mov01f whereMo1gg($value)
 * @method static Builder|Mov01f whereMo1mm($value)
 * @method static Builder|Mov01f whereMo1of($value)
 * @method static Builder|Mov01f whereMo1oi($value)
 * @method static Builder|Mov01f whereMo1qta($value)
 * @method static Builder|Mov01f whereMo1qtv($value)
 * @method static Builder|Mov01f whereMo1tip($value)
 * @method static Builder|Mov01f whereMo1tmo($value)
 * @method static Builder|Mov01f whereMo1um($value)
 * @method static Builder|Mov01f whereMov001($value)
 * @method static Builder|Mov01f whereMov002($value)
 * @method static Builder|Mov01f whereMov003($value)
 * @method static Builder|Mov01f whereMov004($value)
 * @method static Builder|Mov01f whereMov005($value)
 * @method static Builder|Mov01f whereMov2kn($value)
 * @method static Builder|Mov01f whereMov2kz($value)
 *
 * @mixin \Eloquent
 */
class Mov01f extends BaseModel
{
    protected $fillable = [
        'id',
        'ente',
        'matr',
        'mo1tip',
        'mo1cod',
        'mo1aa',
        'mo1mm',
        'mo1gg',
        'mo1qta',
        'mo1tmo',
        'mo1all',
        'mo1qtv',
        'mo1um',
        'mo1oi',
        'mo1of',
        'mo1ann',
        'mov2kn',
        'mov2kz',
        'mov001',
        'mov002',
        'mov003',
        'mov004',
        'mov005',
    ];

    protected $connection = 'generale';

    // this will use the specified database connection
    protected $table = 'mov01f';

    public $timestamps = false;
}
