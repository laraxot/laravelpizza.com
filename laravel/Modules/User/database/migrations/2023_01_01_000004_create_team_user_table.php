<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    /**
     * Nome della tabella gestita dalla migrazione.
     */
    protected string $table_name = 'team_user';

    /**
     * Esegue la migrazione.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            // Rimuoviamo l'id auto-increment e usiamo chiave composita per tabella pivot
            $table->foreignId('team_id');
            $table->uuid('user_id')->nullable();
            $table->string('role')->nullable();

            // Chiave primaria composita per tabella pivot
            $table->primary(['team_id', 'user_id']);
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );

            // $this->updateUser($table);
        });
    }
};
