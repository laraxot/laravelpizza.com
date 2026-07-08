<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ana20l01.
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
 * @method static Builder|Ana20l01 newModelQuery()
 * @method static Builder|Ana20l01 newQuery()
 * @method static Builder|Ana20l01 query()
 * @method static Builder|Ana20l01 whereAgen1($value)
 * @method static Builder|Ana20l01 whereAnaann($value)
 * @method static Builder|Ana20l01 whereAnnise($value)
 * @method static Builder|Ana20l01 whereAspin($value)
 * @method static Builder|Ana20l01 whereAspte($value)
 * @method static Builder|Ana20l01 whereBanca1($value)
 * @method static Builder|Ana20l01 whereCatspe($value)
 * @method static Builder|Ana20l01 whereClafun($value)
 * @method static Builder|Ana20l01 whereCodqua($value)
 * @method static Builder|Ana20l01 whereConome($value)
 * @method static Builder|Ana20l01 whereCont($value)
 * @method static Builder|Ana20l01 whereConto1($value)
 * @method static Builder|Ana20l01 whereDatal($value)
 * @method static Builder|Ana20l01 whereDatdal($value)
 * @method static Builder|Ana20l01 whereDatpas($value)
 * @method static Builder|Ana20l01 whereDisci1($value)
 * @method static Builder|Ana20l01 whereEnte($value)
 * @method static Builder|Ana20l01 whereEntpro($value)
 * @method static Builder|Ana20l01 whereFlagse($value)
 * @method static Builder|Ana20l01 whereId($value)
 * @method static Builder|Ana20l01 whereInail($value)
 * @method static Builder|Ana20l01 whereJapp($value)
 * @method static Builder|Ana20l01 whereJipco($value)
 * @method static Builder|Ana20l01 whereJisci2($value)
 * @method static Builder|Ana20l01 whereJodqua($value)
 * @method static Builder|Ana20l01 whereJosfun($value)
 * @method static Builder|Ana20l01 whereJropro($value)
 * @method static Builder|Ana20l01 whereJuolo($value)
 * @method static Builder|Ana20l01 whereMatr($value)
 * @method static Builder|Ana20l01 whereNome($value)
 * @method static Builder|Ana20l01 whereOree($value)
 * @method static Builder|Ana20l01 whereOret($value)
 * @method static Builder|Ana20l01 wherePiaorg($value)
 * @method static Builder|Ana20l01 wherePosfun($value)
 * @method static Builder|Ana20l01 wherePosiz($value)
 * @method static Builder|Ana20l01 wherePropro($value)
 * @method static Builder|Ana20l01 whereQual($value)
 * @method static Builder|Ana20l01 whereQuanz($value)
 * @method static Builder|Ana20l01 whereQudal($value)
 * @method static Builder|Ana20l01 whereRapp($value)
 * @method static Builder|Ana20l01 whereRepal($value)
 * @method static Builder|Ana20l01 whereRepar($value)
 * @method static Builder|Ana20l01 whereRepdal($value)
 * @method static Builder|Ana20l01 whereRepre1($value)
 * @method static Builder|Ana20l01 whereRepre2($value)
 * @method static Builder|Ana20l01 whereRepst1($value)
 * @method static Builder|Ana20l01 whereRepst2($value)
 * @method static Builder|Ana20l01 whereRuolo($value)
 * @method static Builder|Ana20l01 whereSesso($value)
 * @method static Builder|Ana20l01 whereSindac($value)
 * @method static Builder|Ana20l01 whereStabi($value)
 * @method static Builder|Ana20l01 whereStaciv($value)
 * @method static Builder|Ana20l01 whereStass($value)
 * @method static Builder|Ana20l01 whereStdim($value)
 * @method static Builder|Ana20l01 whereTipag($value)
 * @method static Builder|Ana20l01 whereTipasp($value)
 * @method static Builder|Ana20l01 whereTipass($value)
 * @method static Builder|Ana20l01 whereTipco($value)
 * @method static Builder|Ana20l01 whereTipdim($value)
 * @method static Builder|Ana20l01 whereTiprec($value)
 * @method static Builder|Ana20l01 whereTitpro($value)
 * @method static Builder|Ana20l01 whereTitstu($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ana20l01Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ana20l01 extends BaseModel
{
    protected $table = 'ana20l01';
}
