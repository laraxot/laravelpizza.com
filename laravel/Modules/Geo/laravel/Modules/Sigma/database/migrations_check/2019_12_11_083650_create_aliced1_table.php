<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAliced1Table.
 */
class CreateAliced1Table extends XotBaseMigration
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
                $table->string('conome', 25)->nullable();
                $table->string('nome', 25)->nullable();
                $table->integer('con')->nullable()->index('con');
                $table->integer('rap')->nullable();
                $table->integer('ruo')->nullable();
                $table->integer('pro')->nullable();
                $table->integer('pos')->nullable();
                $table->integer('man')->nullable();
                $table->integer('dis')->nullable();
                $table->string('prod', 40)->nullable();
                $table->string('qu1d', 40)->nullable();
                $table->string('qu2d', 40)->nullable();
                $table->string('quli', 2)->nullable();
                $table->integer('anno')->nullable();
                $table->integer('voce')->nullable();
                $table->integer('isti')->nullable();
                $table->string('desret', 40)->nullable();
                $table->integer('tipret')->nullable();
                $table->decimal('import', 13)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('aliced1');
    }
}
