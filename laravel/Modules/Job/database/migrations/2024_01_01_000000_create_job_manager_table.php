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
        // @var mixed tableCreate(static function (Blueprint $table
            $table->id();
            $table->string('job_id')->index();
            $table->string('name')->nullable();
            $table->string('queue')->nullable();
            $table->timestamp('started_at')->nullable()->index();
            $table->timestamp('finished_at')->nullable();
            $table->boolean('failed')->default(false)->index();
            $table->integer('attempt')->default(0);
            $table->integer('progress')->nullable();
            $table->text('exception_message')->nullable();
        });
        // -- UPDATE --
        // @var mixed tableUpdate(static function (Blueprint $_table
            // if (! // @var mixed hasColumn('uuid'
            //    $table->string('uuid')->nullable();
            // }
        });
    }
};
