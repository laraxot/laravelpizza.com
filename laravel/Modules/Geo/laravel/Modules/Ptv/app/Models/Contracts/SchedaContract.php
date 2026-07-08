<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection as SupportCollection;
use Modules\Sigma\Models\Contracts\DateRangeFieldsContract;
use Modules\Sigma\Models\Contracts\EnteMatrFieldsContract;
use Modules\Xot\Contracts\ModelContract;

/**
 * Contract per le schede di valutazione del personale nelle progressioni temporali variabili.
 * Definisce le proprietà essenziali per la gestione dei criteri di esclusione e valutazione.
 *
 * Estende EnteMatrFieldsContract e DateRangeFieldsContract per ereditare matrField/enteField/yearField
 * e rangeFromField/rangeToField/annFieldName — usati nei trait CommonScope e HasEnteMatrRelationHelpers.
 *
 * Ogni implementazione concreta estende `Illuminate\Database\Eloquent\Model` (via `ModelContract`).
 *
 * @phpstan-require-extends Model
 *
 * @property int $ente Codice ente
 * @property int $matr Matricola dipendente
 * @property int|null $ha_diritto Flag se ha diritto alla progressione (0/1)
 * @property string|null $motivo Motivo di esclusione se non ha diritto
 * @property int|null $disci1 Codice disciplinare 1
 * @property int|null $posfun Posizione funzionale
 * @property string|null $cognome Cognome dipendente
 * @property string|null $nome Nome dipendente
 * @property int|null $anno Anno di riferimento
 * @property string|null $categoria_eco Categoria economica
 * @property int|null $posiz Posizione
 * @property int|null $stabi Stabilimento
 * @property int|null $repar Reparto
 * @property string|null $email Email del dipendente
 * @property object|null $valutatore Relazione con il valutatore
 * @property int|null $propro Codice propro
 * @property mixed $last_data_assunz Data ultima assunzione
 * @property Collection<int, Model>|null $criteriEsclusione
 * @property float|null $perf_ind_media Media performance individuale
 * @property int|null $excellences_count_last_3_years Conteggio eccellenze ultimi 3 anni
 *
 * @method HasMany<\Modules\Sigma\Models\Asz00k1, Model> asz() Relazione ASZ — implementata in BaseScheda
 * @method \Illuminate\Database\Eloquent\Relations\MorphMany<\Modules\Ptv\Models\MyLog, \Illuminate\Database\Eloquent\Model> myLogs() Log invio mail — trait HasMyLogs su BaseScheda
 *
 * @mixin \Eloquent
 */
interface SchedaContract extends DateRangeFieldsContract, EnteMatrFieldsContract, ModelContract
{
    /**
     * Criteri di esclusione attivi per anno (config campagna valutazione).
     *
     * @return EloquentCollection<int, Model>|null null se il modello modulo Criteri* non esiste
     */
    public static function getCriteriEsclusioneByYear(int $year, string $fieldName = 'anno'): ?EloquentCollection;

    /**
     * Opzioni criteri tipizzate per anno (name => value_real).
     *
     * @return SupportCollection<string, mixed>|null null se il modello modulo Criteri* non esiste
     */
    public static function getCriteriOptionsParsedByYear(int $year, string $fieldName = 'anno'): ?SupportCollection;
}
