<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateIrp20l1Table.
 */
class CreateIrp20l1Table extends XotBaseMigration
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
                $table->text('irpdal')->nullable();
                $table->text('irpal')->nullable();
                $table->text('iprod')->nullable();
                $table->text('iprof1')->nullable();
                $table->text('iprof2')->nullable();
                $table->text('rifrca')->nullable();
                $table->text('rifrag')->nullable();
                $table->text('rifrco')->nullable();
                $table->text('iproda')->nullable();
                $table->text('iprodb')->nullable();
                $table->text('rifpro')->nullable();
                $table->text('iconi')->nullable();
                $table->text('iprfi')->nullable();
                $table->text('riffig')->nullable();
                $table->text('faliq')->nullable();
                $table->text('assfis')->nullable();
                $table->text('assali')->nullable();
                $table->text('ipdedu')->nullable();
                $table->text('iprite')->nullable();
                $table->text('ipaddr')->nullable();
                $table->text('ipaddc')->nullable();
                $table->text('ipdetl')->nullable();
                $table->text('ipdetc')->nullable();
                $table->text('ipdetf')->nullable();
                $table->text('ipdeta')->nullable();
                $table->text('idisab')->nullable();
                $table->text('comest')->nullable();
                $table->text('iflgad')->nullable();
                $table->text('iann20')->nullable();
                $table->text('campo1')->nullable();
                $table->text('campo2')->nullable();
                $table->text('campo3')->nullable();
                $table->text('vuo1')->nullable();
                $table->text('vuo2')->nullable();
                $table->text('vuo3')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('irp20l1');
    }
}
