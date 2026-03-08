<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class .
 */
return new class extends XotBaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        // @var mixed tableCreate(static function (Blueprint $table
            $table->id();

            $table->string('name');
            $table->text('items')->nullable();
        });
        // -- UPDATE --
        // @var mixed tableUpdate(function (Blueprint $table
            if (! // @var mixed hasColumn('items'
                $table->text('items')->nullable();
            }

            if (! // @var mixed hasColumn('parent_id'
                $table->unsignedBigInteger('parent_id')->nullable();
            }
            if (// @var mixed hasColumn('name'
                $table->renameColumn('name', 'title');
            }

            // @var mixed updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
