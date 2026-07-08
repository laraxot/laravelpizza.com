<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateSto00k1Table.
 */
class CreateSto00k1Table extends XotBaseMigration
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
                $table->integer('stass')->nullable()->index('stass');
                $table->integer('stdim')->nullable()->index('stdim');
                $table->integer('stupd')->nullable()->index('stupd');
                $table->integer('tipass')->nullable();
                $table->integer('tipdim')->nullable();
                $table->string('stann', 1)->nullable();
                $table->integer('stotia')->nullable();
                $table->integer('stotil')->nullable();
                $table->integer('stodaa')->nullable();
                $table->integer('stodal')->nullable();
                $table->string('stonua', 20)->nullable();
                $table->string('stonul', 20)->nullable();
                $table->integer('st2kas')->nullable();
                $table->integer('st2kdi')->nullable();
                $table->integer('st2ku')->nullable();
                $table->integer('sto2ka')->nullable();
                $table->integer('sto2kd')->nullable();
                $table->integer('matina')->nullable();
                $table->integer('sto001')->nullable();
                $table->string('sto002', 1)->nullable();
                $table->string('sto003', 15)->nullable();
                $table->integer('sto004')->nullable();
                $table->integer('sto005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('sto00k1');
    }
}
