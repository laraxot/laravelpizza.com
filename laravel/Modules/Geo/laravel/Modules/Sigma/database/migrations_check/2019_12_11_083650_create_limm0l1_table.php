<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateLimm0l1Table.
 */
class CreateLimm0l1Table extends XotBaseMigration
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
                $table->text('limmti')->nullable();
                $table->text('limmco')->nullable();
                $table->text('limman')->nullable();
                $table->text('limmme')->nullable();
                $table->text('limmte')->nullable();
                $table->text('limmgo')->nullable();
                $table->text('limmum')->nullable();
                $table->text('limm01')->nullable();
                $table->text('limm02')->nullable();
                $table->text('liannu')->nullable();
                $table->text('lmm001')->nullable();
                $table->text('lmm002')->nullable();
                $table->text('lmm003')->nullable();
                $table->text('lmm004')->nullable();
                $table->text('lmm005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('limm0l1');
    }
}
