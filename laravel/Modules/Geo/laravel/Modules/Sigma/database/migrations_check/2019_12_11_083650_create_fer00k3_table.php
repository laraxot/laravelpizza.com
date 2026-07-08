<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateFer00k3Table.
 */
class CreateFer00k3Table extends XotBaseMigration
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
                $table->text('ferano')->nullable();
                $table->text('ferdal')->nullable();
                $table->text('feral')->nullable();
                $table->text('fersta')->nullable();
                $table->text('fertip')->nullable();
                $table->text('fercod')->nullable();
                $table->text('fercon')->nullable();
                $table->text('ferrap')->nullable();
                $table->text('fertor')->nullable();
                $table->text('ferngi')->nullable();
                $table->text('ferngr')->nullable();
                $table->text('ferngd')->nullable();
                $table->text('ferlim')->nullable();
                $table->text('fercx')->nullable();
                $table->text('fernx')->nullable();
                $table->text('fergod')->nullable();
                $table->text('ferum')->nullable();
                $table->text('ferann')->nullable();
                $table->text('fer2kn')->nullable();
                $table->text('fer2kd')->nullable();
                $table->text('fer2ka')->nullable();
                $table->text('fer001')->nullable();
                $table->text('fer002')->nullable();
                $table->text('fer003')->nullable();
                $table->text('fer004')->nullable();
                $table->text('fer005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('fer00k3');
    }
}
