<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Sigma\Models\Traits\Relationships\EnteMatrRelationship;

// ----------traits ---
/**
 * Modules\Sigma\Models\Dipt00f.
 *
 * @property int $id
 * @property int $enteap
 * @property string $dtannu
 * @property int $dtmatr
 * @property string $dtturn
 * @property int $dtdal
 * @property int $dtal
 * @property string $dtcom1
 * @property string $dtcom2
 * @property int $dtcom3
 * @property int $dtcom4
 * @property Carbon|null $data_elab Data elaborazione (accessor o attributo)
 * @property-read mixed $assunzione
 * @property-read string|null $cognome
 * @property-read mixed $dimissione
 * @property-read mixed $ente
 * @property-read mixed $matr
 * @property-read string|null $nome
 * @property-read mixed $oree
 * @property-read mixed $oret
 * @property-read string|null $turno_txt
 * @property-read Anag|null $anag
 * @property-read Collection<int, Qua00f> $qua00f
 * @property-read int|null $qua00f_count
 * @property-read Collection<int, Turn01l1> $turn01l1
 * @property-read int|null $turn01l1_count
 *
 * @method static Builder|Dipt00f newModelQuery()
 * @method static Builder|Dipt00f newQuery()
 * @method static Builder|Dipt00f query()
 * @method static Builder|Dipt00f whereDtal($value)
 * @method static Builder|Dipt00f whereDtannu($value)
 * @method static Builder|Dipt00f whereDtcom1($value)
 * @method static Builder|Dipt00f whereDtcom2($value)
 * @method static Builder|Dipt00f whereDtcom3($value)
 * @method static Builder|Dipt00f whereDtcom4($value)
 * @method static Builder|Dipt00f whereDtdal($value)
 * @method static Builder|Dipt00f whereDtmatr($value)
 * @method static Builder|Dipt00f whereDtturn($value)
 * @method static Builder|Dipt00f whereEnteap($value)
 * @method static Builder|Dipt00f whereId($value)
 *
 * @property-read Collection<int, Rep00f> $rep00f
 * @property-read int|null $rep00f_count
 *
 * @mixin \Eloquent
 */
class Dipt00f extends BaseDateRangeModel
{
    use EnteMatrRelationship;

    protected $fillable = [
        'id',
        'enteap',
        'dtannu',
        'dtmatr',
        'dtturn',
        'dtdal',
        'dtal',
        'dtcom1',
        'dtcom2',
        'dtcom3',
        'dtcom4',
    ];

    protected $table = 'dipt00f';

    public const FROM_FIELD = 'dtdal';

    public const TO_FIELD = 'dtal';

    public const ANN_FIELD = 'dtannu';

    public function rangeFromField(): string
    {
        return 'dtdal';
    }

    public function rangeToField(): string
    {
        return 'dtal';
    }

    public function annFieldName(): string
    {
        return 'dtannu';
    }

    public function matrField(): string
    {
        return 'dtmatr';
    }

    public function enteField(): string
    {
        return 'enteap';
    }

    // -------relationship----
    /**
     * @return HasMany<Turn01l1, Dipt00f>
     */
    public function turn01l1(): HasMany
    {
        /** @var HasMany<Turn01l1, Dipt00f> $relation */
        $relation = $this->hasMany(Turn01l1::class, 't1codi', 'dtturn')
            ->where('enteap', $this->{$this->enteField()});

        return $relation;
    }

    protected function getEnteAttribute(): mixed
    {
        return $this->enteap;
    }

    protected function getMatrAttribute(): mixed
    {
        return $this->dtmatr;
    }

    /**
     * Accessor per cognome dipendente.
     *
     * @param  string|null  $value  Valore cached (non utilizzato)
     * @return string|null Cognome o '----' se anagrafica non trovata
     */
    protected function getCognomeAttribute(?string $value): ?string
    {
        $anag = $this->anag;
        if ($anag === null) {
            return '----';
        }

        return $anag->cognome ?? '----';
    }

    /**
     * Accessor per nome dipendente.
     *
     * @param  string|null  $value  Valore cached (non utilizzato)
     * @return string|null Nome o '----' se anagrafica non trovata
     */
    protected function getNomeAttribute(?string $value): ?string
    {
        $anag = $this->anag;
        if ($anag === null) {
            return '----';
        }

        return $anag->nome ?? '----';
    }

    /**
     * Accessor per testo turno.
     *
     * @return string|null Descrizione turno o null se non trovato
     */
    protected function getTurnoTxtAttribute(): ?string
    {
        $turn01l1 = $this->turn01l1()->orderBy('t1dal', 'desc')->first();
        if ($turn01l1 === null) {
            return null;
        }

        return $turn01l1->t1desc ?? null;

        /*
         * $sql='update '.$tablename.' set turno_txt=(select t1desc from generale.turn01l1
         * where turn01l1.t1codi='.$tablename.'.turno order by t1dal desc limit 1)
         * ';*/
    }

    protected function getOreeAttribute(): string|int|null
    {
        /** @var Qua00f|null $qua00f */
        $qua00f = $this->qua00f()->first();
        if (! $qua00f instanceof Qua00f) {
            return null;
        }

        return $qua00f->oree ?? null;
    }

    protected function getOretAttribute(): string|int|null
    {
        /** @var Qua00f|null $qua00f */
        $qua00f = $this->qua00f()->first();
        if (! $qua00f instanceof Qua00f) {
            return null;
        }

        return $qua00f->oret ?? null;
    }

    /**
     * Accessor per data assunzione.
     *
     * @return string|null Data assunzione o '---' se anagrafica o storico non trovati
     */
    protected function getAssunzioneAttribute(): ?string
    {
        if ($this->anag === null) {
            return '---';
        }

        $sto00f = $this->anag
            ->sto00f()
            ->orderBy('st2kas', 'desc')
            ->first();
        if ($sto00f === null || ! $sto00f instanceof Sto00f) {
            // Log error invece di exit in produzione
            \Log::error('Storico sto00f non trovato', [
                'ente' => $this->stringifyScalar($this->ente ?? null),
                'matr' => $this->stringifyScalar($this->matr ?? null),
                'cognome' => $this->stringifyScalar($this->cognome ?? null),
                'nome' => $this->stringifyScalar($this->nome ?? null),
            ]);

            return '---';
        }

        /** @var Sto00f $sto00f */
        $st2kas = $sto00f->st2kas ?? null;

        return $st2kas !== null ? (string) $st2kas : '---';
    }

    /**
     * Accessor per data dimissione.
     *
     * @return string|null Data dimissione o '---' se anagrafica o storico non trovati
     */
    protected function getDimissioneAttribute(): ?string
    {
        if ($this->anag === null) {
            return '---';
        }

        $sto00f = $this->anag
            ->sto00f()
            ->orderBy('st2kas', 'desc')
            ->first();
        if ($sto00f === null || ! $sto00f instanceof Sto00f) {
            // Log error invece di exit in produzione
            \Log::error('Storico sto00f non trovato per dimissione', [
                'ente' => $this->stringifyScalar($this->ente ?? null),
                'matr' => $this->stringifyScalar($this->matr ?? null),
            ]);

            return '---';
        }

        /** @var Sto00f $sto00f */
        $st2kdi = $sto00f->st2kdi ?? null;

        return $st2kdi !== null ? (string) $st2kdi : '---';
    }

    private function stringifyScalar(mixed $value): string
    {
        if (\is_scalar($value) || (\is_object($value) && method_exists($value, '__toString'))) {
            return (string) $value;
        }

        return 'N/A';
    }
}
