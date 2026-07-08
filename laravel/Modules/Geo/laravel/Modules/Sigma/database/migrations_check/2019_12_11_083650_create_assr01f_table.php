<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAssr01fTable.
 */
class CreateAssr01fTable extends XotBaseMigration
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
                $table->text('strut')->nullable();
                $table->text('tabe')->nullable();
                $table->text('codic')->nullable();
                $table->text('descod')->nullable();
                $table->text('col01')->nullable();
                $table->text('col02')->nullable();
                $table->text('col03')->nullable();
                $table->text('col04')->nullable();
                $table->text('col05')->nullable();
                $table->text('col06')->nullable();
                $table->text('col07')->nullable();
                $table->text('col08')->nullable();
                $table->text('col09')->nullable();
                $table->text('col10')->nullable();
                $table->text('col11')->nullable();
                $table->text('col12')->nullable();
                $table->text('col13')->nullable();
                $table->text('col14')->nullable();
                $table->text('col15')->nullable();
                $table->text('col16')->nullable();
                $table->text('col17')->nullable();
                $table->text('col18')->nullable();
                $table->text('col19')->nullable();
                $table->text('col20')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('assr01f');
    }
}
