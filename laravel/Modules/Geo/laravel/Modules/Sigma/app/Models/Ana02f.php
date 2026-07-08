<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

// ----------traits ---
/**
 * Modules\Sigma\Models\Ana02f.
 *
 * @property int $id
 * @property int $ente
 * @property int $matr
 * @property int $datdec
 * @property int $datint
 * @property int $oraint
 * @property string $utente
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
 * @property string $telnum
 * @property string $celnum
 * @property string $cel2nu
 * @property string $faxnum
 * @property string $emaind
 * @property string $emaper
 * @property string $benefi
 * @property string $invced
 * @property string $cpaese
 * @property int $chedig
 * @property string $statoe
 * @property string $anacup
 * @property string $anacig
 * @property string $anaest
 * @property int $ana031
 * @property int $ana032
 * @property int $ana033
 * @property int $ana034
 * @property int $ana035
 * @property int $ana036
 * @property string $ana037
 * @property string $ana038
 * @property string $ana039
 *
 * @method static Builder|Ana02f newModelQuery()
 * @method static Builder|Ana02f newQuery()
 * @method static Builder|Ana02f query()
 * @method static Builder|Ana02f whereAgen1($value)
 * @method static Builder|Ana02f whereAgen2($value)
 * @method static Builder|Ana02f whereAna031($value)
 * @method static Builder|Ana02f whereAna032($value)
 * @method static Builder|Ana02f whereAna033($value)
 * @method static Builder|Ana02f whereAna034($value)
 * @method static Builder|Ana02f whereAna035($value)
 * @method static Builder|Ana02f whereAna036($value)
 * @method static Builder|Ana02f whereAna037($value)
 * @method static Builder|Ana02f whereAna038($value)
 * @method static Builder|Ana02f whereAna039($value)
 * @method static Builder|Ana02f whereAna2kd($value)
 * @method static Builder|Ana02f whereAnaann($value)
 * @method static Builder|Ana02f whereAnacig($value)
 * @method static Builder|Ana02f whereAnacup($value)
 * @method static Builder|Ana02f whereAnadat($value)
 * @method static Builder|Ana02f whereAnaest($value)
 * @method static Builder|Ana02f whereBanca1($value)
 * @method static Builder|Ana02f whereBanca2($value)
 * @method static Builder|Ana02f whereBenefi($value)
 * @method static Builder|Ana02f whereCap($value)
 * @method static Builder|Ana02f whereCapdom($value)
 * @method static Builder|Ana02f whereCatspe($value)
 * @method static Builder|Ana02f whereCel2nu($value)
 * @method static Builder|Ana02f whereCelnum($value)
 * @method static Builder|Ana02f whereChedig($value)
 * @method static Builder|Ana02f whereClafun($value)
 * @method static Builder|Ana02f whereCodass($value)
 * @method static Builder|Ana02f whereCodfis($value)
 * @method static Builder|Ana02f whereCodic1($value)
 * @method static Builder|Ana02f whereCodic2($value)
 * @method static Builder|Ana02f whereCodpre($value)
 * @method static Builder|Ana02f whereCogacq($value)
 * @method static Builder|Ana02f whereComdo2($value)
 * @method static Builder|Ana02f whereComdom($value)
 * @method static Builder|Ana02f whereComna2($value)
 * @method static Builder|Ana02f whereComnas($value)
 * @method static Builder|Ana02f whereComre2($value)
 * @method static Builder|Ana02f whereComres($value)
 * @method static Builder|Ana02f whereConome($value)
 * @method static Builder|Ana02f whereConto1($value)
 * @method static Builder|Ana02f whereConto2($value)
 * @method static Builder|Ana02f whereCpaese($value)
 * @method static Builder|Ana02f whereDatdec($value)
 * @method static Builder|Ana02f whereDatint($value)
 * @method static Builder|Ana02f whereEmaind($value)
 * @method static Builder|Ana02f whereEmaper($value)
 * @method static Builder|Ana02f whereEnte($value)
 * @method static Builder|Ana02f whereEntpro($value)
 * @method static Builder|Ana02f whereFaxnum($value)
 * @method static Builder|Ana02f whereFegoda($value)
 * @method static Builder|Ana02f whereFegodc($value)
 * @method static Builder|Ana02f whereFemata($value)
 * @method static Builder|Ana02f whereFematc($value)
 * @method static Builder|Ana02f whereFesopg($value)
 * @method static Builder|Ana02f whereFesopm($value)
 * @method static Builder|Ana02f whereFlagse($value)
 * @method static Builder|Ana02f whereId($value)
 * @method static Builder|Ana02f whereImp2($value)
 * @method static Builder|Ana02f whereImpeu($value)
 * @method static Builder|Ana02f whereInail($value)
 * @method static Builder|Ana02f whereIndir($value)
 * @method static Builder|Ana02f whereIndird($value)
 * @method static Builder|Ana02f whereInvced($value)
 * @method static Builder|Ana02f whereLireu($value)
 * @method static Builder|Ana02f whereLocdom($value)
 * @method static Builder|Ana02f whereLocres($value)
 * @method static Builder|Ana02f whereMatr($value)
 * @method static Builder|Ana02f whereMatseg($value)
 * @method static Builder|Ana02f whereNome($value)
 * @method static Builder|Ana02f whereNumtel($value)
 * @method static Builder|Ana02f whereOraint($value)
 * @method static Builder|Ana02f wherePretel($value)
 * @method static Builder|Ana02f whereRepar($value)
 * @method static Builder|Ana02f whereSesso($value)
 * @method static Builder|Ana02f whereSinda($value)
 * @method static Builder|Ana02f whereSinda2($value)
 * @method static Builder|Ana02f whereSinda3($value)
 * @method static Builder|Ana02f whereStabi($value)
 * @method static Builder|Ana02f whereStaciv($value)
 * @method static Builder|Ana02f whereStatoe($value)
 * @method static Builder|Ana02f whereTelnum($value)
 * @method static Builder|Ana02f whereTipag($value)
 * @method static Builder|Ana02f whereTipdip($value)
 * @method static Builder|Ana02f whereTitpro($value)
 * @method static Builder|Ana02f whereTitstu($value)
 * @method static Builder|Ana02f whereTopo($value)
 * @method static Builder|Ana02f whereTopod($value)
 * @method static Builder|Ana02f whereUtente($value)
 *
 * @mixin \Eloquent
 */
class Ana02f extends BaseModel
{
    protected $fillable = [
        'id',
        'ente',
        'matr',
        'datdec',
        'datint',
        'oraint',
        'utente',
        'conome',
        'nome',
        'cogacq',
        'sesso',
        'codfis',
        'staciv',
        'anadat',
        'comnas',
        'clafun',
        'titstu',
        'entpro',
        'sinda',
        'sinda2',
        'sinda3',
        'catspe',
        'titpro',
        'topo',
        'indir',
        'locres',
        'comres',
        'cap',
        'topod',
        'indird',
        'locdom',
        'comdom',
        'capdom',
        'pretel',
        'numtel',
        'tipag',
        'stabi',
        'repar',
        'banca1',
        'agen1',
        'conto1',
        'banca2',
        'agen2',
        'conto2',
        'imp2',
        'codass',
        'codpre',
        'codic1',
        'codic2',
        'inail',
        'matseg',
        'tipdip',
        'fematc',
        'fegodc',
        'fesopm',
        'fesopg',
        'femata',
        'fegoda',
        'flagse',
        'anaann',
        'lireu',
        'ana2kd',
        'impeu',
        'comna2',
        'comre2',
        'comdo2',
        'telnum',
        'celnum',
        'cel2nu',
        'faxnum',
        'emaind',
        'emaper',
        'benefi',
        'invced',
        'cpaese',
        'chedig',
        'statoe',
        'anacup',
        'anacig',
        'anaest',
        'ana031',
        'ana032',
        'ana033',
        'ana034',
        'ana035',
        'ana036',
        'ana037',
        'ana038',
        'ana039',
    ];

    protected $connection = 'generale';

    // this will use the specified database connection
    protected $table = 'ana02f';

    public $timestamps = false;
}
