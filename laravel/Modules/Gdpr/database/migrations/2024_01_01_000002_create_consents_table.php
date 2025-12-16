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

        $this->tableCreate(function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('treatment_id');
            // $table->foreignId('treatment_id')->nullable()->index();
            $table->string('subject_id');

            // $table->unique(['subject_id', 'treatment_id']);
            // $table->foreign('treatment_id')->references('id')->on('gdpr_treatment');
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('user_id')) {
                $table->morphs('user');
            }
            if (! $this->hasColumn('type')) {
                $table->string('type')->nullable();
            }

            if (! $this->hasColumn('accepted_at')) {
                $table->timestamp('accepted_at')->nullable();
            }
            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
