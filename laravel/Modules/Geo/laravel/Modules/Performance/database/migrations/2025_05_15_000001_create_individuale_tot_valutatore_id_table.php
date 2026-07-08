<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Migrazione secondo standard WindSurf/Laraxot per IndividualeTotValutatoreId.
 * Motivazione: garantire coerenza, modularità, compliance PHPStan 10, tracciabilità storica.
 * Allineata a organizzativa_tot_valutatore_id ma adattata per Individuale.
 * Ultimo aggiornamento: 2025-05-15
 */
return new class extends XotBaseMigration
{
    /**
     * Esegui la creazione della tabella individuale_tot_valutatore_id.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('valutatore_id')->nullable()->index()->comment('ID del valutatore');
                $table->string('anno')->nullable()->index()->comment('Anno di riferimento');
                $table->decimal('tot_budget_assegnato', 15, 2)->nullable()->comment('Totale budget assegnato');
                $table->decimal('tot_quota_effettiva', 15, 2)->nullable()->comment('Totale quota effettiva');
                $table->decimal('tot_resti', 15, 2)->nullable()->comment('Totale resti');
                $table->decimal('tot_budget_assegnato_min_punteggio', 15, 2)->nullable()->comment('Totale budget assegnato min punteggio');
                $table->decimal('tot_quota_effettiva_min_punteggio', 15, 2)->nullable()->comment('Totale quota effettiva min punteggio');
                $table->decimal('tot_resti_min_punteggio', 15, 2)->nullable()->comment('Totale resti min punteggio');
                $table->decimal('delta', 15, 4)->nullable()->comment('Fattore delta');
                $table->decimal('delta_min_punteggio', 15, 4)->nullable()->comment('Fattore delta min punteggio');
            }
        );
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('valutatore_id')) {
                    $table->unsignedBigInteger('valutatore_id')->nullable()->index()->comment('ID del valutatore');
                }
                $this->updateTimestamps($table, true);
            }
        );
    }
};
