<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAcp00l2Table.
 */
class CreateAcp00l2Table extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('ente');
                $table->integer('matr');
                $table->integer('acpkvo');
                $table->integer('acpali');
                $table->integer('acpmli');
                $table->integer('acpgio');
                $table->integer('acpcon');
                $table->char('acpope', 1);
                $table->char('acptip', 1);
                $table->integer('acpvoc');
                $table->integer('acpimp');
                $table->decimal('acpeur', 13);
                $table->char('acpann', 1);
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('acp00l2');
    }
}
