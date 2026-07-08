<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
// ----- models -----
use Modules\Performance\Models\Option as MyModel;
// ----- bases ----
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Migrazione per la tabella performance_options.
 * @see docs/valutatore-distribution-implementation.md
 */
return new class extends XotBaseMigration
{
    // use XotBaseMigrationTrait;
    protected ?string $model_class = MyModel::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->nullableMorphs('option');
                $table->text('name')->nullable();
                $table->text('value')->nullable();
            });

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('updated_at')) {
                    $table->timestamps();
                }

                if (! $this->hasColumn('updated_by')) {
                    $table->string('updated_by')->nullable()->after('updated_at');
                    $table->string('created_by')->nullable()->after('created_at');
                }

                if (! $this->hasColumn('year')) {
                    $table->integer('year')->nullable()->after('value');
                }
            }); // end update
    }

    // end function up
};
