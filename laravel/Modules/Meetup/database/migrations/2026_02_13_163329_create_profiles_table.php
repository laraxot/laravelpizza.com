<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\Profile;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migration: Change profiles id to UUID.
 * 
 * NOTA: La conversione UUID è già gestita nella migrazione originale
 * 2024_12_26_000008_create_profiles_table.php nel metodo tableUpdate()
 * Questa migrazione è ridondante e può essere eliminata dopo verifica.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = Profile::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Conversione id da bigint a string(36) per UUID
        $this->tableUpdate(function (Blueprint $table): void {
            // Verifica tipo corrente prima di modificare
            if (in_array($this->getColumnType('id'), ['bigint', 'integer'], strict: true)) {
                $table->string('id', 36)->change();
            }
        });
    }
};
