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
            // L'id utente e' un UUID di 36 caratteri: una colonna intera lo troncherebbe
            // a 0, legando la riga all'utente sbagliato o a nessuno.
            $table->string('user_id', 36)->nullable();
            $table->text('comment');

            $table->index('task_id', 'task_comments_task_id_idx');
            $table->index('user_id', 'task_comments_user_id_idx');
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
