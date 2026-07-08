<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAlicedjTable.
 */
class CreateAlicedjTable extends XotBaseMigration
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
                $table->integer('annor')->nullable()->index('annor');
                $table->integer('meser')->nullable()->index('meser');
                $table->string('conome', 25)->nullable();
                $table->string('nome', 25)->nullable();
                $table->integer('con')->nullable();
                $table->integer('tip')->nullable();
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
                $table->integer('matina')->nullable();
                $table->string('codfis', 16)->nullable();
                $table->integer('repst2')->nullable();
                $table->integer('repre2')->nullable();
                $table->string('desst', 40)->nullable();
                $table->string('desre', 40)->nullable();
                $table->decimal('pt1', 7)->nullable();
                $table->decimal('pt2', 7)->nullable();
                $table->integer('assunz')->nullable();
                $table->integer('dimiss')->nullable();
                $table->decimal('v1', 13)->nullable();
                $table->decimal('q1', 13)->nullable();
                $table->decimal('v2', 13)->nullable();
                $table->decimal('q2', 13)->nullable();
                $table->decimal('v3', 13)->nullable();
                $table->decimal('q3', 13)->nullable();
                $table->decimal('v4', 13)->nullable();
                $table->decimal('q4', 13)->nullable();
                $table->decimal('v5', 13)->nullable();
                $table->decimal('q5', 13)->nullable();
                $table->decimal('v6', 13)->nullable();
                $table->decimal('q6', 13)->nullable();
                $table->decimal('v7', 13)->nullable();
                $table->decimal('q7', 13)->nullable();
                $table->decimal('v8', 13)->nullable();
                $table->decimal('q8', 13)->nullable();
                $table->decimal('v9', 13)->nullable();
                $table->decimal('q9', 13)->nullable();
                $table->decimal('v10', 13)->nullable();
                $table->decimal('q10', 13)->nullable();
                $table->decimal('v11', 13)->nullable();
                $table->decimal('q11', 13)->nullable();
                $table->decimal('v12', 13)->nullable();
                $table->decimal('q12', 13)->nullable();
                $table->decimal('v13', 13)->nullable();
                $table->decimal('q13', 13)->nullable();
                $table->decimal('v14', 13)->nullable();
                $table->decimal('q14', 13)->nullable();
                $table->decimal('v15', 13)->nullable();
                $table->decimal('q15', 13)->nullable();
                $table->decimal('v16', 13)->nullable();
                $table->decimal('q16', 13)->nullable();
                $table->decimal('tot670', 13)->nullable();
                $table->decimal('tot679', 13)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('alicedj');
    }
}
