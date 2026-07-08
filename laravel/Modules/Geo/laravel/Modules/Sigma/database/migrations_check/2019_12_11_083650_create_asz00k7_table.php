<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAsz00k7Table.
 */
class CreateAsz00k7Table extends XotBaseMigration
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
                $table->text('cont')->nullable();
                $table->text('matr')->nullable();
                $table->text('asztip')->nullable();
                $table->text('aszcod')->nullable();
                $table->text('aszdal')->nullable();
                $table->text('aszal')->nullable();
                $table->text('aszini')->nullable();
                $table->text('aszfin')->nullable();
                $table->text('aszcom')->nullable();
                $table->text('asztpr')->nullable();
                $table->text('aszdpr')->nullable();
                $table->text('asznpr')->nullable();
                $table->text('aszumi')->nullable();
                $table->text('aszpes')->nullable();
                $table->text('aszdur')->nullable();
                $table->text('asz01')->nullable();
                $table->text('asz02')->nullable();
                $table->text('asz03')->nullable();
                $table->text('asz04')->nullable();
                $table->text('asz05')->nullable();
                $table->text('aszcm')->nullable();
                $table->text('aszcms')->nullable();
                $table->text('asztim')->nullable();
                $table->text('aszpro')->nullable();
                $table->text('aszprv')->nullable();
                $table->text('aszann')->nullable();
                $table->text('asz2kd')->nullable();
                $table->text('asz2ka')->nullable();
                $table->text('asz2kc')->nullable();
                $table->text('asz2kp')->nullable();
                $table->text('asz2kz')->nullable();
                $table->text('aszeup')->nullable();
                $table->text('asztin')->nullable();
                $table->text('asz001')->nullable();
                $table->text('asz002')->nullable();
                $table->text('asz003')->nullable();
                $table->text('asz004')->nullable();
                $table->text('asz005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('asz00k7');
    }
}
