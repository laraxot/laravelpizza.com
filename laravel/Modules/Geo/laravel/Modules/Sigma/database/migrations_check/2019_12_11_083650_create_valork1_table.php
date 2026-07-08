<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateValork1Table.
 */
class CreateValork1Table extends XotBaseMigration
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
                $table->text('ENTE')->nullable();
                $table->text('CONT')->nullable();
                $table->text('VALRAP')->nullable();
                $table->text('VALORA')->nullable();
                $table->text('VALDAL')->nullable();
                $table->text('VALAL')->nullable();
                $table->text('VALO')->nullable();
                $table->text('VALG')->nullable();
                $table->text('VALS')->nullable();
                $table->text('VALM')->nullable();
                $table->text('VALANN')->nullable();
                $table->text('VAL2KD')->nullable();
                $table->text('VAL2KA')->nullable();
                $table->text('VAL001')->nullable();
                $table->text('VAL002')->nullable();
                $table->text('VAL003')->nullable();
                $table->text('VAL004')->nullable();
                $table->text('VAL005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('valork1');
    }
}
