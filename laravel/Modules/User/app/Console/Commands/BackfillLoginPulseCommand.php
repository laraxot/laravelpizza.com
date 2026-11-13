<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Laravel\Pulse\Contracts\Storage;
use Laravel\Pulse\Entry;
use Throwable;

final class BackfillLoginPulseCommand extends Command
{
    protected $signature = 'user:pulse-backfill-logins
        {--days=7 : Giorni di storico richiesti}
        {--chunk=500 : Dimensione dei blocchi (1-1000)}
        {--dry-run : Mostra i dati senza modificarli}
        {--force : Non chiedere conferma}';

    protected $description = 'Ricostruisce la metrica user_login di Pulse da authentication_logs';

    private const string TYPE = 'user_login';
    private const string METRIC_KEY = 'all';
    private const string SOURCE_CONNECTION = 'user';
    private const string SOURCE_TABLE = 'authentication_logs';
    private const array PERIODS = [60 => '1 ora', 360 => '6 ore', 1440 => '24 ore', 10080 => '7 giorni'];

    public function handle(Storage $storage): int
    {
        $days = filter_var($this->option('days'), FILTER_VALIDATE_INT);
        $chunk = filter_var($this->option('chunk'), FILTER_VALIDATE_INT);

        if ($days === false || $days < 1 || $chunk === false || $chunk < 1 || $chunk > 1000) {
            $this->error('Parametri non validi: --days >= 1 e --chunk tra 1 e 1000.');
            return self::FAILURE;
        }

        if (config('pulse.storage.driver') !== 'database') {
            $this->error('Richiesto PULSE_STORAGE_DRIVER=database.');
            return self::FAILURE;
        }

        // Lo storage è quello legato al contract Storage: store()/purge()
        // sono nel contratto, nessun instanceof su classi @internal di Pulse.
        $source = DB::connection(self::SOURCE_CONNECTION);

        $configuredConnection = config('pulse.storage.database.connection');
        $defaultConnection = config('database.default');
        $pulseConnection = is_string($configuredConnection) && $configuredConnection !== ''
            ? $configuredConnection
            : (is_string($defaultConnection) ? $defaultConnection : 'mysql');
        $pulseDb = DB::connection($pulseConnection);

        // authentication_logs.login_at è assunto in UTC: adeguare se usa un altro fuso.
        $now = CarbonImmutable::now('UTC');
        $requestedSince = $now->subDays($days);
        $effectiveSince = $requestedSince->greaterThan($now->subDays(7))
            ? $requestedSince : $now->subDays(7);

        $query = static fn () => $source->table(self::SOURCE_TABLE)
            ->whereNotNull('login_at')
            ->where('login_at', '>=', $effectiveSince->toDateTimeString())
            ->where('login_at', '<=', $now->toDateTimeString());

        try {
            $requestedCount = $source->table(self::SOURCE_TABLE)
                ->whereNotNull('login_at')
                ->where('login_at', '>=', $requestedSince->toDateTimeString())
                ->where('login_at', '<=', $now->toDateTimeString())
                ->count();
            $eligibleCount = $query()->count();

            $this->newLine();
            $this->info('=== BACKFILL LARAVEL PULSE ===');
            $this->table(['Parametro', 'Valore'], [
                ['Database sorgente', $source->getDatabaseName()],
                ['Tabella sorgente', self::SOURCE_TABLE],
                ['Connessione sorgente', self::SOURCE_CONNECTION],
                ['Database Pulse', $pulseDb->getDatabaseName()],
                ['Connessione Pulse', $pulseConnection],
                ['Driver Pulse', $pulseDb->getDriverName()],
                ['Metrica', self::TYPE],
                ['Chiave', self::METRIC_KEY],
                ['Giorni richiesti', (string) $days],
                ['Da (UTC)', $effectiveSince->toDateTimeString()],
                ['A (UTC)', $now->toDateTimeString()],
                ['Login nel periodo richiesto', (string) $requestedCount],
                ['Login importabili (massimo 7 giorni)', (string) $eligibleCount],
            ]);

            if ($days > 7) {
                $this->warn('Pulse 1.x standard aggrega al massimo 7 giorni: i login più vecchi non verranno salvati.');
            }

            $this->showTableCounts($pulseDb, 'PRIMA');

            if ($this->option('dry-run')) {
                $this->info('Dry-run completato: nessuna modifica.');
                return self::SUCCESS;
            }

            if (! $this->option('force') && ! $this->confirm('Ricostruire la metrica user_login?', false)) {
                $this->warn('Operazione annullata.');
                return self::SUCCESS;
            }

            $lock = Cache::lock('user:pulse-backfill-logins', 3600);
            if (! $lock->get()) {
                $this->error('Un altro backfill è già in esecuzione.');
                return self::FAILURE;
            }

            try {
                $processed = 0;
                // IMPORTANTE: sospendere il recorder live di user_login durante la ricostruzione.
                // La transazione è sulla stessa connessione usata da DatabaseStorage.
                $pulseDb->transaction(function () use ($storage, $query, $chunk, &$processed): void {
                    $storage->purge([self::TYPE]);

                    $query()->chunkById($chunk, function ($logs) use ($storage, &$processed): void {
                        $entries = new \Illuminate\Support\Collection();

                        foreach ($logs as $log) {
                            $loginAt = $log->login_at ?? null;

                            if (! $loginAt instanceof \DateTimeInterface && ! is_string($loginAt)) {
                                continue;
                            }

                            $timestamp = CarbonImmutable::parse($loginAt, 'UTC')->getTimestamp();
                            $entries->push(
                                (new Entry($timestamp, self::TYPE, self::METRIC_KEY))
                                    ->count()
                                    ->onlyBuckets()
                            );
                        }

                        if ($entries->isEmpty()) {
                            return;
                        }

                        // Chiamata diretta: gli errori dello storage NON vengono silenziati da Pulse::rescue().
                        $storage->store($entries);
                        $processed += $entries->count();
                        $this->line("Login elaborati: {$processed}");
                    }, 'id');
                }, 1);

                $this->info("Backfill completato: {$processed} login elaborati.");
                $this->showTableCounts($pulseDb, 'DOPO');
                $this->verifyAggregates($source, $pulseDb, $now, $effectiveSince);

                return self::SUCCESS;
            } finally {
                $lock->release();
            }
        } catch (Throwable $e) {
            $this->error('Backfill fallito: '.get_class($e).': '.$e->getMessage());
            if ($this->output->isVerbose()) {
                $this->line($e->getTraceAsString());
            }
            return self::FAILURE;
        }
    }

    private function showTableCounts(ConnectionInterface $db, string $phase): void
    {
        $this->newLine();
        $this->info("=== TABELLE PULSE {$phase} ===");
        $rows = [];
        foreach (['pulse_entries', 'pulse_aggregates', 'pulse_values'] as $table) {
            $rows[] = [
                $db->getDatabaseName().'.'.$table,
                $db->table($table)->count(),
                $db->table($table)->where('type', self::TYPE)->count(),
            ];
        }
        $this->table(['Database.Tabella', 'Righe totali', 'Righe user_login'], $rows);
    }

    private function verifyAggregates(
        ConnectionInterface $source,
        ConnectionInterface $pulseDb,
        CarbonImmutable $importEnd,
        CarbonImmutable $effectiveSince,
    ): void {
        $this->newLine();
        $this->info('=== VERIFICA AGGREGATI PULSE ===');
        $rows = [];

        foreach (self::PERIODS as $period => $label) {
            $since = $importEnd->subMinutes($period);
            if ($effectiveSince->greaterThan($since)) {
                $since = $effectiveSince;
            }

            $expected = $source->table(self::SOURCE_TABLE)
                ->whereNotNull('login_at')
                ->where('login_at', '>=', $since->toDateTimeString())
                ->where('login_at', '<=', $importEnd->toDateTimeString())
                ->count();

            $aggregateQuery = $pulseDb->table('pulse_aggregates')
                ->where('type', self::TYPE)
                ->where('key', self::METRIC_KEY)
                ->where('aggregate', 'count')
                ->where('period', $period);

            $actual = (int) (clone $aggregateQuery)->sum('value');
            $rows[] = [
                $label,
                $period,
                (clone $aggregateQuery)->count(),
                $expected,
                $actual,
                $expected === $actual ? 'OK' : 'DIFFERENZA',
            ];
        }

        $this->table(
            ['Periodo', 'Minuti', 'Righe Pulse', 'Login sorgente', 'Login Pulse', 'Esito'],
            $rows
        );
        $this->line('Database: '.$pulseDb->getDatabaseName());
        $this->line('Tabella: pulse_aggregates');
        $this->warn('I confini delle finestre sono calcolati da Pulse al momento dello store: differenze marginali sono possibili vicino ai confini.');
    }
}
