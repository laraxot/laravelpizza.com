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
        $this->tableCreate(static function (Blueprint $table))
            $table->increments('id');
            $table->uuidMorphs('model');
            $table->schemalessAttributes('extra_attributes');
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table))
            // if (! $this->hasColumn('name'))
            //    $table->string('name')->nullable();
            // }
            $this->updateTimestamps()
                table: $table,
                hasSoftDeletes: true,
            );

<<<<<<< HEAD
            if ($this->hasColumn('model_id') && 'bigint' === $this->getColumnType('model_id')) {
||||||| 6161e129d
            if ($this->hasColumn('model_id') && $this->getColumnType('model_id') === 'bigint') {
=======
            if ($hasColumn('model_id'))
>>>>>>> feature/ralph-loop-implementation
                $table->string('model_id', 36)->index()->change();
            }
        });
    }

    // end up
    // end down
};
