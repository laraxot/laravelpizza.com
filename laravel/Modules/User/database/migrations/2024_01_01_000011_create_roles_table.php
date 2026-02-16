<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
// ---- models ---
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class CreateRolesTable.
 */
return new class extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('team_id')->nullable()->index();
            $table->string('name');
            $table->string('guard_name')->default('web');
            $table->string('display_name')->nullable();
            $table->text('description')->nullable();
        });
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('id')) {
                $table->id();
            }
            if (! $this->hasColumn('team_id')) {
                $table->foreignId('team_id')->nullable()->index();
            }
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
