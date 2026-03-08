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
        // @var mixed tableCreate(static function (Blueprint $table
            $table->increments('id');
            $table->unsignedInteger('frequency_id');
            $table->string('name');
            $table->string('value');
        });
        // -- UPDATE --
        // @var mixed tableUpdate(function (Blueprint $table
            // @var mixed updateTimestamps($table;
        });
    }
};
