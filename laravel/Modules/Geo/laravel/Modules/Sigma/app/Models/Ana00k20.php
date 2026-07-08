<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ana00k20.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $conome
 * @property string|null $nome
 * @property string|null $cogacq
 * @property string|null $sesso
 * @property string|null $codfis
 * @property string|null $staciv
 * @property string|null $anadat
 * @property string|null $comnas
 * @property string|null $clafun
 * @property string|null $titstu
 * @property string|null $entpro
 * @property string|null $sinda
 * @property string|null $sinda2
 * @property string|null $sinda3
 * @property string|null $catspe
 * @property string|null $titpro
 * @property string|null $topo
 * @property string|null $indir
 * @property string|null $locres
 * @property string|null $comres
 * @property string|null $cap
 * @property string|null $topod
 * @property string|null $indird
 * @property string|null $locdom
 * @property string|null $comdom
 * @property string|null $capdom
 * @property string|null $pretel
 * @property string|null $numtel
 * @property string|null $tipag
 * @property string|null $stabi
 * @property string|null $repar
 * @property string|null $banca1
 * @property string|null $agen1
 * @property string|null $conto1
 * @property string|null $banca2
 * @property string|null $agen2
 * @property string|null $conto2
 * @property string|null $imp2
 * @property string|null $codass
 * @property string|null $codpre
 * @property string|null $codic1
 * @property string|null $codic2
 * @property string|null $inail
 * @property string|null $matseg
 * @property string|null $tipdip
 * @property string|null $fematc
 * @property string|null $fegodc
 * @property string|null $fesopm
 * @property string|null $fesopg
 * @property string|null $femata
 * @property string|null $fegoda
 * @property string|null $flagse
 * @property string|null $anaann
 * @property string|null $lireu
 * @property string|null $ana2kd
 * @property string|null $impeu
 * @property string|null $comna2
 * @property string|null $comre2
 * @property string|null $comdo2
 *
 * @method static Builder|Ana00k20 newModelQuery()
 * @method static Builder|Ana00k20 newQuery()
 * @method static Builder|Ana00k20 query()
 * @method static Builder|Ana00k20 whereAgen1($value)
 * @method static Builder|Ana00k20 whereAgen2($value)
 * @method static Builder|Ana00k20 whereAna2kd($value)
 * @method static Builder|Ana00k20 whereAnaann($value)
 * @method static Builder|Ana00k20 whereAnadat($value)
 * @method static Builder|Ana00k20 whereBanca1($value)
 * @method static Builder|Ana00k20 whereBanca2($value)
 * @method static Builder|Ana00k20 whereCap($value)
 * @method static Builder|Ana00k20 whereCapdom($value)
 * @method static Builder|Ana00k20 whereCatspe($value)
 * @method static Builder|Ana00k20 whereClafun($value)
 * @method static Builder|Ana00k20 whereCodass($value)
 * @method static Builder|Ana00k20 whereCodfis($value)
 * @method static Builder|Ana00k20 whereCodic1($value)
 * @method static Builder|Ana00k20 whereCodic2($value)
 * @method static Builder|Ana00k20 whereCodpre($value)
 * @method static Builder|Ana00k20 whereCogacq($value)
 * @method static Builder|Ana00k20 whereComdo2($value)
 * @method static Builder|Ana00k20 whereComdom($value)
 * @method static Builder|Ana00k20 whereComna2($value)
 * @method static Builder|Ana00k20 whereComnas($value)
 * @method static Builder|Ana00k20 whereComre2($value)
 * @method static Builder|Ana00k20 whereComres($value)
 * @method static Builder|Ana00k20 whereConome($value)
 * @method static Builder|Ana00k20 whereConto1($value)
 * @method static Builder|Ana00k20 whereConto2($value)
 * @method static Builder|Ana00k20 whereEnte($value)
 * @method static Builder|Ana00k20 whereEntpro($value)
 * @method static Builder|Ana00k20 whereFegoda($value)
 * @method static Builder|Ana00k20 whereFegodc($value)
 * @method static Builder|Ana00k20 whereFemata($value)
 * @method static Builder|Ana00k20 whereFematc($value)
 * @method static Builder|Ana00k20 whereFesopg($value)
 * @method static Builder|Ana00k20 whereFesopm($value)
 * @method static Builder|Ana00k20 whereFlagse($value)
 * @method static Builder|Ana00k20 whereId($value)
 * @method static Builder|Ana00k20 whereImp2($value)
 * @method static Builder|Ana00k20 whereImpeu($value)
 * @method static Builder|Ana00k20 whereInail($value)
 * @method static Builder|Ana00k20 whereIndir($value)
 * @method static Builder|Ana00k20 whereIndird($value)
 * @method static Builder|Ana00k20 whereLireu($value)
 * @method static Builder|Ana00k20 whereLocdom($value)
 * @method static Builder|Ana00k20 whereLocres($value)
 * @method static Builder|Ana00k20 whereMatr($value)
 * @method static Builder|Ana00k20 whereMatseg($value)
 * @method static Builder|Ana00k20 whereNome($value)
 * @method static Builder|Ana00k20 whereNumtel($value)
 * @method static Builder|Ana00k20 wherePretel($value)
 * @method static Builder|Ana00k20 whereRepar($value)
 * @method static Builder|Ana00k20 whereSesso($value)
 * @method static Builder|Ana00k20 whereSinda($value)
 * @method static Builder|Ana00k20 whereSinda2($value)
 * @method static Builder|Ana00k20 whereSinda3($value)
 * @method static Builder|Ana00k20 whereStabi($value)
 * @method static Builder|Ana00k20 whereStaciv($value)
 * @method static Builder|Ana00k20 whereTipag($value)
 * @method static Builder|Ana00k20 whereTipdip($value)
 * @method static Builder|Ana00k20 whereTitpro($value)
 * @method static Builder|Ana00k20 whereTitstu($value)
 * @method static Builder|Ana00k20 whereTopo($value)
 * @method static Builder|Ana00k20 whereTopod($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ana00k20Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ana00k20 extends BaseModel
{
    protected $table = 'ana00k20';
}
