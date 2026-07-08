<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAliqu5l2Table.
 */
class CreateAliqu5l2Table extends XotBaseMigration
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
                $table->text('q32kd')->nullable();
                $table->text('q32ka')->nullable();
                $table->text('q32ka2')->nullable();
                $table->text('q32ka1')->nullable();
                $table->text('q3003')->nullable();
                $table->text('q3cont')->nullable();
                $table->text('q3pro')->nullable();
                $table->text('q3voc1')->nullable();
                $table->text('q3desc')->nullable();
                $table->text('q3des2')->nullable();
                $table->text('q3des3')->nullable();
                $table->text('q3004')->nullable();
                $table->text('dq3004')->nullable();
                $table->text('q3005')->nullable();
                $table->text('dq3005')->nullable();
                $table->text('strco1')->nullable();
                $table->text('desstr')->nullable();
                $table->text('sstco1')->nullable();
                $table->text('dessst')->nullable();
                $table->text('artco1')->nullable();
                $table->text('desart')->nullable();
                $table->text('lib001')->nullable();
                $table->text('lib002')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('aliqu5l2');
    }
}
