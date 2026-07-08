<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateEccez01lTable.
 */
class CreateEccez01lTable extends XotBaseMigration
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
                $table->text('ecannu')->nullable();
                $table->text('enteap')->nullable();
                $table->text('ecmatr')->nullable();
                $table->text('ecgior')->nullable();
                $table->text('ecsogl')->nullable();
                $table->text('ecsogd')->nullable();
                $table->text('ec0001')->nullable();
                $table->text('ec0002')->nullable();
                $table->text('ecmodp')->nullable();
                $table->text('ec0003')->nullable();
                $table->text('ecpers')->nullable();
                $table->text('ec0004')->nullable();
                $table->text('ec0005')->nullable();
                $table->text('ecaste')->nullable();
                $table->text('ecgipe')->nullable();
                $table->text('ec0006')->nullable();
                $table->text('ec0007')->nullable();
                $table->text('ecttur')->nullable();
                $table->text('ecpaui')->nullable();
                $table->text('ecpauf')->nullable();
                $table->text('ecpaum')->nullable();
                $table->text('ecpaus')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('eccez01l');
    }
}
