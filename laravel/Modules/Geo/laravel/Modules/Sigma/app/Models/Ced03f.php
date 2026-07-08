<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

// ----------traits ---
/**
 * Modules\Sigma\Models\Ced03f.
 *
 * @property int $id
 * @property int $ente
 * @property int $scont
 * @property int $smatr
 * @property int $smesli
 * @property int $sannli
 * @property int $sgiome
 * @property int $svocfi
 * @property string $perrid
 * @property int $totale
 * @property string $impoeu
 * @property int $totsav
 * @property string $impseu
 * @property string $qtaore
 * @property int $anno
 * @property int $mese
 * @property int $sruolo
 * @property int $impbil
 * @property int $clafun
 * @property int $flagcf
 * @property int $cedist
 *
 * @method static Builder|Ced03f newModelQuery()
 * @method static Builder|Ced03f newQuery()
 * @method static Builder|Ced03f query()
 * @method static Builder|Ced03f whereAnno($value)
 * @method static Builder|Ced03f whereCedist($value)
 * @method static Builder|Ced03f whereClafun($value)
 * @method static Builder|Ced03f whereEnte($value)
 * @method static Builder|Ced03f whereFlagcf($value)
 * @method static Builder|Ced03f whereId($value)
 * @method static Builder|Ced03f whereImpbil($value)
 * @method static Builder|Ced03f whereImpoeu($value)
 * @method static Builder|Ced03f whereImpseu($value)
 * @method static Builder|Ced03f whereMese($value)
 * @method static Builder|Ced03f wherePerrid($value)
 * @method static Builder|Ced03f whereQtaore($value)
 * @method static Builder|Ced03f whereSannli($value)
 * @method static Builder|Ced03f whereScont($value)
 * @method static Builder|Ced03f whereSgiome($value)
 * @method static Builder|Ced03f whereSmatr($value)
 * @method static Builder|Ced03f whereSmesli($value)
 * @method static Builder|Ced03f whereSruolo($value)
 * @method static Builder|Ced03f whereSvocfi($value)
 * @method static Builder|Ced03f whereTotale($value)
 * @method static Builder|Ced03f whereTotsav($value)
 *
 * @mixin \Eloquent
 */
class Ced03f extends BaseModel
{
    protected $fillable = [
        'id',
        'ente',
        'scont',
        'smatr',
        'smesli',
        'sannli',
        'sgiome',
        'svocfi',
        'perrid',
        'totale',
        'impoeu',
        'totsav',
        'impseu',
        'qtaore',
        'anno',
        'mese',
        'sruolo',
        'impbil',
        'clafun',
        'flagcf',
        'cedist',
    ];

    protected $connection = 'generale';

    // this will use the specified database connection
    protected $table = 'ced03f';

    public $timestamps = false;
}
