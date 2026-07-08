<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateEst23fTable.
 */
class CreateEst23fTable extends XotBaseMigration
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
                $table->text('dal')->nullable();
                $table->text('al')->nullable();
                $table->text('seqs')->nullable();
                $table->text('sede')->nullable();
                $table->text('num1s')->nullable();
                $table->text('num2s')->nullable();
                $table->text('num3s')->nullable();
                $table->text('tar1s')->nullable();
                $table->text('tar2s')->nullable();
                $table->text('tar3s')->nullable();
                $table->text('imp1s')->nullable();
                $table->text('imp2s')->nullable();
                $table->text('imp3s')->nullable();
                $table->text('auto1s')->nullable();
                $table->text('auto2s')->nullable();
                $table->text('auto3s')->nullable();
                $table->text('voce1s')->nullable();
                $table->text('voce2s')->nullable();
                $table->text('voce3s')->nullable();
                $table->text('rimbo')->nullable();
                $table->text('voce4s')->nullable();
                $table->text('desc23')->nullable();
                $table->text('prof23')->nullable();
                $table->text('elab23')->nullable();
                $table->text('mese23')->nullable();
                $table->text('ann23')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('est23f');
    }
}
