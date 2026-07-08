<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateQua01k2Table.
 */
class CreateQua01k2Table extends XotBaseMigration
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
                $table->text('prvdal')->nullable();
                $table->text('prvsca')->nullable();
                $table->text('matsos')->nullable();
                $table->text('prov1')->nullable();
                $table->text('prda1')->nullable();
                $table->text('nupr1')->nullable();
                $table->text('prov2')->nullable();
                $table->text('prda2')->nullable();
                $table->text('nupr2')->nullable();
                $table->text('prov3')->nullable();
                $table->text('prda3')->nullable();
                $table->text('nupr3')->nullable();
                $table->text('prov4')->nullable();
                $table->text('prda4')->nullable();
                $table->text('nupr4')->nullable();
                $table->text('prov5')->nullable();
                $table->text('prda5')->nullable();
                $table->text('nupr5')->nullable();
                $table->text('flgan')->nullable();
                $table->text('prv2kl')->nullable();
                $table->text('prv2ks')->nullable();
                $table->text('prd2k1')->nullable();
                $table->text('prd2k2')->nullable();
                $table->text('prd2k3')->nullable();
                $table->text('prd2k4')->nullable();
                $table->text('prd2k5')->nullable();
                $table->text('tipsca')->nullable();
                $table->text('qua011')->nullable();
                $table->text('qua012')->nullable();
                $table->text('qua013')->nullable();
                $table->text('qua014')->nullable();
                $table->text('qua015')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('qua01k2');
    }
}
