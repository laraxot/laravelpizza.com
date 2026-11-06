<?php

declare(strict_types=1);
/**
 * Mirror di Modules\DbForge\Console\Commands\ViewDatabaseConfigCommand (canonico, stessa signature).
 *
 * @see ---
 */

namespace Modules\Xot\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ViewDatabaseConfigCommand extends Command
{
    /**
     * Frammenti (minuscoli) che marcano una chiave di config come segreta:
     * il valore non viene mai stampato. `url` e `dsn` perche' possono
     * contenere le credenziali inline (mysql://utente:password@host).
     *
     * @var list<string>
     */
    private const array SECRET_KEY_PARTS = ['password', 'passwd', 'secret', 'token', 'key', 'url', 'dsn'];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xot:view-db-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mostra la config delle connessioni database con le credenziali mascherate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $connections = config('database.connections');
        if (! is_array($connections)) {
            $this->error('config database.connections non e un array');

            return self::FAILURE;
        }

        $rows = [];
        foreach (Arr::dot($connections) as $path => $value) {
            $path = (string) $path;
            $rows[] = [$path, match (true) {
                $this->isSecret($path) && filled($value) => '********',
                is_array($value) => '[]', // Arr::dot appiattisce gli array non vuoti
                is_bool($value) => $value ? 'true' : 'false',
                $value === null => 'null',
                is_scalar($value) => (string) $value,
                default => get_debug_type($value),
            }];
        }

        $this->table(['Chiave', 'Valore'], $rows);

        return self::SUCCESS;
    }

    private function isSecret(string $path): bool
    {
        return Str::contains(Str::lower(Str::afterLast($path, '.')), self::SECRET_KEY_PARTS);
    }
}
