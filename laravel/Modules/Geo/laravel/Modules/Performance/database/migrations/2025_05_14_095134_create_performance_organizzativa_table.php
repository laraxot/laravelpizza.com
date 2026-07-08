<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Performance\Models\Organizzativa as MyModel;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Migrazione aggiornata per la tabella performance_organizzativa.
 * Aggiunta colonne valutatore_id, importo_totale_valutatore_id, resti_pond_valutatore_id se non esistono.
 * Documentazione: Modules/Performance/docs/organizzativa-migration-errors.md
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = MyModel::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->integer('id', true);
                $table->integer('ente')->default(0);
                $table->integer('matr')->nullable();
                $table->string('cognome', 250)->nullable();
                $table->string('nome', 250)->nullable();
                $table->string('email', 250)->nullable();
                $table->integer('stabi')->nullable();
                $table->integer('repar')->nullable();
                $table->integer('stabival')->nullable();
                $table->integer('reparval')->nullable();
                $table->string('stabi_txt', 250)->nullable();
                $table->string('repar_txt', 250)->nullable();
                $table->integer('disci')->nullable();
                $table->string('disci_txt', 100)->nullable();
                $table->integer('rep2kd')->nullable();
                $table->integer('rep2ka')->nullable();
                $table->integer('posiz')->nullable();
                $table->integer('propro')->nullable();
                $table->integer('posfun')->nullable();
                $table->string('categoria_eco', 50)->nullable();
                $table->integer('qua2kd')->nullable();
                $table->integer('qua2ka')->nullable();
                $table->integer('dal')->nullable();
                $table->integer('al')->nullable();
                $table->integer('anno')->nullable();
                $table->integer('giornitempodet')->nullable();
                $table->integer('gg_tempo_determinato')->nullable();
                $table->integer('gg_posiz_1_in_sede')->nullable();
                $table->integer('gg_assenza_anno')->nullable();
                $table->integer('gg_presenza_anno')->nullable();
                $table->integer('gg_ruolo')->nullable();
                $table->date('last_data_assunz')->nullable();
                $table->decimal('ore_assenza_anno', 10)->nullable();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('posiz_txt')->nullable();
                $table->integer('clafun')->nullable();
                $table->integer('disci1')->nullable();
                $table->string('disci1_txt')->nullable();
                $table->integer('gg_assenza_dalal')->nullable();
                $table->decimal('hh_assenza_anno', 10, 3)->nullable();
                $table->decimal('hh_assenza_dalal', 10, 3)->nullable();
                $table->decimal('gg_parttimevert_anno', 10, 3)->nullable();
                $table->decimal('perc_parttimepond_anno', 10, 3)->nullable();
                $table->decimal('perc_parttimepond_dalal', 10, 3)->nullable();
                $table->decimal('gg_parttimevert_dalal', 10, 3)->nullable();
                $table->decimal('gg_presenza_dalal', 10, 3)->nullable();
                $table->decimal('perc_parttime_dalal', 10, 3)->nullable();
                $table->decimal('perc_parttime_anno', 10, 3)->nullable();
            });

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('updated_at')) {
                    $table->timestamps();
                }
                // Aggiunta colonne amministrative se non esistono
                if (! $this->hasColumn('valutatore_id')) {
                    $table->unsignedBigInteger('valutatore_id')->nullable()->index()->after('stabi');
                }
                if (! $this->hasColumn('importo_totale_valutatore_id')) {
                    $table->decimal('importo_totale_valutatore_id', 15, 5)->nullable()->after('valutatore_id');
                }
                if (! $this->hasColumn('resti_pond_valutatore_id')) {
                    $table->decimal('resti_pond_valutatore_id', 15, 5)->nullable()->after('importo_totale_valutatore_id');
                }
            });
    }
};
