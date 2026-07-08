<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\Phase;
use Modules\Incentivi\Models\Project;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Activity::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->string('nome');
                $table->string('tipo');
                $table->integer('quota_percentuale');
                $table->decimal('importo', 10, 3)->default(null)->nullable();
                $table->string('anno_competenza');
                $table->foreignIdFor(Project::class)->nullable()->constrained('projects')->onDelete('cascade');
                $table->foreignIdFor(Phase::class, 'phase_id')->nullable();
                $table->timestamps();
            });

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                /*Column already exists: 1060 Duplicate column name 'project_id'
                if ($this->hasColumn('project_id')) {
                    $table->foreignIdFor(Project::class, 'project_id')
                        ->nullable()
                        ->constrained('projects')
                        ->onDelete('cascade')
                        ->change();
                }
                */
                $this->updateTimestamps($table);
            }
        );
    }
};
