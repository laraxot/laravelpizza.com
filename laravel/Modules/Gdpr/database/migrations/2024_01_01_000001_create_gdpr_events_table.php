<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Gdpr\Models\Event;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = Event::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --

        // @var mixed tableCreate(function (Blueprint $table
            $table->uuid('id')->primary();
            $table->uuid('treatment_id')->nullable();
            $table->uuid('consent_id')->nullable();
            $table->string('subject_id');
            $table->string('ip');
            $table->string('action');
            $table->text('payload');

            // $table->foreignId('treatment_id')->nullable();
            /*
             * $table
             * ->foreign('treatment_id')
             * ->references('id')
             * ->on('gdpr_treatment');
             */
            // $table->foreignId('consent_id')->nullable();
            /*
             * $table
             * ->foreign('consent_id')
             * ->references('id')
             * ->on('gdpr_consent')
             * ->onDelete('set null');
             */
        });

        // -- UPDATE --
        // @var mixed tableUpdate(function (Blueprint $table
            // if (! // @var mixed hasColumn('email'
            //    $table->string('email')->nullable();
            // }
            // @var mixed updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
