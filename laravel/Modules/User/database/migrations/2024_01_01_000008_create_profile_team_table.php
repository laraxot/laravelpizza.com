<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    /**
     * Nome della tabella gestita dalla migrazione.
     */
    protected string $table_name = 'profile_team';

    /**
     * Esegue la migrazione.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->uuid('profile_id')->nullable()->index();
            $table->foreignId('team_id');
            $table->string('role')->nullable();
            $table->text('permissions')->nullable();

            // Indice univoco per evitare duplicati profile_id + team_id
            $table->unique(['profile_id', 'team_id']);
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Aggiorniamo i timestamp e soft deletes
            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
