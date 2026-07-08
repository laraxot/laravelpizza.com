<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ana00f.
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
 *
 * @method static Builder|Ana00f newModelQuery()
 * @method static Builder|Ana00f newQuery()
 * @method static Builder|Ana00f query()
 * @method static Builder|Ana00f whereAgen1($value)
 * @method static Builder|Ana00f whereAgen2($value)
 * @method static Builder|Ana00f whereAnaann($value)
 * @method static Builder|Ana00f whereAnadat($value)
 * @method static Builder|Ana00f whereBanca1($value)
 * @method static Builder|Ana00f whereBanca2($value)
 * @method static Builder|Ana00f whereCap($value)
 * @method static Builder|Ana00f whereCapdom($value)
 * @method static Builder|Ana00f whereCatspe($value)
 * @method static Builder|Ana00f whereClafun($value)
 * @method static Builder|Ana00f whereCodass($value)
 * @method static Builder|Ana00f whereCodfis($value)
 * @method static Builder|Ana00f whereCodic1($value)
 * @method static Builder|Ana00f whereCodic2($value)
 * @method static Builder|Ana00f whereCodpre($value)
 * @method static Builder|Ana00f whereCogacq($value)
 * @method static Builder|Ana00f whereComdom($value)
 * @method static Builder|Ana00f whereComnas($value)
 * @method static Builder|Ana00f whereComres($value)
 * @method static Builder|Ana00f whereConome($value)
 * @method static Builder|Ana00f whereConto1($value)
 * @method static Builder|Ana00f whereConto2($value)
 * @method static Builder|Ana00f whereEnte($value)
 * @method static Builder|Ana00f whereEntpro($value)
 * @method static Builder|Ana00f whereFegoda($value)
 * @method static Builder|Ana00f whereFegodc($value)
 * @method static Builder|Ana00f whereFemata($value)
 * @method static Builder|Ana00f whereFematc($value)
 * @method static Builder|Ana00f whereFesopg($value)
 * @method static Builder|Ana00f whereFesopm($value)
 * @method static Builder|Ana00f whereFlagse($value)
 * @method static Builder|Ana00f whereId($value)
 * @method static Builder|Ana00f whereImp2($value)
 * @method static Builder|Ana00f whereInail($value)
 * @method static Builder|Ana00f whereIndir($value)
 * @method static Builder|Ana00f whereIndird($value)
 * @method static Builder|Ana00f whereLocdom($value)
 * @method static Builder|Ana00f whereLocres($value)
 * @method static Builder|Ana00f whereMatr($value)
 * @method static Builder|Ana00f whereMatseg($value)
 * @method static Builder|Ana00f whereNome($value)
 * @method static Builder|Ana00f whereNumtel($value)
 * @method static Builder|Ana00f wherePretel($value)
 * @method static Builder|Ana00f whereRepar($value)
 * @method static Builder|Ana00f whereSesso($value)
 * @method static Builder|Ana00f whereSinda($value)
 * @method static Builder|Ana00f whereSinda2($value)
 * @method static Builder|Ana00f whereSinda3($value)
 * @method static Builder|Ana00f whereStabi($value)
 * @method static Builder|Ana00f whereStaciv($value)
 * @method static Builder|Ana00f whereTipag($value)
 * @method static Builder|Ana00f whereTipdip($value)
 * @method static Builder|Ana00f whereTitpro($value)
 * @method static Builder|Ana00f whereTitstu($value)
 * @method static Builder|Ana00f whereTopo($value)
 * @method static Builder|Ana00f whereTopod($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ana00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ana00f extends BaseModel
{
    protected $table = 'ana00f';
}
