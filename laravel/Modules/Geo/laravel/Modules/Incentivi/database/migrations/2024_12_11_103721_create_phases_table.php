<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Incentivi\Models\Phase;
use Modules\Incentivi\Models\Project;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Phase::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->string('description')->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->foreignIdFor(Project::class, 'project_id')->nullable()->constrained('projects')->nullOnDelete();
            });

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // if (! $this->hasColumn('project_id')) {
                //     $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
                // }
                $this->updateTimestamps($table);
            }
        );
    }
};
