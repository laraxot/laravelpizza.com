<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateFatturl1Table.
 */
class CreateFatturl1Table extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->integer('id', true);
                $table->text('ente')->nullable();
                $table->text('anno')->nullable();
                $table->text('mese')->nullable();
                $table->text('dipser')->nullable();
                $table->text('dipces')->nullable();
                $table->text('dipcet')->nullable();
                $table->text('cedela')->nullable();
                $table->text('cedelp')->nullable();
                $table->text('cedneg')->nullable();
                $table->text('cedpre')->nullable();
                $table->text('datela')->nullable();
                $table->text('datpri')->nullable();
                $table->text('propri')->nullable();
                $table->text('datric')->nullable();
                $table->text('proric')->nullable();
                $table->text('datchi')->nullable();
                $table->text('prochi')->nullable();
                $table->text('datall')->nullable();
                $table->text('proall')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('fatturl1');
    }
}
