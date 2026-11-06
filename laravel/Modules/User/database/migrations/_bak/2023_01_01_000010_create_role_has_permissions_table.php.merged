<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\RoleHasPermission;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Pivot Spatie HasRoles — tabella e connessione dal modello
 * (RoleHasPermission::getTable() legge config('permission.table_names.role_has_permissions')
 * a ogni chiamata). Vietato hardcodare il nome tabella in migrazione.
 */
return new class extends XotBaseMigration {
    protected ?string $model_class = RoleHasPermission::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
        });
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table);

            // $this->updateUser($table);
        });
    }
};
