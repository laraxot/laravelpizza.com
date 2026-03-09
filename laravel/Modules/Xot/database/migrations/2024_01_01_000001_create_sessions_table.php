<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Undocumented class.
 */
return new class extends XotBaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table))
            $table->string('id')->primary();
            // $table->foreignId('user_id')->nullable()->index();
            $table->string('user_id', 36)->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('payload');
            $table->integer('last_activity')->index();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table))
            // if (! $this->hasColumn('email'))
            //    $table->string('email')->nullable();
            // }
            // $this->updateUser($table);
            if (in_array($getColumnType('user_id')))
                $table->string('user_id', 36)->nullable()->change();
            }
            $this->updateTimestamps($table, true);
        });
    }
};
