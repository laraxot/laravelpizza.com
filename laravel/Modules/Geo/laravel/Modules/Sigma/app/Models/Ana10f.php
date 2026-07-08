<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

// ----------traits ---
/**
 * Modules\Sigma\Models\Ana10f.
 *
 * @property int $id
 * @property int $tiprec
 * @property int $ente
 * @property int $matr
 * @property string $conome
 * @property string|null $nome
 * @property string $sesso
 * @property string $staciv
 * @property int $clafun
 * @property int $titstu
 * @property int $entpro
 * @property int $sindac
 * @property int $catspe
 * @property int $titpro
 * @property int $tipag
 * @property int $stabi
 * @property int $repar
 * @property int $banca1
 * @property int $agen1
 * @property string $conto1
 * @property string $inail
 * @property string $flagse
 * @property int $stass
 * @property int $stdim
 * @property int $tipass
 * @property int $tipdim
 * @property int $repdal
 * @property int $repal
 * @property int $repst1
 * @property int $repre1
 * @property int $repst2
 * @property int $repre2
 * @property int $piaorg
 * @property int $qudal
 * @property int $qual
 * @property int $quanz
 * @property int $annise
 * @property int $posiz
 * @property int $datpas
 * @property string $oree
 * @property string $oret
 * @property int $cont
 * @property int $tipco
 * @property int $rapp
 * @property int $ruolo
 * @property int $propro
 * @property int $posfun
 * @property int $codqua
 * @property int $disci1
 * @property int $jipco
 * @property int $japp
 * @property int $juolo
 * @property int $jropro
 * @property int $josfun
 * @property int $jodqua
 * @property int $jisci2
 * @property int $tipasp
 * @property int $aspin
 * @property int $aspte
 * @property string $anaann
 * @property-read string|null $cognome
 *
 * @method static Builder|Ana10f newModelQuery()
 * @method static Builder|Ana10f newQuery()
 * @method static Builder|Ana10f query()
 * @method static Builder|Ana10f whereAgen1($value)
 * @method static Builder|Ana10f whereAnaann($value)
 * @method static Builder|Ana10f whereAnnise($value)
 * @method static Builder|Ana10f whereAspin($value)
 * @method static Builder|Ana10f whereAspte($value)
 * @method static Builder|Ana10f whereBanca1($value)
 * @method static Builder|Ana10f whereCatspe($value)
 * @method static Builder|Ana10f whereClafun($value)
 * @method static Builder|Ana10f whereCodqua($value)
 * @method static Builder|Ana10f whereConome($value)
 * @method static Builder|Ana10f whereCont($value)
 * @method static Builder|Ana10f whereConto1($value)
 * @method static Builder|Ana10f whereDatpas($value)
 * @method static Builder|Ana10f whereDisci1($value)
 * @method static Builder|Ana10f whereEnte($value)
 * @method static Builder|Ana10f whereEntpro($value)
 * @method static Builder|Ana10f whereFlagse($value)
 * @method static Builder|Ana10f whereId($value)
 * @method static Builder|Ana10f whereInail($value)
 * @method static Builder|Ana10f whereJapp($value)
 * @method static Builder|Ana10f whereJipco($value)
 * @method static Builder|Ana10f whereJisci2($value)
 * @method static Builder|Ana10f whereJodqua($value)
 * @method static Builder|Ana10f whereJosfun($value)
 * @method static Builder|Ana10f whereJropro($value)
 * @method static Builder|Ana10f whereJuolo($value)
 * @method static Builder|Ana10f whereMatr($value)
 * @method static Builder|Ana10f whereNome($value)
 * @method static Builder|Ana10f whereOree($value)
 * @method static Builder|Ana10f whereOret($value)
 * @method static Builder|Ana10f wherePiaorg($value)
 * @method static Builder|Ana10f wherePosfun($value)
 * @method static Builder|Ana10f wherePosiz($value)
 * @method static Builder|Ana10f wherePropro($value)
 * @method static Builder|Ana10f whereQual($value)
 * @method static Builder|Ana10f whereQuanz($value)
 * @method static Builder|Ana10f whereQudal($value)
 * @method static Builder|Ana10f whereRapp($value)
 * @method static Builder|Ana10f whereRepal($value)
 * @method static Builder|Ana10f whereRepar($value)
 * @method static Builder|Ana10f whereRepdal($value)
 * @method static Builder|Ana10f whereRepre1($value)
 * @method static Builder|Ana10f whereRepre2($value)
 * @method static Builder|Ana10f whereRepst1($value)
 * @method static Builder|Ana10f whereRepst2($value)
 * @method static Builder|Ana10f whereRuolo($value)
 * @method static Builder|Ana10f whereSesso($value)
 * @method static Builder|Ana10f whereSindac($value)
 * @method static Builder|Ana10f whereStabi($value)
 * @method static Builder|Ana10f whereStaciv($value)
 * @method static Builder|Ana10f whereStass($value)
 * @method static Builder|Ana10f whereStdim($value)
 * @method static Builder|Ana10f whereTipag($value)
 * @method static Builder|Ana10f whereTipasp($value)
 * @method static Builder|Ana10f whereTipass($value)
 * @method static Builder|Ana10f whereTipco($value)
 * @method static Builder|Ana10f whereTipdim($value)
 * @method static Builder|Ana10f whereTiprec($value)
 * @method static Builder|Ana10f whereTitpro($value)
 * @method static Builder|Ana10f whereTitstu($value)
 *
 * @mixin \Eloquent
 */
class Ana10f extends BaseModel
{
    protected $fillable = [
        'id',
        'tiprec',
        'ente',
        'matr',
        'conome',
        'nome',
        'sesso',
        'staciv',
        'clafun',
        'titstu',
        'entpro',
        'sindac',
        'catspe',
        'titpro',
        'tipag',
        'stabi',
        'repar',
        'banca1',
        'agen1',
        'conto1',
        'inail',
        'flagse',
        'stass',
        'stdim',
        'tipass',
        'tipdim',
        'repdal',
        'repal',
        'repst1',
        'repre1',
        'repst2',
        'repre2',
        'piaorg',
        'qudal',
        'qual',
        'quanz',
        'annise',
        'posiz',
        'datpas',
        'oree',
        'oret',
        'cont',
        'tipco',
        'rapp',
        'ruolo',
        'propro',
        'posfun',
        'codqua',
        'disci1',
        'jipco',
        'japp',
        'juolo',
        'jropro',
        'josfun',
        'jodqua',
        'jisci2',
        'tipasp',
        'aspin',
        'aspte',
        'anaann',
    ];

    protected $connection = 'generale';

    // this will use the specified database connection
    protected $table = 'ana10f';

    public $timestamps = false;

    // --- mutators --

    protected function getCognomeAttribute(?string $value): ?string
    {
        return $this->conome;
    }

    protected function getNomeAttribute(?string $value): ?string
    {
        // per non fare loop
        return $value;
    }
}
