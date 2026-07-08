<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Accessors;

/**
 * PerfAccessor - Accessor per performance (perf_ind_*).
 *
 * @phpstan-ignore trait.unused
 */
trait PerfAccessor
{
    protected function getTotalePondAttribute(?float $value): ?float
    {
        // Cache hit
        if ($value !== null) {
            return $value;
        }

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro
        $value = $this->getTotalePond();

        // Persist con update chirurgico (salva SOLO questo campo, previene loop)
        $this->update(['totale_pond' => $value]);

        return $value;
    }

    protected function getPuntProgressioneFinaleAttribute(?float $value): ?float
    {
        $old_value = $value;
        /*
         * //if($value!='') return $value;
         * $scheda_criteri=$this->schedaCriteri;
         * $tot=0;
         * foreach($scheda_criteri as $k=>$v){
         * $converted=$this->convertedIn($v->field_name,$v->converted_in);
         * $converted_peso=$converted*$v->peso/10;
         * $tot+=$converted_peso;
         * }
         *
         * $value=$tot;
         */
        $value = $this->puntProgressioneFinale();
        // dddx(['old_value' => $old_value, 'value' => $value]);
        if ($old_value !== $value) {
            // ✅ Check: record deve esistere prima di save()
            if ($this->getKey() == null) {
                return round($value, 3);
            }

            // Persist con update chirurgico (salva SOLO questo campo, previene loop)
            $this->update(['punt_progressione_finale' => $value]);
        }

        return round($value, 3);
    }

    protected function getExcellencesCountLast3yearsAttribute(?int $value): ?int
    {
        if ($value != null && ! request()->input('refresh', 0)) {
            return $value;
        }

        $value = $this->excellencesCountLast3years();

        $this->update(['excellences_count_last_3_years' => $value]);

        return $value;
    }
}
