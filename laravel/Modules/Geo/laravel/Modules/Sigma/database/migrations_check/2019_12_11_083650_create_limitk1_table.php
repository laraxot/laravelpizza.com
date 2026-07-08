<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateLimitk1Table.
 */
class CreateLimitk1Table extends XotBaseMigration
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
                $table->text('cont')->nullable();
                $table->text('limora')->nullable();
                $table->text('limtip')->nullable();
                $table->text('limcod')->nullable();
                $table->text('limrap')->nullable();
                $table->text('limdal')->nullable();
                $table->text('limal')->nullable();
                $table->text('limcup')->nullable();
                $table->text('limcum')->nullable();
                $table->text('effcup')->nullable();
                $table->text('effcum')->nullable();
                $table->text('limum')->nullable();
                $table->text('limper')->nullable();
                $table->text('limt1')->nullable();
                $table->text('limc1')->nullable();
                $table->text('limann')->nullable();
                $table->text('lim2kd')->nullable();
                $table->text('lim2ka')->nullable();
                $table->text('lim001')->nullable();
                $table->text('lim002')->nullable();
                $table->text('lim003')->nullable();
                $table->text('lim004')->nullable();
                $table->text('lim005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('limitk1');
    }
}
