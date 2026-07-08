<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Cor02l2.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $anno
 * @property string|null $codcor
 * @property string|null $tipo02
 * @property string|null $crecm2
 * @property string|null $repst2
 * @property string|null $repre2
 * @property string|null $ceco1
 * @property string|null $ceco2
 * @property string|null $ceco3
 * @property string|null $autmez
 * @property string|null $antice
 * @property string|null $valuta
 * @property string|null $iscent
 * @property string|null $discee
 * @property string|null $biscee
 * @property string|null $cspes1
 * @property string|null $bspes1
 * @property string|null $cspes2
 * @property string|null $bspes2
 * @property string|null $cspes3
 * @property string|null $bspes3
 * @property string|null $cspes4
 * @property string|null $bspes4
 * @property string|null $cspes5
 * @property string|null $bspes5
 * @property string|null $cspes6
 * @property string|null $bspes6
 * @property string|null $impegn
 * @property string|null $prevdi
 * @property string|null $spedip
 * @property string|null $despes
 * @property string|null $modant
 * @property string|null $datant
 * @property string|null $partec
 * @property string|null $numore
 * @property string|null $numgio
 * @property string|null $valpos
 * @property string|null $punteg
 * @property string|null $nonpar
 * @property string|null $inora
 * @property string|null $fuora
 * @property string|null $email
 * @property string|null $sponso
 * @property string|null $tabaut
 * @property string|null $dataut
 * @property string|null $nproto
 * @property string|null $flaga
 * @property string|null $flagb
 * @property string|null $flagc
 * @property string|null $flagd
 * @property string|null $flage
 * @property string|null $flagf
 * @property string|null $comoa
 * @property string|null $comob
 * @property string|null $comoc
 * @property string|null $comod
 *
 * @method static Builder|Cor02l2 newModelQuery()
 * @method static Builder|Cor02l2 newQuery()
 * @method static Builder|Cor02l2 query()
 * @method static Builder|Cor02l2 whereAnno($value)
 * @method static Builder|Cor02l2 whereAntice($value)
 * @method static Builder|Cor02l2 whereAutmez($value)
 * @method static Builder|Cor02l2 whereBiscee($value)
 * @method static Builder|Cor02l2 whereBspes1($value)
 * @method static Builder|Cor02l2 whereBspes2($value)
 * @method static Builder|Cor02l2 whereBspes3($value)
 * @method static Builder|Cor02l2 whereBspes4($value)
 * @method static Builder|Cor02l2 whereBspes5($value)
 * @method static Builder|Cor02l2 whereBspes6($value)
 * @method static Builder|Cor02l2 whereCeco1($value)
 * @method static Builder|Cor02l2 whereCeco2($value)
 * @method static Builder|Cor02l2 whereCeco3($value)
 * @method static Builder|Cor02l2 whereCodcor($value)
 * @method static Builder|Cor02l2 whereComoa($value)
 * @method static Builder|Cor02l2 whereComob($value)
 * @method static Builder|Cor02l2 whereComoc($value)
 * @method static Builder|Cor02l2 whereComod($value)
 * @method static Builder|Cor02l2 whereCrecm2($value)
 * @method static Builder|Cor02l2 whereCspes1($value)
 * @method static Builder|Cor02l2 whereCspes2($value)
 * @method static Builder|Cor02l2 whereCspes3($value)
 * @method static Builder|Cor02l2 whereCspes4($value)
 * @method static Builder|Cor02l2 whereCspes5($value)
 * @method static Builder|Cor02l2 whereCspes6($value)
 * @method static Builder|Cor02l2 whereDatant($value)
 * @method static Builder|Cor02l2 whereDataut($value)
 * @method static Builder|Cor02l2 whereDespes($value)
 * @method static Builder|Cor02l2 whereDiscee($value)
 * @method static Builder|Cor02l2 whereEmail($value)
 * @method static Builder|Cor02l2 whereEnte($value)
 * @method static Builder|Cor02l2 whereFlaga($value)
 * @method static Builder|Cor02l2 whereFlagb($value)
 * @method static Builder|Cor02l2 whereFlagc($value)
 * @method static Builder|Cor02l2 whereFlagd($value)
 * @method static Builder|Cor02l2 whereFlage($value)
 * @method static Builder|Cor02l2 whereFlagf($value)
 * @method static Builder|Cor02l2 whereFuora($value)
 * @method static Builder|Cor02l2 whereId($value)
 * @method static Builder|Cor02l2 whereImpegn($value)
 * @method static Builder|Cor02l2 whereInora($value)
 * @method static Builder|Cor02l2 whereIscent($value)
 * @method static Builder|Cor02l2 whereMatr($value)
 * @method static Builder|Cor02l2 whereModant($value)
 * @method static Builder|Cor02l2 whereNonpar($value)
 * @method static Builder|Cor02l2 whereNproto($value)
 * @method static Builder|Cor02l2 whereNumgio($value)
 * @method static Builder|Cor02l2 whereNumore($value)
 * @method static Builder|Cor02l2 wherePartec($value)
 * @method static Builder|Cor02l2 wherePrevdi($value)
 * @method static Builder|Cor02l2 wherePunteg($value)
 * @method static Builder|Cor02l2 whereRepre2($value)
 * @method static Builder|Cor02l2 whereRepst2($value)
 * @method static Builder|Cor02l2 whereSpedip($value)
 * @method static Builder|Cor02l2 whereSponso($value)
 * @method static Builder|Cor02l2 whereTabaut($value)
 * @method static Builder|Cor02l2 whereTipo02($value)
 * @method static Builder|Cor02l2 whereValpos($value)
 * @method static Builder|Cor02l2 whereValuta($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Cor02l2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Cor02l2 extends BaseModel
{
    protected $table = 'cor02l2';
}
