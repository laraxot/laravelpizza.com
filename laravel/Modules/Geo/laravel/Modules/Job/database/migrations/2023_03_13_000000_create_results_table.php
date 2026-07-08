<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
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
            $table->timestamp('ran_at')->useCurrent();
            $table->decimal('duration', 24, 14)->default(0.0);
            $table->longText('result');

            // $table->index('task_id', 'task_results_task_id_idx');
            // $table->index('ran_at', 'task_results_ran_at_idx');
            // $table->foreign('task_id', 'task_id_fk')
            //     ->references('id')
            //     ->on(TOTEM_TABLE_PREFIX.'tasks')
            //     ;
        });
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table);
        });
    }
};
