<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWstr03fTable.
 */
class CreateWstr03fTable extends XotBaseMigration
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
                $table->text('w3annu')->nullable();
                $table->text('enteap')->nullable();
                $table->text('stdata')->nullable();
                $table->text('w3matr')->nullable();
                $table->text('w3reco')->nullable();
                $table->text('w3ind1')->nullable();
                $table->text('w3fld1')->nullable();
                $table->text('w3ind2')->nullable();
                $table->text('w3fld2')->nullable();
                $table->text('w3ind3')->nullable();
                $table->text('w3fld3')->nullable();
                $table->text('w3ind4')->nullable();
                $table->text('w3fld4')->nullable();
                $table->text('w3ind5')->nullable();
                $table->text('w3fld5')->nullable();
                $table->text('w3ind6')->nullable();
                $table->text('w3fld6')->nullable();
                $table->text('w3ind7')->nullable();
                $table->text('w3fld7')->nullable();
                $table->text('w3flg1')->nullable();
                $table->text('w3flg2')->nullable();
                $table->text('w3com1')->nullable();
                $table->text('w3com2')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wstr03f');
    }
}
