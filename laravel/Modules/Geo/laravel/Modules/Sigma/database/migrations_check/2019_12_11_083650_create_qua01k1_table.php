<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateQua01k1Table.
 */
class CreateQua01k1Table extends XotBaseMigration
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
                $table->integer('ente')->nullable()->index('ente');
                $table->integer('matr')->nullable()->index('matr');
                $table->integer('prvdal')->nullable()->index('prvdal');
                $table->integer('prvsca')->nullable()->index('prvsca');
                $table->integer('matsos')->nullable()->index('matsos');
                $table->integer('prov1')->nullable();
                $table->integer('prda1')->nullable();
                $table->string('nupr1', 20)->nullable();
                $table->integer('prov2')->nullable();
                $table->integer('prda2')->nullable();
                $table->string('nupr2', 20)->nullable();
                $table->integer('prov3')->nullable();
                $table->integer('prda3')->nullable();
                $table->string('nupr3', 20)->nullable();
                $table->integer('prov4')->nullable();
                $table->integer('prda4')->nullable();
                $table->string('nupr4', 20)->nullable();
                $table->integer('prov5')->nullable();
                $table->integer('prda5')->nullable();
                $table->string('nupr5', 20)->nullable();
                $table->string('flgan', 1)->nullable();
                $table->integer('prv2kl')->nullable();
                $table->integer('prv2ks')->nullable();
                $table->integer('prd2k1')->nullable();
                $table->integer('prd2k2')->nullable();
                $table->integer('prd2k3')->nullable();
                $table->integer('prd2k4')->nullable();
                $table->integer('prd2k5')->nullable();
                $table->integer('tipsca')->nullable();
                $table->integer('qua011')->nullable();
                $table->string('qua012', 1)->nullable();
                $table->string('qua013', 15)->nullable();
                $table->integer('qua014')->nullable();
                $table->integer('qua015')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('qua01k1');
    }
}
