<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Role;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Role::class;

    public function up(): void
    {
        // This migration behaves as a **schema extension** for the roles table.
        // The authoritative CREATE is defined in 2024_01_01_000011_create_roles_table.php.

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Laraxot extensions with hasColumn checks - DRY + KISS
            if (! $this->hasColumn('display_name')) {
                $table->string('display_name')->nullable();
            }

            if (! $this->hasColumn('description')) {
                $table->text('description')->nullable();
            }
            $this->updateTimestamps($table);
        });
    }
};
