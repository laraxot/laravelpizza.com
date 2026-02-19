<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Gdpr\Models\Consent;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = Consent::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --

        $this->tableCreate(
            function (Blueprint $table): void {
                $table->uuid('id')->primary();
                $table->uuid('treatment_id');
                // $table->foreignId('treatment_id')->nullable()->index();
                $table->string('subject_id');

                // $table->unique(['subject_id', 'treatment_id']);

                // $table->foreign('treatment_id')->references('id')->on('gdpr_treatment');
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('user_id')) {
                    $table->morphs('user');
                }
                if (! $this->hasColumn('type')) {
                    $table->string('type')->nullable();
                }

                if (! $this->hasColumn('accepted_at')) {
                    $table->timestamp('accepted_at')->nullable();
                }
                if (! $this->hasColumn('ip_address')) {
                    $table->string('ip_address', 45)->nullable();
                }
                if (! $this->hasColumn('user_agent')) {
                    $table->string('user_agent')->nullable();
                }
                // -- Change --
                if ($this->hasColumn('user_id')) {
                    $table->string('user_id')->nullable()->change();
                }
                $table->uuid('treatment_id')->nullable()->change();
                $table->string('subject_id')->nullable()->change();

                $this->updateTimestamps(table: $table, hasSoftDeletes: true);
            }
        );
    }
};
