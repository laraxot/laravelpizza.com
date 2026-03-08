<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Lang\Models\Translation;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = Translation::class;

    public function up(): void
    {
        // -- CREATE --
        // @var mixed tableCreate(function (Blueprint $table
            $table->id();
            $table->string('lang')->nullable()->index();
            $table->text('value')->nullable();
            $table->string('namespace')->nullable()->index();
            $table->string('group')->nullable()->index();
            $table->string('item')->nullable();
            $table->string('key')->nullable()->index();
            $table->string('locale')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
        });

        // -- UPDATE --
        // @var mixed tableUpdate(function (Blueprint $table
            // @var mixed updateTimestamps($table, false;
        });
    }
};
