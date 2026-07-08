<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ana20l03.
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
 * @method static Builder|Ana20l03 newModelQuery()
 * @method static Builder|Ana20l03 newQuery()
 * @method static Builder|Ana20l03 query()
 * @method static Builder|Ana20l03 whereAgen1($value)
 * @method static Builder|Ana20l03 whereAnaann($value)
 * @method static Builder|Ana20l03 whereAnnise($value)
 * @method static Builder|Ana20l03 whereAspin($value)
 * @method static Builder|Ana20l03 whereAspte($value)
 * @method static Builder|Ana20l03 whereBanca1($value)
 * @method static Builder|Ana20l03 whereCatspe($value)
 * @method static Builder|Ana20l03 whereClafun($value)
 * @method static Builder|Ana20l03 whereCodqua($value)
 * @method static Builder|Ana20l03 whereConome($value)
 * @method static Builder|Ana20l03 whereCont($value)
 * @method static Builder|Ana20l03 whereConto1($value)
 * @method static Builder|Ana20l03 whereDatal($value)
 * @method static Builder|Ana20l03 whereDatdal($value)
 * @method static Builder|Ana20l03 whereDatpas($value)
 * @method static Builder|Ana20l03 whereDisci1($value)
 * @method static Builder|Ana20l03 whereEnte($value)
 * @method static Builder|Ana20l03 whereEntpro($value)
 * @method static Builder|Ana20l03 whereFlagse($value)
 * @method static Builder|Ana20l03 whereId($value)
 * @method static Builder|Ana20l03 whereInail($value)
 * @method static Builder|Ana20l03 whereJapp($value)
 * @method static Builder|Ana20l03 whereJipco($value)
 * @method static Builder|Ana20l03 whereJisci2($value)
 * @method static Builder|Ana20l03 whereJodqua($value)
 * @method static Builder|Ana20l03 whereJosfun($value)
 * @method static Builder|Ana20l03 whereJropro($value)
 * @method static Builder|Ana20l03 whereJuolo($value)
 * @method static Builder|Ana20l03 whereMatr($value)
 * @method static Builder|Ana20l03 whereNome($value)
 * @method static Builder|Ana20l03 whereOree($value)
 * @method static Builder|Ana20l03 whereOret($value)
 * @method static Builder|Ana20l03 wherePiaorg($value)
 * @method static Builder|Ana20l03 wherePosfun($value)
 * @method static Builder|Ana20l03 wherePosiz($value)
 * @method static Builder|Ana20l03 wherePropro($value)
 * @method static Builder|Ana20l03 whereQual($value)
 * @method static Builder|Ana20l03 whereQuanz($value)
 * @method static Builder|Ana20l03 whereQudal($value)
 * @method static Builder|Ana20l03 whereRapp($value)
 * @method static Builder|Ana20l03 whereRepal($value)
 * @method static Builder|Ana20l03 whereRepar($value)
 * @method static Builder|Ana20l03 whereRepdal($value)
 * @method static Builder|Ana20l03 whereRepre1($value)
 * @method static Builder|Ana20l03 whereRepre2($value)
 * @method static Builder|Ana20l03 whereRepst1($value)
 * @method static Builder|Ana20l03 whereRepst2($value)
 * @method static Builder|Ana20l03 whereRuolo($value)
 * @method static Builder|Ana20l03 whereSesso($value)
 * @method static Builder|Ana20l03 whereSindac($value)
 * @method static Builder|Ana20l03 whereStabi($value)
 * @method static Builder|Ana20l03 whereStaciv($value)
 * @method static Builder|Ana20l03 whereStass($value)
 * @method static Builder|Ana20l03 whereStdim($value)
 * @method static Builder|Ana20l03 whereTipag($value)
 * @method static Builder|Ana20l03 whereTipasp($value)
 * @method static Builder|Ana20l03 whereTipass($value)
 * @method static Builder|Ana20l03 whereTipco($value)
 * @method static Builder|Ana20l03 whereTipdim($value)
 * @method static Builder|Ana20l03 whereTiprec($value)
 * @method static Builder|Ana20l03 whereTitpro($value)
 * @method static Builder|Ana20l03 whereTitstu($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ana20l03Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ana20l03 extends BaseModel
{
    protected $table = 'ana20l03';
}
