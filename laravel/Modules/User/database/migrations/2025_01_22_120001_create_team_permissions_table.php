<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    /**
     * Nome della tabella gestita dalla migrazione.
     */
    protected string $table_name = 'team_permissions';

    /**
     * Esegue la migrazione.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
            $table->string('permission'); // The permission key/slug
            $table->string('name')->nullable(); // Human readable name

            // Optional: Add uniqueness if needed, e.g. unique(['team_id', 'permission'])
            $table->unique(['team_id', 'permission']);
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('permission')) {
                $table->string('permission');
            }
            if (! $this->hasColumn('name')) {
                $table->string('name')->nullable();
            }

            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
