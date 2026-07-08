<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Incentivi\Models\Settlement;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Settlement::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->string('denominazione');
                $table->string('tipologia');
                $table->timestamps();
            });

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('project_id')) {
                    $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
                }
                if (! $this->hasColumn('model_id')) {
                    $table->nullableMorphs('model');
                }
                if (! $this->hasColumn('importo')) {
                    $table->decimal('importo', 10, 3)->default(0);
                }
                $this->updateTimestamps($table);
            }
        );
    }
};
