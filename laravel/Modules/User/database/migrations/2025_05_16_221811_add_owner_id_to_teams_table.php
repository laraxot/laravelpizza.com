<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Nome della tabella gestita dalla migrazione.
     */
    protected string $table_name = 'teams';

    /**
     * Esegue la migrazione.
     */
    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if (! Schema::hasColumn($this->table_name, 'owner_id')) {
                $table->uuid('owner_id')->nullable()->after('id');
            }
        });
    }
};
