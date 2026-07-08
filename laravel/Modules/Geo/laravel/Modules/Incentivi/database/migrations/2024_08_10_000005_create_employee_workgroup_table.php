<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\EmployeeWorkgroup;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Workgroup;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = EmployeeWorkgroup::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->foreignIdFor(Employee::class, 'employee_id');
                $table->foreignIdFor(Workgroup::class, 'workgroup_id');
                $table->timestamps();
                $table->unique(['employee_id', 'workgroup_id']);
            });

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // if (! $this->hasColumn('project_id')) {
                //     $table->foreignIdFor(Project::class, 'project_id');
                // }
                // if ($this->hasColumn('project_id')) {
                //     $table->dropColumn('project_id');
                // }
                $this->updateTimestamps($table);
            }
        );
    }
};
