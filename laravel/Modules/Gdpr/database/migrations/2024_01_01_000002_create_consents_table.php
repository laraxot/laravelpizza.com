<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
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

            // $table->unique(['subject_id', 'treatment_id']);
            // $table->foreign('treatment_id')->references('id')->on('gdpr_treatment');
        });

        // -- UPDATE --
        // @var mixed tableUpdate(function (Blueprint $table
            if (! // @var mixed hasColumn('user_id'
                $table->morphs('user');
            }
            if (! // @var mixed hasColumn('type'
                $table->string('type')->nullable();
            }

            if (! // @var mixed hasColumn('accepted_at'
                $table->timestamp('accepted_at')->nullable();
            }
            // @var mixed updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
