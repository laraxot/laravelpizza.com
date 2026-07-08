<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Fatturl1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $anno
 * @property string|null $mese
 * @property string|null $dipser
 * @property string|null $dipces
 * @property string|null $dipcet
 * @property string|null $cedela
 * @property string|null $cedelp
 * @property string|null $cedneg
 * @property string|null $cedpre
 * @property string|null $datela
 * @property string|null $datpri
 * @property string|null $propri
 * @property string|null $datric
 * @property string|null $proric
 * @property string|null $datchi
 * @property string|null $prochi
 * @property string|null $datall
 * @property string|null $proall
 *
 * @method static Builder|Fatturl1 newModelQuery()
 * @method static Builder|Fatturl1 newQuery()
 * @method static Builder|Fatturl1 query()
 * @method static Builder|Fatturl1 whereAnno($value)
 * @method static Builder|Fatturl1 whereCedela($value)
 * @method static Builder|Fatturl1 whereCedelp($value)
 * @method static Builder|Fatturl1 whereCedneg($value)
 * @method static Builder|Fatturl1 whereCedpre($value)
 * @method static Builder|Fatturl1 whereDatall($value)
 * @method static Builder|Fatturl1 whereDatchi($value)
 * @method static Builder|Fatturl1 whereDatela($value)
 * @method static Builder|Fatturl1 whereDatpri($value)
 * @method static Builder|Fatturl1 whereDatric($value)
 * @method static Builder|Fatturl1 whereDipces($value)
 * @method static Builder|Fatturl1 whereDipcet($value)
 * @method static Builder|Fatturl1 whereDipser($value)
 * @method static Builder|Fatturl1 whereEnte($value)
 * @method static Builder|Fatturl1 whereId($value)
 * @method static Builder|Fatturl1 whereMese($value)
 * @method static Builder|Fatturl1 whereProall($value)
 * @method static Builder|Fatturl1 whereProchi($value)
 * @method static Builder|Fatturl1 wherePropri($value)
 * @method static Builder|Fatturl1 whereProric($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Fatturl1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Fatturl1 extends BaseModel
{
    protected $table = 'fatturl1';
}
