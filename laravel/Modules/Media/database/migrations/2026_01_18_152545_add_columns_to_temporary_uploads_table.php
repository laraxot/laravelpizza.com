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
        $this->tableUpdate(function (Blueprint $table) {
            if (! $this->hasColumn('user_id')) {
                $table->uuid('user_id')->nullable();
            }
            if (! $this->hasColumn('file_name')) {
                $table->string('file_name')->nullable();
            }
            if (! $this->hasColumn('file_size')) {
                $table->integer('file_size')->nullable();
            }
            if (! $this->hasColumn('mime_type')) {
                $table->string('mime_type')->nullable();
            }
            if (! $this->hasColumn('status')) {
                $table->string('status')->default('uploading');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->tableUpdate(function (Blueprint $table) {
            $columnsToDrop = [];
            if ($this->hasColumn('user_id')) {
                $columnsToDrop[] = 'user_id';
            }
            if ($this->hasColumn('file_name')) {
                $columnsToDrop[] = 'file_name';
            }
            if ($this->hasColumn('file_size')) {
                $columnsToDrop[] = 'file_size';
            }
            if ($this->hasColumn('mime_type')) {
                $columnsToDrop[] = 'mime_type';
            }
            if ($this->hasColumn('status')) {
                $columnsToDrop[] = 'status';
            }

            if (! empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
