<?php

/**
 * @see https://github.com/spatie/laravel-medialibrary/blob/main/database/migrations/create_media_table.php.stub
 */

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
// ----- models -----
use Modules\Media\Models\Media;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateImagesTable.
 */
return new class extends XotBaseMigration
{
    /**
     * i don't write table name, it take from Model, model is singular of this class wit.
     */
    public function up(): void
    {
        // -- CREATE --
        // @var mixed tableCreate(function (Blueprint $table
            $table->id();
            $table->foreignIdFor(Media::class, 'media_id');
            $table->string('format')->nullable();
            $table->string('codec_video')->nullable();
            $table->string('codec_audio')->nullable();
            $table->string('preset')->nullable();
            $table->string('bitrate')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('threads')->nullable();
            $table->integer('speed')->nullable();
            $table->decimal('percentage', 7, 3)->nullable();
            $table->decimal('remaining', 7, 3)->nullable();
            $table->decimal('rate', 7, 3)->nullable();
            $table->decimal('execution_time', 7, 3)->nullable();
        });
        // -- UPDATE --
        // @var mixed tableUpdate(function (Blueprint $table
            if (! // @var mixed hasColumn('format'
                $table->string('format')->nullable();
            }

            // @var mixed updateTimestamps($table, true;
        });
    }
};
