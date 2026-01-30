<?php

declare(strict_types=1);

namespace Modules\DbForge\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use RuntimeException;

use function Safe\shell_exec;

class ImportMdbToSQLite extends Command
{
    /**
     * Il nome e la firma del comando.
     *
     * @var string
     */
    protected $signature = 'xot:import-mdb-to-sqlite';

    /**
     * La descrizione del comando.
     *
     * @var string
     */
    protected $description = 'Importa un file .mdb in SQLite con un processo passo-passo';

    /**
     * Esegui il comando.
     */
    public function handle(): int
    {
        $mdbFileInput = $this->ask('Per favore, inserisci il percorso del file .mdb');
        $sqliteDbInput = $this->ask('Per favore, inserisci il nome del database SQLite (includi l\'estensione .sqlite)');

        $mdbFile = is_string($mdbFileInput) ? $mdbFileInput : '';
        $sqliteDb = is_string($sqliteDbInput) ? $sqliteDbInput : '';

        if (empty($mdbFile) || empty($sqliteDb)) {
            $this->error('I percorsi del file non possono essere vuoti.');

            return Command::FAILURE;
        }

        $this->info(sprintf('File .mdb: %s', $mdbFile));
        $this->info(sprintf('Database SQLite: %s', $sqliteDb));

        try {
            $this->info('Esportando tabelle dal file .mdb in CSV...');
            $tables = $this->exportTablesToCSV($mdbFile);

            $this->info('Creando tabelle nel database SQLite...');
            $this->createTables($mdbFile, $sqliteDb);

            $this->info('Importando i dati CSV nelle tabelle SQLite...');
            $this->importDataToSQLite($tables, $sqliteDb);

            $this->info('Processo completato!');

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        }
    }

    /**
     * Esporta tutte le tabelle dal file .mdb in formato CSV.
     *
     * @return array<int, string>
     */
    private function exportTablesToCSV(string $mdbFile): array
    {
        $tables = [];
        try {
            $result = shell_exec(sprintf('mdb-tables %s', $mdbFile));

            if ($result === null) {
                throw new RuntimeException('Impossibile eseguire mdb-tables. Assicurati che mdb-tools sia installato.');
            }

            $tableNames = explode("\n", trim($result));
            foreach ($tableNames as $tableName) {
                $tableName = trim($tableName);
                if (empty($tableName)) {
                    continue;
                }
                $tables[] = $tableName;
                $csvFile = storage_path(sprintf('app/%s.csv', $tableName));
                shell_exec(sprintf('mdb-export %s %s > %s', $mdbFile, $tableName, $csvFile));
            }

            return $tables;
        } catch (Exception $e) {
            throw new RuntimeException(sprintf('Errore durante l\'esportazione delle tabelle: %s', $e->getMessage()));
        }
    }

    /**
     * Crea le tabelle nel database SQLite basandosi sullo schema del file .mdb.
     */
    private function createTables(string $mdbFile, string $sqliteDb): void
    {
        try {
            $form = shell_exec(sprintf('mdb-schema %s sqlite', $mdbFile));

            if ($form === null) {
                throw new RuntimeException('Impossibile eseguire mdb-schema. Assicurati che mdb-tools sia installato.');
            }

            $tableSchemas = explode(";\n", $form);

            foreach ($tableSchemas as $tableSchema) {
                $formStr = trim($tableSchema);
                if (empty($formStr)) {
                    continue;
                }

                $formStr = str_replace('`', '"', $formStr);
                shell_exec(sprintf('sqlite3 %s "%s;"', $sqliteDb, $formStr));
            }
        } catch (Exception $e) {
            throw new RuntimeException(sprintf('Errore durante la creazione delle tabelle: %s', $e->getMessage()));
        }
    }

    /**
     * Importa i dati CSV nelle tabelle SQLite.
     *
     * @param  array<int, string>  $tables
     */
    private function importDataToSQLite(array $tables, string $sqliteDb): void
    {
        try {
            foreach ($tables as $table) {
                $csvFile = storage_path(sprintf('app/%s.csv', $table));
                shell_exec(sprintf('sqlite3 %s ".mode csv" ".import %s %s"', $sqliteDb, $csvFile, $table));
            }
        } catch (Exception $e) {
            throw new RuntimeException(sprintf('Errore durante l\'importazione dei dati: %s', $e->getMessage()));
        }
    }
}
