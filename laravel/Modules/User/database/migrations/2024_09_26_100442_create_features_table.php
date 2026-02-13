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
        if (!$this->tableExists()) {
            $this->tableCreate(static function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->string('scope');
                $table->text('value');

                $table->unique(['name', 'scope']);
            });
        }

        if ($this->tableExists() && !$this->hasColumn('created_at')) {
            $this->tableUpdate(function (Blueprint $table): void {
                $this->updateTimestamps(
                    table: $table,
                    hasSoftDeletes: true,
                );
            });
        }
    }
};
