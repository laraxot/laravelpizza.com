<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Datas\XotData;

/*
 * Pivot Spatie HasRoles — tabella e connessione da ModelHasRole (derivato dal nome file).
 * Vietato: nome tabella hardcoded, secondo argomento a tableCreate(), const TABLE.
 * SSoT runtime: config('permission.table_names.model_has_roles') via ModelHasRole::getTable().
 */
return new class extends XotBaseMigration {
    public function up(): void
    {
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
            if ('uuid' === $this->getColumnType('model_id')) {
                $table->string('model_id', 36)->index()->change();
            }
            if ('uuid' === $this->getColumnType('role_id')) {
                $table->integer('role_id')->index()->change();
            }
            $this->updateTimestamps($table);
        });
    }
};
