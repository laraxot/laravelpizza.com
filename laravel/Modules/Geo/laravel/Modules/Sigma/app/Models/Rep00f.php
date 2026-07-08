<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
// ----------traits ---
use Illuminate\Support\Collection;
use Modules\Sigma\Models\Traits\Mutators\EnteMatrMutator;
use Modules\Sigma\Models\Traits\Relationships\EnteMatrRelationship;
use stdClass;

/**
 * Modules\Sigma\Models\Rep00f
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
 * @property-read mixed $repar
 * @property-read string|null $repar_txt
 * @property-read string|null $stabi_txt
 * @property-read Repart|null $repart
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Repart> $reparts
 * @property-read int|null $reparts_count
 * @property-read Repart|null $stabi
 *
 * @method static Builder|Rep00f newModelQuery()
 * @method static Builder|Rep00f newQuery()
 * @method static Builder|Rep00f ofDate(int $date)
 * @method static Builder|Rep00f ofEnteRangeDate(int $ente, int $date_start, int $date_end)
 * @method static Builder|Rep00f ofEnteYear(?int $ente, ?int $year)
 * @method static Builder|Rep00f ofQuarter(int $quarter, int $year)
 * @method static Builder|Rep00f ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|Rep00f ofYear(int $year)
 * @method static Builder|Rep00f query()
 * @method static Builder|Rep00f whereEnte($value)
 * @method static Builder|Rep00f whereGrppag($value)
 * @method static Builder|Rep00f whereId($value)
 * @method static Builder|Rep00f whereMatr($value)
 * @method static Builder|Rep00f whereNumpag($value)
 * @method static Builder|Rep00f wherePerc1($value)
 * @method static Builder|Rep00f wherePerc2($value)
 * @method static Builder|Rep00f wherePerc3($value)
 * @method static Builder|Rep00f wherePiaorg($value)
 * @method static Builder|Rep00f whereRep001($value)
 * @method static Builder|Rep00f whereRep002($value)
 * @method static Builder|Rep00f whereRep003($value)
 * @method static Builder|Rep00f whereRep004($value)
 * @method static Builder|Rep00f whereRep005($value)
 * @method static Builder|Rep00f whereRep2ka($value)
 * @method static Builder|Rep00f whereRep2kd($value)
 * @method static Builder|Rep00f whereRepal($value)
 * @method static Builder|Rep00f whereRepann($value)
 * @method static Builder|Rep00f whereRepc1a($value)
 * @method static Builder|Rep00f whereRepc1b($value)
 * @method static Builder|Rep00f whereRepc1c($value)
 * @method static Builder|Rep00f whereRepc2a($value)
 * @method static Builder|Rep00f whereRepc2b($value)
 * @method static Builder|Rep00f whereRepc2c($value)
 * @method static Builder|Rep00f whereRepc3a($value)
 * @method static Builder|Rep00f whereRepc3b($value)
 * @method static Builder|Rep00f whereRepc3c($value)
 * @method static Builder|Rep00f whereRepcla($value)
 * @method static Builder|Rep00f whereRepdal($value)
 * @method static Builder|Rep00f whereRepmar($value)
 * @method static Builder|Rep00f whereRepre1($value)
 * @method static Builder|Rep00f whereRepre2($value)
 * @method static Builder|Rep00f whereRepst1($value)
 * @method static Builder|Rep00f whereRepst2($value)
 * @method static Builder|Rep00f withDays(int $date_min, int $date_max)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Ana02f> $ana02f
 * @property-read int|null $ana02f_count
 * @property-read Ana10f|null $ana10f
 * @property-read Anag|null $anag
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Asz00f> $asz00f
 * @property-read int|null $asz00f_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Asz00k1> $asz00k1
 * @property-read int|null $asz00k1_count
 * @property-read string|null $codice_fiscale
 * @property-read string|null $cognome
 * @property-read string|null $email
 * @property-read string|null $inail
 * @property-read mixed $last_data_assunz
 * @property-read string|null $nome
 * @property-read string|null $sesso
 * @property-read string $titolo_di_studio
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Qua03f> $qua03f
 * @property-read int|null $qua03f_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Rep00f> $rep00f
 * @property-read int|null $rep00f_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Sto00f> $sto00f
 * @property-read int|null $sto00f_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Wstr01lx> $wstr01lx
 * @property-read int|null $wstr01lx_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Wstr01lx> $wstr01lxYear
 * @property-read int|null $wstr01lx_year_count
 *
 * @method static Builder|Rep00f ofEnte(int $ente)
 *
 * @property-read string $from_field
 * @property-read string|null $nome_diri
 * @property-read string $to_field
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Integparam> $integParams
 * @property-read int|null $integ_params_count
 *
 * @method static Builder<static>|Rep00f ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Qua00f> $qua00f
 * @property-read int|null $qua00f_count
 *
 * @mixin \Eloquent
 */
class Rep00f extends BaseDateRangeModel
{
    // use SigmaModelTrait;
    use EnteMatrMutator;
    use EnteMatrRelationship;

    protected $fillable = [
        'id',
        'ente',
        'matr',
        'repdal',
        'repal',
        'repst1',
        'repre1',
        'repst2',
        'repre2',
        'repcla',
        'repmar',
        'grppag',
        'numpag',
        'repc1a',
        'repc1b',
        'repc1c',
        'repc2a',
        'repc2b',
        'repc2c',
        'repc3a',
        'repc3b',
        'repc3c',
        'perc1',
        'perc2',
        'perc3',
        'piaorg',
        'repann',
        'rep2kd',
        'rep2ka',
        'rep001',
        'rep002',
        'rep003',
        'rep004',
        'rep005',
    ];

    protected $table = 'rep00f';

    // protected $dates=['rep2kd','rep2ka'];
    public const FROM_FIELD = 'rep2kd';

    public const TO_FIELD = 'rep2ka';

    public const ANN_FIELD = 'repann';

    public string $from_field = 'rep2kd';

    public string $to_field = 'rep2ka';

    public function rangeFromField(): string
    {
        return 'rep2kd';
    }

    public function rangeToField(): string
    {
        return 'rep2ka';
    }

    public function annFieldName(): string
    {
        return 'repann';
    }

    // ----------- RelationShip
    /**
     * @return HasMany<Repart, Rep00f>
     */
    public function reparts(): HasMany
    {
        /** @var HasMany<Repart, Rep00f> $relation */
        $relation = $this->hasMany(Repart::class, 'ente', 'ente')->where('stabi', $this->repst1);

        return $relation;
    }

    /**
     * @return HasOne<Repart, Rep00f>
     */
    public function repart(): HasOne
    {
        /** @var HasOne<Repart, Rep00f> $relation */
        $relation = $this->hasOne(Repart::class, 'ente', 'ente')
            ->where('stabi', $this->repst1)
            ->where('repar', $this->repre1);

        return $relation;
    }

    /**
     * @return HasOne<Repart, Rep00f>
     */
    public function stabi(): HasOne
    {
        /** @var HasOne<Repart, Rep00f> $relation */
        $relation = $this->hasOne(Repart::class, 'ente', 'ente')
            ->where('stabi', $this->repst1)
            ->where('repar', 0);

        return $relation;
    }

    /**
     * @return HasMany<Qua00f, Rep00f>
     */
    public function qua00f(): HasMany
    {
        /** @var HasMany<Qua00f, Rep00f> $relation */
        $relation = $this->hasManyByEnteMatr(Qua00f::class)
            ->ofRangeDate($this->rep2kd, $this->rep2ka);

        return $relation;
    }

    // -------------- MUTATORS ---------------
    /*
     * public function getFromFieldAttribute(?string $value):string {
     * return 'rep2kd';
     * }
     *
     * public function getToFieldAttribute(?string $value):string {
     * return 'rep2ka';
     * }
     *
     * public function getAnnAttribute(): void {
     * return 'repann';
     * }
     *
     * public function getDalAttribute(): void {
     * return 'rep2kd';
     * }
     *
     * public function getAlAttribute(): void {
     * return 'rep2ka';
     * }
     */

    /*
     * public function getRep2kdAttribute(): void {
     *
     * if(!is_object($value)){
     * $value=Carbon::parse($value);
     * }
     * return $value;
     * }
     * public function getRep2kaAttribute(): void {
     * if($value==0) return $value;
     * if(!is_object($value)){
     * $value=Carbon::parse($value);
     * }
     * return $value;
     * }
     */

    protected function getStabiTxtAttribute(?string $value): ?string
    {
        /** @var Repart|null $repart */
        $repart = $this->reparts->where('repar', 0)->first();

        if ($repart === null) {
            return null;
        }

        /** @var string|null $dest1 */
        $dest1 = $repart->dest1 ?? null;

        return $dest1;
    }

    /*
     * Undocumented function.
     *
     *
     * @return string
     */
    // public function getReparAttribute(): void {
    //    return $this->repre1;
    // }

    protected function getReparTxtAttribute(?string $value): ?string
    {
        /** @var Repart|null $repart */
        $repart = $this->reparts->where('repar', $this->repre1)->first();

        if ($repart === null) {
            return null;
        }

        /** @var string|null $dest1 */
        $dest1 = $repart->dest1 ?? null;

        return $dest1;
    }

    // --------- SCOPES --------------
    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    protected function scopeWithDays(Builder $query, ?int $date_min, ?int $date_max): Builder
    {
        if ($date_min === null || $date_max === null) {
            return $query;
        }

        return $query->selectRaw(
            'greatest(datediff(if(rep2ka=0 or rep2ka>?, ?, rep2ka), if(rep2kd<?, ?, rep2kd))+1, 0) AS days',
            [$date_max, $date_max, $date_min, $date_min],
        );
    }

    protected function scopeOfYear(Builder $query, ?int $year): Builder
    {
        if ($year === null) {
            return $query;
        }

        return $query->where(static function (Builder $q) use ($year): void {
            $q->whereRaw('(? between year(rep2kd) and year(rep2ka))', [$year])
                ->orWhereRaw('(? >= year(rep2kd) and rep2ka = 0)', [$year]);
        });
    }

    protected function scopeOfDate(Builder $query, ?int $date): Builder
    {
        if ($date === null) {
            return $query;
        }

        return $query->where(static function (Builder $q) use ($date): void {
            $q->whereRaw('(? between rep2kd and rep2ka)', [$date])
                ->orWhereRaw('(? >= rep2kd and rep2ka = 0)', [$date]);
        });
    }

    protected function scopeOfEnteYear(Builder $query, ?int $ente, ?int $year): Builder
    {
        if ($ente === null || $year === null) {
            return $query;
        }

        // 267    Call to an undefined method Illuminate\Database\Eloquent\Builder<Illuminate\Database\Eloquent\Model>::ofYear().
        return $query->where('ente', $ente)->whereRaw('repann=""')->ofYear($year);
    }

    /*
     * public function scopeOfRangeDate(): void {
     * if(is_object($date_start)){
     * $date_start=$date_start->format('Ymd');
     * }
     *
     * if($date_end==0){
     * $sql='((rep2ka >= '.$date_start.') or (rep2ka =0))';
     * return $query->whereRaw($sql);
     * }
     * $sql='
     * (
     * (
     * ('.$date_start.' between rep2kd and rep2ka ) or
     * ('.$date_start.' >= rep2kd and rep2ka=0 )
     * ) or
     * (
     * ('.$date_end.' between rep2kd and rep2ka ) or
     * ('.$date_end.' >= rep2kd and rep2ka=0 )
     * ) or
     *
     * (rep2kd between '.$date_start.' and '.$date_end.' )
     *
     *
     * )';
     *
     *
     * return $query->whereRaw($sql);
     * }
     */

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    protected function scopeOfEnteRangeDate(Builder $query, int $ente, int $date_start, int $date_end): Builder
    {
        // 301    Call to an undefined method Illuminate\Database\Eloquent\Builder<Illuminate\Database\Eloquent\Model>::ofRangeDate().
        return $query->where('ente', $ente)->whereRaw('repann=""')->ofRangeDate($date_start, $date_end);
    }

    /**
     * @param  array<string, mixed>  $params
     * @return Collection<string, array<string, mixed>>
     */
    public static function stabiReparOfYearCollection(array $params): Collection
    {
        // Estrai variabili da $params senza extract()
        $anno = $params['anno'] ?? null;
        if (! is_numeric($anno)) {
            throw new Exception('!isset($anno) or anno is not numeric');
        }
        $annoInt = (int) $anno;

        $ente = $params['ente'] ?? null;
        if (! is_numeric($ente)) {
            throw new Exception('!isset($ente) or ente is not numeric');
        }
        $enteInt = (int) $ente;

        $rep00f = self::ofYear($annoInt)
            ->whereRaw('repann=""')
            ->where('ente', $enteInt)
            ->get();
        // dddx($rep00f->count());//432
        /** @var Collection<int, array<string, mixed>> $rep00f_coll */
        $rep00f_coll = collect($rep00f->toArray())->map(static function (mixed $item) use ($annoInt): array {
            if (! \is_array($item)) {
                throw new \InvalidArgumentException('Item must be an array');
            }
            /** @var array<string, mixed> $item */
            $tmp = new stdClass;
            $tmp->ente = $item['ente'] ?? null;
            $tmp->matr = $item['matr'] ?? null;

            $repst1Value = $item['repst1'] ?? 0;
            $repst1Int = is_numeric($repst1Value) ? (int) $repst1Value : 0;
            if ($repst1Int !== 0) {
                $tmp->stabi = $repst1Int;
                $tmp->repar = $item['repre1'] ?? null;
            } else {
                $tmp->stabi = $item['repst2'] ?? null;
                $tmp->repar = $item['repre2'] ?? null;
            }

            $rep2kdValue = $item['rep2kd'] ?? null;
            if ($rep2kdValue instanceof Carbon) {
                $tmp->rep2kd = (int) $rep2kdValue->format('Ymd');
            } else {
                $rep2kdNumeric = is_numeric($rep2kdValue) ? (int) $rep2kdValue : null;
                $tmp->rep2kd = $rep2kdNumeric;
            }

            $rep2kaValue = $item['rep2ka'] ?? null;
            if ($rep2kaValue instanceof Carbon) {
                $tmp->rep2ka = (int) $rep2kaValue->format('Ymd');
            } else {
                $rep2kaNumeric = is_numeric($rep2kaValue) ? (int) $rep2kaValue : null;
                $tmp->rep2ka = $rep2kaNumeric;
            }

            $tmp->anno = $annoInt;

            return get_object_vars($tmp);
        });

        /** @var Collection<string, Collection<int, array<string, mixed>>> $grouped */
        $grouped = $rep00f_coll->groupBy(static function (array $item): string {
            $ente = $item['ente'] ?? null;
            $matr = $item['matr'] ?? null;
            $stabi = $item['stabi'] ?? null;
            $repar = $item['repar'] ?? null;
            $enteStr = is_numeric($ente) || is_string($ente) ? (string) $ente : '';
            $matrStr = is_numeric($matr) || is_string($matr) ? (string) $matr : '';
            $stabiStr = is_numeric($stabi) || is_string($stabi) ? (string) $stabi : '';
            $reparStr = is_numeric($repar) || is_string($repar) ? (string) $repar : '';

            return $enteStr.'-'.$matrStr.'-'.$stabiStr.'-'.$reparStr;
        });

        // dddx($rep00f_coll->count());//424
        /** @var Collection<string, array<string, mixed>> $result */
        $result = $grouped->map(static function (Collection $item): array {
            $firstItem = $item->first();
            if (! \is_array($firstItem)) {
                return [];
            }
            /** @var array<string, mixed> $firstItem */
            $sortedByKd = $item->sortBy('rep2kd');
            $firstByKd = $sortedByKd->first();
            $rep2kd = \is_array($firstByKd) && isset($firstByKd['rep2kd']) ? $firstByKd['rep2kd'] : null;

            $sortedByKdDesc = $item->sortByDesc('rep2kd');
            $firstByKdDesc = $sortedByKdDesc->first();
            $rep2ka = \is_array($firstByKdDesc) && isset($firstByKdDesc['rep2ka']) ? $firstByKdDesc['rep2ka'] : null;

            return [
                'ente' => $firstItem['ente'] ?? null,
                'matr' => $firstItem['matr'] ?? null,
                'stabi' => $firstItem['stabi'] ?? null,
                'repar' => $firstItem['repar'] ?? null,
                // --- da aggiungere il controllo se non ci sono "buchi" in mezzo
                'rep2kd' => $rep2kd,
                'rep2ka' => $rep2ka,
                'anno' => $firstItem['anno'] ?? null,
            ];
        });

        return $result;
    }

    protected function getNomeDiriAttribute(): ?string
    {
        /** @var Qua00f|null $record */
        $record = $this->qua00f()->first();
        if (! $record instanceof Qua00f) {
            return null;
        }

        $value = $record->nome_dire ?? null;

        return \is_string($value) ? $value : null;
    }
}
