<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Extra;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class CreateExtraTable.
 */
return new class extends XotBaseMigration {
    protected ?string $model_class = Extra::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
<<<<<<< HEAD
        $this->tableCreate(static function (Blueprint $table): void {
=======
        $this->tableCreate(static function (Blueprint $table) {
>>>>>>> 74e589dbb (.)
            $table->increments('id');
            $table->uuidMorphs('model');
            $table->schemalessAttributes('extra_attributes');
        });

        // -- UPDATE --
<<<<<<< HEAD
        $this->tableUpdate(function (Blueprint $table): void {
=======
        $this->tableUpdate(function (Blueprint $table) {
>>>>>>> 74e589dbb (.)
            // if (! $this->hasColumn('name'))
            //    $table->string('name')->nullable();
            // }
            $this->updateTimestamps(table: $table, hasSoftDeletes: true);

<<<<<<< HEAD
            if ($this->hasColumn('model_id')) {
=======
            if ($hasColumn('model_id')) {
>>>>>>> 74e589dbb (.)
                $table->string('model_id', 36)->index()->change();
            }
        });
    }

    // end up
    // end down
};
