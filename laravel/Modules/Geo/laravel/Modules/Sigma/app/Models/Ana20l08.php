<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ana20l08.
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
 * @method static Builder|Ana20l08 newModelQuery()
 * @method static Builder|Ana20l08 newQuery()
 * @method static Builder|Ana20l08 query()
 * @method static Builder|Ana20l08 whereAgen1($value)
 * @method static Builder|Ana20l08 whereAnaann($value)
 * @method static Builder|Ana20l08 whereAnnise($value)
 * @method static Builder|Ana20l08 whereAspin($value)
 * @method static Builder|Ana20l08 whereAspte($value)
 * @method static Builder|Ana20l08 whereBanca1($value)
 * @method static Builder|Ana20l08 whereCatspe($value)
 * @method static Builder|Ana20l08 whereClafun($value)
 * @method static Builder|Ana20l08 whereCodqua($value)
 * @method static Builder|Ana20l08 whereConome($value)
 * @method static Builder|Ana20l08 whereCont($value)
 * @method static Builder|Ana20l08 whereConto1($value)
 * @method static Builder|Ana20l08 whereDatal($value)
 * @method static Builder|Ana20l08 whereDatdal($value)
 * @method static Builder|Ana20l08 whereDatpas($value)
 * @method static Builder|Ana20l08 whereDisci1($value)
 * @method static Builder|Ana20l08 whereEnte($value)
 * @method static Builder|Ana20l08 whereEntpro($value)
 * @method static Builder|Ana20l08 whereFlagse($value)
 * @method static Builder|Ana20l08 whereId($value)
 * @method static Builder|Ana20l08 whereInail($value)
 * @method static Builder|Ana20l08 whereJapp($value)
 * @method static Builder|Ana20l08 whereJipco($value)
 * @method static Builder|Ana20l08 whereJisci2($value)
 * @method static Builder|Ana20l08 whereJodqua($value)
 * @method static Builder|Ana20l08 whereJosfun($value)
 * @method static Builder|Ana20l08 whereJropro($value)
 * @method static Builder|Ana20l08 whereJuolo($value)
 * @method static Builder|Ana20l08 whereMatr($value)
 * @method static Builder|Ana20l08 whereNome($value)
 * @method static Builder|Ana20l08 whereOree($value)
 * @method static Builder|Ana20l08 whereOret($value)
 * @method static Builder|Ana20l08 wherePiaorg($value)
 * @method static Builder|Ana20l08 wherePosfun($value)
 * @method static Builder|Ana20l08 wherePosiz($value)
 * @method static Builder|Ana20l08 wherePropro($value)
 * @method static Builder|Ana20l08 whereQual($value)
 * @method static Builder|Ana20l08 whereQuanz($value)
 * @method static Builder|Ana20l08 whereQudal($value)
 * @method static Builder|Ana20l08 whereRapp($value)
 * @method static Builder|Ana20l08 whereRepal($value)
 * @method static Builder|Ana20l08 whereRepar($value)
 * @method static Builder|Ana20l08 whereRepdal($value)
 * @method static Builder|Ana20l08 whereRepre1($value)
 * @method static Builder|Ana20l08 whereRepre2($value)
 * @method static Builder|Ana20l08 whereRepst1($value)
 * @method static Builder|Ana20l08 whereRepst2($value)
 * @method static Builder|Ana20l08 whereRuolo($value)
 * @method static Builder|Ana20l08 whereSesso($value)
 * @method static Builder|Ana20l08 whereSindac($value)
 * @method static Builder|Ana20l08 whereStabi($value)
 * @method static Builder|Ana20l08 whereStaciv($value)
 * @method static Builder|Ana20l08 whereStass($value)
 * @method static Builder|Ana20l08 whereStdim($value)
 * @method static Builder|Ana20l08 whereTipag($value)
 * @method static Builder|Ana20l08 whereTipasp($value)
 * @method static Builder|Ana20l08 whereTipass($value)
 * @method static Builder|Ana20l08 whereTipco($value)
 * @method static Builder|Ana20l08 whereTipdim($value)
 * @method static Builder|Ana20l08 whereTiprec($value)
 * @method static Builder|Ana20l08 whereTitpro($value)
 * @method static Builder|Ana20l08 whereTitstu($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ana20l08Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ana20l08 extends BaseModel
{
    protected $table = 'ana20l08';
}
