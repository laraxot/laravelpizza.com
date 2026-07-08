<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCorregfTable.
 */
class CreateCorregfTable extends XotBaseMigration
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
                $table->text('form')->nullable();
                $table->text('nreg')->nullable();
                $table->text('prog')->nullable();
                $table->text('voxp')->nullable();
                $table->text('voxn')->nullable();
                $table->text('istx')->nullable();
                $table->text('valuni')->nullable();
                $table->text('rappt')->nullable();
                $table->text('condiz')->nullable();
                $table->text('dames')->nullable();
                $table->text('ames')->nullable();
                $table->text('stab')->nullable();
                $table->text('repa')->nullable();
                $table->text('codqc')->nullable();
                $table->text('pron')->nullable();
                $table->text('codql')->nullable();
                $table->text('limmen')->nullable();
                $table->text('limann')->nullable();
                $table->text('valamm')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('corregf');
    }
}
