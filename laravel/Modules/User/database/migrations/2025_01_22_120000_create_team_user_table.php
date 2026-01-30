<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Migrazione per team_user con id autoincrement.
 *
 * Questa migrazione gestisce sia la creazione che l'aggiornamento della tabella team_user.
 * Se la tabella esiste già con id UUID, viene convertita a id autoincrement.
 */
return new class extends XotBaseMigration {
    /**
     * Nome della tabella gestita dalla migrazione.
     */
    protected string $table_name = 'team_user';

    /**
     * Esegue la migrazione.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('team_id');
            $table->uuid('user_id')->nullable()->index();
            $table->string('role')->nullable();

            // Indice univoco per evitare duplicati team_id + user_id
            $table->unique(['team_id', 'user_id']);
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Se la tabella esiste già con id UUID, convertiamo a autoincrement
            if ($this->hasColumn('id') && in_array($this->getColumnType('id'), ['string', 'guid'], true)) {
                // Rimuoviamo la PRIMARY KEY esistente
                $this->dropPrimaryKey();

                // Se non esiste già, rinominiamo id a uuid per preservare i dati
                if (! $this->hasColumn('uuid')) {
                    $this->renameColumn('id', 'uuid');
                }

                // Aggiungiamo la nuova colonna id come bigint autoincrement
                if (! $this->hasColumn('id')) {
                    $table->id()->first();
                }

                // Impostiamo la nuova PRIMARY KEY su id
                $this->query('ALTER TABLE `'.$this->table_name.'` ADD PRIMARY KEY (`id`)');
            }

            // Aggiorniamo i timestamp e soft deletes
            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
            /*
            // Aggiungiamo l'indice univoco se non esiste già
            // Verifichiamo tramite query SQL se l'indice esiste
            $connection = $this->getConn()->getConnection();
            $database = $connection->getDatabaseName();
            //@var array{count: int}|object{count: int}|null $indexExists
            $indexExists = $connection->selectOne(
                "SELECT COUNT(*) as count
                 FROM information_schema.statistics
                 WHERE table_schema = ?
                 AND table_name = ?
                 AND index_name = 'team_user_team_id_user_id_unique'",
                [$database, $this->table_name]
            );

            $count = 0;
            if (is_array($indexExists) && isset($indexExists['count'])) {
                $count = (int) $indexExists['count'];
            } elseif (is_object($indexExists) && isset($indexExists->count)) {
                $count = (int) $indexExists->count;
            }

            if ($count === 0) {
                $table->unique(['team_id', 'user_id'], 'team_user_team_id_user_id_unique');
            }
            */
        });
    }
};
