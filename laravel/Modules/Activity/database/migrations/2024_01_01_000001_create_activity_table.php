<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Activity\Models\Activity;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Activity::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table))
            $table->bigIncrements('id');
            $table->string('log_name')->nullable();
            $table->text('description');
            $table->nullableMorphs('subject', 'subject');
            $table->nullableMorphs('causer', 'causer');
            $table->json('properties')->nullable();
            $table->index('log_name');
            $table->uuid('batch_uuid')->nullable();
            $table->string('event')->nullable();
        });
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table))
            // Ensure causer columns are nullable to allow console operations without an authenticated user
            if ($hasColumn('causer_id'))
                $table->string('causer_id', 36)->change()->nullable()->change();
            }
            if ($hasColumn('causer_type'))
                $table->string('causer_type')->nullable()->change();
            }
            $this->updateTimestamps($table, true);
        });
    }
};
