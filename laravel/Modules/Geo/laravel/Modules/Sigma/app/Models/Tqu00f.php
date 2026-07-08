<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

// ----------traits ---
/**
 * Modules\Sigma\Models\Tqu00f.
 *
 * @property int $id
 * @property int|null $cont
 * @property int|null $tipco
 * @property int|null $rapp
 * @property int|null $ruolo
 * @property int|null $propro
 * @property int|null $posfun
 * @property int|null $codqua
 * @property int|null $codinq
 * @property string|null $desc1
 * @property string|null $desc2
 * @property string|null $liv
 * @property string|null $tqann
 *
 * @method static Builder|Tqu00f newModelQuery()
 * @method static Builder|Tqu00f newQuery()
 * @method static Builder|Tqu00f query()
 * @method static Builder|Tqu00f whereCodinq($value)
 * @method static Builder|Tqu00f whereCodqua($value)
 * @method static Builder|Tqu00f whereCont($value)
 * @method static Builder|Tqu00f whereDesc1($value)
 * @method static Builder|Tqu00f whereDesc2($value)
 * @method static Builder|Tqu00f whereId($value)
 * @method static Builder|Tqu00f whereLiv($value)
 * @method static Builder|Tqu00f wherePosfun($value)
 * @method static Builder|Tqu00f wherePropro($value)
 * @method static Builder|Tqu00f whereRapp($value)
 * @method static Builder|Tqu00f whereRuolo($value)
 * @method static Builder|Tqu00f whereTipco($value)
 * @method static Builder|Tqu00f whereTqann($value)
 *
 * @mixin \Eloquent
 */
class Tqu00f extends BaseModel
{
    protected $fillable = [
        'id',
        'cont',
        'tipco',
        'rapp',
        'ruolo',
        'propro',
        'posfun',
        'codqua',
        'codinq',
        'desc1',
        'desc2',
        'liv',
        'tqann',
    ];

    protected $connection = 'generale';

    // this will use the specified database connection
    protected $table = 'tqu00f';

    public $timestamps = false;
}
