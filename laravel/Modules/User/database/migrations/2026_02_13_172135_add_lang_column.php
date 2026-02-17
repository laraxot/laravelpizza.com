<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('user')->table('users', function (Blueprint $table): void {
            if (! $this->hasColumn('lang')) {
                $table->string('lang', 5)->default('it')->after('state');
            }
        });
    }

    public function down(): void
    {
        Schema::connection('user')->table('users', function (Blueprint $table): void {
            $table->dropColumn('lang');
        });
    }

    private function hasColumn(string $column): bool
    {
        $connection = Schema::connection('user')->getConnection();
        $result = $connection->select('SHOW COLUMNS FROM users WHERE Field = ?', [$column]);

        return ! empty($result);
    }
};
