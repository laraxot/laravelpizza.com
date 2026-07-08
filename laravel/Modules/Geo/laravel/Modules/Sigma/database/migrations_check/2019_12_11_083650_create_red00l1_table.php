<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateRed00l1Table.
 */
class CreateRed00l1Table extends XotBaseMigration
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
                $table->text('datstr')->nullable();
                $table->text('datend')->nullable();
                $table->text('statoc')->nullable();
                $table->text('tipnuc')->nullable();
                $table->text('nucleo')->nullable();
                $table->text('redfam')->nullable();
                $table->text('reddip')->nullable();
                $table->text('flaga')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('red00l1');
    }
}
