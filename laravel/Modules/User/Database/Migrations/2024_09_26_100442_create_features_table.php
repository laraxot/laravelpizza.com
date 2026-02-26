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
        if (! $this->tableExists()) {
            $this->tableCreate(static function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->string('scope');
                $table->text('value');
                $table->unique(['name', 'scope']);
                $table->timestamps(); // Add timestamps here
                $table->softDeletes(); // Add soft deletes here, as hasSoftDeletes was true
            });
        }
    }
};
