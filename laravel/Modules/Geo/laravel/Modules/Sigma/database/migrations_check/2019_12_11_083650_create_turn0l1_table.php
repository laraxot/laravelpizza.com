<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateTurn0l1Table.
 */
class CreateTurn0l1Table extends XotBaseMigration
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
                $table->integer('ente')->nullable()->index('ente');
                $table->integer('cont')->nullable()->index('cont');
                $table->integer('turrap')->nullable()->index('turrap');
                $table->integer('turora')->nullable()->index('turora');
                $table->integer('turdal')->nullable()->index('turdal');
                $table->integer('tural')->nullable();
                $table->integer('oralun')->nullable();
                $table->integer('oramar')->nullable();
                $table->integer('oramer')->nullable();
                $table->integer('oragio')->nullable();
                $table->integer('oraven')->nullable();
                $table->integer('orasab')->nullable();
                $table->integer('oradom')->nullable();
                $table->string('turann', 1)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('turn0l1');
    }
}
