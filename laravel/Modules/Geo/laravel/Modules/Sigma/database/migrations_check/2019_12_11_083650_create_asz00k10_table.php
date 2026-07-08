<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAsz00k10Table.
 */
class CreateAsz00k10Table extends XotBaseMigration
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
                $table->integer('cont')->nullable()->index('cont');
                $table->integer('matr')->nullable()->index('matr');
                $table->integer('asztip')->nullable()->index('asztip');
                $table->integer('aszcod')->nullable()->index('aszcod');
                $table->integer('aszdal')->nullable();
                $table->integer('aszal')->nullable();
                $table->decimal('aszini', 6)->nullable();
                $table->decimal('aszfin', 6)->nullable();
                $table->integer('aszcom')->nullable();
                $table->integer('asztpr')->nullable();
                $table->integer('aszdpr')->nullable();
                $table->string('asznpr', 20)->nullable();
                $table->string('aszumi', 1)->nullable();
                $table->string('aszpes', 1)->nullable();
                $table->decimal('aszdur', 9)->nullable();
                $table->integer('asz01')->nullable();
                $table->integer('asz02')->nullable();
                $table->integer('asz03')->nullable();
                $table->integer('asz04')->nullable();
                $table->integer('asz05')->nullable();
                $table->string('aszcm', 3)->nullable();
                $table->string('aszcms', 1)->nullable();
                $table->integer('asztim')->nullable();
                $table->string('aszpro', 10)->nullable();
                $table->integer('aszprv')->nullable();
                $table->string('aszann', 1)->nullable();
                $table->integer('asz2kd')->nullable();
                $table->integer('asz2ka')->nullable();
                $table->integer('asz2kc')->nullable();
                $table->integer('asz2kp')->nullable();
                $table->integer('asz2kz')->nullable();
                $table->decimal('aszeup', 11, 3)->nullable();
                $table->integer('asztin')->nullable();
                $table->integer('asz001')->nullable();
                $table->string('asz002', 1)->nullable();
                $table->string('asz003', 15)->nullable();
                $table->integer('asz004')->nullable();
                $table->integer('asz005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('asz00k10');
    }
}
