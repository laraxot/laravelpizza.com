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
use Modules\Sigma\Models\Traits\Relationships\EnteMatrRelationship;
use Modules\Sigma\Models\Traits\SigmaModelTrait;
use Modules\Sigma\Models\Wstr01lx;

// https://www.php.net/manual/en/language.namespaces.importing.php
// use some\namespace\{ClassA, ClassB, ClassC as C};
/**
 * Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoroRep.
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
 * @method static Builder|CondizioniLavoroRep newModelQuery()
 * @method static Builder|CondizioniLavoroRep newQuery()
 * @method static Builder|CondizioniLavoroRep ofDate(int $date)
 * @method static Builder|CondizioniLavoroRep ofEnteYear(int $ente, int $year)
 * @method static Builder|CondizioniLavoroRep ofQuarter(int $quarter, int $year)
 * @method static Builder|CondizioniLavoroRep ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|CondizioniLavoroRep ofYear(int $year)
 * @method static Builder|CondizioniLavoroRep query()
 * @method static Builder|CondizioniLavoroRep whereEnte($value)
 * @method static Builder|CondizioniLavoroRep whereGrppag($value)
 * @method static Builder|CondizioniLavoroRep whereId($value)
 * @method static Builder|CondizioniLavoroRep whereMatr($value)
 * @method static Builder|CondizioniLavoroRep whereNumpag($value)
 * @method static Builder|CondizioniLavoroRep wherePerc1($value)
 * @method static Builder|CondizioniLavoroRep wherePerc2($value)
 * @method static Builder|CondizioniLavoroRep wherePerc3($value)
 * @method static Builder|CondizioniLavoroRep wherePiaorg($value)
 * @method static Builder|CondizioniLavoroRep whereRep001($value)
 * @method static Builder|CondizioniLavoroRep whereRep002($value)
 * @method static Builder|CondizioniLavoroRep whereRep003($value)
 * @method static Builder|CondizioniLavoroRep whereRep004($value)
 * @method static Builder|CondizioniLavoroRep whereRep005($value)
 * @method static Builder|CondizioniLavoroRep whereRep2ka($value)
 * @method static Builder|CondizioniLavoroRep whereRep2kd($value)
 * @method static Builder|CondizioniLavoroRep whereRepal($value)
 * @method static Builder|CondizioniLavoroRep whereRepann($value)
 * @method static Builder|CondizioniLavoroRep whereRepc1a($value)
 * @method static Builder|CondizioniLavoroRep whereRepc1b($value)
 * @method static Builder|CondizioniLavoroRep whereRepc1c($value)
 * @method static Builder|CondizioniLavoroRep whereRepc2a($value)
 * @method static Builder|CondizioniLavoroRep whereRepc2b($value)
 * @method static Builder|CondizioniLavoroRep whereRepc2c($value)
 * @method static Builder|CondizioniLavoroRep whereRepc3a($value)
 * @method static Builder|CondizioniLavoroRep whereRepc3b($value)
 * @method static Builder|CondizioniLavoroRep whereRepc3c($value)
 * @method static Builder|CondizioniLavoroRep whereRepcla($value)
 * @method static Builder|CondizioniLavoroRep whereRepdal($value)
 * @method static Builder|CondizioniLavoroRep whereRepmar($value)
 * @method static Builder|CondizioniLavoroRep whereRepre1($value)
 * @method static Builder|CondizioniLavoroRep whereRepre2($value)
 * @method static Builder|CondizioniLavoroRep whereRepst1($value)
 * @method static Builder|CondizioniLavoroRep whereRepst2($value)
 * @method static Builder|CondizioniLavoroRep withDays(int $date_min, int $date_max)
 * @property-read string|null $codice_fiscale
 * @property-read string $from_field
 * @property-read string|null $inail
 * @property-read string|null $sesso
 * @property-read string $to_field
 * @property-read Collection<int, \Modules\Sigma\Models\Integparam> $integParams
 * @property-read int|null $integ_params_count
 * @method static Builder<static>|CondizioniLavoroRep ofEnte(int $ente)
 * @method static Builder<static>|CondizioniLavoroRep ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @mixin \Eloquent
 */
class CondizioniLavoroRep extends Model
{
    // !!!
    use EnteMatrMutator; // ??
    use EnteMatrRelationship;
    use HasEnteMatrRelationHelpers;
    use SigmaModelTrait;

    // use function \Modules\Sigma\Models\Traits\Mutators\EnteMatrMutator\getCognomeAttribute as getCognomeAttribute;
    // syntax error, unexpected token "function"
    // use function \Modules\Sigma\Models\Traits\Mutators\EnteMatrMutator\getCognomeAttribute;

    protected $fillable = ['id', 'ente', 'matr', 'repdal', 'repal', 'repst1', 'repre1', 'repst2', 'repre2', 'repcla', 'repmar', 'grppag', 'numpag', 'repc1a', 'repc1b', 'repc1c', 'repc2a', 'repc2b', 'repc2c', 'repc3a', 'repc3b', 'repc3c', 'perc1', 'perc2', 'perc3', 'piaorg', 'repann', 'rep2kd', 'rep2ka', 'rep001', 'rep002', 'rep003', 'rep004', 'rep005'];

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

    // ---- RELATIONSHIPS
    // ---- MUTATORS
    /*
    public function getCognomeAttribute(?string $value): ?string {
        if (null !== $value) {
            return $value;
        }
        $anag = $this->ana10f;
        if (! \is_object($anag)) {
            return '---';
        }
        $value = $anag->cognome;
        if (\in_array('cognome',  $this->getFillable(), false)) {
            $this->cognome = $value;
            $this->save();
        }

        return $value.' ';
    }
    //*/
}
