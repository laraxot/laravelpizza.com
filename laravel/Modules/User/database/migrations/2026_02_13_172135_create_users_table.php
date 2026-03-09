<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Migration: Add lang column to users table.
 *
 * NOTA: La colonna lang è già gestita nella migrazione originale
 * 2024_01_01_000007_create_users_table.php nel metodo tableUpdate().
 * Questa migrazione è ridondante e può essere eliminata dopo verifica.
 */
return new class extends XotBaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Aggiunge lang solo se non esiste.
        $this->tableUpdate(function (Blueprint $table))
            if (! $this->hasColumn('lang'))
                $table->string('lang', 5)->default('it')->after('state');
            }
        });
    }
};
