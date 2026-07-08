<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateFerie1fTable.
 */
class CreateFerie1fTable extends XotBaseMigration
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
                $table->text('matr')->nullable();
                $table->text('f1aa')->nullable();
                $table->text('f1tip')->nullable();
                $table->text('f1dat1')->nullable();
                $table->text('f1ora1')->nullable();
                $table->text('f1dat2')->nullable();
                $table->text('f1ora2')->nullable();
                $table->text('f1dat3')->nullable();
                $table->text('f1fas')->nullable();
                $table->text('f1ann')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ferie1f');
    }
}
