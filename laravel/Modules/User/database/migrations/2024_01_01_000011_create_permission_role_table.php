<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class CreateRolesTable.
 */
return new class extends XotBaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
<<<<<<< HEAD
        $this->tableCreate(static function (Blueprint $table): void {
=======
        $this->tableCreate(static function (Blueprint $table) {
>>>>>>> 74e589dbb (.)
            $table->id();
            $table->foreignIdFor(Permission::class, 'permission_id')->nullable();
            $table->foreignIdFor(Role::class, 'role_id')->nullable();
        });
        // -- UPDATE --
<<<<<<< HEAD
        $this->tableUpdate(function (Blueprint $table): void {
=======
        $this->tableUpdate(function (Blueprint $table) {
>>>>>>> 74e589dbb (.)
            $this->updateTimestamps($table);
        });
    }
};
