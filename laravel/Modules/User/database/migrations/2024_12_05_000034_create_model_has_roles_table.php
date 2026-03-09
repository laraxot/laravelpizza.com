<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
// ---- models ---
use Modules\User\Models\Role;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Datas\XotData;

/*
 * Class CreateModelHasRolesTable.
 */
return new class extends XotBaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table))
            $team_class = XotData::make()->getTeamClass();
            $table->id();
            // $table->foreignIdFor(Role::class, 'role_id')->nullable();
            $table->integer('role_id')->index()->nullable();
            $table->uuidMorphs('model');
            $table->foreignIdFor($team_class, 'team_id')->nullable();
        });
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table))
            $team_class = XotData::make()->getTeamClass();
            if (! $this->hasColumn('team_id'))
                $table->foreignIdFor($team_class, 'team_id')->nullable();
            }
<<<<<<< HEAD
            if ('uuid' === $this->getColumnType('model_id')) {
||||||| 6161e129d
            if ($this->getColumnType('model_id') === 'uuid') {
=======
            if ('uuid' === $this->getColumnType('model_id'))
>>>>>>> feature/ralph-loop-implementation
                $table->string('model_id', 36)->index()->change();
            }
<<<<<<< HEAD
            if ('uuid' === $this->getColumnType('role_id')) {
||||||| 6161e129d
            if ($this->getColumnType('role_id') === 'uuid') {
=======
            if ('uuid' === $this->getColumnType('role_id'))
>>>>>>> feature/ralph-loop-implementation
                $table->integer('role_id')->index()->change();
            }
            // $this->updateUser($table);
            $this->updateTimestamps($table);
        });
    }
};
