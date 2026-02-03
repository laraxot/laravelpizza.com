<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Profile;
use Modules\Xot\Database\Migrations\XotBaseMigration;

use function Safe\file_put_contents;

return new class extends XotBaseMigration {
    protected ?string $model_class = Profile::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $conn = $this->model->getConnectionName();
        $db = $this->getConn()->getConnection()->getDatabaseName();
        $exists = $this->tableExists();
        file_put_contents(base_path('migration_debug.log'), "MIGRATING profiles | CONN: $conn | DB: $db | EXISTS: ".($exists ? 'YES' : 'NO')."\n", FILE_APPEND);

        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('user_id', 36)->index()->nullable();
            $table->string('type')->index()->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender', 1)->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('timezone')->nullable();
            $table->string('locale')->nullable();
            $table->json('preferences')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('extra')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('user_id')) {
                $table->string('user_id', 36)->index()->nullable()->after('id');
            }
            if (! $this->hasColumn('email')) {
                $table->string('email')->nullable()->after('last_name');
            }
            if (! $this->hasColumn('phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (! $this->hasColumn('avatar')) {
                $table->string('avatar')->nullable();
            }
            if (! $this->hasColumn('timezone')) {
                $table->string('timezone')->nullable();
            }
            if (! $this->hasColumn('locale')) {
                $table->string('locale')->nullable();
            }
            if (! $this->hasColumn('preferences')) {
                $table->json('preferences')->nullable();
            }
            if (! $this->hasColumn('status')) {
                $table->string('status')->nullable();
            }
        });
    }
};
