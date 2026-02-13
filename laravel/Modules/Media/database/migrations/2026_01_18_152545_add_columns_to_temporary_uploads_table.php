<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('temporary_uploads', function (Blueprint $table) {
            if (! Schema::hasColumn('temporary_uploads', 'user_id')) {
                $table->uuid('user_id')->nullable();
            }
            if (! Schema::hasColumn('temporary_uploads', 'file_name')) {
                $table->string('file_name')->nullable();
            }
            if (! Schema::hasColumn('temporary_uploads', 'file_size')) {
                $table->integer('file_size')->nullable();
            }
            if (! Schema::hasColumn('temporary_uploads', 'mime_type')) {
                $table->string('mime_type')->nullable();
            }
            if (! Schema::hasColumn('temporary_uploads', 'status')) {
                $table->string('status')->default('uploading');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temporary_uploads', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('temporary_uploads', 'user_id')) {
                $columnsToDrop[] = 'user_id';
            }
            if (Schema::hasColumn('temporary_uploads', 'file_name')) {
                $columnsToDrop[] = 'file_name';
            }
            if (Schema::hasColumn('temporary_uploads', 'file_size')) {
                $columnsToDrop[] = 'file_size';
            }
            if (Schema::hasColumn('temporary_uploads', 'mime_type')) {
                $columnsToDrop[] = 'mime_type';
            }
            if (Schema::hasColumn('temporary_uploads', 'status')) {
                $columnsToDrop[] = 'status';
            }

            if (! empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
