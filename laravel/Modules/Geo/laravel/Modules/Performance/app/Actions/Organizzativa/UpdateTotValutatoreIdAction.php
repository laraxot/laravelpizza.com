<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Organizzativa;

use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;
use Modules\Performance\Models\Organizzativa as Scheda;
use Modules\Performance\Models\OrganizzativaTotValutatoreId as TotValutatoreId;
use Spatie\QueueableAction\QueueableAction;

/**
 * Aggrega i totali per ogni valutatore per i calcoli di performance organizzativa.
 *
 * Questa Action crea e aggiorna i record nella tabella organizzativa_tot_valutatore_id,
 * calcolando i totali per budget_assegnato, quota_effettiva e resti per ogni valutatore.
 * Inoltre calcola il coefficiente delta necessario per la redistribuzione dei resti.
 */
class UpdateTotValutatoreIdAction
{
    use QueueableAction;

    /**
     * I campi per cui calcolare i totali.
     *
     * @var array<int, string>
     */
    protected array $fields = ['budget_assegnato', 'quota_effettiva', 'resti'];

    /**
     * Il modello Scheda per le query.
     */
    protected Scheda $model;

    /**
     * Costruttore.
     *
     * @param  Scheda  $schedeModel  Il modello Scheda
     */
    public function __construct(Scheda $schedeModel)
    {
        $this->model = $schedeModel;
    }

    /**
     * Esegue l'aggregazione dei totali per valutatore.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance ('dip' per dipendenti)
     */
    public function execute(string $year, string $type = 'dip'): void
    {
        // Cancella i record esistenti per l'anno
        $this->clearExistingRecords($year);

        // Crea record per ogni valutatore distinto
        $this->createRecordsForValutatori($year, $type);

        // Aggiorna i totali per ogni campo
        $this->updateTotals($year, $type);

        // Calcola i delta
        $this->calculateDeltas($year);
    }

    /**
     * Cancella i record esistenti per l'anno specificato.
     *
     * @param  string  $year  Anno di riferimento
     */
    protected function clearExistingRecords(string $year): void
    {
        TotValutatoreId::where('anno', $year)->delete();
        echo "Cancellati record esistenti per anno: {$year}\n";
    }

    /**
     * Crea record per ogni valutatore distinto.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance
     */
    protected function createRecordsForValutatori(string $year, string $type): void
    {
        // Trova tutti i valutatori_id distinti
        $valutatoriIds = $this->model
            ->where('anno', $year)
            ->where('type', $type)
            ->whereNotNull('valutatore_id')
            ->distinct()
            ->pluck('valutatore_id');

        // Crea record per ogni valutatore
        foreach ($valutatoriIds as $valutatoreId) {
            TotValutatoreId::create([
                'valutatore_id' => $valutatoreId,
                'anno' => $year,
            ]);
        }

        // Log::info("Creati {$valutatoriIds->count()} record per valutatori, anno: {$year}");
    }

    /**
     * Aggiorna i totali per ogni campo.
     *
     * @param  string  $year  Anno di riferimento
     * @param  string  $type  Tipo di performance
     */
    protected function updateTotals(string $year, string $type): void
    {
        foreach ($this->fields as $field) {
            $sumSql = match ($field) {
                'budget_assegnato' => 'SUM(budget_assegnato) as total',
                'quota_effettiva' => 'SUM(quota_effettiva) as total',
                'resti' => 'SUM(resti) as total',
                default => throw new \InvalidArgumentException("Unknown field: {$field}"),
            };
            $totals = $this->model
                ->where('anno', $year)
                ->where('type', $type)
                ->where('ha_diritto', '>', 0)
                ->whereNotNull('valutatore_id')
                ->select('valutatore_id')
                ->selectRaw($sumSql)
                ->groupBy('valutatore_id')
                ->get();

            // Aggiorna i totali nella tabella
            foreach ($totals as $total) {
                if (is_null($total->valutatore_id)) {
                    echo 'Valutatore ID null trovato durante aggiornamento totali';

                    continue;
                }

                TotValutatoreId::where('valutatore_id', $total->valutatore_id)
                    ->where('anno', $year)
                    ->update([
                        "tot_{$field}" => $total->total ?? 0,
                        "tot_{$field}_min_punteggio" => $total->total ?? 0,
                    ]);
            }

            echo "Aggiornati totali per campo {$field}, anno: {$year}\n";
        }
    }

    /**
     * Calcola i coefficienti delta per ogni valutatore.
     *
     * @param  string  $year  Anno di riferimento
     */
    protected function calculateDeltas(string $year): void
    {
        // Aggiorna il campo delta per tutti i record
        // Nota: NULLIF previene divisioni per zero
        $updated = TotValutatoreId::where('anno', $year)
            ->update([
                'delta' => DB::raw('tot_resti / NULLIF(tot_quota_effettiva, 0)'),
                'delta_min_punteggio' => DB::raw('tot_resti_min_punteggio / NULLIF(tot_quota_effettiva_min_punteggio, 0)'),
            ]);

        // Imposta delta a 0 dove è NULL (casi di divisione per zero)
        TotValutatoreId::where('anno', $year)
            ->whereNull('delta')
            ->update(['delta' => 0]);

        TotValutatoreId::where('anno', $year)
            ->whereNull('delta_min_punteggio')
            ->update(['delta_min_punteggio' => 0]);

        echo "Calcolati coefficienti delta per {$updated} valutatori, anno: {$year}\n";
    }
}
