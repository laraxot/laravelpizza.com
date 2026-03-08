<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Datas\XotData;

return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(static function (Blueprint $table
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
<<<<<<< HEAD
        $this->tableUpdate(function (Blueprint $table): void {
            if ('string' !== $this->getColumnType('id')) {
||||||| 6161e129d
        $this->tableUpdate(function (Blueprint $table): void {
            if ($this->getColumnType('id') !== 'string') {
=======
        $this->tableUpdate(function (Blueprint $table
            if ('string' !== $this->getColumnType('id'
>>>>>>> feature/ralph-loop-implementation
                $table->uuid('id')->change(); // is  just primary
            }
            $this->updateTimestamps($table, false);
            $this->updateUser($table);
        });
    }
};
