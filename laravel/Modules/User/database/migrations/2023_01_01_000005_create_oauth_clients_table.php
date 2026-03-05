<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Datas\XotData;

return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(static function (Blueprint $table): void {
            // $table->bigIncrements('id');
            $table->uuid('id')->primary();
            // $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->foreignIdFor(XotData::make()->getUserClass(), 'user_id')->nullable()->index();
            $table->string('name');
            $table->string('secret', 100)->nullable();
            $table->string('provider')->nullable();
            $table->text('redirect');
            $table->boolean('personal_access_client');
            $table->boolean('password_client');
            $table->boolean('revoked');
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            if ('string' !== $this->getColumnType('id')) {
                $table->uuid('id')->change(); // is  just primary
            }
            if (! $this->hasColumn('owner_id') && ! $this->hasColumn('owner_type')) {
                $table->nullableMorphs('owner');
            }
            if (! $this->hasColumn('name')) {
                $table->string('name');
            }
            if (! $this->hasColumn('secret')) {
                $table->string('secret')->nullable();
            }
            if (! $this->hasColumn('provider')) {
                $table->string('provider')->nullable();
            }
            if (! $this->hasColumn('redirect_uris')) {
                $table->text('redirect_uris');
            }
            if (! $this->hasColumn('grant_types')) {
                $table->text('grant_types');
            }
            if (! $this->hasColumn('revoked')) {
                $table->boolean('revoked');
            }
            $this->updateTimestamps($table, false);
            // $this->updateUser($table);
        });
    }
};
