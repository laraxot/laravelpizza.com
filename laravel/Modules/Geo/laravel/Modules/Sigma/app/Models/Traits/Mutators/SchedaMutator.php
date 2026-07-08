<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Mutators;

use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Modules\Sigma\Models\Codici;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Tqu00f;
use Modules\Sigma\Models\Traits\Helpers\SchedaHelper;

/**
 * SchedaMutator - Accessor (get*Attribute) per Scheda.
 *
 * Responsabilità: Orchestrazione accessor (cache, guard, delega a helper, persist).
 * Delega calcoli puri a SchedaHelper.
 * Include CommonMutator per mutator generici (delegation cascade).
 *
 * @see SchedaHelper
 * @see CommonMutator
 */
trait SchedaMutator
{
    // Helper puri (calcoli)
    use CommonMutator; // Mutator comuni (delegato da SchedaTrait)
    use EnteMatrAnnoMutator; // Mutator ente+matr+anno (delegato da SchedaTrait)
    use EnteMatrDateRangeMutator; // Mutator ente+matr+daterange (delegato da SchedaTrait)
    use EnteMatrMutator; // Mutator ente+matr (delegato da SchedaTrait)
    use EnteStabiMutator; // ⚡ DELEGATION CASCADE
    use SchedaHelper; // Mutator ente+stabi (delegato da SchedaTrait)

    /**
     * Helper method: Ottiene codqua da qua00f (calcolo puro).
     *
     * Business Rule: Estrae codqua dalla relazione qua00f filtrata per qua2kd.
     * Se qua00f esiste, aggiorna anche cont e tipco per consistenza.
     *
     * @return int|null Codqua calcolato, null se non disponibile
     */
    protected function getCodqua(): ?int
    {
        // Guard: qua2kd deve esistere
        if ($this->qua2kd === '') {
            return null;
        }

        /** @var \Illuminate\Database\Eloquent\Collection<int, Qua00f> $qua00fCollection */
        $qua00fCollection = $this->qua00f;
        $qua00f = $qua00fCollection->where('qua2kd', $this->qua2kd)->first();
        if (! \is_object($qua00f)) {
            return null;
        }

        // Effettua update per consistenza (cont e tipco)
        if ($this->getKey() !== null) {
            $this->update([
                'codqua' => $qua00f->codqua,
                'cont' => $qua00f->cont,
                'tipco' => $qua00f->tipco,
            ]);
        }

        return $qua00f->codqua;
    }

    /**
     * Accessor per codqua (codice qualifica da qua00f).
     * Delega calcolo a getCodqua().
     *
     * @return int|null Codqua calcolato
     */
    protected function getCodquaAttribute(?int $value): ?int
    {
        if ($value !== null) {
            return $value;
        }

        // Delega calcolo al metodo puro (VICINO!)
        $value = $this->getCodqua();
        // ✅ Livello 4: Persisto AUTOMATICAMENTE con ActivityLog-Safe
        if ($this->getKey() !== null) {
            static::withoutEvents(function () use ($value): void {
                $this->update(['codqua' => $value]);
            });
        }

        return $value;
    }

    protected function getCodquaTxt(): ?string
    {
        /*
        $row = Codici::where('codice', '768')->get();
        $rows=Tqu00f::limit(10)->get();
        dddx($this->tqu00f()->get());
        //dddx($this->qua00f);
        return $row->desc1;
        */

        return null;
    }

    protected function getCodquaTxtAttributeTmp(?string $value): ?string
    {
        // dddx($this->integParams()->toRawSql());

        if ($value !== null) {
            return $value;
        }

        $tqu00f = $this->tqu00f()->first();
        if (! ($tqu00f instanceof Tqu00f)) {
            return null;
        }

        $value = $tqu00f->liv;
        if ($value === null) {
            return null;
        }

        // ✅ Livello 4: Persisto AUTOMATICAMENTE con ActivityLog-Safe
        // @phpstan-ignore booleanNot.alwaysTrue
        if ($this->getKey() !== null) {
            static::withoutEvents(function () use ($value): void {
                $this->update(['codqua_txt' => $value]);
            });
        }

        return $value;
    }

    /*
    protected function getClafun(): ?int
    {
         $qua00f = $this->qua00f->where('qua2kd', $this->qua2kd)->first();
         dddx($qua00f);
    }


    protected function getClafunAttribute(?int $value): ?int
    {
        if ($value !== null) {
            return $value;
        }
        $value = $this->getClafun();
        // ✅ Livello 4: Persisto AUTOMATICAMENTE con ActivityLog-Safe
        if ($this->getKey() !== null) {
            static::withoutEvents(function () use ($value): void {
                $this->update(['clafun' => $value]);
            });
        }
        return $value;

    }
    */

    /**
     * Helper method: Ottiene cont (contratto) da qua00f (calcolo puro).
     *
     * Business Rule: Estrae cont dalla relazione qua00f filtrata per qua2kd.
     *
     * @return int|string|null Valore cont, null se non disponibile
     */
    protected function getCont(): mixed
    {
        // Guard: qua2kd deve esistere
        if ($this->qua2kd === '') {
            return null;
        }

        /** @var \Illuminate\Database\Eloquent\Collection<int, Qua00f> $qua00fCollection */
        $qua00fCollection = $this->qua00f;
        $qua00f = $qua00fCollection->where('qua2kd', $this->qua2kd)->first();
        if (! ($qua00f instanceof Qua00f)) {
            return null;
        }

        return $qua00f->cont;
    }

    /**
     * Accessor per cont (contratto da qua00f).
     * Delega calcolo a getCont().
     *
     * @return int|string|null Valore cont calcolato
     */
    protected function getContAttribute(): int|string|null
    {
        // Cache hit: se già in attributes, uso quello
        $value = $this->attributes['cont'] ?? null;
        if ($value !== null) {
            /** @var int|string|null $value */
            return $value;
        }

        // Guard: record deve esistere
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro (VICINO!)
        /** @var int|string|null $value */
        $value = $this->getCont();

        // Persist se fillable
        if ($value !== null && \in_array('cont', $this->getFillable(), false)) {
            $this->update(['cont' => $value]);
        }

        return $value;
    }

    /**
     * Helper method: Ottiene tipco (tipo contratto) da qua00f (calcolo puro).
     *
     * Business Rule: Estrae tipco dalla relazione qua00f filtrata per qua2kd.
     *
     * @return int|string|null Valore tipco, null se non disponibile
     */
    protected function getTipco(): int|string|null
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int, Qua00f> $qua00fCollection */
        $qua00fCollection = $this->qua00f;
        $qua00f = $qua00fCollection->where('qua2kd', $this->qua2kd)->first();
        if (! ($qua00f instanceof Qua00f)) {
            return null;
        }

        $value = $qua00f->tipco ?? null;
        if ($value === null) {
            return null;
        }

        return is_numeric($value) ? (int) $value : (string) $value;
    }

    /**
     * Accessor per tipco (tipo contratto da qua00f).
     * Delega calcolo a getTipco().
     *
     * @return int|string|null Valore tipco calcolato
     */
    protected function getTipcoAttribute(): int|string|null
    {
        // Cache hit: se già in attributes, uso quello
        $value = $this->attributes['tipco'] ?? null;
        if ($value !== null) {
            /** @var int|string|null $value */
            return $value;
        }

        // Guard: record deve esistere
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro (VICINO!)
        /** @var int|string|null $value */
        $value = $this->getTipco();

        // Persist se valore valido
        if ($value !== null) {
            $this->update(['tipco' => $value]);
        }

        return $value;
    }

    /**
     * Helper method: Ottiene posizione economica da tqu00f (calcolo puro).
     *
     * Business Rule: Estrae descrizione posizione economica da tqu00f.
     * Formato: "Descrizione (codice)"
     *
     * @return string|null Posizione economica formattata, null se non disponibile
     */
    protected function getPosizioneEco(): ?string
    {
        $tqu00f = $this->tqu00f;
        if (! ($tqu00f instanceof Tqu00f)) {
            return null;
        }

        $desc1 = $tqu00f->desc1 ?? '';
        $desc2 = $tqu00f->desc2 ?? '';
        $value = str_replace('Posizione economica', '', (string) $desc1);
        $value .= ' ('.$desc2.')';

        return $value;
    }

    /**
     * Accessor per posizione_eco (posizione economica da tqu00f).
     * Delega calcolo a getPosizioneEco().
     *
     * @param  string|null  $value  Valore cached dal DB
     * @return string|null Posizione economica calcolata
     */
    protected function getPosizioneEcoAttribute(?string $value): ?string
    {
        // Cache hit (con refresh opzionale)
        if ($value !== null && ! request('refresh', false)) {
            return $value;
        }

        // Guard: record deve esistere
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro (VICINO!)
        $value = $this->getPosizioneEco();

        if ($value === null) {
            return null;
        }

        // Persist con gestione errori
        try {
            $this->update(['posizione_eco' => $value]);
        } catch (\Exception $e) {
            Log::warning('Failed to save posizione_eco in SchedaMutator', [
                'field' => 'posizione_eco',
                'model' => $this::class,
                'error' => $e->getMessage(),
            ]);
        }

        return $value;
    }

    /**
     * Helper method: Calcola percentuale part-time ponderata anno (calcolo puro).
     *
     * Business Rule: perc_parttime_anno * (1 - (gg_parttimevert_anno / gg_presenza_anno)).
     * Se gg_presenza_anno = 0, return 0.
     *
     * @return float|null Percentuale calcolata, null se dati non disponibili
     */
    protected function getPercParttimepondAnno(): ?float
    {
        if ($this->gg_presenza_anno == 0) {
            return 0.0;
        }

        return (float) ($this->perc_parttime_anno * (1 - ($this->gg_parttimevert_anno / $this->gg_presenza_anno)));
    }

    /**
     * Accessor per perc_parttimepond_anno (percentuale part-time ponderata anno).
     * Delega calcolo a getPercParttimepondAnno().
     *
     * @param  float|null  $value  Valore cached dal DB
     * @return float|null Percentuale calcolata
     */
    protected function getPercParttimepondAnnoAttribute(?float $value = null): ?float
    {
        // Cache hit
        $rawValue = $this->attributes['perc_parttime_pond_anno'] ?? null;
        $value = $value ?? ($rawValue !== null && is_numeric($rawValue) ? (float) $rawValue : null);
        if ($value !== null) {
            return $value;
        }

        // Guard: record deve esistere
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro (VICINO!)
        $value = $this->getPercParttimepondAnno();

        // Persist con update
        $this->update(['perc_parttimepond_anno' => $value]);

        return (float) $value;
    }

    /**
     * Helper method: Calcola percentuale part-time ponderata dal-al (calcolo puro).
     *
     * Business Rule: perc_parttime_dalal * (1 - (gg_parttimevert_dalal / gg_presenza_dalal)).
     * Se gg_presenza_dalal = 0, return 0.
     *
     * @return float|null Percentuale calcolata, null se dati non disponibili
     */
    protected function getPercParttimepondDalal(): ?float
    {
        if ($this->gg_presenza_dalal == 0) {
            return 0.0;
        }

        return (float) ($this->perc_parttime_dalal * (1 - ($this->gg_parttimevert_dalal / $this->gg_presenza_dalal)));
    }

    /**
     * Accessor per perc_parttimepond_dalal (percentuale part-time ponderata dal-al).
     * Delega calcolo a getPercParttimepondDalal().
     *
     * @return float|null Percentuale calcolata
     */
    protected function getPercParttimepondDalalAttribute(): ?float
    {
        // Cache hit
        $rawValue = $this->attributes['perc_parttime_pond_dalal'] ?? null;
        $value = $rawValue !== null && is_numeric($rawValue) ? (float) $rawValue : null;
        if ($value !== null) {
            return $value;
        }

        // Guard: record deve esistere
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro (VICINO!)
        $value = $this->getPercParttimepondDalal();

        // Persist con update
        $this->update(['perc_parttimepond_dalal' => $value]);

        return $value;
    }

    /**
     * Helper method: Ottiene descrizione disciplina 1 da Codici (calcolo puro).
     *
     * Business Rule: Estrae desc1 da Codici dove tipo=6 e codice=disci1.
     *
     * @return string|null Descrizione disciplina, null se non disponibile
     */
    protected function getDisci1Txt(): ?string
    {
        if ($this->disci1 == null) {
            return null;
        }

        $row = Codici::where('tipo', 6)->where('codice', $this->disci1)->first();
        if (! \is_object($row)) {
            return null;
        }

        return $row->desc1;
    }

    /**
     * Accessor per disci1_txt (descrizione disciplina 1 da Codici).
     * Delega calcolo a getDisci1Txt().
     *
     * @param  string|null  $value  Valore cached dal DB
     * @return string|null Descrizione calcolata
     */
    protected function getDisci1TxtAttribute(?string $value): ?string
    {
        // Cache hit
        if ($value !== null) {
            return $value;
        }

        // Guard: record deve esistere
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro (VICINO!)
        $value = $this->getDisci1Txt();

        if ($value === null) {
            return null;
        }

        // Persist con gestione errori
        try {
            $this->update(['disci1_txt' => $value]);
        } catch (\Exception) {
            // Se tabella non ha colonna, la crea (legacy behavior)
            $fieldname = 'disci1_txt';
            if (! Schema::connection($this->getConnectionName())->hasColumn($this->getTable(), $fieldname)) {
                Schema::connection($this->getConnectionName())->table($this->getTable(), static function (Blueprint $table) use (
                    $fieldname,
                ): void {
                    $table->string($fieldname);
                });
            }
        }

        return $value;
    }

    protected function getPosizTxtAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        if ($this->posiz == null) {
            return null;
        }

        $row = Codici::firstWhere(['tipo' => 19, 'codice' => $this->posiz]);
        if (! \is_object($row)) {
            return null;
        }

        // ⚠️ DO NOT call update() inside accessor - causes infinite loop
        // Just set the raw attribute value without triggering events
        $this->attributes['posiz_txt'] = $row->desc1;

        return isset($this->attributes['posiz_txt']) && is_string($this->attributes['posiz_txt']) ? $this->attributes['posiz_txt'] : null;
    }

    protected function getDisci1Attribute(?int $value): ?int
    {
        if ($value != null && ! request()->input('refresh', false)) {
            return $value;
        }
        $qua00fRelation = $this->qua00fDaterange();
        if ($qua00fRelation === null) {
            return null;
        }
        $qua00f_curr = $qua00fRelation->first();
        if (! ($qua00f_curr instanceof Qua00f)) {
            return null;
        }

        // Access to disci1 property via getAttribute for type safety
        $value = is_numeric($qua00f_curr->getAttribute('disci1')) ? (int) $qua00f_curr->getAttribute('disci1') : null;
        if ($value === null) {
            return null;
        }

        // ⚠️ DO NOT call update() inside accessor - may causes infinite loop
        // Just set the raw attribute value without triggering events
        $this->attributes['disci1'] = $value;
        if ($this->getKey() != null) {
            $this->update(['disci1' => $value]);
        }

        return $value;
    }

    protected function getCategoriaEcovalAttribute(?string $value): ?string
    {
        if ($value != null && ! request()->input('refresh', false)) {
            return $value;
        }
        if ($this->matr == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        $categoria_propro = $this->categoriaPropro;
        $value = $categoria_propro?->getAttribute('categoria');

        // ⚠️ DO NOT call update() inside accessor - causes infinite loop
        // Just set the raw attribute value without triggering events
        $this->attributes['categoria_ecoval'] = $value;

        return $value === null ? null : (string) $value;
    }

    protected function getPosizAttribute(?int $value = null): ?int
    {
        // Get raw value if not provided
        $rawValue = $this->attributes['posiz'] ?? null;
        $value = $value ?? ($rawValue !== null && is_numeric($rawValue) ? (int) $rawValue : null);
        if ($value !== null) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        $qua00f = $this->qua00f;
        if ($qua00f === null) {
            dddx('errore');
        }

        if ($qua00f->count() !== 1) {
            // dddx($qua00f);
            // @phpstan-ignore argument.type, return.type
            $arr = collect($qua00f)->map(static fn ($item): array => [
                // @phpstan-ignore offsetAccess.nonOffsetAccess
                'propro' => $item->propro,
                // @phpstan-ignore offsetAccess.nonOffsetAccess
                'posfun' => $item->posfun,
            ]);

            // foreach($arr as $i){
            // }
            // dddx($arr->count());
        }

        $value = $qua00f->first()?->getAttribute('posiz');

        // ⚠️ DO NOT call update() inside accessor - causes infinite loop
        // Just set the raw attribute value without triggering events
        $this->attributes['posiz'] = $value;

        return $value === null ? null : (int) $value;
    }

    /**
     * Helper method: Calcola età anagrafica (calcolo puro).
     *
     * Business Rule: Differenza in anni tra data nascita (ana2kd) e data_presenza_al.
     * Se ana02f non esiste o vuota, return 0.
     *
     * @return float|null Età calcolata, 0 se dati non disponibili
     */
    protected function getEta(): ?float
    {
        $ana02f = $this->ana02f;
        if ($ana02f === null) {
            return 0.0;
        }

        if ($ana02f->last() === null) {
            return 0.0;
        }

        /** @var object{ana2kd: string}|null $lastAna */
        $lastAna = $ana02f->last();
        $ana2kd = $lastAna->ana2kd ?? '';
        $ana2kd_date = Date::createFromFormat('Ymd', $ana2kd);
        $date_max = $this->criteriOptionsArr('data_presenza_al');

        // Verifica che $date_max sia una Carbon instance
        if (! ($date_max instanceof Carbon)) {
            return 0.0;
        }

        // Calcolo età: giorni / 365.25 (con anni bisestili)
        $daysDiff = $date_max->diffInDays($ana2kd_date, true);
        $value = $daysDiff / 365.25;

        return abs((float) $value);
    }

    /**
     * Accessor per eta (età anagrafica).
     * Delega calcolo a getEta().
     *
     * @param  float|null  $value  Valore cached dal DB
     * @return float|null Età calcolata
     */
    protected function getEtaAttribute(?float $value): ?float
    {
        // Cache hit
        if ($value !== null && $value > 0 && ! request()->input('refresh', 0)) {
            return $value;
        }

        // Guard: record deve esistere
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro (VICINO!)
        $valueFloat = $this->getEta();

        // Persist con update
        $this->update(['eta' => $valueFloat]);

        return $valueFloat;
    }

    /*
     * public function getPosizTxtAttribute(): void {
     * if (null !== $value) {
     * return $value;
     * }
     *
     * $row = Codici::where('tipo', 19)->where('codice', $this->posiz)->first();
     * if (! \is_object($row)) {
     * return null;
     * }
     *
     * $this->attributes['posiz_txt'] = $row->desc1;
     * $this->save();
     *
     * return $this->attributes['posiz_txt'];
     * }
     */
    /* esempio trimestrale
     * public function getDalAttribute(): void {
     * if ($value != '') {
     * return $value;
     * }
     * $value = $this->anno * 10000 + 101;
     * $this->dal=$value;
     * $this->save();
     * return $value;
     * }
     *
     * public function getAlAttribute(): void {
     * if ($value != '') {
     * return $value;
     * }
     * $value = $this->anno * 10000 + 1231;
     * $this->al=$value;
     * $this->save();
     * return $value;
     * }
     */
    // *
    // */
    public function getWorkerType(): string
    {
        if ($this->isPo()) {
            return 'po';
        }
        if ($this->isRegionale()) {
            return 'regionale';
        }

        return 'dip';
    }

    /**
     * @return mixed
     */
    public function getTypeAttribute(?string $value)
    {
        if ($value != null) {
            return $value;
        }
        $value = $this->getWorkerType();

        if ($this->getKey() !== null) {
            static::withoutEvents(function () use ($value): void {
                // $this->update(['type' => $value]);
                $this->attributes['type'] = $value;
                $this->save();
            });
        }

        return $value;
    }
}
