<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAcp00l1Table.
 */
class CreateAcp00l1Table extends XotBaseMigration
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
                $table->text('acpkvo')->nullable();
                $table->text('acpali')->nullable();
                $table->text('acpmli')->nullable();
                $table->text('acpgio')->nullable();
                $table->text('acpcon')->nullable();
                $table->text('acpope')->nullable();
                $table->text('acptip')->nullable();
                $table->text('acpvoc')->nullable();
                $table->text('acpimp')->nullable();
                $table->text('acpeur')->nullable();
                $table->text('acpann')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('acp00l1');
    }
}
