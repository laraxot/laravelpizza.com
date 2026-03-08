<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected $connection = 'gdpr';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --

        // @var mixed tableCreate(function (Blueprint $table
            $table->uuid('id')->primary();
            $table->uuid('treatment_id');
            // $table->foreignId('treatment_id')->nullable()->index();
            $table->string('subject_id');

            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            // $table->unique(['subject_id', 'treatment_id']);
            // $table->foreign('treatment_id')->references('id')->on('gdpr_treatment');
        });

        // -- UPDATE --
        // @var mixed tableUpdate(function (Blueprint $table
            if (! // @var mixed hasColumn('ip_address'
                $table->string('ip_address', 45)->nullable();
            }
            if (! // @var mixed hasColumn('user_agent'
                $table->string('user_agent')->nullable();
            }
            // @var mixed updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
