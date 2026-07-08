<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWrim03l1Table.
 */
class CreateWrim03l1Table extends XotBaseMigration
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
                $table->text('r3annu')->nullable();
                $table->text('enteap')->nullable();
                $table->text('stdata')->nullable();
                $table->text('r3matr')->nullable();
                $table->text('r3reco')->nullable();
                $table->text('r3ind1')->nullable();
                $table->text('r3fld1')->nullable();
                $table->text('r3ind2')->nullable();
                $table->text('r3fld2')->nullable();
                $table->text('r3ind3')->nullable();
                $table->text('r3fld3')->nullable();
                $table->text('r3ind4')->nullable();
                $table->text('r3fld4')->nullable();
                $table->text('r3ind5')->nullable();
                $table->text('r3fld5')->nullable();
                $table->text('r3ind6')->nullable();
                $table->text('r3fld6')->nullable();
                $table->text('r3ind7')->nullable();
                $table->text('r3fld7')->nullable();
                $table->text('r3flg1')->nullable();
                $table->text('r3flg2')->nullable();
                $table->text('r3com1')->nullable();
                $table->text('r3com2')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wrim03l1');
    }
}
