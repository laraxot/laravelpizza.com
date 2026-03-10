<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

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
            // $table->uuid('id')->primary();
            $table->id();
            $table->foreignId('team_id');
            $table->uuid('user_id')->nullable()->index();
            // $table->foreignIdFor(\Modules\Xot\Datas\XotData::make()->getUserClass());
            $table->string('role')->nullable();

            // $table->unique(['team_id', 'user_id']);
        });

        // -- UPDATE --
<<<<<<< HEAD
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps(table: $table, hasSoftDeletes: true);
=======
        $this->tableUpdate(function (Blueprint $table) {
            $this->updateTimestamps()
                table: $table,
                hasSoftDeletes: true,
            );
>>>>>>> 74e589dbb (.)

            // $this->updateUser($table);
        });
    }
};
