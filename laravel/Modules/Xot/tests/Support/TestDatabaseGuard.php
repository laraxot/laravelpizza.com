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
 * `Modules/Xot/docs/stories/test-database-guard.story.md`.
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
     * @param  array<string, array{driver?: string|null, database?: string|null, url?: string|null}>  $connections
     */
    public static function assert(string $env, array $connections): void
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

            [$driver, $database] = self::resolve($connection);

            if ($driver === null || $database === null || $database === '') {
                continue;
            }

            if ($driver === 'sqlite' || $database === ':memory:' || \str_ends_with($database, '_test')) {
                continue;
            }

            foreach (self::ALLOWED_PREFIXES as $prefix) {
                if (\str_starts_with($database, $prefix)) {
                    continue 2;
                }
            }

            throw new RuntimeException(\sprintf(
                'Test bootstrap refused: connection "%s" (driver %s) points to database "%s", which does not end with "_test".',
                $name,
                $driver,
                $database,
            ));
        }
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

        self::assert($env, self::narrowConnections($config->get('database.connections')));
    }

    /**
     * @param  array{driver?: string|null, database?: string|null, url?: string|null}  $connection
     * @return array{string|null, string|null} driver e database effettivi (l'URL vince, come a runtime)
     */
    private static function resolve(array $connection): array
    {
        $driver = $connection['driver'] ?? null;
        $database = $connection['database'] ?? null;
        $url = $connection['url'] ?? null;

        if ($url === null || $url === '') {
            return [$driver, $database];
        }

        $parsed = (new ConfigurationUrlParser)->parseConfiguration(['url' => $url]);

        $urlDriver = $parsed['driver'] ?? null;
        $urlDatabase = $parsed['database'] ?? null;

        return [
            \is_string($urlDriver) ? $urlDriver : $driver,
            \is_string($urlDatabase) ? $urlDatabase : $database,
        ];
    }

    /**
     * @return array<string, array{driver?: string|null, database?: string|null, url?: string|null}>
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
            ];
        }

        return $narrowed;
    }
}
