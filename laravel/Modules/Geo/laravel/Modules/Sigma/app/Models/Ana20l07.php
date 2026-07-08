<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ana20l07.
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
 * @method static Builder|Ana20l07 newModelQuery()
 * @method static Builder|Ana20l07 newQuery()
 * @method static Builder|Ana20l07 query()
 * @method static Builder|Ana20l07 whereAgen1($value)
 * @method static Builder|Ana20l07 whereAnaann($value)
 * @method static Builder|Ana20l07 whereAnnise($value)
 * @method static Builder|Ana20l07 whereAspin($value)
 * @method static Builder|Ana20l07 whereAspte($value)
 * @method static Builder|Ana20l07 whereBanca1($value)
 * @method static Builder|Ana20l07 whereCatspe($value)
 * @method static Builder|Ana20l07 whereClafun($value)
 * @method static Builder|Ana20l07 whereCodqua($value)
 * @method static Builder|Ana20l07 whereConome($value)
 * @method static Builder|Ana20l07 whereCont($value)
 * @method static Builder|Ana20l07 whereConto1($value)
 * @method static Builder|Ana20l07 whereDatal($value)
 * @method static Builder|Ana20l07 whereDatdal($value)
 * @method static Builder|Ana20l07 whereDatpas($value)
 * @method static Builder|Ana20l07 whereDisci1($value)
 * @method static Builder|Ana20l07 whereEnte($value)
 * @method static Builder|Ana20l07 whereEntpro($value)
 * @method static Builder|Ana20l07 whereFlagse($value)
 * @method static Builder|Ana20l07 whereId($value)
 * @method static Builder|Ana20l07 whereInail($value)
 * @method static Builder|Ana20l07 whereJapp($value)
 * @method static Builder|Ana20l07 whereJipco($value)
 * @method static Builder|Ana20l07 whereJisci2($value)
 * @method static Builder|Ana20l07 whereJodqua($value)
 * @method static Builder|Ana20l07 whereJosfun($value)
 * @method static Builder|Ana20l07 whereJropro($value)
 * @method static Builder|Ana20l07 whereJuolo($value)
 * @method static Builder|Ana20l07 whereMatr($value)
 * @method static Builder|Ana20l07 whereNome($value)
 * @method static Builder|Ana20l07 whereOree($value)
 * @method static Builder|Ana20l07 whereOret($value)
 * @method static Builder|Ana20l07 wherePiaorg($value)
 * @method static Builder|Ana20l07 wherePosfun($value)
 * @method static Builder|Ana20l07 wherePosiz($value)
 * @method static Builder|Ana20l07 wherePropro($value)
 * @method static Builder|Ana20l07 whereQual($value)
 * @method static Builder|Ana20l07 whereQuanz($value)
 * @method static Builder|Ana20l07 whereQudal($value)
 * @method static Builder|Ana20l07 whereRapp($value)
 * @method static Builder|Ana20l07 whereRepal($value)
 * @method static Builder|Ana20l07 whereRepar($value)
 * @method static Builder|Ana20l07 whereRepdal($value)
 * @method static Builder|Ana20l07 whereRepre1($value)
 * @method static Builder|Ana20l07 whereRepre2($value)
 * @method static Builder|Ana20l07 whereRepst1($value)
 * @method static Builder|Ana20l07 whereRepst2($value)
 * @method static Builder|Ana20l07 whereRuolo($value)
 * @method static Builder|Ana20l07 whereSesso($value)
 * @method static Builder|Ana20l07 whereSindac($value)
 * @method static Builder|Ana20l07 whereStabi($value)
 * @method static Builder|Ana20l07 whereStaciv($value)
 * @method static Builder|Ana20l07 whereStass($value)
 * @method static Builder|Ana20l07 whereStdim($value)
 * @method static Builder|Ana20l07 whereTipag($value)
 * @method static Builder|Ana20l07 whereTipasp($value)
 * @method static Builder|Ana20l07 whereTipass($value)
 * @method static Builder|Ana20l07 whereTipco($value)
 * @method static Builder|Ana20l07 whereTipdim($value)
 * @method static Builder|Ana20l07 whereTiprec($value)
 * @method static Builder|Ana20l07 whereTitpro($value)
 * @method static Builder|Ana20l07 whereTitstu($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ana20l07Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ana20l07 extends BaseModel
{
    protected $table = 'ana20l07';
}
