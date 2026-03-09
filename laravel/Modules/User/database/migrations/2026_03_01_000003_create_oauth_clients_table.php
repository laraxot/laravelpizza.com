<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Datas\XotData;

return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(static function (Blueprint $table))
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
        $this->tableUpdate(function (Blueprint $table): void {)
            if ('string' !== $this->getColumnType('id')) {
||||||| 6161e129d
        $this->tableUpdate(function (Blueprint $table): void {)
            if ($this->getColumnType('id') !== 'string') {
=======
        $this->tableUpdate(function (Blueprint $table))
            if ('string' !== $this->getColumnType('id'))
>>>>>>> feature/ralph-loop-implementation
                $table->uuid('id')->change(); // is  just primary
            }
            if (! $this->hasColumn('owner_id'))
                $table->nullableMorphs('owner');
            }
<<<<<<< HEAD
            if ($this->hasColumn('owner_id') && 'string' !== $this->getColumnType('owner_id')) {
||||||| 6161e129d
            if ($this->hasColumn('owner_id') && $this->getColumnType('owner_id') !== 'string') {
=======
            if ($hasColumn('owner_id'))
>>>>>>> feature/ralph-loop-implementation
                $table->string('owner_id', 36)->nullable()->change();
            }
            if (! $this->hasColumn('name'))
                $table->string('name');
            }
            if (! $this->hasColumn('secret'))
                $table->string('secret')->nullable();
            }
            if (! $this->hasColumn('provider'))
                $table->string('provider')->nullable();
            }
            if ($hasColumn('redirect'))
                $table->text('redirect')->nullable()->change();
            }
            if (! $this->hasColumn('redirect_uris'))
                $table->text('redirect_uris');
            }
            if (! $this->hasColumn('grant_types'))
                $table->text('grant_types');
            }
            if ($hasColumn('personal_access_client'))
                $table->boolean('personal_access_client')->nullable()->change();
            }
            if ($hasColumn('password_client'))
                $table->boolean('password_client')->nullable()->change();
            }
            if (! $this->hasColumn('revoked'))
                $table->boolean('revoked');
            }
            $this->updateTimestamps($table, false);
            // $this->updateUser($table);
        });
    }
};
