<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
use Modules\UI\Models\Collection;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Collection::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->string('name')->nullable();
                $table->text('description')->nullable();
                $table->string('type')->nullable();
                $table->unsignedBigInteger('theme_id')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('order')->default(0);
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->softDeletes('deleted_at');
                $table->string('deleted_by')->nullable();
                $table->timestamps();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('type')) {
                    $table->string('type')->nullable();
                }
                if (! $this->hasColumn('theme_id')) {
                    $table->unsignedBigInteger('theme_id')->nullable();
                }
            }
        );
    }
};
