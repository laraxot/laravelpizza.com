<?php

declare(strict_types=1);

namespace Modules\Performance\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\Performance\Models\Individuale;
use Modules\Sigma\Datas\GgFilterData;

/**
 * @template TModel of Model
 */
trait MutatorTrait
{
    /**
     * Calcola giorni assenza nel range dal-al.
     *
     * Metodo separato per il calcolo complesso (Pattern Livello 4).
     */
    public function getGgAssenzaDalal(): int
    {
        $lista_tipo_codice_assenze = $this->listaTipoCodiceAssenze();

        $date_min = $this->dal;
        $date_max = $this->al;

        // Guard: invalid date range prevents SQL errors
        if ($date_min === '' || $date_max === '' || $date_min === null || $date_max === null) {
            return 0;
        }

        // Guard: empty lista_tipo_codice_assenze prevents invalid SQL: IN ()
        if (empty($lista_tipo_codice_assenze)) {
            return 0;
        }

        $asz00k1s = $this->asz00k1()
            ->whereIn(DB::raw("CONCAT(asztip, '-', aszcod)"), $lista_tipo_codice_assenze)
            ->selectRaw('COALESCE(sum(CAST(aszdur AS DECIMAL(10,2))),0) as aszdur_sum')
            ->whereBetween('asz2kd', [$date_min, $date_max])
            ->where('aszumi', 'G')
            ->first();

        // ✅ isset() invece di property_exists() - funziona per attributi magici Eloquent
        $aszdur_sum = (is_object($asz00k1s) && isset($asz00k1s->aszdur_sum)) ? $asz00k1s->aszdur_sum : 0;

        return (int) $aszdur_sum;
    }

    public function getGgAssenzaDalalAttribute(?int $value): ?int
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_int($value)) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $int_value = $this->getGgAssenzaDalal();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE
        static::withoutEvents(function () use ($int_value): void {
            $this->update(['gg_assenza_dalal' => $int_value]);
        });

        return $int_value;
    }

    /**
     * Calcola ore assenza nel range dal-al.
     *
     * Metodo separato per il calcolo complesso (Pattern Livello 4).
     */
    public function getHhAssenzaDalal(): float
    {
        $lista_tipo_codice_assenze = $this->listaTipoCodiceAssenze();

        $date_min = $this->dal;
        $date_max = $this->al;

        if ($date_min === '') {
            return 0.0;
        }

        // Guard: empty lista_tipo_codice_assenze prevents invalid SQL: IN ()
        if (empty($lista_tipo_codice_assenze)) {
            return 0.0;
        }

        $value = $this->asz00k1()
            ->whereIn(DB::raw("CONCAT(asztip, '-', aszcod)"), $lista_tipo_codice_assenze)
            ->selectRaw('COALESCE(sum(CAST(aszdur AS DECIMAL(10,2))),0) as aszdur_sum')
            ->whereBetween('asz2kd', [$date_min, $date_max])
            ->where('aszumi', 'O')
            ->first();

        // ✅ isset() invece di property_exists() - funziona per attributi magici Eloquent
        $aszdur_sum = (is_object($value) && isset($value->aszdur_sum)) ? $value->aszdur_sum : 0;

        if (empty($aszdur_sum)) {
            return 0.0;
        }

        return (float) $aszdur_sum;
    }

    public function getHhAssenzaDalalAttribute(?float $value): ?float
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_float($value)) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $float_value = $this->getHhAssenzaDalal();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE
        static::withoutEvents(function () use ($float_value): void {
            $this->update(['hh_assenza_dalal' => $float_value]);
        });

        return $float_value;
    }

    /**
     * Calcola totale punteggio.
     *
     * Metodo separato per il calcolo complesso (Pattern Livello 4).
     */
    public function getTotalePunteggio(): ?float
    {
        if ($this->getKey() == null) {
            return null;
        }

        $value = 0.0;
        $criteri_valutazione = $this->criteriValutazione->where('post_type', $this->type);

        foreach ($criteri_valutazione as $v) {
            $nomeField = is_object($v) && isset($v->nome) && is_string($v->nome) ? $v->nome : '';
            if ($nomeField === '') {
                continue;
            }

            /** @var float $val */
            $val = (float) ($this->getAttribute($nomeField) ?? 0);
            /** @var float $peso */
            $peso = (float) $this->getPeso($nomeField);

            $value += ((float) $val * (float) $peso) / 4;
        }

        // Fallback: se valore è basso e ha_diritto > 0, copia da altro record
        if ($value <= 0.001 && $this->ha_diritto > 0) {
            $where = [
                'ente' => $this->ente,
                'matr' => $this->matr,
                'anno' => $this->anno,
            ];
            $row = Individuale::where($where)
                ->where('ha_diritto', '>', 0)
                ->where('esperienza_acquisita', '>', 0)
                ->first();

            if ($row !== null) {
                $value = 0.0;
                foreach ($criteri_valutazione as $v) {
                    $nomeField = is_object($v) && isset($v->nome) && is_string($v->nome) ? $v->nome : '';
                    if ($nomeField === '') {
                        continue;
                    }
                    $rowValue = $row->getAttribute($nomeField);
                    if ($rowValue !== null) {
                        $value += ((float) $rowValue * (float) $this->getPeso($nomeField)) / 4;
                    }
                }
            }
        }

        return $value;
    }

    public function getTotalePunteggioAttribute(?float $value): ?float
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_float($value) && $value >= 1) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $value = $this->getTotalePunteggio();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE
        static::withoutEvents(function () use ($value): void {
            $this->update(['totale_punteggio' => $value]);
        });

        return $value;
    }

    /*
     public function getGgPresenzaAnnoAttribute(?int $value): ?int
    {
        if ($value !== null && ! request()->input('refresh', false)) {
            return $value;
        }


        $anno = $this->anno;
        $dal = $anno * 10000 + 101;
        $al = $anno * 10000 + 1231;
        $parz = [
            'date_min' => $dal,
            'date_max' => $al,
        ];
        $anag = $this->anag;
        if ($anag === null) {
            return null;
        }
        $data = GgFilterData::from($parz);

        $value = $anag->ggInSedeTot($data);
        $this->gg_presenza_anno = $value;
        $this->save();

        return $value;
    }
    */
    /*
    public function getGgAssenzaAnnoAttribute(?int $value): ?int
    {
        if ($value !== null && ! request()->input('refresh', 0)) {
            return $value;
        }
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }

        // dddx($this->anno);
        // dddx($this->criteriEsclusione->pluck('value', 'name')['data_presenza_al']);
        // $data_presenza_al = ($this->criteriEsclusione->data_presenza_al);
        // $anno = $data_presenza_al->year;
        $anno = $this->anno;
        $dal = $anno * 10000 + 101;
        $al = $anno * 10000 + 1231;
        $value = $this->anag?->ggAssenzaInSedeTot(
            [
                'date_min' => $dal,
                'date_max' => $al,
            ]
        );
        $this->gg_assenza_anno = $value;
        $this->save();

        return $value;
    }
    */
    public function setTypeAttribute(string|\Modules\Ptv\Enums\WorkerType|null $value): void
    {
        // Convert enum to string value
        $stringValue = $value instanceof \Modules\Ptv\Enums\WorkerType ? $value->value : $value;

        // Auto-detect type if not provided or when refreshing
        if ($stringValue === null || (app()->has('request') && request()->exists('refresh'))) {
            if ($this->isRegionale()) {
                $stringValue = 'regionale';
            } elseif ($this->isDirigente()) {
                $stringValue = 'dirigente';
            } elseif ($this->isPo()) {
                $stringValue = 'po';
            } else {
                $stringValue = 'dip';
            }
        }

        $this->attributes['type'] = $stringValue;

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() === null) {
            return;
        }

        // Persist the value
        static::withoutEvents(function () use ($stringValue): void {
            $this->update([
                'type' => $stringValue,
            ]);
        });
    }
}
