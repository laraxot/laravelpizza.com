<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\Progressioni\Models\CategoriaPropro;
use Modules\Progressioni\Models\SchedaCriteri;
use Modules\Sigma\Datas\GgFilterData;
use Modules\Sigma\Models\Integparam;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Traits\Helpers\SchedaHelper;
use Modules\Sigma\Models\Traits\Mutators\SchedaMutator;
use Modules\Sigma\Models\Traits\Relationships\SchedaRelationship;
use Modules\Sigma\Models\Traits\Scopes\SchedaScope;

/**
 * Modules\Sigma\Models\Traits\SigmaModelTrait.
 *
 * @property float $percparttime
 * @property int $giorni_parttimevert
 * @property int $giorni_presenza
 *
 * @phpstan-ignore trait.unused
 */
trait SchedaExtraFieldTrait
{
    // → CommonScope
    use SchedaHelper; // ⚡ DELEGATION CASCADE PATTERN (DRY + KISS + SRP)
    // SchedaTrait = Pure Orchestrator, delega implementazioni ai trait specifici

    // ⚡ DELEGATION CASCADE PATTERN (4 domain-specific trait)
    use SchedaMutator; // → CommonMutator, EnteMatr*Mutator
    use SchedaRelationship; // → CommonRelationship, EnteMatr*Relationship, TquRelationship
    use SchedaScope; // → FunctionExtra, MassExtra, Helper inline

    // -------------
    // ⚡ HELPER METHODS: Migrated to SchedaHelper.php (703 lines)
    // - 23 protected helper methods (pure calculations)
    // - 12 public helper methods (reusable utilities)
    // Accessible via trait composition above
    //
    // ACCESSOR METHODS: Still in this file (Phase 2 migration planned)
    // - 83 public get*Attribute() methods
    // - Delegate to helpers from SchedaHelper
    //
    // @see \Modules\Sigma\Models\Traits\Helpers\SchedaHelper
    // @see \Modules\Sigma\docs\refactoring\phase1-pragmatic-completion.md
    // -------------

    /**
     * Accessor per gg_integ_params_asz (giorni integrazione parametri assenze).
     * Delega calcolo a getGgIntegParamsAsz().
     *
     * @param  float|null  $value  Valore cached dal DB
     * @return float|null Giorni integrazione parametri calcolati
     */
    // Helper methods delegated to SchedaHelper - removed duplicates

    protected function getGgIntegParamsAszAttribute(?float $value): ?float
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_integ_params_asz') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('gg_integ_params_asz');
        }

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro
        $value = $this->getGgIntegParamsAsz();

        if ($value === null) {
            return null;
        }

        // Store in schemaless attributes
        $this->calculated_data->set('gg_integ_params_asz', $value);

        return $value;
    }

    /**
     * Accessor per gg_esperienza_no_asz (giorni esperienza senza assenze).
     * Delega calcolo a getGgEsperienzaNoAsz().
     *
     * @param  int|null  $value  Valore cached dal DB
     * @return int|null Giorni esperienza netti calcolati
     */
    protected function getGgEsperienzaNoAszAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_esperienza_no_asz') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('gg_esperienza_no_asz');
        }

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro
        $value = $this->getGgEsperienzaNoAsz();

        if ($value === null) {
            return null;
        }

        // Store in schemaless attributes
        $this->calculated_data->set('gg_esperienza_no_asz', $value);

        return $value;
    }

    protected function getGgCatecoPosfunNoAszAttribute(?int $value): ?int
    {
        $fieldname = 'gg_cateco_posfun_no_asz';

        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has($fieldname) && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get($fieldname);
        }

        if ($this->getKey() == null) {
            return null;
        }

        if ($this->matr == null) {
            return null;
        }

        if ($this->propro == null) {
            return null;
        }

        $value = $this->getGgCatecoPosfunNoAsz();

        // Store in schemaless attributes
        $this->calculated_data->set($fieldname, $value);

        return $value;
    }

    protected function getPostTypeAttribute(?string $value): string
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('post_type') && ! request()->input('refresh', 0)) {
            return (string) $this->calculated_data->get('post_type');
        }

        // *

        if ($value !== null && ! request()->input('refresh', 0)) {
            return $value;
        }

        // */
        /**
         * @var array
         */
        $models = config('xra.model');
        $post_type = collect($models)->search(static::class);
        if ($post_type === false) {
            $post_type = Str::snake(class_basename($this));
        }

        if ($post_type === 'progressioni') {
            // tabella generica
            if ($this->isPo()) {
                $post_type = 'po';
            } elseif ($this->isRegionale()) {
                $post_type = 'regionale';
            } else {
                $post_type = 'dip';
            }
        }

        // Guard: record deve esistere
        if ($this->getKey() == null) {
            return (string) $post_type;
        }

        if (! \is_string($post_type)) {
            throw new Exception('['.__LINE__.']['.__FILE__.']');
        }

        // Store in schemaless attributes
        $this->calculated_data->set('post_type', $post_type);

        return $post_type;
    }

    /**
     * Helper method: Calcola valore posizione funzionale (calcolo puro).
     *
     * Business Rule: Estrae ultima cifra da codice posizione funzionale.
     * Es: posfun "D8" → posfunval 8
     *
     * @return int|null Valore posizione funzionale, null se posfun non disponibile
     */
    protected function getPosfunval(): ?int
    {
        if ($this->posfun == null) {
            return null;
        }

        return (int) substr((string) $this->posfun, -1);
    }

    /**
     * Accessor per posfunval (valore numerico posizione funzionale).
     * Delega calcolo a getPosfunval().
     *
     * @param  int|null  $value  Valore cached dal DB
     * @return int|null Valore posizione funzionale calcolato
     */
    protected function getPosfunvalAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('posfunval') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('posfunval');
        }

        // Guard: record deve esistere
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo helper puro
        $value = $this->getPosfunval();

        if ($value === null) {
            return null;
        }

        // Store in schemaless attributes
        $this->calculated_data->set('posfunval', $value);

        return $value;
    }

    protected function getValutatoreTxtAttribute(?string $value): ?string
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('valutatore_txt') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('valutatore_txt');
        }

        if ($value === null) {
            $calculated_value = $this->valutatore?->id.'] '.$this->valutatore?->nome_diri;
        } else {
            $calculated_value = $value;
        }

        // Store in schemaless attributes
        $this->calculated_data->set('valutatore_txt', $calculated_value);

        return $calculated_value;
    }

    protected function getPosizioneAttribute(?int $_value): int
    {
        return $this->avversariCategoriaEco
            ->where('punt_progressione_finale', '>', $this->punt_progressione_finale)
            ->count();
    }

    /**
     * Helper method: Calcola giorni totali di presenza (calcolo puro).
     *
     * Business Rule: Somma giorni in sede + giorni fuori sede = giorni totali presenza.
     *
     * @return int Giorni totali di presenza
     */
    protected function getGg(): int
    {
        return $this->gg_in_sede + $this->gg_fuori_sede;
    }

    /**
     * Accessor per gg (giorni totali presenza).
     * Delega calcolo a getGg().
     *
     * @param  int|null  $_value  Valore cached dal DB (ignorato, sempre ricalcolato)
     * @return int Giorni totali calcolati
     */
    protected function getGgAttribute(?int $_value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('gg');
        }

        // Guard: dipendenze devono esistere
        if ($this->getKey() == null) {
            return null;
        }

        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }

        if ($this->matr == 201661) {
            dddx([
                'gg_in_sede' => $this->gg_in_sede,
                'gg_fuori_sede' => $this->gg_fuori_sede,
            ]);
        }

        // Delega calcolo al metodo helper puro
        $value = $this->getGg();

        // Store in schemaless attributes
        $this->calculated_data->set('gg', $value);

        return $value;
    }

    /**
     * Accessor per gg_asz (totale giorni assenza).
     * Delega calcolo a getGgAsz().
     *
     * @param  int|null  $value  Valore cached dal DB
     * @return int|null Totale giorni assenza calcolati
     */
    protected function getGgAszAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_asz') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('gg_asz');
        }

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro
        $value = $this->getGgAsz();

        if ($value === null) {
            return null;
        }

        // Store in schemaless attributes
        $this->calculated_data->set('gg_asz', $value);

        return $value;
    }

    /**
     * Accessor per gg_no_asz (giorni totali senza assenze).
     * Delega calcolo a getGgNoAsz().
     *
     * @param  float|null  $value  Valore cached dal DB
     * @return float|null Giorni netti calcolati
     */
    protected function getGgNoAszAttribute(?float $value): ?float
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_no_asz') && $this->calculated_data->get('gg_no_asz') !== null && $this->calculated_data->get('gg_no_asz') !== 0.0 && ! request()->input('refresh', false)) {
            return $this->calculated_data->get('gg_no_asz');
        }

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro
        $value = $this->getGgNoAsz();

        // Store in schemaless attributes
        $this->calculated_data->set('gg_no_asz', $value);

        return $value;
    }

    protected function getGgFuoriSedeNoAszAttribute(?float $value): ?float
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_fuori_sede_no_asz') && ! request()->input('refresh', false)) {
            return $this->calculated_data->get('gg_fuori_sede_no_asz');
        }

        if ($this->getKey() == null) {
            return null;
        }

        $value = $this->gg_fuori_sede - $this->gg_asz_fuori_sede - ($this->hh_asz_fuori_sede / 6);

        // Store in schemaless attributes
        $this->calculated_data->set('gg_fuori_sede_no_asz', $value);

        return $value;
    }

    /**
     * Accessor per hh_asz (totale ore assenza).
     * Delega calcolo a getHhAsz().
     *
     * @param  int|null  $value  Valore cached dal DB
     * @return int|null Totale ore assenza calcolate
     */
    protected function getHhAszAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('hh_asz') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('hh_asz');
        }

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro
        $value = $this->getHhAsz();

        if ($value === null) {
            return null;
        }

        // Store in schemaless attributes
        $this->calculated_data->set('hh_asz', (int) $value);

        return (int) $value;
    }

    protected function getHhAszInSedeAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('hh_asz_in_sede') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('hh_asz_in_sede');
        }

        if ($this->getKey() == null) {
            return null;
        }

        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        $lista_aspettative = $this->getListaTipoCodiceAspettative();

        $parz = [
            // 'lista_propro' => $categoria->lista_propro,
            'lista_tipo_codice' => $lista_aspettative,
            // 'posfun' => $this->posfun,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];

        $value = $this->anag?->hhAssenzaInSedeTot($parz);

        // ✅ Check: record must exist before save()
        if ($this->getKey() == null) {
            return $value;
        }

        // Store in schemaless attributes
        $this->calculated_data->set('hh_asz_in_sede', $value);

        return (int) $value;
    }

    protected function getHhAszFuoriSedeAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('hh_asz_fuori_sede') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('hh_asz_fuori_sede');
        }

        if ($this->getKey() == null) {
            return null;
        }
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        // $categoria = optional($this->categoriaPropro);
        // $criteri = $this->criteriEsclusione;
        $lista_aspettative = $this->getListaTipoCodiceAspettative();
        $parz = [
            // 'lista_propro' => $categoria->lista_propro,
            'lista_tipo_codice' => $lista_aspettative,
            // 'posfun' => $this->posfun,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];
        $value = $this->anag?->hhAssenzaFuoriSedeTot($parz);

        if (\in_array('hh_asz_fuori_sede', $this->getFillable(), false)) {
            // ✅ Check: record must exist before save()
            if ($this->getKey() == null) {
                return (int) $value;
            }

            // Store in schemaless attributes
            $this->calculated_data->set('hh_asz_fuori_sede', $value);
        }

        return (int) $value;
    }

    // ------------------------------------------------------------

    /**
     * Helper method: Calcola giorni assenza in sede (calcolo puro).
     *
     * Business Rule: Giorni di assenza registrati nella sede principale.
     * Esclude giorni con codici aspettativa configurati.
     *
     * @return int|null Giorni assenza in sede, null se dati non disponibili
     */
    protected function getGgAszInSede(): ?int
    {
        // Guard: dipendenze devono esistere
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        // Setup lista aspettative da escludere
        $lista_aspettative = $this->getListaTipoCodiceAspettative();

        // Setup parametri query
        $parz = [
            'lista_tipo_codice' => $lista_aspettative,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];

        $data = GgFilterData::from($parz);

        // Calcolo puro delegato ad anagrafica
        return $this->anag?->ggAssenzaInSedeTot($data);
    }

    /**
     * Accessor per gg_asz_in_sede (giorni assenza in sede).
     * Delega calcolo a getGgAszInSede().
     *
     * @param  int|null  $value  Valore cached dal DB
     * @return int|null Giorni assenza in sede calcolati
     */
    protected function getGgAszInSedeAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_asz_in_sede') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('gg_asz_in_sede');
        }

        // Guard: record deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo helper puro
        $value = $this->getGgAszInSede();

        if ($value === null) {
            return null;
        }

        // Store in schemaless attributes
        $this->calculated_data->set('gg_asz_in_sede', $value);

        return (int) $value;
    }

    /**
     * Helper method: Calcola giorni assenza fuori sede (calcolo puro).
     *
     * Business Rule: Giorni di assenza registrati fuori dalla sede principale.
     * Esclude giorni con codici aspettativa configurati.
     *
     * @return int|null Giorni assenza fuori sede, null se dati non disponibili
     */
    protected function getGgAszFuoriSede(): ?int
    {
        // Guard: dipendenze devono esistere
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        // Setup lista aspettative da escludere
        $lista_aspettative = $this->getListaTipoCodiceAspettative();

        // Setup parametri query
        $parz = [
            'lista_tipo_codice' => $lista_aspettative,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];

        // Calcolo puro delegato ad anagrafica
        return $this->anag?->ggAssenzaFuoriSedeTot($parz);
    }

    /**
     * Public method for trait conflict resolution.
     * Delegates to anag->ggAssenzaFuoriSedeTot() or returns 0.
     *
     * @param  array  $params
     */
    public function ggAssenzaFuoriSedeTot(array $params): int
    {
        return $this->anag?->ggAssenzaFuoriSedeTot($params) ?? 0;
    }

    /**
     * Public method for trait conflict resolution.
     * Delegates to anag->hhAssenzaFuoriSedeTot() or returns 0.
     *
     * @param  array  $params
     */
    public function hhAssenzaFuoriSedeTot(array $params): int
    {
        return $this->anag?->hhAssenzaFuoriSedeTot($params) ?? 0;
    }

    /**
     * Public method for trait conflict resolution.
     * Delegates to anag->ggInSedeTot() or returns null.
     *
     * @param  GgFilterData|array  $data
     */
    public function ggInSedeTot($data): ?int
    {
        if ($data instanceof GgFilterData) {
            return $this->anag?->ggInSedeTot($data);
        }

        $filterData = GgFilterData::from($data);

        return $this->anag?->ggInSedeTot($filterData);
    }

    /**
     * Public method for trait conflict resolution.
     * Delegates to anag->ggFuoriSedeTot() or returns null.
     *
     * @param  array  $params
     */
    public function ggFuoriSedeTot(array $params): ?int
    {
        return $this->anag?->ggFuoriSedeTot($params);
    }

    /**
     * Public method for trait conflict resolution.
     * Delegates to anag->ggAssenzaInSedeTot() or returns 0.
     *
     * @param  GgFilterData|array  $data
     */
    public function ggAssenzaInSedeTot($data): int
    {
        if ($data instanceof GgFilterData) {
            return $this->anag?->ggAssenzaInSedeTot($data) ?? 0;
        }

        $filterData = GgFilterData::from($data);

        return $this->anag?->ggAssenzaInSedeTot($filterData) ?? 0;
    }

    /**
     * Public method for trait conflict resolution.
     * Delegates to anag->hhAssenzaInSedeTot() or returns 0.
     *
     * @param  array  $params
     */
    public function hhAssenzaInSedeTot(array $params): int
    {
        return $this->anag?->hhAssenzaInSedeTot($params) ?? 0;
    }

    /**
     * Accessor per gg_asz_fuori_sede (giorni assenza fuori sede).
     * Delega calcolo a getGgAszFuoriSede().
     *
     * @param  int|null  $value  Valore cached dal DB
     * @return int|null Giorni assenza fuori sede calcolati
     */
    protected function getGgAszFuoriSedeAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_asz_fuori_sede') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('gg_asz_fuori_sede');
        }

        // Guard: record deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo helper puro
        $value = $this->getGgAszFuoriSede();

        if ($value === null) {
            return null;
        }

        if (\in_array('gg_asz_fuori_sede', $this->getFillable(), false)) {
            // Store in schemaless attributes
            $this->calculated_data->set('gg_asz_fuori_sede', $value);
        }

        return (int) $value;
    }

    /**
     * Helper method: Calcola giorni assenza categoria economica totali (calcolo puro).
     *
     * Business Rule: Somma giorni assenza cateco in sede + fuori sede.
     *
     * @return int Giorni assenza cateco totali
     */
    protected function getGgAszCateco(): int
    {
        return $this->gg_asz_cateco_in_sede + $this->gg_asz_cateco_fuori_sede;
    }

    /**
     * Accessor per gg_asz_cateco (giorni assenza categoria economica totali).
     * Delega calcolo a getGgAszCateco().
     *
     * @param  int|null  $value  Valore cached dal DB
     * @return int Giorni assenza cateco totali calcolati
     */
    protected function getGgAszCatecoAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_asz_cateco') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('gg_asz_cateco');
        }

        // Guard: record deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo helper puro
        $value = $this->getGgAszCateco();

        if ($this->matr == 2160000) {
            dddx([
                'gg_asz_cateco_in_sede' => $this->gg_asz_cateco_in_sede,
                'gg_asz_cateco_fuori_sede' => $this->gg_asz_cateco_fuori_sede,
            ]);
        }

        // Store in schemaless attributes
        $this->calculated_data->set('gg_asz_cateco', $value);

        return $value;
    }

    /**
     * Helper method: Calcola giorni assenza categoria economica in sede (calcolo puro).
     *
     * Business Rule: Giorni assenza in sede con categoria economica specifica.
     * Filtra per lista propro della categoria e esclude aspettative.
     *
     * @return int|null Giorni assenza cateco in sede, null se dati non disponibili
     */
    protected function getGgAszCatecoInSede(): ?int
    {
        // Guard: dipendenze devono esistere
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        // Setup categoria e lista aspettative
        $categoria = $this->categoriaPropro;
        if (! ($categoria instanceof CategoriaPropro)) {
            return null;
        }
        $lista_aspettative = $this->getListaTipoCodiceAspettative();

        // Setup parametri query
        $parz = [
            'lista_propro' => $categoria->lista_propro ?? '',
            'lista_tipo_codice' => $lista_aspettative,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];

        $data = GgFilterData::from($parz);

        // Calcolo puro delegato ad anagrafica
        return $this->anag?->ggAssenzaInSedeTot($data);
    }

    /**
     * Accessor per gg_asz_cateco_in_sede (giorni assenza cateco in sede).
     * Delega calcolo a getGgAszCatecoInSede().
     *
     * @param  int|null  $value  Valore cached dal DB
     * @return int|null Giorni assenza cateco in sede calcolati
     */
    protected function getGgAszCatecoInSedeAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_asz_cateco_in_sede') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('gg_asz_cateco_in_sede');
        }

        // Guard: record deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo helper puro
        $value = $this->getGgAszCatecoInSede();

        if ($value === null) {
            return null;
        }

        // Store in schemaless attributes
        $this->calculated_data->set('gg_asz_cateco_in_sede', $value);

        return $value;
    }

    public function getGgAszCatecoPosfunInSede(): ?int
    {
        if ($this->getKey() == null) {
            return null;
        }
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        // dddx($value);
        $categoria = $this->categoriaPropro;
        if (! ($categoria instanceof CategoriaPropro)) {
            return null;
        }
        $lista_aspettative = $this->getListaTipoCodiceAspettative();
        $parz = [
            'lista_propro' => $categoria->lista_propro ?? '',
            'lista_tipo_codice' => $lista_aspettative,
            'posfun' => $this->posfun,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];
        $data = GgFilterData::from($parz);
        $value = $this->anag?->ggAssenzaInSedeTot($data);

        return intval($value);
    }

    protected function getGgAszCatecoPosfunInSedeAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_asz_cateco_posfun_in_sede') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('gg_asz_cateco_posfun_in_sede');
        }

        if ($this->getKey() == null) {
            return null;
        }

        $value = $this->getGgAszCatecoPosfunInSede();

        // Store in schemaless attributes
        $this->calculated_data->set('gg_asz_cateco_posfun_in_sede', $value);

        return $value;
    }

    /**
     * Accessor per gg_cateco_no_asz (giorni categoria economica senza assenze).
     * Delega calcolo a getGgCatecoNoAsz().
     *
     * @param  int|null  $value  Valore cached dal DB
     * @return int|null Giorni cateco netti calcolati
     */
    protected function getGgCatecoNoAszAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_cateco_no_asz') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('gg_cateco_no_asz');
        }

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro
        $value = $this->getGgCatecoNoAsz();

        // Store in schemaless attributes
        $this->calculated_data->set('gg_cateco_no_asz', $value);

        return $value;
    }

    public function getPropro(): ?int
    {
        if ($this->getKey() == null) {
            return null;
        }
        if ($this->dal == null && is_numeric($this->anno)) {
            $this->dal = ($this->anno * 10000) + 101;
        }
        if ($this->al == null && is_numeric($this->anno)) {
            $this->al = ($this->anno * 10000) + 1231;
        }
        if ($this->qua2kd == null && is_numeric($this->anno)) {
            $rows = Qua00f::where('ente', $this->ente)->where('matr', $this->matr)->get();

            // ---
        }

        return $this->qua00f
            ->where('qua2kd', $this->qua2kd)
            ->first()
            ?->propro;
    }

    protected function getProproAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('propro') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('propro');
        }

        if ($this->getKey() == null) {
            return null;
        }

        $value = $this->getPropro();

        // Store in schemaless attributes
        $this->calculated_data->set('propro', $value);

        return $value;
    }

    protected function getGgCatecoPosfunInSedeNoAszAttribute(?int $value): ?int
    {
        $fieldname = 'gg_cateco_posfun_in_sede_no_asz';

        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has($fieldname) && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get($fieldname);
        }

        if ($this->getKey() == null) {
            return null;
        }
        if ($this->matr == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        $value = $this->gg_cateco_posfun_in_sede - $this->gg_asz_cateco_posfun; // in_sede
        /*
         * dddx(
         * [
         * 'gg_cateco_posfun_in_sede' => $this->gg_cateco_posfun_in_sede,
         * 'gg_asz_cateco_posfun' => $this->gg_asz_cateco_posfun,
         * 'value' => $value,
         * ]
         * );
         */
        // Store in schemaless attributes
        $this->calculated_data->set($fieldname, $value);

        return $value;
    }

    public function getGgCatecoPosfun(): ?int
    {
        // f($this->gg_cateco_posfun_in_sede==null){
        //    dddx($this->getGgCatecoPosfunInSede());
        // }
        if ($this->getKey() == null) {
            return null;
        }

        return intval($this->gg_cateco_posfun_in_sede) + intval($this->gg_cateco_posfun_fuori_sede);
    }

    protected function getGgCatecoPosfunAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_cateco_posfun') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('gg_cateco_posfun');
        }

        if ($this->getKey() == null) {
            return null;
        }
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        $value = $this->getGgCatecoPosfun();

        // Store in schemaless attributes
        $this->calculated_data->set('gg_cateco_posfun', $value);

        return $value;
    }

    protected function getGgCatecoSupAttribute(?int $value): ?int
    {
        $fieldname = 'gg_cateco_sup';

        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has($fieldname) && ! request()->input('refresh', false)) {
            return $this->calculated_data->get($fieldname);
        }

        if ($this->getKey() == null) {
            return null;
        }
        // 730
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }
        $value = $this->gg_cateco_sup_in_sede + $this->gg_cateco_sup_fuori_sede;
        // DYNAMIC SCHEMA ALTERATION - FORBIDDEN!
        // This code dynamically attempts to add a column if it doesn't exist.
        // Schema alterations must always be handled via dedicated migration files.
        // If 'gg_cateco_sup' is a required column, create a migration for it.
        // If it is a dynamic, schemaless attribute, consider using spatie/laravel-schemaless-attributes.

        // Store in schemaless attributes
        $this->calculated_data->set($fieldname, $value);

        return $value;
    }

    protected function getGgCatecoSupInSedeAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_cateco_sup_in_sede') && ! request()->input('refresh', false)) {
            return $this->calculated_data->get('gg_cateco_sup_in_sede');
        }

        if ($this->getKey() == null) {
            return null;
        }
        if ($this->matr == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        $parz = [
            // 'lista_propro'=>$categoria->lista_propro,
            // 'lista_propro_sup'=>$categoria->lista_propro_sup,
            // 'posfun'=>$this->posfun,
            // 'lista_propro' => $categoria->lista_propro_sup,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];
        $data = GgFilterData::from($parz);

        $value = $this->anag?->ggInSedeTot($data);

        // Store in schemaless attributes
        $this->calculated_data->set('gg_cateco_sup_in_sede', $value);

        return $value;
    }

    protected function getGgCatecoNoPosfunNoAszAttribute(?int $value): ?int
    {
        $fieldname = 'gg_cateco_no_posfun_no_asz';

        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has($fieldname) && ! request()->input('refresh', false)) {
            return $this->calculated_data->get($fieldname);
        }

        if ($this->getKey() == null) {
            return null;
        }
        if ($this->matr == 2160000) {
            dddx([
                'gg_cateco_no_asz' => $this->gg_cateco_no_asz,
                'gg_cateco_posun_no_asz' => $this->gg_cateco_posfun_no_asz,
            ]);
        }
        $value = $this->gg_cateco_no_asz - $this->gg_cateco_posfun_no_asz;

        // Store in schemaless attributes
        $this->calculated_data->set($fieldname, $value);

        return $value;
    }

    public function getGgCatecoInSede(): ?int
    {
        if ($this->matr == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        $categoria = $this->categoriaPropro;
        if (! ($categoria instanceof CategoriaPropro)) {
            return null;
        }
        // dddx($categoria->lista_propro);
        // $criteri = $this->criteriEsclusione;
        $parz = [
            'lista_propro' => $categoria->lista_propro ?? '',
            'lista_propro_sup' => $categoria->lista_propro_sup ?? '',
            // 'posfun'=>$this->posfun,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];
        $data = GgFilterData::from($parz);

        // $parz['value'] = $value;
        // dddx($parz);
        return $this->anag?->ggInSedeTot($data);
    }

    protected function getGgCatecoInSedeAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_cateco_in_sede') && ! request()->input('refresh', false)) {
            return $this->calculated_data->get('gg_cateco_in_sede');
        }

        if ($this->getKey() == null) {
            return null;
        }

        $value = $this->getGgCatecoInSede();

        // Store in schemaless attributes
        $this->calculated_data->set('gg_cateco_in_sede', $value);

        return $value;
    }

    public function getGgCateco(): ?int
    {
        return $this->gg_cateco_in_sede + $this->gg_cateco_fuori_sede;
    }

    protected function getGgCatecoAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_cateco') && ! request()->input('refresh', false)) {
            return $this->calculated_data->get('gg_cateco');
        }

        if ($this->getKey() == null) {
            return null;
        }

        $value = $this->getGgCateco();

        // Store in schemaless attributes
        $this->calculated_data->set('gg_cateco', $value);

        return $value;
    }

    public function getGgCatecoPosfunInSede(): ?int
    {
        $categoria = $this->categoriaPropro;
        if (! ($categoria instanceof CategoriaPropro)) {
            dddx($this->getPropro());
            dddx([
                'scheda' => $this,
                'propro' => $this->propro,
                // 'categoriaPropro_sql' => $this->categoriaPropro()->ddRawSql()
            ]);

            return null;
        }
        $parz = [
            'lista_propro' => $categoria->lista_propro ?? '',
            // 'lista_propro_sup' => $categoria->lista_propro_sup,
            'posfun' => $this->posfun,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ];
        $data = GgFilterData::from($parz);

        return $this->anag?->ggInSedeTot($data);
    }

    protected function getGgCatecoPosfunInSedeAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_cateco_posfun_in_sede') && ! request()->input('refresh', false)) {
            return $this->calculated_data->get('gg_cateco_posfun_in_sede');
        }

        if ($this->matr == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        $value = $this->getGgCatecoPosfunInSede();

        // Store in schemaless attributes
        $this->calculated_data->set('gg_cateco_posfun_in_sede', $value);

        return $value;
    }

    protected function getGgAszCatecoFuoriSedeAttribute(?int $value): ?int
    {
        $fieldname = 'gg_asz_cateco_fuori_sede';

        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has($fieldname) && ! request()->input('refresh', false)) {
            return $this->calculated_data->get($fieldname);
        }

        // 730
        $value = 0; // DA FARE !

        // Store in schemaless attributes
        $this->calculated_data->set($fieldname, $value);

        return $value;
    }

    public function getGgAszCatecoPosfunFuoriSede(): ?int
    {
        // DA FARE !

        return 0;
    }

    protected function getGgAszCatecoPosfunFuoriSedeAttribute(?int $value): ?int
    {
        $fieldname = 'gg_asz_cateco_posfun_fuori_sede';

        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has($fieldname) && ! request()->input('refresh', false)) {
            return $this->calculated_data->get($fieldname);
        }

        $value = $this->getGgAszCatecoPosfunFuoriSede();

        // Store in schemaless attributes
        $this->calculated_data->set($fieldname, $value);

        return $value;
    }

    protected function getGgCatecoSupFuoriSedeAttribute(?int $value): ?int
    {
        $fieldname = 'gg_cateco_sup_fuori_sede';

        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has($fieldname) && ! request()->input('refresh', false)) {
            return $this->calculated_data->get($fieldname);
        }

        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }
        // 730
        $categoria = $this->categoriaPropro;
        if (! ($categoria instanceof CategoriaPropro)) {
            return null;
        }
        // dddx($categoria->lista_propro);
        // $criteri = $this->criteriEsclusione;
        $value = $this->anag?->ggFuoriSedeTot([
            // 'lista_propro'=>$categoria->lista_propro,
            // 'lista_propro_sup'=>$categoria->lista_propro_sup,
            'lista_propro' => $categoria->lista_propro_sup ?? '',
            // 'posfun'=>$this->posfun,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ]);
        // DYNAMIC SCHEMA ALTERATION - FORBIDDEN!
        // This code dynamically attempts to add a column if it doesn't exist.
        // Schema alterations must always be handled via dedicated migration files.
        // If 'gg_cateco_sup_fuori_sede' is a required column, create a migration for it.
        // If it is a dynamic, schemaless attribute, consider using spatie/laravel-schemaless-attributes.

        // Store in schemaless attributes
        $this->calculated_data->set($fieldname, $value);

        return $value;
    }

    public function getGgCatecoFuoriSede(): ?int
    {
        if ($this->matr == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }
        $categoria = $this->categoriaPropro;
        if (! ($categoria instanceof CategoriaPropro)) {
            return null;
        }
        // dddx($categoria->lista_propro);
        // $criteri = $this->criteriEsclusione;
        $value = $this->anag?->ggFuoriSedeTot([
            'lista_propro' => $categoria->lista_propro ?? '',
            'lista_propro_sup' => $categoria->lista_propro_sup ?? '',
            // 'posfun'=>$this->posfun,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ]);

        return intval($value);
    }

    protected function getGgCatecoFuoriSedeAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_cateco_fuori_sede') && $value !== null) { // value check for initial value
            return $this->calculated_data->get('gg_cateco_fuori_sede');
        }

        $value = $this->getGgCatecoFuoriSede();

        // Store in schemaless attributes
        $this->calculated_data->set('gg_cateco_fuori_sede', $value);

        return intval($value);
    }

    public function getGgCatecoPosfunFuoriSede(): ?int
    {
        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }

        $categoria = $this->categoriaPropro;
        if (! ($categoria instanceof CategoriaPropro)) {
            return null;
        }
        $value = $this->anag?->ggFuoriSedeTot([
            'lista_propro' => $categoria->lista_propro ?? '',
            'lista_propro_sup' => $categoria->lista_propro_sup ?? '',
            'posfun' => $this->posfun,
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
        ]);

        return intval($value);
    }

    protected function getGgCatecoPosfunFuoriSedeAttribute(?int $value): ?int
    {
        $fieldname = 'gg_cateco_posfun_fuori_sede';

        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has($fieldname) && ! request()->input('refresh', false)) {
            return $this->calculated_data->get($fieldname);
        }

        $value = $this->getGgCatecoPosfunFuoriSede();

        // Store in schemaless attributes
        $this->calculated_data->set($fieldname, $value);

        return (int) $value;
    }

    /**
     * Accessor per gg_assenza_anno (giorni assenza annuale).
     * Delega calcolo a getGgAssenzaAnno().
     *
     * @param  int|null  $value  Valore cached dal DB
     * @return int|null Giorni assenza calcolati
     */
    protected function getGgAssenzaAnnoAttribute(?int $value): ?int
    {
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('gg_assenza_anno') && ! request()->input('refresh', 0)) {
            return $this->calculated_data->get('gg_assenza_anno');
        }

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro
        $value = $this->getGgAssenzaAnno();

        if ($value === null) {
            return null;
        }

        // Store in schemaless attributes
        $this->calculated_data->set('gg_assenza_anno', $value);

        return $value;
    }

    /*
     * public function getGgAspettativePondFuorisedeAttribute(?int $value):?int {
     * echo ('ora si usano i gg_asz_cateco etc etc');
     *
     * return $value;
     *
     * public function getGgAspettativePondInsedeAttribute(?int $value):?int {
     * echo ('ora si usano i gg_asz_cateco etc etc');
     *
     * return $value;
     * }
     */

    protected function getGgAszCatecoPosfunAttribute(?int $_value): ?int
    {
        $value = $this->gg_asz_cateco_posfun_in_sede + $this->gg_asz_cateco_posfun_fuori_sede;

        return (int) $value;
    }

    /*
     * Trait method getCategoriaEcoAttribute has not been applied,
     * because there are collisions with other trait methods
     * on Modules\Progressioni\Models\Progressioni
     */
    /*
     * public function getCategoriaEcoAttribute($value) {
     * if (null !== $value && ! request()->input('refresh', false)) {
     * return $value;
     * }
     * $categoria_propro = $this->categoriaPropro;
     * $value = $categoria_propro->categoria;
     * $this->categoria_eco = $value;
     * $this->save();
     *
     * return $value;
     * }
     */

    /* moved into Modules/Sigma/Models/Traits/Mutators/SchedaMutator.php
     * public function getPosizAttribute(?int $value): ?int {
     *
     * if (null !== $value) {
     * return $value;
     * }
     *
     * $qua00f = $this->qua00f;
     * if (null === $qua00f) {
     * dddx('errore');
     * }
     *
     * if (1 !== $qua00f->count()) {
     * // dddx($qua00f);
     * $arr = collect($qua00f)->map(static fn ($item): array => ['propro' => $item->propro, 'posfun' => $item->posfun]);
     * // foreach($arr as $i){
     *
     * // }
     * // dddx($arr->count());
     * }
     *
     * $posizValue = $qua00f->first()?->posiz;
     * // ✅ Check: record must exist before save()
     * if ($this->getKey() == null) {
     * return $value;
     * }
     *
     * // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
     * if ($posizValue !== null) {
     * $this->update(['posiz' => $posizValue]);
     * }
     *
     * return $posizValue ?? $value;
     * }
     */
    /*
     * public function getPosizTxtAttribute($value) {
     * if (null !== $value) {
     * return $value;
     * }
     *
     * $row = Codici::where('tipo', 19)->where('codice', $this->posiz)->first();
     * if (! \is_object($row)) {
     * return null;
     * }
     *
     * $posizTxtValue = $row->desc1;
     *
     * // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
     * if (null !== $this->getKey()) {
     * $this->update(['posiz_txt' => $posizTxtValue]);
     * }
     *
     * return $posizTxtValue;
     * }
     */

    /*moved into Modules/Sigma/Models/Traits/Mutators/SchedaMutator.php
     * public function getDisci1Attribute(?int $value): ?int {
     * if (null != $value && ! request()->input('refresh', false)) {
     * return $value;
     * }
     * $qua00f_curr = $this->qua00fDaterange->first();
     * if (! \is_object($qua00f_curr)) {
     * return null;
     * }
     *
     * // Access to an undefined property Modules\Sigma\Models\Qua00f::$disci1.
     * // return $qua00f_curr->disci1;
     * $value = $qua00f_curr->attributes['disci1'];
     * $this->update(['disci1' => $value]);
     *
     * return $value;
     * }
     */
    /*
     * public function getCategoriaEcovalAttribute(?string $value): ?string {
     *
     * if (null != $value && ! request()->input('refresh', false)) {
     * return $value;
     * }
     * if (null == $this->matr) {
     * return null;
     * }
     * if (null == $this->propro) {
     * return null;
     * }
     *
     * $categoria_propro = $this->categoriaPropro;
     * $value = $categoria_propro?->categoria;
     * $this->update(['categoria_ecoval' => $value]);
     *
     * return $value;
     * }
     */

    /**
     * Undocumented function.
     *
     * @param  mixed  $_value  Unused parameter (required by Laravel accessor pattern)
     */
    protected function getAventiDirittoAttribute(mixed $_value): ?int
    {
        $maxCatecoPosfun = $this->maxCatecoPosfun;
        if (\is_object($maxCatecoPosfun) && isset($maxCatecoPosfun->aventi_diritto)) {
            $value = $maxCatecoPosfun->aventi_diritto;

            return is_numeric($value) ? (int) $value : null;
        }

        $id = $this->getKey() ?? 'null';
        $anno = is_numeric($this->anno) ? (string) $this->anno : ($this->anno ?? 'null');
        $categoriaEcoval = is_string($this->categoria_ecoval) ? $this->categoria_ecoval : ($this->categoria_ecoval ?? 'null');
        $posfunval = is_numeric($this->posfunval) ? (string) $this->posfunval : ($this->posfunval ?? 'null');
        echo '<h3>id :'
            .(string) $id
                .'<br/>'
                .'anno :'
                .(string) $anno
                .'<br/>'
                .'categoria_ecoval :'
                .$categoriaEcoval
                .'<br/>'
                .'posfun :'
                .$posfunval
                .'</h3>';
        if (function_exists('dddx')) {
            dddx([$this->maxCatecoPosfun()->toSql()]);
        }

        return null;
    }

    /**
     * Undocumented function.
     *
     * @param  mixed  $_value  Unused parameter (required by Laravel accessor pattern)
     */
    protected function getAventiDirittoEffAttribute(mixed $_value): ?int
    {
        $maxCatecoPosfun = $this->maxCatecoPosfun;
        if (\is_object($maxCatecoPosfun) && isset($maxCatecoPosfun->aventi_diritto_eff)) {
            $value = $maxCatecoPosfun->aventi_diritto_eff;

            return is_numeric($value) ? (int) $value : null;
        }

        $id = $this->getKey() ?? 'null';
        $anno = is_numeric($this->anno) ? (string) $this->anno : ($this->anno ?? 'null');
        $categoriaEcoval = is_string($this->categoria_ecoval) ? $this->categoria_ecoval : ($this->categoria_ecoval ?? 'null');
        $posfunval = is_numeric($this->posfunval) ? (string) $this->posfunval : ($this->posfunval ?? 'null');
        echo '<h3>id :'
            .(string) $id
                .'<br/>'
                .'anno :'
                .(string) $anno
                .'<br/>'
                .'categoria_ecoval :'
                .(string) $categoriaEcoval
                .'<br/>'
                .'posfun :'
                .(string) $posfunval
                .'</h3>';

        return null;
        // dddx([$this->maxCatecoPosfun()->toSql()]); // Unreachable code
    }

    protected function getValoreDifferenzialeRapportatoPtAttribute(?float $value): ?float
    {
        if ($value !== null) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        if ($this->matr == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }
        $value = $this->costo_fascia_up * $this->ptime;

        // ✅ Check: record must exist before save()
        if ($this->getKey() == null) {
            return $value;
        }

        // Persist con update chirurgico (salva SOLO questo campo, previene loop)
        $this->update(['valore_differenziale_rapportato_pt' => $value]);

        return $value;
    }

    protected function getPesoEsperienzaAcquisitaAttribute(?int $value): ?int
    {
        if ($value !== null) {
            return $value;
        }
        if ($this->matr == null) {
            return null;
        }
        if ($this->propro == null) {
            return null;
        }
        $pesi = $this->pesi;
        if (! \is_object($pesi) || ! isset($pesi->peso_esperienza_acquisita)) {
            return null;
        }

        return is_numeric($pesi->peso_esperienza_acquisita) ? (int) $pesi->peso_esperienza_acquisita : null;
    }

    /*
     * public function getGgAttribute($value){
     * //update schede set gg=datediff(al,dal)+1 where anno=2016
     * return 5;
     * }
     */

    /**
     * Accessor per totale_pond (punteggio ponderato progressioni).
     * Delega calcolo a getTotalePond().
     *
     * IMPORTANTE: Calcolo aggregato su TUTTE le schede anno+matr.
     *
     * @param  float|null  $value  Valore cached dal DB
     * @return float Punteggio ponderato calcolato
     */
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

    public function puntProgressioneFinale(): float
    {
        // schedaCriteri può essere una Collection o null
        $scheda_criteri = $this->schedaCriteri ?? null;
        if ($scheda_criteri === null || ! is_iterable($scheda_criteri)) {
            return 0.0;
        }

        $tot = 0.0;
        /** @var SchedaCriteri|object $v */
        foreach ($scheda_criteri as $v) {
            // $v è un oggetto SchedaCriteri con field_name, converted_in, peso
            $field_name = isset($v->field_name) && is_string($v->field_name) ? $v->field_name : null;
            $converted_in = isset($v->converted_in) && is_numeric($v->converted_in) ? (int) $v->converted_in : null;
            $peso = isset($v->peso) && is_numeric($v->peso) ? (float) $v->peso : null;

            if ($field_name === null || $converted_in === null || $peso === null) {
                continue;
            }

            $converted = $this->convertedIn($field_name, $converted_in);
            if ($converted === null) {
                continue;
            }
            $converted_peso = ($converted * (float) $peso) / 10;
            $tot += $converted_peso;

            /*--- 4 debug
             * if (20736 == $this->matr) {
             * echo '<hr>';
             * echo 'field_name :'.$v->field_name.'<br/>';
             * echo 'converted_in :'.$v->converted_in.'<br/>';
             * echo 'converted :'.$converted.'<br/>';
             * echo 'converted_peso :'.$converted_peso.'<br/>';
             * echo 'tot :'.$tot.'<br/>';
             * echo '</hr>';
             * }
             */
        }

        return $tot;
    }

    protected function setPuntProgressioneFinaleAttribute(?float $value): void
    {
        /*
         * $scheda_criteri=$this->schedaCriteri;
         * $tot=0;
         * foreach($scheda_criteri as $k=>$v){
         * $converted=$this->convertedIn($v->field_name,$v->converted_in);
         * $converted_peso=$converted*$v->peso/10;
         * $tot+=$converted_peso;
         * }
         *
         * $this->attributes['punt_progressione_finale']=$tot.'';
         */
        $value = $this->puntProgressioneFinale();
        $this->attributes['punt_progressione_finale'] = $value.'';
    }

    protected function getPuntProgressioneFinaleAttribute(?float $value): ?float
    {
        $old_value = $value; // This old value was probably for debugging or comparison, now it's less relevant for persistence

        // Check if value exists in schemaless attributes and is not being refreshed
        if ($this->calculated_data->has('punt_progressione_finale') && ! request()->input('refresh', 0) && ($old_value === $this->calculated_data->get('punt_progressione_finale'))) {
            return $this->calculated_data->get('punt_progressione_finale');
        }

        $value = $this->puntProgressioneFinale();

        // Store in schemaless attributes
        $this->calculated_data->set('punt_progressione_finale', $value);

        return round($value, 3);
    }

    /**
     * Helper method: Calcola valutatore_id con auto-assegnazione (calcolo puro).
     *
     * Business Rule: Assegna valutatore in base a stabi dirigente.
     * Se stabi dirigente non ha valutatore, crea/trova uno e lo auto-assegna.
     *
     * @return int|null ID valutatore, null se non determinabile
     */
    protected function getValutatoreId(): ?int
    {
        // Se stabi dirigente non esiste, non possiamo determinare valutatore
        $stabi_diri = $this->stabiDirigente;
        if (! \is_object($stabi_diri)) {
            return null;
        }

        // Se stabi dirigente ha già valutatore, usalo
        /** @var object{valutatore_id?: int|null} $stabi_diri */
        $valutatore_id = isset($stabi_diri->valutatore_id) ? $stabi_diri->valutatore_id : null;
        if ($valutatore_id !== null) {
            return (int) $valutatore_id;
        }

        // Altrimenti crea/trova StabiDirigente e auto-assegna
        $stabi_dirigente_class = Str::of(static::class)
            ->beforeLast('\\')
            ->append('\\StabiDirigente')
            ->toString();
        $stabi = $stabi_dirigente_class::firstOrCreate([
            'anno' => $this->anno,
            'stabi' => $this->stabi,
            'repar' => 0,
        ]);

        if (! is_object($stabi) || ! method_exists($stabi, 'save')) {
            return null;
        }

        $stabi_valutatore_id = isset($stabi->valutatore_id) ? $stabi->valutatore_id : null;
        if ($stabi_valutatore_id === null) {
            $stabi_id = isset($stabi->id) ? $stabi->id : null;
            if ($stabi_id !== null && isset($stabi->valutatore_id)) {
                $stabi->valutatore_id = $stabi_id;
                $stabi->save();

                return (int) $stabi_id;
            }
        }

        return is_numeric($stabi_valutatore_id) ? (int) $stabi_valutatore_id : null;
    }

    /**
     * Accessor per valutatore_id con auto-assegnazione se mancante.
     * Delega calcolo a getValutatoreId().
     *
     * @param  int|null  $value  Valore cached dal DB
     * @return int|null ID valutatore calcolato
     */
    protected function getValutatoreIdAttribute(?int $value): ?int
    {
        // Cache hit: se già assegnato (value > 100), usa quello
        // Check if value exists in schemaless attributes
        if ($this->calculated_data->has('valutatore_id') && ($this->calculated_data->get('valutatore_id') > 100 || ! request()->input('refresh', 0))) {
            return $this->calculated_data->get('valutatore_id');
        }

        // Guard: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return $value;
        }

        // Delega calcolo al metodo helper puro
        $value = $this->getValutatoreId();

        if ($value === null) {
            return null;
        }

        // Store in schemaless attributes
        $this->calculated_data->set('valutatore_id', $value);

        return $value;
    }

    protected function getListaProproAttribute(?string $_value): ?string
    {
        $categoria = $this->categoriaPropro;
        if (! ($categoria instanceof CategoriaPropro)) {
            return null;
        }

        return $categoria->lista_propro;
    }

    protected function getListaProproSupAttribute(?string $_value): ?string
    {
        $categoria = $this->categoriaPropro;
        if (! ($categoria instanceof CategoriaPropro)) {
            return null;
        }

        return $categoria->lista_propro_sup;
    }

    /**
     * Accessor per ptime (coefficiente part-time ponderato).
     * Delega calcolo a getPtime().
     *
     * @param  float|null  $value  Valore cached dal DB
     * @return float|null Coefficiente part-time calcolato
     */
    protected function getPtimeAttribute(?float $value): ?float
    {
        // Cache hit
        if ($value !== null && ! request()->input('refresh', false)) {
            return $value;
        }

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Verifica dinamica colonna esiste (legacy code)
        $table = $this->getTable();
        $conn = $this->getConnection();
        $fieldname = 'ptime';
        if (! Schema::connection($conn->getName())->hasColumn($table, $fieldname)) {
            Schema::connection($conn->getName())->table($table, static function (Blueprint $tableBlueprint) use ($fieldname): void {
                $tableBlueprint->decimal($fieldname, 10, 4);
            });
        }

        // Delega calcolo al metodo puro
        $value = $this->getPtime();

        if ($value === null) {
            return null;
        }

        // Persist con update chirurgico (salva SOLO questo campo, previene loop)
        $this->update(['ptime' => $value]);

        return $value;
    }

    /*
     * INSERT INTO stipendio_tabellare (propro,posfun,euro_pond,ptime,euro,anno)
     * (
     * SELECT   distinct propro,substr(posfun,-1)*1 AS posfun
     * ,if(impseu=0,impoeu,impseu) AS euro_pond
     * ,if(oree=0,36,oree)/if(oret=0,36,oret) AS ptime
     * ,round(if(impseu=0,impoeu,impseu) / (if(oree=0,36,oree)/if(oret=0,36,oret)),3) AS euro
     * ,2019
     * FROM generale.ced03f
     * JOIN generale.qua00f
     * ON ced03f.ente=qua00f.ente
     * AND ced03f.smatr=qua00f.matr
     * AND quaann=""
     * AND (
     * ((sannli*10000)+(smesli*100)+sgiome BETWEEN qua2kd AND qua2ka )
     * OR
     * ((sannli*10000)+(smesli*100)+sgiome >= qua2kd AND qua2ka=0 )
     * )
     * WHERE qua00f.ente=90
     * AND svocfi=1200
     * AND sannli=2019
     * AND anno=0
     * order BY propro,substr(posfun,-1)*1,if(oree=0,36,oree)/if(oret=0,36,oret)
     * )
     */
    /*
     * public function getCostoFasciaUpAttribute(?float $value): ?float {
     * if (null !== $value && ! request()->input('refresh', false)) {
     * return $value;
     * }
     *
     * $table = $this->getTable();
     * $conn = $this->getConnection();
     * $fieldname = 'costo_fascia_up';
     * if (! \Schema::connection($conn->getName())->hasColumn($table, $fieldname)) {
     * \Schema::connection($conn->getName())->table($table, static function (Blueprint $tableBlueprint) use ($fieldname): void {
     * $tableBlueprint->decimal($fieldname, 10, 4);
     * });
     * }
     *
     * $tmp = $this->stipendioTabellare;
     * // dddx($this->stipendioTabellare()->toSql());
     * $tmp1 = $this->stipendioTabellareUp;
     * if (\is_object($tmp1) && \is_object($tmp)) {
     * $value = ((float) $tmp1->euro - (float) $tmp->euro) * 13;
     * // ✅ Check: record must exist before save()
     * if ($this->getKey() == null) {
     * return $value;
     * }
     *
     * // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
     * $this->update(['costo_fascia_up' => $value]);
     *
     * return $value;
     * }
     *
     * // echo('<br/>non trovo ['.$this->propro.']['.($this->posfunval+1).'] in stipendia tabellare anno ['.$this->anno.']');
     * return 0;
     * }
     */
    protected function getImportoStipendioAnnuoAttribute(?float $_value): ?float
    {
        $tmp = $this->stipendioTabellare;
        // $tmp è HasOne, quindi può essere un Model o null
        if ($tmp === null || ! \is_object($tmp) || ! isset($tmp->importo_stipendio_annuo)) {
            return null;
        }

        return is_numeric($tmp->importo_stipendio_annuo) ? (float) $tmp->importo_stipendio_annuo : null;
    }

    /**
     * Accessor per gg_in_sede (giorni presenza in sede).
     * Delega calcolo a getGgInSede().
     *
     * @param  int|null  $value  Valore cached dal DB
     * @return int|null Giorni in sede calcolati
     */
    protected function getGgInSedeAttribute(?int $value): ?int
    {
        // Cache hit
        if ($value !== null && ! request()->input('refresh', 0)) {
            return $value;
        }

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro
        $value = $this->getGgInSede();

        if ($value === null) {
            return null;
        }

        // Persist con update chirurgico (salva SOLO questo campo, previene loop)
        $this->update(['gg_in_sede' => $value]);

        return $value;
    }

    /**
     * Accessor per gg_in_sede_no_asz (giorni in sede senza assenze).
     * Delega calcolo a getGgInSedeNoAsz().
     *
     * @param  float|null  $_value  Valore cached dal DB (non usato, sempre ricalcolato)
     * @return float Giorni in sede netti calcolati
     */
    protected function getGgInSedeNoAszAttribute(?float $_value): ?float
    {
        // Nota: questo accessor non usa cache, ricalcola sempre
        // Motivazione: dipende da gg_in_sede, gg_asz_in_sede, hh_asz_in_sede che cambiano

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro
        $value = $this->getGgInSedeNoAsz();

        // Persist con update chirurgico (salva SOLO questo campo, previene loop)
        $this->update(['gg_in_sede_no_asz' => $value]);

        return $value;
    }

    /**
     * Accessor per gg_presenza_anno (giorni presenza annuale).
     * Delega calcolo a getGgPresenzaAnno().
     *
     * @param  int|null  $value  Valore cached dal DB
     * @return int|null Giorni presenza calcolati
     */
    protected function getGgPresenzaAnnoAttribute(?int $value): ?int
    {
        // Cache hit
        if ($value !== null && ! request()->input('refresh', false)) {
            return $value;
        }

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro
        $value = $this->getGgPresenzaAnno();

        if ($value === null) {
            return null;
        }

        // Persist con update chirurgico (salva SOLO questo campo, previene loop)
        $this->update(['gg_presenza_anno' => $value]);

        return $value;
    }

    /**
     * Accessor per gg_anno (giorni effettivi presenza annua).
     * Delega calcolo a getGgAnno().
     *
     * @param  int|null  $value  Valore cached dal DB
     * @return int|null Giorni effettivi calcolati
     */
    protected function getGgAnnoAttribute(?int $value): ?int
    {
        // Cache hit
        if ($value !== null && ! request()->input('refresh', false)) {
            return $value;
        }

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro
        $value = $this->getGgAnno();

        if ($value === null) {
            return null;
        }

        // Persist con update chirurgico (salva SOLO questo campo, previene loop)
        $this->update(['gg_anno' => $value]);

        return $value;
    }

    /**
     * Helper method: Ottiene giorni assenza per tipo codice escluso subito (calcolo puro).
     *
     * Business Rule: Attualmente non implementato. Placeholder per future implementazioni.
     *
     * @return null Sempre null (non implementato)
     */
    protected function getGgAszTipCodEsclusoSubito(): ?int
    {
        // Placeholder: non implementato
        return null;
    }

    /**
     * Accessor per gg_asz_tip_cod_escluso_subito (giorni assenza per tipo codice escluso subito).
     * Delega calcolo a getGgAszTipCodEsclusoSubito().
     *
     * @param  int|null  $_value  Valore cached dal DB (non usato)
     * @return null Sempre null (non implementato)
     */
    protected function getGgAszTipCodEsclusoSubitoAttribute(?int $_value): ?int
    {
        // Delega calcolo al metodo puro (VICINO!)
        return $this->getGgAszTipCodEsclusoSubito();
    }

    /**
     * Accessor per gg_fuori_sede (giorni presenza fuori sede).
     * Delega calcolo a getGgFuoriSede().
     *
     * @param  int|null  $value  Valore cached dal DB
     * @return int|null Giorni fuori sede calcolati
     */
    protected function getGgFuoriSedeAttribute(?int $value): ?int
    {
        // Cache hit
        if ($value !== null && ! request()->input('refresh', false)) {
            return $value;
        }

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro
        $value = $this->getGgFuoriSede();

        if ($value === null) {
            return null;
        }

        // Persist con update chirurgico (salva SOLO questo campo, previene loop)
        $this->update(['gg_fuori_sede' => $value]);

        return $value;
    }

    protected function getGgPosiz1InSedeAttribute(?int $value): ?int
    {
        if ($value !== null && ! request()->input('refresh', false)) {
            return $value;
        }

        if ($this->matr == null) {
            return null;
        }

        if (! \is_object($this->anag)) {
            return $value;
        }

        $parz = [
            'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
            'date_max' => $this->criteriOptionsArr('data_presenza_al'),
            'posiz' => '1',
        ];
        $data = GgFilterData::from($parz);
        $value = $this->anag->ggInSedeTot($data);
        // ✅ Check: record must exist before save()
        if ($this->getKey() == null) {
            return $value;
        }

        // Persist con update chirurgico (salva SOLO questo campo, previene loop)
        $this->update(['gg_posiz_1_in_sede' => $value]);

        return $value;
    }

    public function funcYear(string $func, ?float $value): ?float
    {
        if ($value !== null && ! request()->input('refresh', false)) {
            return $value;
        }

        if ($this->matr === null) {
            return null;
        }

        if ($this->qua2kd === null) {
            return null;
        }

        $str0 = 'get';
        $str1 = 'Attribute';
        $name = substr($func, \strlen($str0), -\strlen($str1));
        $anno = (int) substr($name, -4);
        $name = substr($name, 0, -4);

        if (! method_exists($this, $name)) {
            return null;
        }

        /** @var mixed $res */
        $res = $this->$name($anno);

        if ($res === null || ! is_numeric($res)) {
            return null;
        }

        $result = (float) $res;

        // ✅ Check: record must exist before save()
        if ($this->getKey() === null) {
            return $result;
        }

        $fieldname = Str::snake($name).'_'.$anno;

        // Persist con update chirurgico (salva SOLO questo campo, previene loop)
        $this->update([$fieldname => $result]);

        return $result;
    }

    protected function getPerfInd2030Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2029Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2028Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2027Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2026Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2025Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2024Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2023Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2022Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2021Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2020Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2019Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2018Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2017Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2016Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2015Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    protected function getPerfInd2014Attribute(?float $value): ?float
    {
        return $this->funcYear(__FUNCTION__, $value);
    }

    /**
     * Calcola media performance individuale (metodo legacy con side effects).
     *
     * @deprecated Usare getPerfIndMedia() per calcolo puro
     */
    public function perfIndMedia(): ?float
    {
        $data = [];
        for ($i = 1; $i <= $this->n_perf_ind; $i++) {
            $anno = $this->anno - $i;
            $ris = $this->perfInd($anno);
            $field = 'perf_ind_'.$anno;

            if ($this->getKey() !== null) {
                // Persist con update chirurgico (salva SOLO questo campo, previene loop)
                $this->update([$field => $ris]);
            }

            if ($ris > 0.0) {
                $data[$anno] = $ris;
            }
        }

        if (count($data) === 0) {
            $value = null;

            if ($this->getKey() !== null) {
                // Persist con update chirurgico (salva SOLO questo campo, previene loop)
                $this->update(['perf_ind_media' => $value]);
            }

            return $value;
        }

        $value = array_sum($data) / count($data);

        return (float) $value;
    }

    /**
     * Calcola media performance individuale (versione pura).
     *
     * Business Rule: Media aritmetica performance ultimi N anni (default 3).
     * CCNL Art. 19: Progressione basata su media triennale performance.
     *
     * @return float|null Media performance, null se nessun dato disponibile
     */
    protected function getPerfIndMedia(): ?float
    {
        $data = [];

        for ($i = 1; $i <= $this->n_perf_ind; $i++) {
            $anno = $this->anno - $i;
            $ris = $this->perfInd($anno);

            if ($ris > 0.0) {
                $data[$anno] = $ris;
            }
        }

        if (count($data) === 0) {
            return null;
        }

        return array_sum($data) / count($data);
    }

    /**
     * Accessor per perf_ind_media (media performance individuale).
     * Delega calcolo a getPerfIndMedia().
     *
     * @param  float|null  $value  Valore cached dal DB
     * @return float|null Media performance calcolata (arrotondata a 2 decimali)
     */
    protected function getPerfIndMediaAttribute(?float $value): ?float
    {
        // Cache hit (con arrotondamento per consistenza)
        if ($value !== null && ! request()->input('refresh', 0)) {
            return round($value, 2);
        }

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() == null) {
            return null;
        }

        // Delega calcolo al metodo puro
        $value = $this->getPerfIndMedia();

        if ($value === null) {
            return null;
        }

        // Persist con update chirurgico (salva SOLO questo campo, previene loop)
        $this->update(['perf_ind_media' => $value]);

        return round($value, 2);
    }

    protected function getPerfIndCountLast3YearsAttribute(?int $value): ?int
    {
        if ($value !== null && ! request()->input('refresh', 0)) {
            return $value;
        }

        // ✅ Check: record deve esistere prima di save()
        if ($this->getKey() == null) {
            return null;
        }

        $value = $this->performanceIndividuale()
            ->whereBetween('anno', [$this->anno - 3, $this->anno - 1])
            // ->where('ha_diritto', '>', 0)
            ->where('totale_punteggio', '>', 0)
            ->get()
            ->keyBy('anno')
            ->count();

        // Persist con update chirurgico (salva SOLO questo campo, previene loop)
        $this->update(['perf_ind_count_last_3_years' => $value]);

        return $value;
    }

    public function excellencesCountLast3years(): int
    {
        $anno_range = [$this->anno - 3, $this->anno - 1];

        return $this->performanceIndividuale()
            ->whereBetween('anno', $anno_range)
            // ->where('ha_diritto', '>', 0)
            ->where('excellence', 1)
            ->get()
            ->keyBy('anno')
            ->count();
    }

    protected function getExcellencesCountLast3yearsAttribute(?int $value): ?int
    {
        if ($value !== null && ! request()->input('refresh', 0)) {
            return $value;
        }

        $value = $this->excellencesCountLast3years();

        $this->update(['excellences_count_last_3_years' => $value]);

        return $value;
    }

    /**
     * Get criteri options as Collection.
     *
     * @return Collection<string, mixed>
     */
    public function getCriteriOptions(): Collection
    {
        /** @var Collection<int, object> $criteriOptions */
        $criteriOptions = $this->criteriOptions;

        return $criteriOptions->keyBy('name')->map(static function (object $item): mixed {
            $type = isset($item->type) && is_string($item->type) ? $item->type : null;
            $value = $item->value ?? null;

            return match ($type) {
                'list' => is_string($value) ? explode(',', $value) : [],
                'int' => is_numeric($value) ? (int) $value : 0,
                'date' => ($value !== null && (is_string($value) || is_int($value) || $value instanceof \DateTimeInterface)) ? Date::parse($value) : null,
                default => $value,
            };
        });
    }

    public function getGgIntegParams(): ?int
    {
        $last_integ = Integparam::where('ente', $this->ente)
            ->where('matr', $this->matr)
            ->latest('anv2ka')
            ->first();
        if ($last_integ === null) {
            return null;
        }

        $criteriOption = $this->getCriteriOptions();
        $data_presenza_al = $criteriOption->get('data_presenza_al');
        // aggiornare campo con il valore minimo ..
        // dddx(['rows'=>$rows,'data_presenza_al'=>$data_presenza_al]);

        if (! ($last_integ->anv2kd instanceof Carbon)) {
            return null;
        }

        if (! ($data_presenza_al instanceof \DateTimeInterface) && ! is_string($data_presenza_al)) {
            return null;
        }

        $days = $last_integ->anv2kd->diffInDays($data_presenza_al, true);

        return intval($days);
    }

    /**
     * Get criteri options value by name.
     */
    public function criteriOptionsArr(string $name): mixed
    {
        $criteriOptions = $this->getCriteriOptions();

        return $criteriOptions->get($name);
    }
}
