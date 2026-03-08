<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

<<<<<<< HEAD
/*
 * Migrazione per team_user con id autoincrement.
 *
 * Questa migrazione gestisce sia la creazione che l'aggiornamento della tabella team_user.
 * Se la tabella esiste già con id UUID, viene convertita a id autoincrement.
 */
||||||| 6161e129d
/*
 * Migrazione per team_user con id autoincrement.
 *
 * Questa migrazione gestisce sia la creazione che l'aggiornamento della tabella team_user.
 * Se la tabella esiste già con id UUID, viene convertita a id autoincrement.
 */
return new class extends XotBaseMigration
{
=======
>>>>>>> feature/ralph-loop-implementation
return new class extends XotBaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table
            // $table->uuid('id')->primary();
            $table->id();
            $table->foreignId('team_id');
            $table->uuid('user_id')->nullable()->index();
            // $table->foreignIdFor(\Modules\Xot\Datas\XotData::make()->getUserClass());
            $table->string('role')->nullable();

            // $table->unique(['team_id', 'user_id']);
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table
            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );

            // $this->updateUser($table);
        });
    }
};
