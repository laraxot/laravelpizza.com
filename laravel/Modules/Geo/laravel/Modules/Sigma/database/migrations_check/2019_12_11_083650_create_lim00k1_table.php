<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateLim00k1Table.
 */
class CreateLim00k1Table extends XotBaseMigration
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
                $table->text('tipa')->nullable();
                $table->text('coda')->nullable();
                $table->text('lidal')->nullable();
                $table->text('lial')->nullable();
                $table->text('lquant')->nullable();
                $table->text('ltlim')->nullable();
                $table->text('limpum')->nullable();
                $table->text('lim01')->nullable();
                $table->text('lim02')->nullable();
                $table->text('lmpann')->nullable();
                $table->text('li2kd')->nullable();
                $table->text('li2ka')->nullable();
                $table->text('li001')->nullable();
                $table->text('li002')->nullable();
                $table->text('li003')->nullable();
                $table->text('li004')->nullable();
                $table->text('li005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('lim00k1');
    }
}
