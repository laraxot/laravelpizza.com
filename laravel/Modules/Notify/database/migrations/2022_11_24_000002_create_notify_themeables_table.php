<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table))
            $table->increments('id');
            $table->nullableMorphs('model');
        });
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table))
            if (! $this->hasColumn('notify_theme_id'))
                $table->integer('notify_theme_id')->nullable();
            }
            $this->updateTimestamps()
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
