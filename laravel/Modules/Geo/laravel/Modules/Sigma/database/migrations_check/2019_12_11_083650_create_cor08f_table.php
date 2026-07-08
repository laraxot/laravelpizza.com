<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCor08fTable.
 */
class CreateCor08fTable extends XotBaseMigration
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
                $table->text('anno')->nullable();
                $table->text('codcor')->nullable();
                $table->text('tiprec')->nullable();
                $table->text('riga')->nullable();
                $table->text('testo')->nullable();
                $table->text('matr08')->nullable();
                $table->text('dspp')->nullable();
                $table->text('dse1')->nullable();
                $table->text('dse2')->nullable();
                $table->text('dscr')->nullable();
                $table->text('dsdt')->nullable();
                $table->text('dsdi')->nullable();
                $table->text('dsnp')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('cor08f');
    }
}
