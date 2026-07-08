<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * ...
 */
return new class extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                // ...
            }
        );
        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('perf_ind_media')) {
                    $table->integer('perf_ind_media')->nullable();
                }
                if (! $this->hasColumn('gg_integ_params')) {
                    $table->integer('gg_integ_params')->nullable();
                }
                if (! $this->hasColumn('gg_integ_params_asz')) {
                    $table->decimal('gg_integ_params_asz', 10, 2)->nullable();
                }
                if (! $this->hasColumn('gg_esperienza_no_asz')) {
                    $table->integer('gg_esperienza_no_asz')->nullable();
                }
                if (! $this->hasColumn('type')) {
                    $table->string('type', 50)->nullable();
                }
                $this->updateTimestamps($table);
            }
        );
    }
};
