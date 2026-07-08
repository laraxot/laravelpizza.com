<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateTipmok1Table.
 */
class CreateTipmok1Table extends XotBaseMigration
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
                $table->text('cont')->nullable();
                $table->text('tmotip')->nullable();
                $table->text('tmocod')->nullable();
                $table->text('tmodal')->nullable();
                $table->text('tmoal')->nullable();
                $table->text('tmoap')->nullable();
                $table->text('tmopes')->nullable();
                $table->text('tmoret')->nullable();
                $table->text('tmocf')->nullable();
                $table->text('tmorfr')->nullable();
                $table->text('tmocs')->nullable();
                $table->text('tmordf')->nullable();
                $table->text('tmoult')->nullable();
                $table->text('tmoann')->nullable();
                $table->text('tmoper')->nullable();
                $table->text('tretip')->nullable();
                $table->text('trecod')->nullable();
                $table->text('tmoseg')->nullable();
                $table->text('tmo2kd')->nullable();
                $table->text('tmo2ka')->nullable();
                $table->text('tmo001')->nullable();
                $table->text('tmo002')->nullable();
                $table->text('tmo003')->nullable();
                $table->text('tmo004')->nullable();
                $table->text('tmo005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('tipmok1');
    }
}
