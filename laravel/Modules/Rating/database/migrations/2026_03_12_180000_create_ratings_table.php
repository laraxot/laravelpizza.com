<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
// ----- models -----
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class CreateRatingsTable.
 */
return new class extends XotBaseMigration
{
    /**
     * db up.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->id();
                $table->string('title')->nullable();
                $table->string('slug')->nullable();
                $table->string('color')->nullable();
                $table->string('icon')->nullable();
                $table->string('rule')->nullable();
                $table->text('txt')->nullable();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('title')) {
                    $table->string('title')->nullable();
                }
                if (! $this->hasColumn('slug')) {
                    $table->string('slug')->nullable();
                }
                if (! $this->hasColumn('color')) {
                    $table->string('color')->nullable();
                }
                if (! $this->hasColumn('icon')) {
                    $table->string('icon')->nullable();
                }
                if (! $this->hasColumn('rule')) {
                    $table->string('rule')->nullable();
                }
                if (! $this->hasColumn('txt')) {
                    $table->string('txt')->nullable();
                }
                // @see Modules/Rating/docs/schemaless-attributes-errors.md
                if (! $this->hasColumn('extra_attributes')) {
                    $table->schemalessAttributes('extra_attributes');
                }
                if (! $this->hasColumn('is_disabled')) {
                    $table->boolean('is_disabled')->nullable();
                }
                if (! $this->hasColumn('is_readonly')) {
                    $table->boolean('is_readonly')->nullable();
                }
                if (! $this->hasColumn('order_column')) {
                    $table->unsignedInteger('order_column')->nullable()->index();
                }
                $this->updateTimestamps(table: $table, hasSoftDeletes: false);
            }
        );
    }
};
