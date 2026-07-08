<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Nome della tabella.
     */
    protected string $table_name = 'integparam';

    /**
     * Esegue la migrazione.
     */
    public function up(): void
    {
        // Verifica se la tabella esiste già
        if (Schema::hasTable($this->table_name)) {
            echo 'Tabella ['.$this->table_name.'] già esistente';

            return;
        }

        // Crea la tabella
        Schema::create($this->table_name, static function (Blueprint $table) {
            $table->id();

            // Campi anagrafici
            $table->string('ente', 10);
            $table->string('matr', 10);
            $table->string('conome', 50);
            $table->string('nome', 50);

            // Date di validità
            $table->date('anv2kd');
            $table->date('anv2ka');

            // Parametri di configurazione
            $table->integer('anvist')->default(0);
            $table->string('anvpar', 20);
            $table->decimal('anvimp', 10, 5);
            $table->decimal('anvqta', 10, 2)->default(0.00);
            $table->string('anvvoc', 10);
            $table->string('anvdes', 100);

            // Indici per migliorare le performance
            $table->index('ente');
            $table->index('matr');
            $table->index(['ente', 'matr']);
            $table->index('anv2kd');
            $table->index('anv2ka');
        });

        echo 'Tabella ['.$this->table_name.'] creata con successo!';
    }
};
