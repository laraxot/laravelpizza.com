<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Creazione della tabella criteri_esclusione.
 *
 * Modifiche:
 * - Creazione tabella per gestione criteri di esclusione per progressioni
 * - Campi per configurazione criteri dinamici con operatori e valori
 * - Tracciamento utente e timestamp standard
 * - Indici per performance su anno e campo
 *
 * Riferimento: Modulo Progressioni - Gestione criteri di esclusione
 * Autore: Sistema Laraxot
 * Data: 2025-01-15
 */
return new class extends XotBaseMigration
{
    /**
     * Esegue la migrazione.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->id();

                // Campi di configurazione del criterio
                $table->boolean('is_enabled')->default(true)->comment('Criterio abilitato');
                $table->string('name', 255)->nullable()->comment('Nome del criterio');
                $table->string('field_name', 100)->nullable()->comment('Nome del campo su cui applicare il criterio');
                $table->string('op', 10)->nullable()->comment('Operatore di confronto (=, >, <, IN, NOT IN)');
                $table->text('value')->nullable()->comment('Valore di confronto');
                $table->string('type', 20)->nullable()->comment('Tipo di dato: string, integer, date, list');

                // Campo di riferimento temporale
                $table->integer('anno')->nullable()->comment('Anno di riferimento per il criterio');

                // Indici per performance
                $table->index(['anno', 'is_enabled'], 'idx_anno_enabled');
                $table->index(['field_name', 'type'], 'idx_field_type');
                $table->index('created_by', 'idx_created_by');
                $table->index('updated_by', 'idx_updated_by');
            }
        );
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('is_enabled')) {
                    $table->boolean('is_enabled')->default(false)->comment('Criterio abilitato');
                }
                $this->updateTimestamps($table);
            }
        );
    }
};
