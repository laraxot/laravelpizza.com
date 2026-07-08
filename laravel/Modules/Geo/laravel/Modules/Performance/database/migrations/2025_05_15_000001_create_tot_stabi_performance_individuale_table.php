<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Performance\Models\IndividualeTotStabi as MyModel;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Migrazione secondo standard WindSurf/Laraxot per IndividualeTotStabi.
 * Motivazione: coerenza, modularità, compliance PHPStan 10, tracciabilità storica.
 * Allineata a tot_stabi_performance_organizzativa ma adattata per Individuale.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = MyModel::class;

    /**
     * Esegui la creazione della tabella tot_stabi_performance_individuale.
     */
    public function up(): void
    {
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('stabi')->nullable()->index()->comment('ID stabilimento');
            $table->string('anno')->nullable()->index()->comment('Anno di riferimento');
            $table->decimal('tot_budget_assegnato', 15, 2)->nullable()->comment('Totale budget assegnato');
            $table->decimal('tot_quota_effettiva', 15, 2)->nullable()->comment('Totale quota effettiva');
            $table->decimal('tot_resti', 15, 2)->nullable()->comment('Totale resti');
            $table->decimal('tot_budget_assegnato_min_punteggio', 15, 2)->nullable()->comment('Totale budget assegnato min punteggio');
            $table->decimal('tot_quota_effettiva_min_punteggio', 15, 2)->nullable()->comment('Totale quota effettiva min punteggio');
            $table->decimal('tot_resti_min_punteggio', 15, 2)->nullable()->comment('Totale resti min punteggio');
            $table->decimal('delta', 15, 4)->nullable()->comment('Fattore delta');
            $table->decimal('delta_min_punteggio', 15, 4)->nullable()->comment('Fattore delta min punteggio');
            $table->timestamps();
        });
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('stabi')) {
                    $table->unsignedBigInteger('stabi')->nullable()->index()->comment('ID stabilimento');
                }
            }
        );
    }
};
