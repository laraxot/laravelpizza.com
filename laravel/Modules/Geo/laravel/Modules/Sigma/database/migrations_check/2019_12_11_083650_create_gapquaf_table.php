<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateGapquafTable.
 */
class CreateGapquafTable extends XotBaseMigration
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
                $table->text('qente')->nullable();
                $table->text('qtipo')->nullable();
                $table->text('qprof')->nullable();
                $table->text('qposi')->nullable();
                $table->text('qdesc')->nullable();
                $table->text('qabil')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('gapquaf');
    }
}
