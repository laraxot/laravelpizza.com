<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Mutators;

use Carbon\Carbon;
use Modules\Sigma\Models\Qua00f;

trait EnteMatrDateRangeMutator
{
    /**
     * Convert date value to integer Ymd format.
     */
    private function dateToYmdInt(Carbon|int|string|null $date): int
    {
        if ($date === null) {
            return 0;
        }

        if ($date instanceof Carbon) {
            return (int) $date->format('Ymd');
        }

        if (is_numeric($date)) {
            return (int) $date;
        }

        try {
            $carbon = Carbon::parse((string) $date);

            return (int) $carbon->format('Ymd');
        } catch (\Throwable) {
            return 0;
        }
    }

    /**
     * Get percentage part-time for date range.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Persisto AUTOMATICAMENTE il risultato
     * 4. Mantengo l'accessore pulito e leggibile
     */
    protected function getPercPTimeDaterangeAttribute(?float $value): ?float
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_float($value)) {
            return $value;  // Già calcolato, torno subito
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $value = $this->getPercPTimeDaterange();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE (campo CORRETTO!)
        if ($this->getKey() !== null) {
            static::withoutEvents(function () use ($value): void {
                $this->update(['perc_ptime_daterange' => $value]);
            });
        }

        return $value;
    }

    /**
     * Calcola la percentuale part-time per il range di date.
     *
     * Metodo separato per il calcolo complesso.
     * Questo mantiene l'accessore pulito e leggibile (Livello 4).
     */
    public function getPercPTimeDaterange(): float
    {
        $rows = $this->qua00fDaterange();
        if ($rows === null) {
            return 0.0;
        }

        $array = $rows->get()->toArray();

        $ore = 0.0;
        $giorni = 0;
        foreach ($array as $v) {
            if (! is_array($v)) {
                continue;
            }
            $oreeRaw = $v['oree'] ?? null;
            $oretRaw = $v['oret'] ?? null;
            $giorniRaw = $v['giorni'] ?? null;

            $oree = is_numeric($oreeRaw) ? (float) $oreeRaw : 0.0;
            $oret = is_numeric($oretRaw) ? (float) $oretRaw : 1.0;
            $giorniVal = is_numeric($giorniRaw) ? (int) $giorniRaw : 0;
            if ($oret !== 0.0) {
                $ore += ($oree / $oret) * (float) $giorniVal;
            }
            $giorni += $giorniVal;
        }

        if ($giorni === 0) {
            return 0.0;
        }

        return $ore / $giorni;
    }

    /**
     * Get perc_parttime_dalal attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Persisto AUTOMATICAMENTE il risultato
     * 4. Mantengo l'accessore pulito e leggibile
     */
    protected function getPercParttimeDalalAttribute(?float $value): ?float
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_float($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $value = $this->getPercParttimeDalal();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE
        if ($this->getKey() !== null) {
            static::withoutEvents(function () use ($value): void {
                $this->update(['perc_parttime_dalal' => $value]);
            });
        }

        return $value;
    }

    /**
     * Calcola la percentuale part-time dal/al.
     *
     * Metodo separato per il calcolo complesso.
     * Questo mantiene l'accessore pulito e leggibile (Livello 4).
     */
    public function getPercParttimeDalal(): ?float
    {
        $date_min = $this->dal;
        $date_max = $this->al;
        if ($date_min === null || $date_min === 0 || $date_min === '') {
            return null;
        }
        if ($date_max === null) {
            return null;
        }

        $date_min_int = $this->dateToYmdInt($date_min);
        $date_max_int = $this->dateToYmdInt($date_max);
        if ($date_min_int === 0 || $date_max_int === 0) {
            return null;
        }

        $date_min_int_typed = $date_min_int;
        $date_max_int_typed = $date_max_int;

        $rows = $this->qua00f()
            ->getQuery()
            ->withDays($date_min_int_typed, $date_max_int_typed)
            ->withPercPtime()
            ->having('days', '>', 0)
            ->get();
        $perc = 0.0;
        $peso = 0.0;
        /** @var \Illuminate\Database\Eloquent\Model $row */
        foreach ($rows as $row) {
            // Proprietà dinamiche aggiunte da withDays() e withPercPtime()
            $percPtimeRaw = $row->getAttribute('perc_ptime');
            $daysRaw = $row->getAttribute('days');

            $percPtime = is_numeric($percPtimeRaw) ? (float) $percPtimeRaw : 0.0;
            $days = is_numeric($daysRaw) ? (float) $daysRaw : 0.0;

            $perc += $percPtime * $days;
            $peso += $days;
        }

        if ($peso === 0.0) {
            return null;
        }

        return $perc / $peso;
    }

    /**
     * Get gg_parttimevert_dalal attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Persisto AUTOMATICAMENTE il risultato
     * 4. Mantengo l'accessore pulito e leggibile
     */
    protected function getGgParttimevertDalalAttribute(?float $value): ?float
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_numeric($value)) {
            return (float) $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $value = $this->getGgParttimevertDalal();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE
        if ($this->getKey() !== null) {
            static::withoutEvents(function () use ($value): void {
                $this->update(['gg_parttimevert_dalal' => $value]);
            });
        }

        return $value;
    }

    /**
     * Calcola i giorni parttime verticale dal/al.
     *
     * Metodo separato per il calcolo complesso.
     * Questo mantiene l'accessore pulito e leggibile (Livello 4).
     */
    public function getGgParttimevertDalal(): ?float
    {
        $date_min = $this->dal;
        $date_max = $this->al;
        if ($date_min === null || $date_min === 0 || $date_min === '') {
            return null;
        }
        if ($date_max === null) {
            return null;
        }

        $date_min_int = $this->dateToYmdInt($date_min);
        $date_max_int = $this->dateToYmdInt($date_max);
        if ($date_min_int === 0 || $date_max_int === 0) {
            return null;
        }

        $date_min_int_typed = $date_min_int;
        $date_max_int_typed = $date_max_int;

        $value = $this->asz00k1()
            ->getQuery()
            ->where('asztip', 505)
            ->where('aszcod', 97)
            ->withDays($date_min_int_typed, $date_max_int_typed)
            ->get()
            ->sum('days');

        return is_numeric($value) ? (float) $value : null;
    }

    public function getGgPresenzaDalal(): ?int
    {
        $date_min = $this->dal;
        $date_max = $this->al;
        if ($date_min === null || $date_min === 0 || $date_min === '') {
            return 0;
        }
        if ($date_max === null) {
            return 0;
        }

        $date_min_int = $this->dateToYmdInt($date_min);
        $date_max_int = $this->dateToYmdInt($date_max);
        if ($date_min_int === 0 || $date_max_int === 0) {
            return 0;
        }

        $date_min_int_typed = $date_min_int;
        $date_max_int_typed = $date_max_int;

        $value = $this->qua00f()
            ->getQuery()
            ->withDays($date_min_int_typed, $date_max_int_typed)
            ->get()
            ->sum('days');

        return is_numeric($value) ? (int) $value : null;
    }

    /**
     * Get gg_presenza_dalal attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Persisto AUTOMATICAMENTE il risultato
     * 4. Mantengo l'accessore pulito e leggibile
     */
    protected function getGgPresenzaDalalAttribute(?int $value): ?int
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_int($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $value = $this->getGgPresenzaDalal();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE
        if ($this->getKey() !== null) {
            static::withoutEvents(function () use ($value): void {
                $this->update(['gg_presenza_dalal' => $value]);
            });
        } else {
            dddx($this);
        }

        return $value;
    }

    /**
     * Get categoria_eco attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Persisto AUTOMATICAMENTE il risultato
     * 4. Mantengo l'accessore pulito e leggibile
     */
    protected function getCategoriaEcoAttribute(?string $value): ?string
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if ($value !== null) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $value = $this->getCategoriaEco();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE
        if ($this->getKey() !== null) {
            static::withoutEvents(function () use ($value): void {
                $this->update(['categoria_eco' => $value]);
            });
        }

        return $value;
    }

    /**
     * Calcola la categoria economica.
     *
     * Metodo separato per il calcolo complesso.
     * Questo mantiene l'accessore pulito e leggibile (Livello 4).
     */
    public function getCategoriaEco(): ?string
    {
        if ($this->matr === null) {
            return null;
        }
        if ($this->qua2kd === null) {
            return null;
        }

        $qua00fRelation = $this->qua00fDaterange();
        if ($qua00fRelation === null) {
            return null;
        }
        $qua00f = $qua00fRelation->first();

        if (! ($qua00f instanceof Qua00f)) {
            return null;
        }

        $tqu00f = $qua00f->tqu00f;
        if ($tqu00f === null) {
            return null;
        }

        $categoria_eco = $tqu00f->desc1;
        $categoria_eco = str_replace('Posizione economica ', '', (string) $categoria_eco);

        return $categoria_eco;
    }
}
