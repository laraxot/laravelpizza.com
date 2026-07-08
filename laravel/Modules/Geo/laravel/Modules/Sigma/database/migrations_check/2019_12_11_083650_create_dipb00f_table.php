<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateDipb00fTable.
 */
class CreateDipb00fTable extends XotBaseMigration
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
                $table->string('enteap', 100)->nullable();
                $table->string('dbannu', 100)->nullable();
                $table->string('dbmatr', 100)->nullable();
                $table->string('dbbadg', 100)->nullable();
                $table->string('dbdal', 100)->nullable();
                $table->string('dbal', 100)->nullable();
                $table->string('dbcom1', 100)->nullable();
                $table->string('dbcom2', 100)->nullable();
                $table->string('dbcom3', 100)->nullable();
                $table->string('dbcom4', 100)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('dipb00f');
    }
}
