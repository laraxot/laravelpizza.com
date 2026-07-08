<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Rating::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->string('title')->nullable();
                $table->string('color')->nullable();
                $table->string('icon')->nullable();
                $table->string('rule')->nullable();
                $table->text('txt')->nullable();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('extra_attributes')) {
                    $table->schemalessAttributes('extra_attributes');
                }
                if (! $this->hasColumn('rule')) { // form validation
                    $table->string('rule')->nullable();
                }
                if (! $this->hasColumn('is_disabled')) {
                    $table->boolean('is_disabled')->nullable();
                }
                if (! $this->hasColumn('is_readonly')) {
                    $table->boolean('is_readonly')->nullable();
                }
                if (! $this->hasColumn('slug')) {
                    $table->string('slug')->nullable()->index();
                }
                if (! $this->hasColumn('order_column')) {
                    $table->unsignedInteger('order_column')->nullable()->index();
                }
            }
        );
    }
};
