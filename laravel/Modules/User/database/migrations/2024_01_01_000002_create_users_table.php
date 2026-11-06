<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\User\Models\User;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class CreateLiveuserUsersTable.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = User::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            // $table->uuid('id')->primary();
            $table->string('id', 36)->primary();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(); // se entra con sso
            $table->softDeletes();
        });
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('first_name')) {
                $table->string('first_name')->after('name')->nullable();
            } else {
                $table->string('first_name')->nullable()->change();
            }

            if (! $this->hasColumn('last_name')) {
                $table->string('last_name')->after('name')->nullable();
            } else {
                $table->string('last_name')->nullable()->change();
            }

            if ($this->hasColumn('password')) {
                $table->string('password')->nullable()->change();
            }

            if ($this->getColumnType('id') === 'uuid') {
                Schema::disableForeignKeyConstraints();

                $table->dropPrimary(['id']);
                $table->string('id', 36)->nullable()->change();
                $table->primary('id');

                Schema::enableForeignKeyConstraints();
            }
            // $this->updateUser($table);
            $this->updateTimestamps($table, true);
        });
    }
};
