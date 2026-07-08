<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\IndennitaResponsabilita\Models\RatingMorph;
use Modules\User\Models\User;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateRatingMorphTable extends XotBaseMigration
{
    protected ?string $model_class = RatingMorph::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->foreignIdFor(Rating::class, 'rating_id')->nullable();
                $table->nullableMorphs('model');
                $table->foreignIdFor(User::class, 'user_id')->nullable();
                $table->integer('value')->nullable();
                $table->text('note')->nullable();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('model_id')) {
                    $table->nullableMorphs('model');
                }
                if (! $this->hasColumn('rating_id')) {
                    $table->foreignIdFor(Rating::class, 'rating_id')->nullable();
                }
            }
        );
    }
}
