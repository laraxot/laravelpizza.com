<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Aliced1.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $conome
 * @property string|null $nome
 * @property int|null $con
 * @property int|null $rap
 * @property int|null $ruo
 * @property int|null $pro
 * @property int|null $pos
 * @property int|null $man
 * @property int|null $dis
 * @property string|null $prod
 * @property string|null $qu1d
 * @property string|null $qu2d
 * @property string|null $quli
 * @property int|null $anno
 * @property int|null $voce
 * @property int|null $isti
 * @property string|null $desret
 * @property int|null $tipret
 * @property string|null $import
 *
 * @method static Builder|Aliced1 newModelQuery()
 * @method static Builder|Aliced1 newQuery()
 * @method static Builder|Aliced1 query()
 * @method static Builder|Aliced1 whereAnno($value)
 * @method static Builder|Aliced1 whereCon($value)
 * @method static Builder|Aliced1 whereConome($value)
 * @method static Builder|Aliced1 whereDesret($value)
 * @method static Builder|Aliced1 whereDis($value)
 * @method static Builder|Aliced1 whereEnte($value)
 * @method static Builder|Aliced1 whereId($value)
 * @method static Builder|Aliced1 whereImport($value)
 * @method static Builder|Aliced1 whereIsti($value)
 * @method static Builder|Aliced1 whereMan($value)
 * @method static Builder|Aliced1 whereMatr($value)
 * @method static Builder|Aliced1 whereNome($value)
 * @method static Builder|Aliced1 wherePos($value)
 * @method static Builder|Aliced1 wherePro($value)
 * @method static Builder|Aliced1 whereProd($value)
 * @method static Builder|Aliced1 whereQu1d($value)
 * @method static Builder|Aliced1 whereQu2d($value)
 * @method static Builder|Aliced1 whereQuli($value)
 * @method static Builder|Aliced1 whereRap($value)
 * @method static Builder|Aliced1 whereRuo($value)
 * @method static Builder|Aliced1 whereTipret($value)
 * @method static Builder|Aliced1 whereVoce($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Aliced1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Aliced1 extends BaseModel
{
    protected $table = 'aliced1';
}
