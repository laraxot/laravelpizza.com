<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAll00fTable.
 */
class CreateAll00fTable extends XotBaseMigration
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
                $table->text('pmese')->nullable();
                $table->text('panno')->nullable();
                $table->text('pdata')->nullable();
                $table->text('pm00')->nullable();
                $table->text('pm98')->nullable();
                $table->text('pm96')->nullable();
                $table->text('pm99')->nullable();
                $table->text('pm95')->nullable();
                $table->text('pm94')->nullable();
                $table->text('pm93')->nullable();
                $table->text('pa00')->nullable();
                $table->text('pa98')->nullable();
                $table->text('pa96')->nullable();
                $table->text('pa99')->nullable();
                $table->text('pa95')->nullable();
                $table->text('pa94')->nullable();
                $table->text('pa93')->nullable();
                $table->text('pp00')->nullable();
                $table->text('pp98')->nullable();
                $table->text('pp96')->nullable();
                $table->text('pp99')->nullable();
                $table->text('pp95')->nullable();
                $table->text('pp94')->nullable();
                $table->text('pp93')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('all00f');
    }
}
