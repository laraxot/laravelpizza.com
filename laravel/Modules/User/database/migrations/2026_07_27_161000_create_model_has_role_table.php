<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\ModelHasRole;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Datas\XotData;

/*
 * Pivot Spatie HasRoles — tabella da ModelHasRole::getTable() → config permission.table_names.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = ModelHasRole::class;

    public function up(): void
    {
        $this->adoptPluralLegacyTableNameIfNeeded();

        $this->tableCreate(static function (Blueprint $table): void {
            $teamClass = XotData::make()->getTeamClass();
            $table->id();
            $table->integer('role_id')->index()->nullable();
            $table->uuidMorphs('model');
            $table->foreignIdFor($teamClass, 'team_id')->nullable();
        });

        $this->tableUpdate(function (Blueprint $table): void {
            $teamClass = XotData::make()->getTeamClass();
            if (! $this->hasColumn('team_id')) {
                $table->foreignIdFor($teamClass, 'team_id')->nullable();
            }
            if ($this->getColumnType('model_id') === 'uuid') {
                $table->string('model_id', 36)->index()->change();
            }
            if ($this->getColumnType('role_id') === 'uuid') {
                $table->integer('role_id')->index()->change();
            }
            $this->updateTimestamps($table);
        });
    }
};
