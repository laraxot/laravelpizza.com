<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCed50fTable.
 */
class CreateCed50fTable extends XotBaseMigration
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
                $table->text('repst2')->nullable();
                $table->text('repre2')->nullable();
                $table->text('cont')->nullable();
                $table->text('propro')->nullable();
                $table->text('posfun')->nullable();
                $table->text('comme1')->nullable();
                $table->text('comme2')->nullable();
                $table->text('comme3')->nullable();
                $table->text('comme4')->nullable();
                $table->text('comme5')->nullable();
                $table->text('comme6')->nullable();
                $table->text('ordced')->nullable();
                $table->text('orduff')->nullable();
                $table->text('ordnas')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ced50f');
    }
}
