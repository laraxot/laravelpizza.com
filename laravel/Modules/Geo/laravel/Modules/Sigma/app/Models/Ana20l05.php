<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ana20l05.
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
 * @method static Builder|Ana20l05 newModelQuery()
 * @method static Builder|Ana20l05 newQuery()
 * @method static Builder|Ana20l05 query()
 * @method static Builder|Ana20l05 whereAgen1($value)
 * @method static Builder|Ana20l05 whereAnaann($value)
 * @method static Builder|Ana20l05 whereAnnise($value)
 * @method static Builder|Ana20l05 whereAspin($value)
 * @method static Builder|Ana20l05 whereAspte($value)
 * @method static Builder|Ana20l05 whereBanca1($value)
 * @method static Builder|Ana20l05 whereCatspe($value)
 * @method static Builder|Ana20l05 whereClafun($value)
 * @method static Builder|Ana20l05 whereCodqua($value)
 * @method static Builder|Ana20l05 whereConome($value)
 * @method static Builder|Ana20l05 whereCont($value)
 * @method static Builder|Ana20l05 whereConto1($value)
 * @method static Builder|Ana20l05 whereDatal($value)
 * @method static Builder|Ana20l05 whereDatdal($value)
 * @method static Builder|Ana20l05 whereDatpas($value)
 * @method static Builder|Ana20l05 whereDisci1($value)
 * @method static Builder|Ana20l05 whereEnte($value)
 * @method static Builder|Ana20l05 whereEntpro($value)
 * @method static Builder|Ana20l05 whereFlagse($value)
 * @method static Builder|Ana20l05 whereId($value)
 * @method static Builder|Ana20l05 whereInail($value)
 * @method static Builder|Ana20l05 whereJapp($value)
 * @method static Builder|Ana20l05 whereJipco($value)
 * @method static Builder|Ana20l05 whereJisci2($value)
 * @method static Builder|Ana20l05 whereJodqua($value)
 * @method static Builder|Ana20l05 whereJosfun($value)
 * @method static Builder|Ana20l05 whereJropro($value)
 * @method static Builder|Ana20l05 whereJuolo($value)
 * @method static Builder|Ana20l05 whereMatr($value)
 * @method static Builder|Ana20l05 whereNome($value)
 * @method static Builder|Ana20l05 whereOree($value)
 * @method static Builder|Ana20l05 whereOret($value)
 * @method static Builder|Ana20l05 wherePiaorg($value)
 * @method static Builder|Ana20l05 wherePosfun($value)
 * @method static Builder|Ana20l05 wherePosiz($value)
 * @method static Builder|Ana20l05 wherePropro($value)
 * @method static Builder|Ana20l05 whereQual($value)
 * @method static Builder|Ana20l05 whereQuanz($value)
 * @method static Builder|Ana20l05 whereQudal($value)
 * @method static Builder|Ana20l05 whereRapp($value)
 * @method static Builder|Ana20l05 whereRepal($value)
 * @method static Builder|Ana20l05 whereRepar($value)
 * @method static Builder|Ana20l05 whereRepdal($value)
 * @method static Builder|Ana20l05 whereRepre1($value)
 * @method static Builder|Ana20l05 whereRepre2($value)
 * @method static Builder|Ana20l05 whereRepst1($value)
 * @method static Builder|Ana20l05 whereRepst2($value)
 * @method static Builder|Ana20l05 whereRuolo($value)
 * @method static Builder|Ana20l05 whereSesso($value)
 * @method static Builder|Ana20l05 whereSindac($value)
 * @method static Builder|Ana20l05 whereStabi($value)
 * @method static Builder|Ana20l05 whereStaciv($value)
 * @method static Builder|Ana20l05 whereStass($value)
 * @method static Builder|Ana20l05 whereStdim($value)
 * @method static Builder|Ana20l05 whereTipag($value)
 * @method static Builder|Ana20l05 whereTipasp($value)
 * @method static Builder|Ana20l05 whereTipass($value)
 * @method static Builder|Ana20l05 whereTipco($value)
 * @method static Builder|Ana20l05 whereTipdim($value)
 * @method static Builder|Ana20l05 whereTiprec($value)
 * @method static Builder|Ana20l05 whereTitpro($value)
 * @method static Builder|Ana20l05 whereTitstu($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ana20l05Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ana20l05 extends BaseModel
{
    protected $table = 'ana20l05';
}
