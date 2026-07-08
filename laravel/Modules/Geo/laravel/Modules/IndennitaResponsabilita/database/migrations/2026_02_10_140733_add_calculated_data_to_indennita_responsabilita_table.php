<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = IndennitaResponsabilita::class;

    public function up(): void
    {
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('extra_attributes')) {
                    // @see https://github.com/spatie/laravel-schemaless-attributes
                    $table->schemalessAttributes('extra_attributes');
                }
                $this->updateTimestamps(table: $table, hasSoftDeletes: false);
            }
        );
    }
};
