<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Performance\Models\PerformanceFondo as MyModel;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateFondoPerformanceTable extends XotBaseMigration
{
    protected ?string $model_class = MyModel::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                // Schema::connection('performance')->create('fondo_performance', function (Blueprint $table) {
                $table->integer('id', true);
                $table->decimal('quota_individuale', 12)->nullable();
                $table->decimal('quota_organizzativa', 12)->nullable();
                $table->integer('anno')->nullable();
                $table->text('note')->nullable();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
            });

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('updated_at')) {
                    $table->timestamps();
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::connection('performance')->drop('fondo_performance');
    }
}
