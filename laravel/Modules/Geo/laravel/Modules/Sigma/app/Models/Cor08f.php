<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Cor08f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $anno
 * @property string|null $codcor
 * @property string|null $tiprec
 * @property string|null $riga
 * @property string|null $testo
 * @property string|null $matr08
 * @property string|null $dspp
 * @property string|null $dse1
 * @property string|null $dse2
 * @property string|null $dscr
 * @property string|null $dsdt
 * @property string|null $dsdi
 * @property string|null $dsnp
 *
 * @method static Builder|Cor08f newModelQuery()
 * @method static Builder|Cor08f newQuery()
 * @method static Builder|Cor08f query()
 * @method static Builder|Cor08f whereAnno($value)
 * @method static Builder|Cor08f whereCodcor($value)
 * @method static Builder|Cor08f whereDscr($value)
 * @method static Builder|Cor08f whereDsdi($value)
 * @method static Builder|Cor08f whereDsdt($value)
 * @method static Builder|Cor08f whereDse1($value)
 * @method static Builder|Cor08f whereDse2($value)
 * @method static Builder|Cor08f whereDsnp($value)
 * @method static Builder|Cor08f whereDspp($value)
 * @method static Builder|Cor08f whereEnte($value)
 * @method static Builder|Cor08f whereId($value)
 * @method static Builder|Cor08f whereMatr08($value)
 * @method static Builder|Cor08f whereRiga($value)
 * @method static Builder|Cor08f whereTesto($value)
 * @method static Builder|Cor08f whereTiprec($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Cor08fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Cor08f extends BaseModel
{
    protected $table = 'cor08f';
}
