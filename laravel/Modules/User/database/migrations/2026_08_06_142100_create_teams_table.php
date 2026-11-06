<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Team;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Datas\XotData;

/*
 * Team — unica migrazione owner (1 model = 1 create_*).
 *
 * owner_id → User (senza constrained cross-DB).
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = Team::class;

    public function up(): void
    {
        /** @var class-string $userClass */
        $userClass = XotData::make()->getUserClass();

        $this->tableCreate(static function (Blueprint $table) use ($userClass): void {
            $table->id();
            $table->foreignIdFor($userClass, 'owner_id')->nullable()->index();
            $table->uuid('uuid')->nullable()->index();
            $table->foreignIdFor($userClass, 'user_id')->nullable()->index();
            $table->string('name');
            $table->boolean('personal_team')->default(false);
        });

        $this->tableUpdate(function (Blueprint $table) use ($userClass): void {
            $this->syncTeamsColumns($table, $userClass);
            $this->updateTimestamps($table, true);
        });
    }

    private function syncTeamsColumns(Blueprint $table, string $userClass): void
    {
        // NB: `teams.id` resta INT UNSIGNED (forma legacy). Non allargarlo a BIGINT:
        // `team_permissions.team_id` e' stato allineato a INT UNSIGNED e la FK
        // team_permissions_team_id_foreign ora esiste — MySQL rifiuta la modifica
        // del tipo di una colonna referenziata da un vincolo attivo.
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
            $table->foreignIdFor($userClass, 'owner_id')
                ->nullable()
                ->index()
                ->after('id');
        }

        if (! $this->hasColumn('user_id')) {
            $table->foreignIdFor($userClass, 'user_id')->nullable()->index();
        }
    }
};
