<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateRipo00l1Table.
 */
class CreateRipo00l1Table extends XotBaseMigration
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
                $table->text('ripaa')->nullable();
                $table->text('riprip')->nullable();
                $table->text('ripaut')->nullable();
                $table->text('ripfes')->nullable();
                $table->text('ripflg')->nullable();
                $table->text('ripann')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ripo00l1');
    }
}
