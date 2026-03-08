<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    public function up(): void
    {
        // @var mixed tableCreate(function (Blueprint $blueprint
            $blueprint->increments('id');
            $blueprint->string('name')->index();
            $blueprint->text('description')->nullable();
            $blueprint->timestamps();
        });
    }
};
