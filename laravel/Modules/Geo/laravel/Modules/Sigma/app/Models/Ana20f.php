<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ana20f.
 *
 * @property int $id
 * @property string|null $tiprec
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $conome
 * @property string|null $nome
 * @property string|null $sesso
 * @property string|null $staciv
 * @property string|null $clafun
 * @property string|null $titstu
 * @property string|null $entpro
 * @property string|null $sindac
 * @property string|null $catspe
 * @property string|null $titpro
 * @property string|null $tipag
 * @property string|null $stabi
 * @property string|null $repar
 * @property string|null $banca1
 * @property string|null $agen1
 * @property string|null $conto1
 * @property string|null $inail
 * @property string|null $flagse
 * @property string|null $stass
 * @property string|null $stdim
 * @property string|null $tipass
 * @property string|null $tipdim
 * @property string|null $repdal
 * @property string|null $repal
 * @property string|null $repst1
 * @property string|null $repre1
 * @property string|null $repst2
 * @property string|null $repre2
 * @property string|null $piaorg
 * @property string|null $qudal
 * @property string|null $qual
 * @property string|null $quanz
 * @property string|null $annise
 * @property string|null $posiz
 * @property string|null $datpas
 * @property string|null $oree
 * @property string|null $oret
 * @property string|null $cont
 * @property string|null $tipco
 * @property string|null $rapp
 * @property string|null $ruolo
 * @property string|null $propro
 * @property string|null $posfun
 * @property string|null $codqua
 * @property string|null $disci1
 * @property string|null $jipco
 * @property string|null $japp
 * @property string|null $juolo
 * @property string|null $jropro
 * @property string|null $josfun
 * @property string|null $jodqua
 * @property string|null $jisci2
 * @property string|null $tipasp
 * @property string|null $aspin
 * @property string|null $aspte
 * @property string|null $datdal
 * @property string|null $datal
 * @property string|null $anaann
 *
 * @method static Builder|Ana20f newModelQuery()
 * @method static Builder|Ana20f newQuery()
 * @method static Builder|Ana20f query()
 * @method static Builder|Ana20f whereAgen1($value)
 * @method static Builder|Ana20f whereAnaann($value)
 * @method static Builder|Ana20f whereAnnise($value)
 * @method static Builder|Ana20f whereAspin($value)
 * @method static Builder|Ana20f whereAspte($value)
 * @method static Builder|Ana20f whereBanca1($value)
 * @method static Builder|Ana20f whereCatspe($value)
 * @method static Builder|Ana20f whereClafun($value)
 * @method static Builder|Ana20f whereCodqua($value)
 * @method static Builder|Ana20f whereConome($value)
 * @method static Builder|Ana20f whereCont($value)
 * @method static Builder|Ana20f whereConto1($value)
 * @method static Builder|Ana20f whereDatal($value)
 * @method static Builder|Ana20f whereDatdal($value)
 * @method static Builder|Ana20f whereDatpas($value)
 * @method static Builder|Ana20f whereDisci1($value)
 * @method static Builder|Ana20f whereEnte($value)
 * @method static Builder|Ana20f whereEntpro($value)
 * @method static Builder|Ana20f whereFlagse($value)
 * @method static Builder|Ana20f whereId($value)
 * @method static Builder|Ana20f whereInail($value)
 * @method static Builder|Ana20f whereJapp($value)
 * @method static Builder|Ana20f whereJipco($value)
 * @method static Builder|Ana20f whereJisci2($value)
 * @method static Builder|Ana20f whereJodqua($value)
 * @method static Builder|Ana20f whereJosfun($value)
 * @method static Builder|Ana20f whereJropro($value)
 * @method static Builder|Ana20f whereJuolo($value)
 * @method static Builder|Ana20f whereMatr($value)
 * @method static Builder|Ana20f whereNome($value)
 * @method static Builder|Ana20f whereOree($value)
 * @method static Builder|Ana20f whereOret($value)
 * @method static Builder|Ana20f wherePiaorg($value)
 * @method static Builder|Ana20f wherePosfun($value)
 * @method static Builder|Ana20f wherePosiz($value)
 * @method static Builder|Ana20f wherePropro($value)
 * @method static Builder|Ana20f whereQual($value)
 * @method static Builder|Ana20f whereQuanz($value)
 * @method static Builder|Ana20f whereQudal($value)
 * @method static Builder|Ana20f whereRapp($value)
 * @method static Builder|Ana20f whereRepal($value)
 * @method static Builder|Ana20f whereRepar($value)
 * @method static Builder|Ana20f whereRepdal($value)
 * @method static Builder|Ana20f whereRepre1($value)
 * @method static Builder|Ana20f whereRepre2($value)
 * @method static Builder|Ana20f whereRepst1($value)
 * @method static Builder|Ana20f whereRepst2($value)
 * @method static Builder|Ana20f whereRuolo($value)
 * @method static Builder|Ana20f whereSesso($value)
 * @method static Builder|Ana20f whereSindac($value)
 * @method static Builder|Ana20f whereStabi($value)
 * @method static Builder|Ana20f whereStaciv($value)
 * @method static Builder|Ana20f whereStass($value)
 * @method static Builder|Ana20f whereStdim($value)
 * @method static Builder|Ana20f whereTipag($value)
 * @method static Builder|Ana20f whereTipasp($value)
 * @method static Builder|Ana20f whereTipass($value)
 * @method static Builder|Ana20f whereTipco($value)
 * @method static Builder|Ana20f whereTipdim($value)
 * @method static Builder|Ana20f whereTiprec($value)
 * @method static Builder|Ana20f whereTitpro($value)
 * @method static Builder|Ana20f whereTitstu($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ana20fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ana20f extends BaseModel
{
    protected $table = 'ana20f';
}
