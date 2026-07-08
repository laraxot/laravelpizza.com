<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateJprog01lTable.
 */
class CreateJprog01lTable extends XotBaseMigration
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
                $table->text('flanac')->nullable();
                $table->text('cdpgac')->nullable();
                $table->text('dspgac')->nullable();
                $table->text('flctac')->nullable();
                $table->text('flrvac')->nullable();
                $table->text('flpcac')->nullable();
                $table->text('flauac')->nullable();
                $table->text('fljhac')->nullable();
                $table->text('flcfac')->nullable();
                $table->text('nmpgac')->nullable();
                $table->text('tppgac')->nullable();
                $table->text('pfjbac')->nullable();
                $table->text('nmjqac')->nullable();
                $table->text('nmljac')->nullable();
                $table->text('nmoqac')->nullable();
                $table->text('nmlqac')->nullable();
                $table->text('pyjqac')->nullable();
                $table->text('grpgac')->nullable();
                $table->text('nmlhac')->nullable();
                $table->text('nmfhac')->nullable();
                $table->text('nmmhac')->nullable();
                $table->text('tpohac')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('jprog01l');
    }
}
