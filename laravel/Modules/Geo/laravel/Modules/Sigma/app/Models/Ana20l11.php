<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ana20l11.
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
 * @method static Builder|Ana20l11 newModelQuery()
 * @method static Builder|Ana20l11 newQuery()
 * @method static Builder|Ana20l11 query()
 * @method static Builder|Ana20l11 whereAgen1($value)
 * @method static Builder|Ana20l11 whereAnaann($value)
 * @method static Builder|Ana20l11 whereAnnise($value)
 * @method static Builder|Ana20l11 whereAspin($value)
 * @method static Builder|Ana20l11 whereAspte($value)
 * @method static Builder|Ana20l11 whereBanca1($value)
 * @method static Builder|Ana20l11 whereCatspe($value)
 * @method static Builder|Ana20l11 whereClafun($value)
 * @method static Builder|Ana20l11 whereCodqua($value)
 * @method static Builder|Ana20l11 whereConome($value)
 * @method static Builder|Ana20l11 whereCont($value)
 * @method static Builder|Ana20l11 whereConto1($value)
 * @method static Builder|Ana20l11 whereDatal($value)
 * @method static Builder|Ana20l11 whereDatdal($value)
 * @method static Builder|Ana20l11 whereDatpas($value)
 * @method static Builder|Ana20l11 whereDisci1($value)
 * @method static Builder|Ana20l11 whereEnte($value)
 * @method static Builder|Ana20l11 whereEntpro($value)
 * @method static Builder|Ana20l11 whereFlagse($value)
 * @method static Builder|Ana20l11 whereId($value)
 * @method static Builder|Ana20l11 whereInail($value)
 * @method static Builder|Ana20l11 whereJapp($value)
 * @method static Builder|Ana20l11 whereJipco($value)
 * @method static Builder|Ana20l11 whereJisci2($value)
 * @method static Builder|Ana20l11 whereJodqua($value)
 * @method static Builder|Ana20l11 whereJosfun($value)
 * @method static Builder|Ana20l11 whereJropro($value)
 * @method static Builder|Ana20l11 whereJuolo($value)
 * @method static Builder|Ana20l11 whereMatr($value)
 * @method static Builder|Ana20l11 whereNome($value)
 * @method static Builder|Ana20l11 whereOree($value)
 * @method static Builder|Ana20l11 whereOret($value)
 * @method static Builder|Ana20l11 wherePiaorg($value)
 * @method static Builder|Ana20l11 wherePosfun($value)
 * @method static Builder|Ana20l11 wherePosiz($value)
 * @method static Builder|Ana20l11 wherePropro($value)
 * @method static Builder|Ana20l11 whereQual($value)
 * @method static Builder|Ana20l11 whereQuanz($value)
 * @method static Builder|Ana20l11 whereQudal($value)
 * @method static Builder|Ana20l11 whereRapp($value)
 * @method static Builder|Ana20l11 whereRepal($value)
 * @method static Builder|Ana20l11 whereRepar($value)
 * @method static Builder|Ana20l11 whereRepdal($value)
 * @method static Builder|Ana20l11 whereRepre1($value)
 * @method static Builder|Ana20l11 whereRepre2($value)
 * @method static Builder|Ana20l11 whereRepst1($value)
 * @method static Builder|Ana20l11 whereRepst2($value)
 * @method static Builder|Ana20l11 whereRuolo($value)
 * @method static Builder|Ana20l11 whereSesso($value)
 * @method static Builder|Ana20l11 whereSindac($value)
 * @method static Builder|Ana20l11 whereStabi($value)
 * @method static Builder|Ana20l11 whereStaciv($value)
 * @method static Builder|Ana20l11 whereStass($value)
 * @method static Builder|Ana20l11 whereStdim($value)
 * @method static Builder|Ana20l11 whereTipag($value)
 * @method static Builder|Ana20l11 whereTipasp($value)
 * @method static Builder|Ana20l11 whereTipass($value)
 * @method static Builder|Ana20l11 whereTipco($value)
 * @method static Builder|Ana20l11 whereTipdim($value)
 * @method static Builder|Ana20l11 whereTiprec($value)
 * @method static Builder|Ana20l11 whereTitpro($value)
 * @method static Builder|Ana20l11 whereTitstu($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ana20l11Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ana20l11 extends BaseModel
{
    protected $table = 'ana20l11';
}
