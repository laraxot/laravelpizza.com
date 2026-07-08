<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Modules\Sigma\Models\Traits\Extras\FunctionExtra;
use Modules\Sigma\Models\Traits\Mutators\CommonMutator;
use Modules\Sigma\Models\Traits\Mutators\EnteMatrMutator;
use Modules\Sigma\Models\Traits\Relationships\CommonRelationship;
// ----------traits ---
use Modules\Sigma\Models\Traits\Relationships\EnteMatrRelationship;

// ----------services --
/**
 * Modules\Sigma\Models\Anag.
 *
 * @property int $id
 * @property int $anno
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
 * @property-read Collection<int, Ana02f> $ana02f
 * @property-read int|null $ana02f_count
 * @property-read Ana10f|null $ana10f
 * @property-read Anag|null $anag
 * @property-read Collection<int, Asz00f> $asz00f
 * @property-read int|null $asz00f_count
 * @property-read Collection<int, Asz00k1> $asz00k1
 * @property-read int|null $asz00k1_count
 * @property-read string|null $cognome
 * @property-read mixed $email
 * @property-read mixed $last_data_assunz
 * @property-read mixed $titolo_di_studio
 * @property-read Collection<int, Qua00f> $qua00f
 * @property-read int|null $qua00f_count
 * @property-read Collection<int, Qua03f> $qua03f
 * @property-read int|null $qua03f_count
 * @property-read Collection<int, Rep00f> $rep00f
 * @property-read int|null $rep00f_count
 * @property-read Collection<int, Sto00f> $sto00f
 * @property-read int|null $sto00f_count
 * @property-read Collection<int, Wstr01lx> $wstr01lx
 * @property-read int|null $wstr01lx_count
 * @property-read Collection<int, Wstr01lx> $wstr01lxYear
 * @property-read int|null $wstr01lx_year_count
 *
 * @method static Builder|Anag newModelQuery()
 * @method static Builder|Anag newQuery()
 * @method static Builder|Anag query()
 * @method static Builder|Anag whereAgen1($value)
 * @method static Builder|Anag whereAnaann($value)
 * @method static Builder|Anag whereAnnise($value)
 * @method static Builder|Anag whereAspin($value)
 * @method static Builder|Anag whereAspte($value)
 * @method static Builder|Anag whereBanca1($value)
 * @method static Builder|Anag whereCatspe($value)
 * @method static Builder|Anag whereClafun($value)
 * @method static Builder|Anag whereCodqua($value)
 * @method static Builder|Anag whereConome($value)
 * @method static Builder|Anag whereCont($value)
 * @method static Builder|Anag whereConto1($value)
 * @method static Builder|Anag whereDatpas($value)
 * @method static Builder|Anag whereDisci1($value)
 * @method static Builder|Anag whereEnte($value)
 * @method static Builder|Anag whereEntpro($value)
 * @method static Builder|Anag whereFlagse($value)
 * @method static Builder|Anag whereId($value)
 * @method static Builder|Anag whereInail($value)
 * @method static Builder|Anag whereJapp($value)
 * @method static Builder|Anag whereJipco($value)
 * @method static Builder|Anag whereJisci2($value)
 * @method static Builder|Anag whereJodqua($value)
 * @method static Builder|Anag whereJosfun($value)
 * @method static Builder|Anag whereJropro($value)
 * @method static Builder|Anag whereJuolo($value)
 * @method static Builder|Anag whereMatr($value)
 * @method static Builder|Anag whereNome($value)
 * @method static Builder|Anag whereOree($value)
 * @method static Builder|Anag whereOret($value)
 * @method static Builder|Anag wherePiaorg($value)
 * @method static Builder|Anag wherePosfun($value)
 * @method static Builder|Anag wherePosiz($value)
 * @method static Builder|Anag wherePropro($value)
 * @method static Builder|Anag whereQual($value)
 * @method static Builder|Anag whereQuanz($value)
 * @method static Builder|Anag whereQudal($value)
 * @method static Builder|Anag whereRapp($value)
 * @method static Builder|Anag whereRepal($value)
 * @method static Builder|Anag whereRepar($value)
 * @method static Builder|Anag whereRepdal($value)
 * @method static Builder|Anag whereRepre1($value)
 * @method static Builder|Anag whereRepre2($value)
 * @method static Builder|Anag whereRepst1($value)
 * @method static Builder|Anag whereRepst2($value)
 * @method static Builder|Anag whereRuolo($value)
 * @method static Builder|Anag whereSesso($value)
 * @method static Builder|Anag whereSindac($value)
 * @method static Builder|Anag whereStabi($value)
 * @method static Builder|Anag whereStaciv($value)
 * @method static Builder|Anag whereStass($value)
 * @method static Builder|Anag whereStdim($value)
 * @method static Builder|Anag whereTipag($value)
 * @method static Builder|Anag whereTipasp($value)
 * @method static Builder|Anag whereTipass($value)
 * @method static Builder|Anag whereTipco($value)
 * @method static Builder|Anag whereTipdim($value)
 * @method static Builder|Anag whereTiprec($value)
 * @method static Builder|Anag whereTitpro($value)
 * @method static Builder|Anag whereTitstu($value)
 *
 * @property-read string|null $codice_fiscale
 * @property-read Collection<int, Integparam> $integParams
 * @property-read int|null $integ_params_count
 *
 * @mixin \Eloquent
 */
class Anag extends BaseModel
{
    use CommonMutator;
    use CommonRelationship;
    use EnteMatrMutator;
    use EnteMatrRelationship;
    use FunctionExtra;

    // use MassExtra;
    // use SigmaModelTrait;

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

    protected $appends = ['email'];

    public $timestamps = false;

    public string $from_field = '';

    public string $to_field = '';

    // --------------------------------------
    // ----------- MUTATORS ---------------
}
