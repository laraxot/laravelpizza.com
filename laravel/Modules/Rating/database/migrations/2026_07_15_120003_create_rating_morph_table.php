<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Rating\Models\Rating;
use Modules\Rating\Models\RatingMorph;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = RatingMorph::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Rating::class, 'rating_id')->nullable();
            $table->nullableMorphs('model');
            $table->nullableUuidMorphs('user');
            $table->decimal('value', 10, 3)->nullable();
            $table->decimal('percentage', 10, 3)->nullable()->comment('Percentuale calcolata per il rating');
            $table->text('note')->nullable();
            $table->boolean('is_winner')->default(0);
            $table->decimal('reward', 10, 3)->default(0);
        });

        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('percentage')) {
                $table->decimal('percentage', 10, 3)
                    ->nullable()
                    ->comment('Percentuale calcolata per il rating');
            }

            $this->updateTimestamps($table, true);
        });
    }
};
