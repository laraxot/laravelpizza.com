<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Anagdic.
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
 * @method static Builder|Anagdic newModelQuery()
 * @method static Builder|Anagdic newQuery()
 * @method static Builder|Anagdic query()
 * @method static Builder|Anagdic whereAgen1($value)
 * @method static Builder|Anagdic whereAgen2($value)
 * @method static Builder|Anagdic whereAna2kd($value)
 * @method static Builder|Anagdic whereAnaann($value)
 * @method static Builder|Anagdic whereAnadat($value)
 * @method static Builder|Anagdic whereBanca1($value)
 * @method static Builder|Anagdic whereBanca2($value)
 * @method static Builder|Anagdic whereCap($value)
 * @method static Builder|Anagdic whereCapdom($value)
 * @method static Builder|Anagdic whereCatspe($value)
 * @method static Builder|Anagdic whereClafun($value)
 * @method static Builder|Anagdic whereCodass($value)
 * @method static Builder|Anagdic whereCodfis($value)
 * @method static Builder|Anagdic whereCodic1($value)
 * @method static Builder|Anagdic whereCodic2($value)
 * @method static Builder|Anagdic whereCodpre($value)
 * @method static Builder|Anagdic whereCogacq($value)
 * @method static Builder|Anagdic whereComdo2($value)
 * @method static Builder|Anagdic whereComdom($value)
 * @method static Builder|Anagdic whereComna2($value)
 * @method static Builder|Anagdic whereComnas($value)
 * @method static Builder|Anagdic whereComre2($value)
 * @method static Builder|Anagdic whereComres($value)
 * @method static Builder|Anagdic whereConome($value)
 * @method static Builder|Anagdic whereConto1($value)
 * @method static Builder|Anagdic whereConto2($value)
 * @method static Builder|Anagdic whereEnte($value)
 * @method static Builder|Anagdic whereEntpro($value)
 * @method static Builder|Anagdic whereFegoda($value)
 * @method static Builder|Anagdic whereFegodc($value)
 * @method static Builder|Anagdic whereFemata($value)
 * @method static Builder|Anagdic whereFematc($value)
 * @method static Builder|Anagdic whereFesopg($value)
 * @method static Builder|Anagdic whereFesopm($value)
 * @method static Builder|Anagdic whereFlagse($value)
 * @method static Builder|Anagdic whereId($value)
 * @method static Builder|Anagdic whereImp2($value)
 * @method static Builder|Anagdic whereImpeu($value)
 * @method static Builder|Anagdic whereInail($value)
 * @method static Builder|Anagdic whereIndir($value)
 * @method static Builder|Anagdic whereIndird($value)
 * @method static Builder|Anagdic whereLireu($value)
 * @method static Builder|Anagdic whereLocdom($value)
 * @method static Builder|Anagdic whereLocres($value)
 * @method static Builder|Anagdic whereMatr($value)
 * @method static Builder|Anagdic whereMatseg($value)
 * @method static Builder|Anagdic whereNome($value)
 * @method static Builder|Anagdic whereNumtel($value)
 * @method static Builder|Anagdic wherePretel($value)
 * @method static Builder|Anagdic whereRepar($value)
 * @method static Builder|Anagdic whereSesso($value)
 * @method static Builder|Anagdic whereSinda($value)
 * @method static Builder|Anagdic whereSinda2($value)
 * @method static Builder|Anagdic whereSinda3($value)
 * @method static Builder|Anagdic whereStabi($value)
 * @method static Builder|Anagdic whereStaciv($value)
 * @method static Builder|Anagdic whereTipag($value)
 * @method static Builder|Anagdic whereTipdip($value)
 * @method static Builder|Anagdic whereTitpro($value)
 * @method static Builder|Anagdic whereTitstu($value)
 * @method static Builder|Anagdic whereTopo($value)
 * @method static Builder|Anagdic whereTopod($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\AnagdicFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Anagdic extends BaseModel
{
    protected $table = 'anagdic';
}
