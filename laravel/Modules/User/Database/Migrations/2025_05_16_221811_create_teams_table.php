<?php

/**
 * ---.
 */

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    /**
     * Esegue la migrazione.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->nullable()->index();
            $table->string('user_id', 36)->nullable()->index();
            // $table->foreignIdFor(\Modules\Xot\Datas\XotData::make()->getUserClass());
            $table->string('name');
            $table->boolean('personal_team')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // MySqlConnection::getDoctrineSchemaManager does not exist.
            // MySqlConnection::getSchemaGrammar() ?
            // if ($this->hasIndexName('team_invitations_team_id_foreign')) {
            //    $table->dropForeign('team_invitations_team_id_foreign');
            // }
            if ($this->hasColumn('uuid')) {
                $table->uuid('uuid')->nullable()->change();
            }
            if ($this->hasColumn('personal_team')) {
                $table->boolean('personal_team')->default(false)->change();
            }

            if (! $this->hasColumn('code')) {
                $table->string('code', 36)->nullable()->index();
            }

            if (! $this->hasColumn('owner_id')) {
                $table->uuid('owner_id')->nullable()->after('id');
            }

            if (! $this->hasColumn('slug')) {
                $table->string('slug')->nullable()->unique();
            }

            if (! $this->hasColumn('description')) {
                $table->text('description')->nullable();
            }

            if (! $this->hasColumn('avatar_path')) {
                $table->string('avatar_path')->nullable();
            }

            if (! $this->hasColumn('settings')) {
                $table->json('settings')->nullable();
            }

            $this->updateTimestamps($table, true);
        });
    }
};
