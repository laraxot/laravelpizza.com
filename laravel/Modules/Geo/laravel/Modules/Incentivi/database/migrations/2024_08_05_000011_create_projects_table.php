<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Incentivi\Models\Project;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Project::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->text('nome');
                $table->text('tipo');
                $table->text('stato');
                $table->date('data_aggiudicazione');
                $table->date('data_inizio_esecuzione');
                $table->date('data_fine_esecuzione');
                $table->string('ente_finanziatore');
                $table->text('oggetto');
                $table->string('determina');
                $table->decimal('percentuale_fondo');
                $table->decimal('importo_totale', 10, 3);
                $table->decimal('importo_effettivo_fondo', 10, 3);
                $table->decimal('componente_incentivante', 10, 3);
                $table->decimal('componente_innovazione', 10, 3);
                $table->string('settore');
            });

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if ($this->hasColumn('settore')) {
                    $table->string('settore')->nullable()->change();
                }

                if ($this->hasColumn('workgroup_id')) {
                    // $table->dropColumn('workgroup_id');
                }

                if ($this->hasColumn('settore')) {
                    $table->dropColumn('settore');
                }

                $table->decimal('importo_totale', 10, 3)->change();
                $table->decimal('importo_effettivo_fondo', 10, 3)->change();
                $table->decimal('componente_incentivante', 10, 3)->change();
                $table->decimal('componente_innovazione', 10, 3)->change();

                if (! $this->hasColumn('rup')) {
                    $table->string('rup');
                }
                if (! $this->hasColumn('dec')) {
                    $table->string('dec');
                }
                if (! $this->hasColumn('ditta_nome')) {
                    $table->string('ditta_nome');
                }
                if (! $this->hasColumn('ditta_sede')) {
                    $table->string('ditta_sede');
                }
                if (! $this->hasColumn('ditta_partitaiva')) {
                    $table->string('ditta_partitaiva');
                }
                if (! $this->hasColumn('ditta_oneri_sicurezza')) {
                    $table->decimal('ditta_oneri_sicurezza');
                }
                if (! $this->hasColumn('ditta_trattativa')) {
                    $table->string('ditta_trattativa');
                }

                if (! $this->hasColumn('department_id')) {
                    $table->foreign('department_id')->references('id')->on('departments');
                }

                $this->updateTimestamps($table);
            }
        );
    }
};
