<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
use Modules\UI\Models\Category;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Category::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->string('name')->nullable();
                $table->string('title');
                $table->string('slug');
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->text('description')->nullable();
                $table->string('icon')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
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
                if (! $this->hasColumn('slug')) {
                    $table->string('slug')->nullable()->index();
                }
            }
        );
    }
};
