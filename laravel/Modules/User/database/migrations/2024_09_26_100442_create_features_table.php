<?php

declare(strict_types=1);

/**
 * @see https://laravel.com/docs/11.x/pennant
 */

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableCreate(static function (Blueprint $table))
            $table->id();
            $table->string('name');
            $table->string('scope');
            $table->text('value');
            $table->unique(['name', 'scope']);
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
