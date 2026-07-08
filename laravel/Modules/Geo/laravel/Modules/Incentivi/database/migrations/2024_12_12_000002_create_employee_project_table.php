<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Incentivi\Models\EmployeeProject;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = EmployeeProject::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
                $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
                $table->unique(['employee_id', 'project_id']);
            });

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // $table->dropForeign(['employee_id']);
                // $table->dropForeign('employee_project_employee_id_foreign');

                // if (! $this->hasColumn('percentuale_attivita_dipendente')) {
                //     $table->integer('percentuale_attivita_dipendente');
                // }
                // if (! $this->hasColumn('importo_attivita_dipendente')) {
                //     $table->decimal('importo_attivita_dipendente');
                // }
                // if ($this->hasColumn('importo_dipendente_attivita')) {
                //     $table->dropColumn('importo_dipendente_attivita');
                // }
                $this->updateTimestamps($table);
            }
        );
    }
};
