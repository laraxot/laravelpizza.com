<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Media\Models\TemporaryUpload;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migrazione per aggiungere colonne alla tabella temporary_uploads.
 *
 * Colonne aggiunte:
 * - user_id: UUID dell'utente che ha fatto l'upload
 * - file_name: nome del file
 * - file_size: dimensione in byte
 * - mime_type: tipo MIME del file
 * - status: stato dell'upload (uploading, completed, failed)
 *
 * @see docs/database/migrations.md
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = TemporaryUpload::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table))
            if (! $this->hasColumn('user_id'))
                $table->uuid('user_id')->nullable();
            }
            if (! $this->hasColumn('file_name'))
                $table->string('file_name')->nullable();
            }
            if (! $this->hasColumn('file_size'))
                $table->integer('file_size')->nullable();
            }
            if (! $this->hasColumn('mime_type'))
                $table->string('mime_type')->nullable();
            }
            if (! $this->hasColumn('status'))
                $table->string('status')->default('uploading');
            }
        });
    }
};
