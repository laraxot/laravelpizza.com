<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreatePro03l1Table.
 */
class CreatePro03l1Table extends XotBaseMigration
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
                $table->text('p3annu')->nullable();
                $table->text('enteap')->nullable();
                $table->text('p3dtal')->nullable();
                $table->text('p3dtul')->nullable();
                $table->text('p3matr')->nullable();
                $table->text('p3reco')->nullable();
                $table->text('p3ind1')->nullable();
                $table->text('p3fld1')->nullable();
                $table->text('p3ind2')->nullable();
                $table->text('p3fld2')->nullable();
                $table->text('p3ind3')->nullable();
                $table->text('p3fld3')->nullable();
                $table->text('p3ind4')->nullable();
                $table->text('p3fld4')->nullable();
                $table->text('p3ind5')->nullable();
                $table->text('p3fld5')->nullable();
                $table->text('p3ind6')->nullable();
                $table->text('p3fld6')->nullable();
                $table->text('p3ind7')->nullable();
                $table->text('p3fld7')->nullable();
                $table->text('p3flg1')->nullable();
                $table->text('p3flg2')->nullable();
                $table->text('p3com1')->nullable();
                $table->text('p3com2')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('pro03l1');
    }
}
