<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Sigma\Models\Ana02f;
use Modules\Sigma\Models\Ana10f;
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Asz00f;
use Modules\Sigma\Models\Asz00k1;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Qua03f;
use Modules\Sigma\Models\Rep00f;
use Modules\Sigma\Models\Sto00f;
use Modules\Sigma\Models\Traits\Concerns\HasEnteMatrRelationHelpers;
use Modules\Sigma\Models\Traits\Mutators\EnteMatrMutator;
// ------ ext models---
use Modules\Sigma\Models\Traits\Relationships\EnteMatrRelationship;
use Modules\Sigma\Models\Traits\SigmaModelTrait;
use Modules\Sigma\Models\Wstr01lx;

// ---- traits --
/**
 * Modules\IndennitaCondizioniLavoro\Models\ServizioEsternoRep.
 *
 * @property int $id
 * @property int $ente
 * @property int $matr
 * @property int $repdal
 * @property int $repal
 * @property int $repst1
 * @property int $repre1
 * @property int $repst2
 * @property int $repre2
 * @property int $repcla
 * @property int $repmar
 * @property string $grppag
 * @property int $numpag
 * @property int $repc1a
 * @property int $repc1b
 * @property int $repc1c
 * @property int $repc2a
 * @property int $repc2b
 * @property int $repc2c
 * @property int $repc3a
 * @property int $repc3b
 * @property int $repc3c
 * @property string $perc1
 * @property string $perc2
 * @property string $perc3
 * @property int $piaorg
 * @property string $repann
 * @property int $rep2kd
 * @property int $rep2ka
 * @property int $rep001
 * @property string $rep002
 * @property string $rep003
 * @property int $rep004
 * @property int $rep005
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
 * @property-read string|null $nome
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
 * @method static Builder|ServizioEsternoRep newModelQuery()
 * @method static Builder|ServizioEsternoRep newQuery()
 * @method static Builder|ServizioEsternoRep ofDate(int $date)
 * @method static Builder|ServizioEsternoRep ofEnteYear(int $ente, int $year)
 * @method static Builder|ServizioEsternoRep ofQuarter(int $quarter, int $year)
 * @method static Builder|ServizioEsternoRep ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|ServizioEsternoRep ofYear(int $year)
 * @method static Builder|ServizioEsternoRep query()
 * @method static Builder|ServizioEsternoRep whereEnte($value)
 * @method static Builder|ServizioEsternoRep whereGrppag($value)
 * @method static Builder|ServizioEsternoRep whereId($value)
 * @method static Builder|ServizioEsternoRep whereMatr($value)
 * @method static Builder|ServizioEsternoRep whereNumpag($value)
 * @method static Builder|ServizioEsternoRep wherePerc1($value)
 * @method static Builder|ServizioEsternoRep wherePerc2($value)
 * @method static Builder|ServizioEsternoRep wherePerc3($value)
 * @method static Builder|ServizioEsternoRep wherePiaorg($value)
 * @method static Builder|ServizioEsternoRep whereRep001($value)
 * @method static Builder|ServizioEsternoRep whereRep002($value)
 * @method static Builder|ServizioEsternoRep whereRep003($value)
 * @method static Builder|ServizioEsternoRep whereRep004($value)
 * @method static Builder|ServizioEsternoRep whereRep005($value)
 * @method static Builder|ServizioEsternoRep whereRep2ka($value)
 * @method static Builder|ServizioEsternoRep whereRep2kd($value)
 * @method static Builder|ServizioEsternoRep whereRepal($value)
 * @method static Builder|ServizioEsternoRep whereRepann($value)
 * @method static Builder|ServizioEsternoRep whereRepc1a($value)
 * @method static Builder|ServizioEsternoRep whereRepc1b($value)
 * @method static Builder|ServizioEsternoRep whereRepc1c($value)
 * @method static Builder|ServizioEsternoRep whereRepc2a($value)
 * @method static Builder|ServizioEsternoRep whereRepc2b($value)
 * @method static Builder|ServizioEsternoRep whereRepc2c($value)
 * @method static Builder|ServizioEsternoRep whereRepc3a($value)
 * @method static Builder|ServizioEsternoRep whereRepc3b($value)
 * @method static Builder|ServizioEsternoRep whereRepc3c($value)
 * @method static Builder|ServizioEsternoRep whereRepcla($value)
 * @method static Builder|ServizioEsternoRep whereRepdal($value)
 * @method static Builder|ServizioEsternoRep whereRepmar($value)
 * @method static Builder|ServizioEsternoRep whereRepre1($value)
 * @method static Builder|ServizioEsternoRep whereRepre2($value)
 * @method static Builder|ServizioEsternoRep whereRepst1($value)
 * @method static Builder|ServizioEsternoRep whereRepst2($value)
 * @method static Builder|ServizioEsternoRep withDays(int $date_min, int $date_max)
 * @property-read string|null $codice_fiscale
 * @property-read string $from_field
 * @property-read string|null $inail
 * @property-read string|null $sesso
 * @property-read string $to_field
 * @property-read Collection<int, \Modules\Sigma\Models\Integparam> $integParams
 * @property-read int|null $integ_params_count
 * @method static Builder<static>|ServizioEsternoRep ofEnte(int $ente)
 * @method static Builder<static>|ServizioEsternoRep ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @mixin \Eloquent
 */
class ServizioEsternoRep extends Model
{
    // !!!
    use EnteMatrMutator;
    use EnteMatrRelationship;
    use HasEnteMatrRelationHelpers;
    use SigmaModelTrait;

    protected $fillable = ['id', 'ente', 'matr', 'repdal', 'repal',
        'repst1', 'repre1', 'repst2', 'repre2', 'repcla', 'repmar', 'grppag',
        'numpag', 'repc1a', 'repc1b', 'repc1c', 'repc2a', 'repc2b', 'repc2c', 'repc3a',
        'repc3b', 'repc3c', 'perc1', 'perc2', 'perc3', 'piaorg', 'repann', 'rep2kd',
        'rep2ka', 'rep001', 'rep002', 'rep003', 'rep004', 'rep005', ];

    protected $connection = 'generale';

    // this will use the specified database connection
    protected $table = 'rep00f';

    public string $from_field = 'rep2kd';

    public string $to_field = 'rep2ka';

    public function matrField(): string
    {
        return 'matr';
    }

    public function enteField(): string
    {
        return 'ente';
    }

    protected function rangeFromField(): string
    {
        return 'rep2kd';
    }

    protected function rangeToField(): string
    {
        return 'rep2ka';
    }

    protected function annFieldName(): string
    {
        return 'repann';
    }
}
