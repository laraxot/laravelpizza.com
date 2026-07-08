<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateMov02k1Table.
 */
class CreateMov02k1Table extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->string('ente', 100)->nullable();
                $table->string('matr', 100)->nullable();
                $table->string('mo2tip', 100)->nullable();
                $table->string('mo2cod', 100)->nullable();
                $table->string('mo2aa', 100)->nullable();
                $table->string('mo2m01', 100)->nullable();
                $table->string('mo2m02', 100)->nullable();
                $table->string('mo2m03', 100)->nullable();
                $table->string('mo2m04', 100)->nullable();
                $table->string('mo2m05', 100)->nullable();
                $table->string('mo2m06', 100)->nullable();
                $table->string('mo2m07', 100)->nullable();
                $table->string('mo2m08', 100)->nullable();
                $table->string('mo2m09', 100)->nullable();
                $table->string('mo2m10', 100)->nullable();
                $table->string('mo2m11', 100)->nullable();
                $table->string('mo2m12', 100)->nullable();
                $table->string('mo2um', 100)->nullable();
                $table->string('mo2v01', 100)->nullable();
                $table->string('mo2v02', 100)->nullable();
                $table->string('mo2v03', 100)->nullable();
                $table->string('mo2v04', 100)->nullable();
                $table->string('mo2v05', 100)->nullable();
                $table->string('mo2v06', 100)->nullable();
                $table->string('mo2v07', 100)->nullable();
                $table->string('mo2v08', 100)->nullable();
                $table->string('mo2v09', 100)->nullable();
                $table->string('mo2v10', 100)->nullable();
                $table->string('mo2v11', 100)->nullable();
                $table->string('mo2v12', 100)->nullable();
                $table->string('mo2ann', 100)->nullable();
                $table->string('mo22kn', 100)->nullable();
                $table->string('mo22kz', 100)->nullable();
                $table->string('mo2001', 100)->nullable();
                $table->string('mo2002', 100)->nullable();
                $table->string('mo2003', 100)->nullable();
                $table->string('mo2004', 100)->nullable();
                $table->string('mo2005', 100)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('mov02k1');
    }
}
