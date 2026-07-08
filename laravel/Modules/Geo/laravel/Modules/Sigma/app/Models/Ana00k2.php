<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ana00k2.
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
 * @method static Builder|Ana00k2 newModelQuery()
 * @method static Builder|Ana00k2 newQuery()
 * @method static Builder|Ana00k2 query()
 * @method static Builder|Ana00k2 whereAgen1($value)
 * @method static Builder|Ana00k2 whereAgen2($value)
 * @method static Builder|Ana00k2 whereAna2kd($value)
 * @method static Builder|Ana00k2 whereAnaann($value)
 * @method static Builder|Ana00k2 whereAnadat($value)
 * @method static Builder|Ana00k2 whereBanca1($value)
 * @method static Builder|Ana00k2 whereBanca2($value)
 * @method static Builder|Ana00k2 whereCap($value)
 * @method static Builder|Ana00k2 whereCapdom($value)
 * @method static Builder|Ana00k2 whereCatspe($value)
 * @method static Builder|Ana00k2 whereClafun($value)
 * @method static Builder|Ana00k2 whereCodass($value)
 * @method static Builder|Ana00k2 whereCodfis($value)
 * @method static Builder|Ana00k2 whereCodic1($value)
 * @method static Builder|Ana00k2 whereCodic2($value)
 * @method static Builder|Ana00k2 whereCodpre($value)
 * @method static Builder|Ana00k2 whereCogacq($value)
 * @method static Builder|Ana00k2 whereComdo2($value)
 * @method static Builder|Ana00k2 whereComdom($value)
 * @method static Builder|Ana00k2 whereComna2($value)
 * @method static Builder|Ana00k2 whereComnas($value)
 * @method static Builder|Ana00k2 whereComre2($value)
 * @method static Builder|Ana00k2 whereComres($value)
 * @method static Builder|Ana00k2 whereConome($value)
 * @method static Builder|Ana00k2 whereConto1($value)
 * @method static Builder|Ana00k2 whereConto2($value)
 * @method static Builder|Ana00k2 whereEnte($value)
 * @method static Builder|Ana00k2 whereEntpro($value)
 * @method static Builder|Ana00k2 whereFegoda($value)
 * @method static Builder|Ana00k2 whereFegodc($value)
 * @method static Builder|Ana00k2 whereFemata($value)
 * @method static Builder|Ana00k2 whereFematc($value)
 * @method static Builder|Ana00k2 whereFesopg($value)
 * @method static Builder|Ana00k2 whereFesopm($value)
 * @method static Builder|Ana00k2 whereFlagse($value)
 * @method static Builder|Ana00k2 whereId($value)
 * @method static Builder|Ana00k2 whereImp2($value)
 * @method static Builder|Ana00k2 whereImpeu($value)
 * @method static Builder|Ana00k2 whereInail($value)
 * @method static Builder|Ana00k2 whereIndir($value)
 * @method static Builder|Ana00k2 whereIndird($value)
 * @method static Builder|Ana00k2 whereLireu($value)
 * @method static Builder|Ana00k2 whereLocdom($value)
 * @method static Builder|Ana00k2 whereLocres($value)
 * @method static Builder|Ana00k2 whereMatr($value)
 * @method static Builder|Ana00k2 whereMatseg($value)
 * @method static Builder|Ana00k2 whereNome($value)
 * @method static Builder|Ana00k2 whereNumtel($value)
 * @method static Builder|Ana00k2 wherePretel($value)
 * @method static Builder|Ana00k2 whereRepar($value)
 * @method static Builder|Ana00k2 whereSesso($value)
 * @method static Builder|Ana00k2 whereSinda($value)
 * @method static Builder|Ana00k2 whereSinda2($value)
 * @method static Builder|Ana00k2 whereSinda3($value)
 * @method static Builder|Ana00k2 whereStabi($value)
 * @method static Builder|Ana00k2 whereStaciv($value)
 * @method static Builder|Ana00k2 whereTipag($value)
 * @method static Builder|Ana00k2 whereTipdip($value)
 * @method static Builder|Ana00k2 whereTitpro($value)
 * @method static Builder|Ana00k2 whereTitstu($value)
 * @method static Builder|Ana00k2 whereTopo($value)
 * @method static Builder|Ana00k2 whereTopod($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ana00k2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ana00k2 extends BaseModel
{
    protected $table = 'ana00k2';
}
