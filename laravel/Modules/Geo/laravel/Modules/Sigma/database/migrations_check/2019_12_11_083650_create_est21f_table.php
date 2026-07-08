<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateEst21fTable.
 */
class CreateEst21fTable extends XotBaseMigration
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
                $table->text('data21')->nullable();
                $table->text('dalo21')->nullable();
                $table->text('alor21')->nullable();
                $table->text('codcom')->nullable();
                $table->text('num1c')->nullable();
                $table->text('num2c')->nullable();
                $table->text('num3c')->nullable();
                $table->text('tar1c')->nullable();
                $table->text('tar2c')->nullable();
                $table->text('tar3c')->nullable();
                $table->text('imp1c')->nullable();
                $table->text('imp2c')->nullable();
                $table->text('imp3c')->nullable();
                $table->text('auto1c')->nullable();
                $table->text('auto2c')->nullable();
                $table->text('auto3c')->nullable();
                $table->text('voce1c')->nullable();
                $table->text('voce2c')->nullable();
                $table->text('voce3c')->nullable();
                $table->text('getto')->nullable();
                $table->text('imp4c')->nullable();
                $table->text('voce4c')->nullable();
                $table->text('impfor')->nullable();
                $table->text('vocfor')->nullable();
                $table->text('desc21')->nullable();
                $table->text('prof21')->nullable();
                $table->text('elab21')->nullable();
                $table->text('mese21')->nullable();
                $table->text('ann21')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('est21f');
    }
}
