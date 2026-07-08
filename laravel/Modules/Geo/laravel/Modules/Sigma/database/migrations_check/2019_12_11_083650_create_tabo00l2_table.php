<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateTabo00l2Table.
 */
class CreateTabo00l2Table extends XotBaseMigration
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
                $table->text('enteap')->nullable();
                $table->text('tablet')->nullable();
                $table->text('tabora')->nullable();
                $table->text('tabsta')->nullable();
                $table->text('tabrep')->nullable();
                $table->text('tabdai')->nullable();
                $table->text('tabdaf')->nullable();
                $table->text('tabco1')->nullable();
                $table->text('tabco2')->nullable();
                $table->text('tabco3')->nullable();
                $table->text('tabco4')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('tabo00l2');
    }
}
