<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateApp00l1Table.
 */
class CreateApp00l1Table extends XotBaseMigration
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
                $table->text('anzdal')->nullable();
                $table->text('anzal')->nullable();
                $table->text('anzvoc')->nullable();
                $table->text('anzini')->nullable();
                $table->text('anzfin')->nullable();
                $table->text('anznv')->nullable();
                $table->text('anzdif')->nullable();
                $table->text('anzeur')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('app00l1');
    }
}
