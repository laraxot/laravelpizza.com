<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateInq00l1Table.
 */
class CreateInq00l1Table extends XotBaseMigration
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
                $table->text('cont')->nullable();
                $table->text('codinq')->nullable();
                $table->text('inqdal')->nullable();
                $table->text('inqal')->nullable();
                $table->text('strvoc')->nullable();
                $table->text('stvocn')->nullable();
                $table->text('inann')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('inq00l1');
    }
}
