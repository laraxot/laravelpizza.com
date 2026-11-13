<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\SocialiteUser;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Datas\XotData;

/**
 * Canonical owner migration for SocialiteUser on the user connection.
 *
 * The old singular migration could be marked as run against the wrong
 * connection in legacy deployments; this forward-only owner repairs that
 * drift without moving or deleting OAuth data.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = SocialiteUser::class;

    public function up(): void
    {
        $userClass = XotData::make()->getUserClass();

        $this->tableCreate(static function (Blueprint $table) use ($userClass): void {
            $table->id();
            $table->foreignIdFor($userClass, 'user_id');
            $table->string('provider');
            $table->string('provider_id');
            $table->text('token')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('avatar')->nullable();
        });

        $this->tableUpdate(function (Blueprint $table): void {
            if ($this->getColumnType('token') === 'varchar') {
                $table->text('token')->nullable()->change();
            }

            $this->updateTimestamps($table);
        });
    }
};
