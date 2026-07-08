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
        // Ensure causer_id is a UUID-compatible string(36) column so that
        // models with UUID primary keys (Modules\User) can act as causers.
        $this->tableUpdate(function (Blueprint $table): void {
            if ($this->hasColumn('causer_id')) {
                $table->string('causer_id', 36)->nullable()->change();
            }
            if ($this->hasColumn('causer_type')) {
                $table->string('causer_type')->nullable()->change();
            }
        });
    }
};
