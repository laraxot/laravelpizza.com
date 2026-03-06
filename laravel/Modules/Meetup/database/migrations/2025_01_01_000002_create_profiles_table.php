<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\Profile;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Profile::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
                $table->string('id', 36)->primary();
                $table->string('user_id', 36)->index()->nullable();
                $table->string('first_name')->nullable()->index();
                $table->string('last_name')->nullable()->index();
                $table->string('fiscal_code')->nullable()->index();
                $table->string('phone')->nullable();
                $table->string('email')->nullable()->index();
                $table->text('notes')->nullable();

                $this->updateTimestamps(
                    table: $table,
                    hasSoftDeletes: true,
                );
        });

        $this->tableUpdate(function (Blueprint $table): void {
                if (! $this->hasColumn('user_id')) {
                    $table->string('user_id', 36)->index()->nullable()->after('id');
                }
                if (! $this->hasColumn('first_name')) {
                    $table->string('first_name')->nullable()->index()->after('user_id');
                }
                if (! $this->hasColumn('last_name')) {
                    $table->string('last_name')->nullable()->index()->after('first_name');
                }
                if (! $this->hasColumn('fiscal_code')) {
                    $table->string('fiscal_code')->nullable()->index()->after('last_name');
                }
                if (! $this->hasColumn('phone')) {
                    $table->string('phone')->nullable()->after('fiscal_code');
                }
                if (! $this->hasColumn('email')) {
                    $table->string('email')->nullable()->index()->after('phone');
                }
                if (! $this->hasColumn('notes')) {
                    $table->text('notes')->nullable()->after('email');
                }

                $this->updateTimestamps(
                    table: $table,
                    hasSoftDeletes: true,
                );
        });
    }
};
