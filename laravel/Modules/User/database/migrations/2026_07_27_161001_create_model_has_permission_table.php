<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\ModelHasPermission;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Datas\XotData;

return new class extends XotBaseMigration
{
    protected ?string $model_class = ModelHasPermission::class;

    public function up(): void
    {
        $this->adoptPluralLegacyTableNameIfNeeded();

        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('permission_id');
            $table->uuidMorphs('model');
        });

        $this->tableUpdate(function (Blueprint $table): void {
            $teamClass = XotData::make()->getTeamClass();
            if (! $this->hasColumn('team_id')) {
                $table->foreignIdFor($teamClass, 'team_id')->nullable();
            }
            if ($this->getColumnType('model_id') === 'uuid') {
                $table->string('model_id', 36)->index()->change();
            }
            $this->updateTimestamps($table);
        });
    }
};
