<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ana00ef.
 *
 * @property int $id
 * @property int $ente
 * @property int $matr
 * @property string $conome
 * @property string $nome
 * @property string $cogacq
 * @property string $sesso
 * @property string $codfis
 * @property string $staciv
 * @property int $anadat
 * @property int $comnas
 * @property int $clafun
 * @property int $titstu
 * @property int $entpro
 * @property int $sinda
 * @property int $sinda2
 * @property int $sinda3
 * @property int $catspe
 * @property int $titpro
 * @property string $topo
 * @property string $indir
 * @property string $locres
 * @property int $comres
 * @property int $cap
 * @property string $topod
 * @property string $indird
 * @property string $locdom
 * @property int $comdom
 * @property int $capdom
 * @property string $pretel
 * @property string $numtel
 * @property int $tipag
 * @property int $stabi
 * @property int $repar
 * @property int $banca1
 * @property int $agen1
 * @property string $conto1
 * @property int $banca2
 * @property int $agen2
 * @property string $conto2
 * @property int $imp2
 * @property string $codass
 * @property string $codpre
 * @property string $codic1
 * @property string $codic2
 * @property string $inail
 * @property int $matseg
 * @property int $tipdip
 * @property string $fematc
 * @property string $fegodc
 * @property string $fesopm
 * @property string $fesopg
 * @property string $femata
 * @property string $fegoda
 * @property string $flagse
 * @property string $anaann
 * @property string $lireu
 * @property int $ana2kd
 * @property string $impeu
 * @property int $comna2
 * @property int $comre2
 * @property int $comdo2
 *
 * @method static Builder|Ana00ef newModelQuery()
 * @method static Builder|Ana00ef newQuery()
 * @method static Builder|Ana00ef query()
 * @method static Builder|Ana00ef whereAgen1($value)
 * @method static Builder|Ana00ef whereAgen2($value)
 * @method static Builder|Ana00ef whereAna2kd($value)
 * @method static Builder|Ana00ef whereAnaann($value)
 * @method static Builder|Ana00ef whereAnadat($value)
 * @method static Builder|Ana00ef whereBanca1($value)
 * @method static Builder|Ana00ef whereBanca2($value)
 * @method static Builder|Ana00ef whereCap($value)
 * @method static Builder|Ana00ef whereCapdom($value)
 * @method static Builder|Ana00ef whereCatspe($value)
 * @method static Builder|Ana00ef whereClafun($value)
 * @method static Builder|Ana00ef whereCodass($value)
 * @method static Builder|Ana00ef whereCodfis($value)
 * @method static Builder|Ana00ef whereCodic1($value)
 * @method static Builder|Ana00ef whereCodic2($value)
 * @method static Builder|Ana00ef whereCodpre($value)
 * @method static Builder|Ana00ef whereCogacq($value)
 * @method static Builder|Ana00ef whereComdo2($value)
 * @method static Builder|Ana00ef whereComdom($value)
 * @method static Builder|Ana00ef whereComna2($value)
 * @method static Builder|Ana00ef whereComnas($value)
 * @method static Builder|Ana00ef whereComre2($value)
 * @method static Builder|Ana00ef whereComres($value)
 * @method static Builder|Ana00ef whereConome($value)
 * @method static Builder|Ana00ef whereConto1($value)
 * @method static Builder|Ana00ef whereConto2($value)
 * @method static Builder|Ana00ef whereEnte($value)
 * @method static Builder|Ana00ef whereEntpro($value)
 * @method static Builder|Ana00ef whereFegoda($value)
 * @method static Builder|Ana00ef whereFegodc($value)
 * @method static Builder|Ana00ef whereFemata($value)
 * @method static Builder|Ana00ef whereFematc($value)
 * @method static Builder|Ana00ef whereFesopg($value)
 * @method static Builder|Ana00ef whereFesopm($value)
 * @method static Builder|Ana00ef whereFlagse($value)
 * @method static Builder|Ana00ef whereId($value)
 * @method static Builder|Ana00ef whereImp2($value)
 * @method static Builder|Ana00ef whereImpeu($value)
 * @method static Builder|Ana00ef whereInail($value)
 * @method static Builder|Ana00ef whereIndir($value)
 * @method static Builder|Ana00ef whereIndird($value)
 * @method static Builder|Ana00ef whereLireu($value)
 * @method static Builder|Ana00ef whereLocdom($value)
 * @method static Builder|Ana00ef whereLocres($value)
 * @method static Builder|Ana00ef whereMatr($value)
 * @method static Builder|Ana00ef whereMatseg($value)
 * @method static Builder|Ana00ef whereNome($value)
 * @method static Builder|Ana00ef whereNumtel($value)
 * @method static Builder|Ana00ef wherePretel($value)
 * @method static Builder|Ana00ef whereRepar($value)
 * @method static Builder|Ana00ef whereSesso($value)
 * @method static Builder|Ana00ef whereSinda($value)
 * @method static Builder|Ana00ef whereSinda2($value)
 * @method static Builder|Ana00ef whereSinda3($value)
 * @method static Builder|Ana00ef whereStabi($value)
 * @method static Builder|Ana00ef whereStaciv($value)
 * @method static Builder|Ana00ef whereTipag($value)
 * @method static Builder|Ana00ef whereTipdip($value)
 * @method static Builder|Ana00ef whereTitpro($value)
 * @method static Builder|Ana00ef whereTitstu($value)
 * @method static Builder|Ana00ef whereTopo($value)
 * @method static Builder|Ana00ef whereTopod($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ana00efFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ana00ef extends BaseModel
{
    protected $table = 'ana00ef';
}
