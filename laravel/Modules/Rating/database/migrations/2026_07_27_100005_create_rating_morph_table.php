<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Rating\Models\Rating;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Datas\XotData;

/*
 * Class CreateRatingMorphTable.
 */
return new class extends XotBaseMigration
{
    /**
     * db up.
     */
    public function up(): void
    {
        $userClass = XotData::make()->getUserClass();

        $this->tableCreate(
            static function (Blueprint $table) use ($userClass): void {
                $table->id();
                $table->foreignIdFor(Rating::class, 'rating_id')->nullable();
                $table->nullableMorphs('model');
                $table->foreignIdFor($userClass, 'user_id')->nullable()->index();
                $table->decimal('value', 10, 3)->nullable();
                $table->decimal('percentage', 10, 3)->nullable();
                $table->text('note')->nullable();
            }
        );

        $this->tableUpdate(
            function (Blueprint $table) use ($userClass): void {
                if (! $this->hasColumn('model_id')) {
                    $table->nullableMorphs('model');
                }

                if (! $this->hasColumn('rating_id')) {
                    $table->foreignIdFor(Rating::class, 'rating_id')->nullable();
                }

                if (! $this->hasColumn('user_id')) {
                    $table->foreignIdFor($userClass, 'user_id')->nullable()->index();
                }

                if (! $this->hasColumn('note')) {
                    $table->text('note')->nullable();
                }

                if (! $this->hasColumn('is_winner')) {
                    $table->boolean('is_winner')->default(0);
                }

                if (! $this->hasColumn('reward')) {
                    $table->decimal('reward', 10, 3)->default(0);
                }

                if (! $this->hasColumn('percentage')) {
                    $table->decimal('percentage', 10, 3)->nullable();
                }

                if ($this->hasColumn('value')) {
                    $table->decimal('value', 10, 3)->nullable()->change();
                } else {
                    $table->decimal('value', 10, 3)->nullable();
                }

                $this->updateTimestamps(table: $table, hasSoftDeletes: true);
            }
        );
    }
};
