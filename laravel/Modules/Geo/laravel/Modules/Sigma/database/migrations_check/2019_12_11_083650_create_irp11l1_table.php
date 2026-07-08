<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateIrp11l1Table.
 */
class CreateIrp11l1Table extends XotBaseMigration
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
                $table->text('impon1')->nullable();
                $table->text('impon2')->nullable();
                $table->text('aliq')->nullable();
                $table->text('aliq2')->nullable();
                $table->text('cumu99')->nullable();
                $table->text('cumu98')->nullable();
                $table->text('cumu96')->nullable();
                $table->text('cumu95')->nullable();
                $table->text('cumu94')->nullable();
                $table->text('cumu93')->nullable();
                $table->text('cumu97')->nullable();
                $table->text('cumpro')->nullable();
                $table->text('cumcon')->nullable();
                $table->text('cumfig')->nullable();
                $table->text('cumalt')->nullable();
                $table->text('cumass')->nullable();
                $table->text('ritadd')->nullable();
                $table->text('imppen')->nullable();
                $table->text('iirapt')->nullable();
                $table->text('iirap1')->nullable();
                $table->text('iirap2')->nullable();
                $table->text('iirap3')->nullable();
                $table->text('assvit')->nullable();
                $table->text('assinf')->nullable();
                $table->text('rasimp')->nullable();
                $table->text('rasrit')->nullable();
                $table->text('rasrim')->nullable();
                $table->text('rirap1')->nullable();
                $table->text('rirap2')->nullable();
                $table->text('rirap3')->nullable();
                $table->text('rirapt')->nullable();
                $table->text('cumuv1')->nullable();
                $table->text('cumuv2')->nullable();
                $table->text('cumuv3')->nullable();
                $table->text('cumuv4')->nullable();
                $table->text('irpann')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('irp11l1');
    }
}
