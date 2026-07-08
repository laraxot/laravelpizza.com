<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Cor01f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $anno
 * @property string|null $codcor
 * @property string|null $proeve
 * @property string|null $nediz
 * @property string|null $mater
 * @property string|null $concor
 * @property string|null $tipo01
 * @property string|null $tipo02
 * @property string|null $desco1
 * @property string|null $desco2
 * @property string|null $obiet1
 * @property string|null $obiet2
 * @property string|null $obiet3
 * @property string|null $resnom
 * @property string|null $restel
 * @property string|null $resema
 * @property string|null $prelir
 * @property string|null $finlir
 * @property string|null $preeur
 * @property string|null $fineur
 * @property string|null $luogo1
 * @property string|null $luogo2
 * @property string|null $discor
 * @property string|null $percor
 * @property string|null $organ1
 * @property string|null $organ2
 * @property string|null $datcor
 * @property string|null $daore
 * @property string|null $aore
 * @property string|null $nore
 * @property string|null $dalcor
 * @property string|null $alcor
 * @property string|null $ngio
 * @property string|null $tabaut
 * @property string|null $dataut
 * @property string|null $nproto
 * @property string|null $cosdoe
 * @property string|null $cosale
 * @property string|null $cosise
 * @property string|null $cosecm
 * @property string|null $prespe
 * @property string|null $preimp
 * @property string|null $pasto
 * @property string|null $ceco1
 * @property string|null $ceco2
 * @property string|null $ceco3
 * @property string|null $necm1
 * @property string|null $necm2
 * @property string|null $crecme
 * @property string|null $ecmdat
 *
 * @method static Builder|Cor01f newModelQuery()
 * @method static Builder|Cor01f newQuery()
 * @method static Builder|Cor01f query()
 * @method static Builder|Cor01f whereAlcor($value)
 * @method static Builder|Cor01f whereAnno($value)
 * @method static Builder|Cor01f whereAore($value)
 * @method static Builder|Cor01f whereCeco1($value)
 * @method static Builder|Cor01f whereCeco2($value)
 * @method static Builder|Cor01f whereCeco3($value)
 * @method static Builder|Cor01f whereCodcor($value)
 * @method static Builder|Cor01f whereConcor($value)
 * @method static Builder|Cor01f whereCosale($value)
 * @method static Builder|Cor01f whereCosdoe($value)
 * @method static Builder|Cor01f whereCosecm($value)
 * @method static Builder|Cor01f whereCosise($value)
 * @method static Builder|Cor01f whereCrecme($value)
 * @method static Builder|Cor01f whereDalcor($value)
 * @method static Builder|Cor01f whereDaore($value)
 * @method static Builder|Cor01f whereDataut($value)
 * @method static Builder|Cor01f whereDatcor($value)
 * @method static Builder|Cor01f whereDesco1($value)
 * @method static Builder|Cor01f whereDesco2($value)
 * @method static Builder|Cor01f whereDiscor($value)
 * @method static Builder|Cor01f whereEcmdat($value)
 * @method static Builder|Cor01f whereEnte($value)
 * @method static Builder|Cor01f whereFineur($value)
 * @method static Builder|Cor01f whereFinlir($value)
 * @method static Builder|Cor01f whereId($value)
 * @method static Builder|Cor01f whereLuogo1($value)
 * @method static Builder|Cor01f whereLuogo2($value)
 * @method static Builder|Cor01f whereMater($value)
 * @method static Builder|Cor01f whereNecm1($value)
 * @method static Builder|Cor01f whereNecm2($value)
 * @method static Builder|Cor01f whereNediz($value)
 * @method static Builder|Cor01f whereNgio($value)
 * @method static Builder|Cor01f whereNore($value)
 * @method static Builder|Cor01f whereNproto($value)
 * @method static Builder|Cor01f whereObiet1($value)
 * @method static Builder|Cor01f whereObiet2($value)
 * @method static Builder|Cor01f whereObiet3($value)
 * @method static Builder|Cor01f whereOrgan1($value)
 * @method static Builder|Cor01f whereOrgan2($value)
 * @method static Builder|Cor01f wherePasto($value)
 * @method static Builder|Cor01f wherePercor($value)
 * @method static Builder|Cor01f wherePreeur($value)
 * @method static Builder|Cor01f wherePreimp($value)
 * @method static Builder|Cor01f wherePrelir($value)
 * @method static Builder|Cor01f wherePrespe($value)
 * @method static Builder|Cor01f whereProeve($value)
 * @method static Builder|Cor01f whereResema($value)
 * @method static Builder|Cor01f whereResnom($value)
 * @method static Builder|Cor01f whereRestel($value)
 * @method static Builder|Cor01f whereTabaut($value)
 * @method static Builder|Cor01f whereTipo01($value)
 * @method static Builder|Cor01f whereTipo02($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Cor01fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Cor01f extends BaseModel
{
    protected $table = 'cor01f';
}
