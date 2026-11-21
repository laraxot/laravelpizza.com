<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Support;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ConfigurationUrlParser;
use RuntimeException;

/**
 * Guardia di bootstrap dei test: si ferma prima del primo test se una
 * connessione puo' raggiungere un database che non e' usa-e-getta.
 *
 * Il DB reale e quello di test vivono sullo stesso server con lo stesso
 * account (che ha DROP): li separa solo il nome. Vedi
 * `Modules/Xot/docs/testing/difese-database-nei-test.md`.
 *
 * Due controlli per ogni connessione non sqlite (driver, database e host effettivi: l'URL vince):
 * 1. il database finisce per `_test` (o e' un DB usa-e-getta di pest-scratch-db.sh);
 * 2. l'host e' locale: un .env.testing copiato che punta a un server remoto (staging, produzione)
 *    si ferma qui anche se il nome finisce per `_test`. Altri host ammessi: `TEST_DB_ALLOWED_HOSTS`
 *    (separati da virgola), per esempio un servizio CI.
 */
final class TestDatabaseGuard
{
    /**
     * Connessioni che leggono una variabile DB_* non definita in `.env.testing`
     * e quindi ricadono su un nome reale (config/localhost/database.php).
     */
    private const array ALLOWED_CONNECTIONS = ['liveuser_general'];

    /** Prefisso dei database temporanei creati da `bashscripts/tools/pest-scratch-db.sh`. */
    private const array ALLOWED_PREFIXES = ['claude_scratch_pest_'];

    /**
     * Host considerati locali: la macchina stessa e i nomi di servizio di docker compose, che
     * esistono solo dentro la rete dei container.
     */
    private const array LOCAL_HOSTS = ['', 'localhost', '127.0.0.1', '::1', '[::1]', 'mysql', 'mariadb', 'db', 'database', 'pgsql', 'postgres'];

    /**
     * @param  array<string, array{driver?: string|null, database?: string|null, url?: string|null, host?: string|null}>  $connections
     * @param  list<string>  $allowedHosts  host remoti ammessi in piu' (TEST_DB_ALLOWED_HOSTS)
     */
    public static function assert(string $env, array $connections, array $allowedHosts = []): void
    {
        if ($env !== 'testing') {
            throw new RuntimeException(
                \sprintf('Test bootstrap refused: APP_ENV is "%s", expected "testing".', $env),
            );
        }

        foreach ($connections as $name => $connection) {
            if (\in_array($name, self::ALLOWED_CONNECTIONS, true)) {
                continue;
            }

            [$driver, $database, $host] = self::resolve($connection);

            if ($driver === null || $driver === 'sqlite' || $database === null || $database === '' || $database === ':memory:') {
                continue;
            }

            if (! self::isThrowaway($database)) {
                throw new RuntimeException(\sprintf(
                    'Test bootstrap refused: connection "%s" (%s) -> database "%s", which does not end with "_test".',
                    $name,
                    $driver,
                    $database,
                ));
            }

            $host = \strtolower(\trim($host ?? ''));
            if (! \in_array($host, self::LOCAL_HOSTS, true) && ! \in_array($host, \array_map('strtolower', $allowedHosts), true)) {
                throw new RuntimeException(\sprintf(
                    'Test bootstrap refused: connection "%s" (%s) -> host "%s" is not local. Tests never touch remote databases; add the host to TEST_DB_ALLOWED_HOSTS only for a disposable CI server.',
                    $name,
                    $driver,
                    $host,
                ));
            }
        }
    }

    private static function isThrowaway(string $database): bool
    {
        if (\str_ends_with($database, '_test')) {
            return true;
        }

        foreach (self::ALLOWED_PREFIXES as $prefix) {
            if (\str_starts_with($database, $prefix)) {
                return true;
            }
        }

        return false;
    }

    public static function assertApplication(Application $app): void
    {
        $env = $app->environment();
        if (! \is_string($env)) {
            throw new RuntimeException('Test bootstrap refused: the application environment is not a string.');
        }

        $config = $app->make('config');
        if (! $config instanceof Repository) {
            throw new RuntimeException('Test bootstrap refused: the config repository is not bound.');
        }

        $allowed = \getenv('TEST_DB_ALLOWED_HOSTS');
        $allowedHosts = \is_string($allowed) && $allowed !== ''
            ? \array_values(\array_filter(\array_map('trim', \explode(',', $allowed)), static fn (string $h): bool => $h !== ''))
            : [];

        self::assert($env, self::narrowConnections($config->get('database.connections')), $allowedHosts);
    }

    /**
     * @param  array{driver?: string|null, database?: string|null, url?: string|null, host?: string|null}  $connection
     * @return array{string|null, string|null, string|null} driver, database e host effettivi (l'URL vince, come a runtime)
     */
    private static function resolve(array $connection): array
    {
        $driver = $connection['driver'] ?? null;
        $database = $connection['database'] ?? null;
        $host = $connection['host'] ?? null;
        $url = $connection['url'] ?? null;

        if ($url === null || $url === '') {
            return [$driver, $database, $host];
        }

        $parsed = (new ConfigurationUrlParser)->parseConfiguration(['url' => $url]);

        $urlDriver = $parsed['driver'] ?? null;
        $urlDatabase = $parsed['database'] ?? null;
        $urlHost = $parsed['host'] ?? null;

        return [
            \is_string($urlDriver) ? $urlDriver : $driver,
            \is_string($urlDatabase) ? $urlDatabase : $database,
            \is_string($urlHost) ? $urlHost : $host,
        ];
    }

    /**
     * @return array<string, array{driver?: string|null, database?: string|null, url?: string|null, host?: string|null}>
     */
    private static function narrowConnections(mixed $connections): array
    {
        if (! \is_array($connections)) {
            return [];
        }

        $narrowed = [];
        foreach ($connections as $name => $connection) {
            if (! \is_string($name) || ! \is_array($connection)) {
                continue;
            }

            $narrowed[$name] = [
                'driver' => \is_string($connection['driver'] ?? null) ? $connection['driver'] : null,
                'database' => \is_string($connection['database'] ?? null) ? $connection['database'] : null,
                'url' => \is_string($connection['url'] ?? null) ? $connection['url'] : null,
                'host' => \is_string($connection['host'] ?? null) ? $connection['host'] : null,
            ];
        }

        return $narrowed;
    }
}
