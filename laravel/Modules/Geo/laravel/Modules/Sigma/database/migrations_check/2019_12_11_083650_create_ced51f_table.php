<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCed51fTable.
 */
class CreateCed51fTable extends XotBaseMigration
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
                $table->integer('ente')->nullable()->index('ente');
                $table->integer('matr')->nullable()->index('matr');
                $table->integer('dal')->nullable();
                $table->integer('al')->nullable();
                $table->string('co1', 78)->nullable();
                $table->string('co2', 78)->nullable();
                $table->string('co3', 78)->nullable();
                $table->string('co4', 78)->nullable();
                $table->string('co5', 78)->nullable();
                $table->string('co6', 78)->nullable();
                $table->string('co7', 78)->nullable();
                $table->string('co8', 78)->nullable();
                $table->string('co9', 78)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ced51f');
    }
}
