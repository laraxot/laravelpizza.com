<?php

declare(strict_types=1);

use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class CreateCmsPagesTable.
 */
return new class extends XotBaseMigration {
    /**
     * db up.
     */
    public function up(): void
    {
        // -- CREATE --
        // @var mixed tableCreate(static function (Blueprint $table
            $table->id();

            $table->string('slug')->unique()->index();
            $table->string('name');
            $table->json('blocks')->nullable();

            // $table->json('blocks')->default(new Expression('(JSON_ARRAY())'));
        });
        // -- UPDATE --
        // @var mixed tableUpdate(function (Blueprint $table
            // @var mixed updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
