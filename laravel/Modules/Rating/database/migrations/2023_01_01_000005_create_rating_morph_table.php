<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Rating\Models\Rating;
// ----- models -----

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
        // ----- create -----
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->id();
                $table->foreignIdFor(Rating::class, 'rating_id')->nullable();
                $table->nullableMorphs('model');
                $table->foreignIdFor(XotData::make()->getUserClass(), 'user_id')->nullable();
                $table->decimal('value', 10, 3)->nullable();
                $table->text('note')->nullable();
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

                if (! $this->hasColumn('note')) {
                    $table->text('note')->nullable();
                }

                if (! $this->hasColumn('is_winner')) {
                    $table->boolean('is_winner')->default(0);
                }

                if (! $this->hasColumn('reward')) {
                    $table->decimal('reward', 10, 3)->default(0);
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
