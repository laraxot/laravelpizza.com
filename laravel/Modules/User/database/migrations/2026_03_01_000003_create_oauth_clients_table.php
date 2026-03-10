<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Datas\XotData;

return new class extends XotBaseMigration {
    public function up(): void
    {
<<<<<<< HEAD
        $this->tableCreate(static function (Blueprint $table): void {
=======
        $this->tableCreate(static function (Blueprint $table) {
>>>>>>> 74e589dbb (.)
            // $table->bigIncrements('id');
            $table->uuid('id')->primary();
            // $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->foreignIdFor(XotData::make()->getUserClass(), 'user_id')->nullable()->index();
            $table->string('name');
            $table->string('secret', 100)->nullable();
            $table->string('provider')->nullable();
            $table->text('redirect')->nullable();
            $table->boolean('personal_access_client')->nullable();
            $table->boolean('password_client')->nullable();
            $table->boolean('revoked');
        });

        // -- UPDATE --
<<<<<<< HEAD
        $this->tableUpdate(function (Blueprint $table): void {
=======
        $this->tableUpdate(function (Blueprint $table) {
>>>>>>> 74e589dbb (.)
            if ('string' !== $this->getColumnType('id')) {
                $table->uuid('id')->change(); // is  just primary
            }
            if (! $this->hasColumn('owner_id')) {
                $table->nullableMorphs('owner');
            }
<<<<<<< HEAD
            if ($this->hasColumn('owner_id')) {
=======
            if ($hasColumn('owner_id')) {
>>>>>>> 74e589dbb (.)
                $table->string('owner_id', 36)->nullable()->change();
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
<<<<<<< HEAD
            if ($this->hasColumn('redirect')) {
=======
            if ($hasColumn('redirect')) {
>>>>>>> 74e589dbb (.)
                $table->text('redirect')->nullable()->change();
            }
            if (! $this->hasColumn('redirect_uris')) {
                $table->text('redirect_uris');
            }
            if (! $this->hasColumn('grant_types')) {
                $table->text('grant_types');
            }
<<<<<<< HEAD
            if ($this->hasColumn('personal_access_client')) {
                $table->boolean('personal_access_client')->nullable()->change();
            }
            if ($this->hasColumn('password_client')) {
=======
            if ($hasColumn('personal_access_client')) {
                $table->boolean('personal_access_client')->nullable()->change();
            }
            if ($hasColumn('password_client')) {
>>>>>>> 74e589dbb (.)
                $table->boolean('password_client')->nullable()->change();
            }
            if (! $this->hasColumn('revoked')) {
                $table->boolean('revoked');
            }
            $this->updateTimestamps($table, false);
            // $this->updateUser($table);
        });
    }
};
