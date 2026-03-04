<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('user')->table('users', function (Blueprint $table): void {
            if (! Schema::connection('user')->hasColumn('users', 'uuid')) {
                $table->uuid('uuid')->nullable()->unique()->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::connection('user')->table('users', function (Blueprint $table): void {
            if (Schema::connection('user')->hasColumn('users', 'uuid')) {
                $table->dropColumn('uuid');
            }
        });
    }
};
