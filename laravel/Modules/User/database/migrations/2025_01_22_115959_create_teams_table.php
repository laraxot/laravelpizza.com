<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Team;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Team::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            // No ->after('id') here: valid only on ALTER (see tableUpdate() below
            // for the equivalent add-if-missing branch on existing tables) —
            // MySQL rejects AFTER inside CREATE TABLE, column order is already
            // fixed by declaration order.
            $table->uuid('owner_id')->nullable()->index();
            $table->uuid('uuid')->nullable()->index();
            $table->string('user_id', 36)->nullable()->index();
            $table->string('name');
            $table->boolean('personal_team')->default(false);
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if ($this->hasColumn('uuid')) {
                $table->uuid('uuid')->nullable()->change();
            }

            if ($this->hasColumn('personal_team')) {
                $table->boolean('personal_team')->default(false)->change();
            }

            if (! $this->hasColumn('code')) {
                $table->string('code', 36)->nullable()->index();
            }

            if (! $this->hasColumn('owner_id')) {
                $table->uuid('owner_id')->nullable()->index()->after('id');
            }

            $this->updateTimestamps($table, true);
        });
    }
};
