<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Activity\Models\Activity;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Activity::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            // Spatie activitylog may write attribute changes as JSON; add column if missing.
            if (! $this->hasColumn('attribute_changes')) {
                $table->json('attribute_changes')->nullable()->after('properties');
            }
        });
    }
};
