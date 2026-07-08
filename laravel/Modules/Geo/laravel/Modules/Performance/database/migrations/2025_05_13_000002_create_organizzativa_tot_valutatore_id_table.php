<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migrazione per la tabella organizzativa_tot_valutatore_id.
 * Struttura simile a organizzativa_tot_stabi, ma con valutatore_id.
 *
 * @see docs/valutatore-distribution-implementation.md
 */
return new class extends XotBaseMigration
{
    /**
     * Esegui la migrazione.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('valutatore_id')->index();
                $table->decimal('tot_budget_assegnato', 15, 2)->nullable();
                $table->decimal('tot_budget_assegnato_min_punteggio', 15, 2)->nullable();
                $table->decimal('tot_quota_effettiva', 15, 2)->nullable();
                $table->decimal('tot_quota_effettiva_min_punteggio', 15, 2)->nullable();
                $table->decimal('tot_resti', 15, 2)->nullable();
                $table->decimal('tot_resti_min_punteggio', 15, 2)->nullable();
                $table->decimal('delta', 15, 2)->nullable();
                $table->decimal('delta_min_punteggio', 15, 2)->nullable();
                $table->integer('anno')->nullable()->index();
            }
        );
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                $this->updateTimestamps($table, true);
            }
        );
    }
};
