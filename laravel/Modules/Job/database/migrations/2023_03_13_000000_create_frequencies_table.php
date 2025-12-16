<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('task_id');
            $table->string('label');
            $table->string('interval');

            // $table->index('task_id', 'task_frequencies_task_id_idx');
            // $table->foreign('task_id', 'task_frequencies_task_id_fk')
            //     ->references('id')
            //     ->on(TOTEM_TABLE_PREFIX.'tasks');
        });
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table);
        });
    }
};
