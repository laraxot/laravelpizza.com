<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateWmeneczfTable.
 */
class CreateWmeneczfTable extends XotBaseMigration
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
                $table->text('mematr')->nullable();
                $table->text('medata')->nullable();
                $table->text('meorat')->nullable();
                $table->text('mefla0')->nullable();
                $table->text('mefla1')->nullable();
                $table->text('mecaus')->nullable();
                $table->text('mecom1')->nullable();
                $table->text('mecom2')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('wmeneczf');
    }
}
