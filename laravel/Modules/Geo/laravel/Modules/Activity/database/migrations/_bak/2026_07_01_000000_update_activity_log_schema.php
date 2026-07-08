<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $connection = $this->resolveConnection();

        Schema::connection($connection)->table('activity_log', function (Blueprint $table) use ($connection): void {
            if (! Schema::connection($connection)->hasColumn('activity_log', 'attribute_changes')) {
                $table->json('attribute_changes')->nullable()->after('properties');
            }

            if (Schema::connection($connection)->hasColumn('activity_log', 'causer_id')) {
                $table->string('causer_id', 36)->nullable()->change();
            }

            if (Schema::connection($connection)->hasColumn('activity_log', 'causer_type')) {
                $table->string('causer_type')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        $connection = $this->resolveConnection();

        Schema::connection($connection)->table('activity_log', function (Blueprint $table) use ($connection): void {
            if (Schema::connection($connection)->hasColumn('activity_log', 'attribute_changes')) {
                $table->dropColumn('attribute_changes');
            }

            if (Schema::connection($connection)->hasColumn('activity_log', 'causer_id')) {
                $table->unsignedBigInteger('causer_id')->nullable()->change();
            }

            if (Schema::connection($connection)->hasColumn('activity_log', 'causer_type')) {
                $table->string('causer_type')->nullable(false)->change();
            }
        });
    }

    private function resolveConnection(): string
    {
        $connection = config('activitylog.database_connection');
        if (is_string($connection) && $connection !== '') {
            return $connection;
        }

        $default = config('database.default');

        return is_string($default) && $default !== '' ? $default : 'mysql';
    }
};
