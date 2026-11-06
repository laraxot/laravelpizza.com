<?php

declare(strict_types=1);

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\DB;
use Modules\Xot\Tests\XotBaseTestCase;
use Throwable;

use function Safe\glob;
use function Safe\preg_replace;
use function Safe\touch;
use function Safe\unlink;

/**
 * Costruisce lo schema del database SQLite usato dai test.
 *
 * Il file è in `.gitignore`, quindi non viaggia con il repository: senza questo comando
 * ogni macchina se lo deve ricostruire a mano, e i test partono contro un database con
 * tredici tabelle incidentali che non contengono `users`, `media` né `activity_log`.
 * Da lì le centinaia di `SQLSTATE[HY000]: General error: 1 no such table` che tenevano
 * rossa la maggior parte delle suite.
 */
class BuildTestSqliteCommand extends Command
{
    protected $signature = 'xot:build-test-sqlite
                            {--path= : File da costruire; default quello usato dai test}
                            {--fresh : Riparte da un file vuoto invece di migrare sull\'esistente}';

    protected $description = 'Esegue le migration di tutti i moduli sul database SQLite dei test';

    /**
     * Connessioni dichiarate dai model dei moduli (`protected $connection`).
     *
     * Non sono tutte in `config/database.php` al bootstrap — alcune le registra il
     * ServiceProvider del modulo — e senza di loro `migrate` esce con
     * «Database connection [activity] not configured».
     *
     * @var list<string>
     */
    private const array MODULE_CONNECTIONS = [
        'activity', 'generale', 'incentivi', 'indennita_condizioni_lavoro',
        'indennita_responsabilita', 'job', 'lang', 'media', 'notify', 'performance',
        'progressione', 'ptv', 'rating', 'tenant', 'u_i', 'user', 'xot',
    ];

    public function handle(Repository $config): int
    {
        $target = $this->stringOption('path') ?? XotBaseTestCase::sharedSqlitePath();

        if ($this->option('fresh') === true && file_exists($target)) {
            unlink($target);
        }

        if (! file_exists($target)) {
            touch($target);
        }

        $this->pointEveryConnectionAt($config, $target);

        $failures = $this->migrateModuleByModule();

        $this->newLine();
        $this->info(sprintf('Tabelle in %s: %d', $target, $this->countTables($target)));

        if ($failures === []) {
            return self::SUCCESS;
        }

        $this->newLine();
        $this->warn(sprintf('Moduli con migration non applicate: %d', count($failures)));
        foreach ($failures as $module => $reason) {
            $this->line(sprintf('  <fg=yellow>%s</>: %s', $module, $reason));
        }

        return self::SUCCESS;
    }

    /**
     * Riscrive ogni connessione su SQLite.
     *
     * Puntare solo `database.default` non basta: `XotBaseMigration::resolveConnectionName()`
     * prende il nome dal model, quindi ogni migration bussa alla connessione del suo modulo
     * e, se quella resta MySQL su un host irraggiungibile, paga un timeout TCP pieno.
     */
    private function pointEveryConnectionAt(Repository $config, string $target): void
    {
        /** @var array<string, mixed> $connections */
        $connections = (array) $config->get('database.connections', []);

        foreach (self::MODULE_CONNECTIONS as $name) {
            $connections[$name] ??= [];
        }

        foreach (array_keys($connections) as $name) {
            $config->set('database.connections.'.$name, [
                'driver' => 'sqlite',
                'database' => $target,
                'prefix' => '',
                'foreign_key_constraints' => false,
                'busy_timeout' => 20000,
            ]);
            DB::purge((string) $name);
        }

        $config->set('database.default', 'sqlite');

        $this->info(sprintf('Connessioni puntate su SQLite: %d', count($connections)));
    }

    /**
     * Migra un modulo alla volta: una migration incompatibile con SQLite non deve
     * impedire agli altri diciassette di creare le proprie tabelle.
     *
     * @return array<string, string> modulo => motivo del fallimento
     */
    private function migrateModuleByModule(): array
    {
        $paths = glob(base_path('Modules/*/database/migrations'));
        sort($paths);
        array_unshift($paths, database_path('migrations'));

        $failures = [];

        foreach ($paths as $path) {
            if (! is_string($path)) {
                continue;
            }
            if (! is_dir($path)) {
                continue;
            }

            $module = basename(dirname($path, 2));

            try {
                $this->callSilent('migrate', [
                    '--force' => true,
                    '--path' => $path,
                    '--realpath' => true,
                ]);
                $this->line(sprintf('  %-32s <fg=green>ok</>', $module));
            } catch (Throwable $e) {
                // Una migration che inciampa ferma tutte quelle dopo di lei nella stessa
                // directory: la prima volta è successo con `imports already exists`, e le
                // tabelle `cache` e `model_has_roles` — dichiarate più avanti nella stessa
                // cartella — non sono mai state create. Si riprova file per file.
                $survivors = $this->migrateFileByFile($path);

                if ($survivors === []) {
                    $this->line(sprintf('  %-32s <fg=green>ok</> (file per file)', $module));
                } else {
                    $failures[$module] = $this->firstLine(implode('; ', $survivors));
                    $this->line(sprintf('  %-32s <fg=yellow>parziale</> (%d migration non applicate)', $module, count($survivors)));
                }
                unset($e);
            }
        }

        return $failures;
    }

    /**
     * Applica le migration di una directory una alla volta, restituendo solo quelle che
     * non passano. Serve dopo il fallimento del passaggio in blocco: senza, una singola
     * incompatibilità con SQLite si porta dietro tutte le migration successive.
     *
     * @return list<string>
     */
    private function migrateFileByFile(string $path): array
    {
        $files = glob($path.'/*.php');
        sort($files);

        $failed = [];

        foreach ($files as $file) {
            if (! is_string($file)) {
                continue;
            }
            try {
                $this->callSilent('migrate', [
                    '--force' => true,
                    '--path' => $file,
                    '--realpath' => true,
                ]);
            } catch (Throwable $e) {
                $failed[] = basename($file).': '.$this->firstLine($e->getMessage());
            }
        }

        return $failed;
    }

    private function countTables(string $target): int
    {
        $pdo = new \PDO('sqlite:'.$target);
        $count = $pdo->query('SELECT count(*) FROM sqlite_master WHERE type = "table"');

        return $count === false ? 0 : (int) $count->fetchColumn();
    }

    private function firstLine(string $message): string
    {
        $normalised = preg_replace('/\s+/', ' ', $message);

        return mb_substr($normalised, 0, 160);
    }

    private function stringOption(string $name): ?string
    {
        $value = $this->option($name);

        return is_string($value) && $value !== '' ? $value : null;
    }
}
