<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateRubricaTable.
 */
class CreateRubricaTable extends XotBaseMigration
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
                $table->text('nome')->nullable();
                $table->text('cognome')->nullable();
                $table->text('secondo_nome')->nullable();
                $table->text('nome_e_cognome')->nullable();
                $table->text('alternativo')->nullable();
                $table->text('posta_elettronica')->nullable();
                $table->text('via_ab')->nullable();
                $table->text('citta_ab')->nullable();
                $table->text('cap_ab')->nullable();
                $table->text('provincia_ab')->nullable();
                $table->text('paese_ab')->nullable();
                $table->text('telefono_ab')->nullable();
                $table->text('fax_ab')->nullable();
                $table->text('cellulare')->nullable();
                $table->text('pagina_web_personale')->nullable();
                $table->text('via_uff')->nullable();
                $table->text('citta_uff')->nullable();
                $table->text('cap_uff')->nullable();
                $table->text('provincia_uff')->nullable();
                $table->text('paese_uff')->nullable();
                $table->text('pagina_web_professionale')->nullable();
                $table->text('telefono_uff')->nullable();
                $table->text('fax_uff')->nullable();
                $table->text('cercapersone')->nullable();
                $table->text('societa')->nullable();
                $table->text('posizione')->nullable();
                $table->text('reparto')->nullable();
                $table->text('ufficio')->nullable();
                $table->text('note')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('rubrica');
    }
}
