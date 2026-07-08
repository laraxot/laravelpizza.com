<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ana20l09.
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
 * @method static Builder|Ana20l09 newModelQuery()
 * @method static Builder|Ana20l09 newQuery()
 * @method static Builder|Ana20l09 query()
 * @method static Builder|Ana20l09 whereAgen1($value)
 * @method static Builder|Ana20l09 whereAnaann($value)
 * @method static Builder|Ana20l09 whereAnnise($value)
 * @method static Builder|Ana20l09 whereAspin($value)
 * @method static Builder|Ana20l09 whereAspte($value)
 * @method static Builder|Ana20l09 whereBanca1($value)
 * @method static Builder|Ana20l09 whereCatspe($value)
 * @method static Builder|Ana20l09 whereClafun($value)
 * @method static Builder|Ana20l09 whereCodqua($value)
 * @method static Builder|Ana20l09 whereConome($value)
 * @method static Builder|Ana20l09 whereCont($value)
 * @method static Builder|Ana20l09 whereConto1($value)
 * @method static Builder|Ana20l09 whereDatal($value)
 * @method static Builder|Ana20l09 whereDatdal($value)
 * @method static Builder|Ana20l09 whereDatpas($value)
 * @method static Builder|Ana20l09 whereDisci1($value)
 * @method static Builder|Ana20l09 whereEnte($value)
 * @method static Builder|Ana20l09 whereEntpro($value)
 * @method static Builder|Ana20l09 whereFlagse($value)
 * @method static Builder|Ana20l09 whereId($value)
 * @method static Builder|Ana20l09 whereInail($value)
 * @method static Builder|Ana20l09 whereJapp($value)
 * @method static Builder|Ana20l09 whereJipco($value)
 * @method static Builder|Ana20l09 whereJisci2($value)
 * @method static Builder|Ana20l09 whereJodqua($value)
 * @method static Builder|Ana20l09 whereJosfun($value)
 * @method static Builder|Ana20l09 whereJropro($value)
 * @method static Builder|Ana20l09 whereJuolo($value)
 * @method static Builder|Ana20l09 whereMatr($value)
 * @method static Builder|Ana20l09 whereNome($value)
 * @method static Builder|Ana20l09 whereOree($value)
 * @method static Builder|Ana20l09 whereOret($value)
 * @method static Builder|Ana20l09 wherePiaorg($value)
 * @method static Builder|Ana20l09 wherePosfun($value)
 * @method static Builder|Ana20l09 wherePosiz($value)
 * @method static Builder|Ana20l09 wherePropro($value)
 * @method static Builder|Ana20l09 whereQual($value)
 * @method static Builder|Ana20l09 whereQuanz($value)
 * @method static Builder|Ana20l09 whereQudal($value)
 * @method static Builder|Ana20l09 whereRapp($value)
 * @method static Builder|Ana20l09 whereRepal($value)
 * @method static Builder|Ana20l09 whereRepar($value)
 * @method static Builder|Ana20l09 whereRepdal($value)
 * @method static Builder|Ana20l09 whereRepre1($value)
 * @method static Builder|Ana20l09 whereRepre2($value)
 * @method static Builder|Ana20l09 whereRepst1($value)
 * @method static Builder|Ana20l09 whereRepst2($value)
 * @method static Builder|Ana20l09 whereRuolo($value)
 * @method static Builder|Ana20l09 whereSesso($value)
 * @method static Builder|Ana20l09 whereSindac($value)
 * @method static Builder|Ana20l09 whereStabi($value)
 * @method static Builder|Ana20l09 whereStaciv($value)
 * @method static Builder|Ana20l09 whereStass($value)
 * @method static Builder|Ana20l09 whereStdim($value)
 * @method static Builder|Ana20l09 whereTipag($value)
 * @method static Builder|Ana20l09 whereTipasp($value)
 * @method static Builder|Ana20l09 whereTipass($value)
 * @method static Builder|Ana20l09 whereTipco($value)
 * @method static Builder|Ana20l09 whereTipdim($value)
 * @method static Builder|Ana20l09 whereTiprec($value)
 * @method static Builder|Ana20l09 whereTitpro($value)
 * @method static Builder|Ana20l09 whereTitstu($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ana20l09Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ana20l09 extends BaseModel
{
    protected $table = 'ana20l09';
}
