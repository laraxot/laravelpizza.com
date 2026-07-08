<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateEst20fTable.
 */
class CreateEst20fTable extends XotBaseMigration
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
                $table->text('auto1')->nullable();
                $table->text('auto2')->nullable();
                $table->text('auto3')->nullable();
                $table->text('tarif1')->nullable();
                $table->text('tarif2')->nullable();
                $table->text('tarif3')->nullable();
                $table->text('commi1')->nullable();
                $table->text('commi2')->nullable();
                $table->text('commi3')->nullable();
                $table->text('commi4')->nullable();
                $table->text('commi5')->nullable();
                $table->text('commi6')->nullable();
                $table->text('commi7')->nullable();
                $table->text('dal1')->nullable();
                $table->text('al1')->nullable();
                $table->text('dal2')->nullable();
                $table->text('al2')->nullable();
                $table->text('dal3')->nullable();
                $table->text('al3')->nullable();
                $table->text('dal4')->nullable();
                $table->text('al4')->nullable();
                $table->text('dal5')->nullable();
                $table->text('al5')->nullable();
                $table->text('dal6')->nullable();
                $table->text('al6')->nullable();
                $table->text('dal7')->nullable();
                $table->text('al7')->nullable();
                $table->text('libe1')->nullable();
                $table->text('libe2')->nullable();
                $table->text('ann20')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('est20f');
    }
}
