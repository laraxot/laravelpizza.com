<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCor02l2Table.
 */
class CreateCor02l2Table extends XotBaseMigration
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
                $table->text('anno')->nullable();
                $table->text('codcor')->nullable();
                $table->text('tipo02')->nullable();
                $table->text('crecm2')->nullable();
                $table->text('repst2')->nullable();
                $table->text('repre2')->nullable();
                $table->text('ceco1')->nullable();
                $table->text('ceco2')->nullable();
                $table->text('ceco3')->nullable();
                $table->text('autmez')->nullable();
                $table->text('antice')->nullable();
                $table->text('valuta')->nullable();
                $table->text('iscent')->nullable();
                $table->text('discee')->nullable();
                $table->text('biscee')->nullable();
                $table->text('cspes1')->nullable();
                $table->text('bspes1')->nullable();
                $table->text('cspes2')->nullable();
                $table->text('bspes2')->nullable();
                $table->text('cspes3')->nullable();
                $table->text('bspes3')->nullable();
                $table->text('cspes4')->nullable();
                $table->text('bspes4')->nullable();
                $table->text('cspes5')->nullable();
                $table->text('bspes5')->nullable();
                $table->text('cspes6')->nullable();
                $table->text('bspes6')->nullable();
                $table->text('impegn')->nullable();
                $table->text('prevdi')->nullable();
                $table->text('spedip')->nullable();
                $table->text('despes')->nullable();
                $table->text('modant')->nullable();
                $table->text('datant')->nullable();
                $table->text('partec')->nullable();
                $table->text('numore')->nullable();
                $table->text('numgio')->nullable();
                $table->text('valpos')->nullable();
                $table->text('punteg')->nullable();
                $table->text('nonpar')->nullable();
                $table->text('inora')->nullable();
                $table->text('fuora')->nullable();
                $table->text('email')->nullable();
                $table->text('sponso')->nullable();
                $table->text('tabaut')->nullable();
                $table->text('dataut')->nullable();
                $table->text('nproto')->nullable();
                $table->text('flaga')->nullable();
                $table->text('flagb')->nullable();
                $table->text('flagc')->nullable();
                $table->text('flagd')->nullable();
                $table->text('flage')->nullable();
                $table->text('flagf')->nullable();
                $table->text('comoa')->nullable();
                $table->text('comob')->nullable();
                $table->text('comoc')->nullable();
                $table->text('comod')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('cor02l2');
    }
}
