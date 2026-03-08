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
            $table->timestamp('completed_at')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('importer');
            $table->unsignedInteger('processed_rows')->default(0);
            $table->unsignedInteger('total_rows');
            $table->unsignedInteger('successful_rows')->default(0);
            // $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // $table->string('user_id',36)->nullable()->index();
            $table->nullableUuidMorphs('user');
        });
        // -- UPDATE --
        // @var mixed tableUpdate(function (Blueprint $table
            if (! // @var mixed hasColumn('user_type'
                $table->string('user_type', 36)->nullable()->index();
            }

            // @var mixed updateTimestamps($table, true;
        });
    }
};
