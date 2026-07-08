<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWmen00l4Table.
 */
class CreateWmen00l4Table extends XotBaseMigration
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
                $table->text('enteap')->nullable();
                $table->text('mnannu')->nullable();
                $table->text('mnbadg')->nullable();
                $table->text('mnmatr')->nullable();
                $table->text('mncogn')->nullable();
                $table->text('mnnome')->nullable();
                $table->text('mncaus')->nullable();
                $table->text('mnp1')->nullable();
                $table->text('mnp2')->nullable();
                $table->text('mnp3')->nullable();
                $table->text('mnp4')->nullable();
                $table->text('mndata')->nullable();
                $table->text('mnorat')->nullable();
                $table->text('mnflg1')->nullable();
                $table->text('mnflg2')->nullable();
                $table->text('mnflg3')->nullable();
                $table->text('mnflg4')->nullable();
                $table->text('mntmen')->nullable();
                $table->text('mncom2')->nullable();
                $table->text('mncom3')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wmen00l4');
    }
}
