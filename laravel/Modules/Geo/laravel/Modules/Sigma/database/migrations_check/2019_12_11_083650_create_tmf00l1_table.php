<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateTmf00l1Table.
 */
class CreateTmf00l1Table extends XotBaseMigration
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
                $table->text('vocfis')->nullable();
                $table->text('cont')->nullable();
                $table->text('tipco')->nullable();
                $table->text('rapp')->nullable();
                $table->text('ruolo')->nullable();
                $table->text('propro')->nullable();
                $table->text('posfun')->nullable();
                $table->text('anz')->nullable();
                $table->text('tmfdal')->nullable();
                $table->text('tmfal')->nullable();
                $table->text('tmfimp')->nullable();
                $table->text('tmfeur')->nullable();
                $table->text('tmfdes')->nullable();
                $table->text('tmfliv')->nullable();
                $table->text('tmfann')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('tmf00l1');
    }
}
