<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAsp00k1Table.
 */
class CreateAsp00k1Table extends XotBaseMigration
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
                $table->integer('ente')->nullable();
                $table->integer('matr')->nullable();
                $table->text('tipasp')->nullable();
                $table->text('aspin')->nullable();
                $table->text('aspte')->nullable();
                $table->text('aspco')->nullable();
                $table->text('numrid')->nullable();
                $table->text('aspper')->nullable();
                $table->text('aspann')->nullable();
                $table->text('asptip')->nullable();
                $table->text('aspdat')->nullable();
                $table->text('aspnum')->nullable();
                $table->text('asp2ki')->nullable();
                $table->text('asp2kf')->nullable();
                $table->text('asp2kc')->nullable();
                $table->text('asp2kp')->nullable();
                $table->text('asp001')->nullable();
                $table->text('asp002')->nullable();
                $table->text('asp003')->nullable();
                $table->text('asp004')->nullable();
                $table->text('asp005')->nullable();
                $table->index(['ente', 'matr'], 'ente_matr');
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('asp00k1');
    }
}
