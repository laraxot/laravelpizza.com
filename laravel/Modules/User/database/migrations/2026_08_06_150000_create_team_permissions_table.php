<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\TeamPermission;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = TeamPermission::class;

    /**
     * Esegue la migrazione.
     */
    public function up(): void
    {
        // MySQL pretende che la colonna referenziante abbia il tipo IDENTICO alla
        // colonna referenziata: se non combaciano rifiuta la FK con errno 150
        // "Foreign key constraint is incorrectly formed".
        //
        // `teams.id` non ha lo stesso tipo ovunque: la sua migrazione dichiara
        // `$table->id()` (bigint unsigned), ma i database storici del progetto hanno
        // ancora `int unsigned`. Allargare la colonna li' non e' un'opzione una volta
        // che una FK la referenzia (errore 1833) e i dati sono sacri: si legge il tipo
        // reale e ci si adatta. Cosi' la migrazione regge sia sul database storico sia
        // su uno creato da zero.
        $teamsIdIsInt = in_array(
            $this->getConn()->getColumnType('teams', 'id'),
            ['int', 'integer', 'mediumint', 'smallint'],
            true,
        );

        // -- CREATE --
        $this->tableCreate(function (Blueprint $table) use ($teamsIdIsInt): void {
            $table->id();
            if ($teamsIdIsInt) {
                $table->unsignedInteger('team_id');
            } else {
                $table->unsignedBigInteger('team_id');
            }
            $table->string('permission'); // The permission key/slug
            $table->string('name')->nullable(); // Human readable name

            $table->unique(['team_id', 'permission']);
            $table->foreign('team_id')->references('id')->on('teams')->cascadeOnDelete();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table) use ($teamsIdIsInt): void {
            if (! $this->hasColumn('permission')) {
                $table->string('permission');
            }
            if (! $this->hasColumn('name')) {
                $table->string('name')->nullable();
            }

            // Recupero dei tentativi falliti: la CREATE era passata ma la FK no, quindi
            // la tabella esiste senza vincolo e `tableCreate` non la tocca piu'.
            // Il tipo va riallineato a `teams.id` solo se diverge, e solo finche' nessuna
            // FK lo blocca (MySQL 1833: "Cannot change column used in a foreign key").
            $teamIdIsInt = in_array($this->getColumnType('team_id'), ['int', 'integer', 'mediumint', 'smallint'], true);
            if ($teamIdIsInt !== $teamsIdIsInt && ! $this->getConn()->hasForeignKey($this->getTable(), 'team_permissions_team_id_foreign')) {
                if ($teamsIdIsInt) {
                    $table->unsignedInteger('team_id')->change();
                } else {
                    $table->unsignedBigInteger('team_id')->change();
                }
            }
            if (! $this->getConn()->hasForeignKey($this->getTable(), 'team_permissions_team_id_foreign')) {
                $table->foreign('team_id')->references('id')->on('teams')->cascadeOnDelete();
            }

            // L'unique vive solo nel ramo CREATE: su una tabella gia' esistente quel
            // blocco non viene eseguito, quindi senza questa riga il vincolo non
            // nascerebbe mai e resterebbero possibili permessi duplicati per team.
            if (! $this->hasIndex('team_permissions_team_id_permission_unique')) {
                $table->unique(['team_id', 'permission']);
            }

            $this->updateTimestamps(table: $table, hasSoftDeletes: true);
        });
    }

};
