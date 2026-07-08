<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateEcz00l1Table.
 */
class CreateEcz00l1Table extends XotBaseMigration
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
                $table->text('eczann')->nullable();
                $table->text('ente')->nullable();
                $table->text('matr')->nullable();
                $table->text('ecztip')->nullable();
                $table->text('eczdal')->nullable();
                $table->text('eczal')->nullable();
                $table->text('eczpro')->nullable();
                $table->text('eczrec')->nullable();
                $table->text('eczrx')->nullable();
                $table->text('eczan')->nullable();
                $table->text('ecztor')->nullable();
                $table->text('ecz001')->nullable();
                $table->text('ecz002')->nullable();
                $table->text('ecz003')->nullable();
                $table->text('ecz004')->nullable();
                $table->text('ecz005')->nullable();
                $table->text('ecz011')->nullable();
                $table->text('ecz012')->nullable();
                $table->text('ecz013')->nullable();
                $table->text('ecz014')->nullable();
                $table->text('ecz015')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('ecz00l1');
    }
}
