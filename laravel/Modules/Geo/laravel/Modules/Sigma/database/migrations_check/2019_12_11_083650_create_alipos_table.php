<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAliposTable.
 */
class CreateAliposTable extends XotBaseMigration
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
                $table->text('conome')->nullable();
                $table->text('nome')->nullable();
                $table->text('spdata')->nullable();
                $table->text('prou')->nullable();
                $table->text('posu')->nullable();
                $table->text('codu')->nullable();
                $table->text('assu1')->nullable();
                $table->text('dimi1')->nullable();
                $table->text('cont')->nullable();
                $table->text('tipco')->nullable();
                $table->text('rapp')->nullable();
                $table->text('ruolo')->nullable();
                $table->text('propro')->nullable();
                $table->text('posfun')->nullable();
                $table->text('codqua')->nullable();
                $table->text('disci1')->nullable();
                $table->text('desc1')->nullable();
                $table->text('desc2')->nullable();
                $table->text('descx')->nullable();
                $table->text('dsliv')->nullable();
                $table->text('dss1x')->nullable();
                $table->text('oree')->nullable();
                $table->text('oret')->nullable();
                $table->text('qua2kp')->nullable();
                $table->text('tmf')->nullable();
                $table->text('v4110')->nullable();
                $table->text('v4410')->nullable();
                $table->text('v4400')->nullable();
                $table->text('diff')->nullable();
                $table->text('flagat')->nullable();
                $table->text('flagx')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('alipos');
    }
}
