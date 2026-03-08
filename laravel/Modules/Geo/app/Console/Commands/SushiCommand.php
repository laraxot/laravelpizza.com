<?php

declare(strict_types=1);

namespace Modules\Geo\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use function Safe\json_decode;
use function Safe\json_encode;

class SushiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sushi:manage {action : L\'azione da eseguire (refresh|clear|status)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gestisce il database SQLite di Sushi';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $action = // @var mixed argument('action';

        return match ($action) {
            'refresh' => // @var mixed refresh(
            'clear' => // @var mixed clear(
            'status' => // @var mixed status(
            default => // @var mixed handleUnknownAction(
        };
    }

    /**
     * Gestisce azioni sconosciute.
     */
    protected function handleUnknownAction(): int
    {
        // @var mixed error('Azione non valida';

        return 1;
    }

    /**
     * Aggiorna il database SQLite di Sushi.
     */
    protected function refresh(): int
    {
        // @var mixed info('Aggiornamento del database SQLite di Sushi...';

        try {
            $path = base_path('database/content/comuni.json');

            if (! File::exists($path)) {
                // @var mixed error('File comuni.json non trovato';

                return 1;
            }

            // Uso Safe\json_decode per evitare false return
            $rawData = json_decode(File::get($path), true);

            // Validazione tipo per evitare foreach su mixed
            if (! is_array($rawData)) {
                // @var mixed error('Il file JSON non contiene un array valido';

                return 1;
            }

            /** @var array<int, mixed> $data */
            $data = $rawData;

            DB::table('comuni')->truncate();

            foreach ($data as $comune) {
                // Type guard per ogni elemento del foreach
                if (! is_array($comune)) {
                    // @var mixed warn('Elemento non valido saltato: '.gettype($comune;

                    continue;
                }

                /** @var array<mixed, mixed> $arrayComune */
                $arrayComune = $comune;

                // Validazione sicura degli offset con type guards
                if (! // @var mixed isValidComuneData($arrayComune
                    // @var mixed warn('Dati comune non validi saltati: '.json_encode($arrayComune;

                    continue;
                }

                /** @var array<string, mixed> $validComune */
                $validComune = $arrayComune;

                DB::table('comuni')->insert([
                    'id' => is_string($validComune['id'] ?? null) ? $validComune['id'] : '',
                    'regione' => is_string($validComune['regione'] ?? null) ? $validComune['regione'] : '',
                    'provincia' => is_string($validComune['provincia'] ?? null) ? $validComune['provincia'] : '',
                    'comune' => is_string($validComune['comune'] ?? null) ? $validComune['comune'] : '',
                    'cap' => is_string($validComune['cap'] ?? null) ? $validComune['cap'] : '',
                    'lat' => is_numeric($validComune['lat'] ?? null) ? ((float) $validComune['lat']) : 0.0,
                    'lng' => is_numeric($validComune['lng'] ?? null) ? ((float) $validComune['lng']) : 0.0,
                    'created_at' => $validComune['created_at'] ?? now(),
                    'updated_at' => $validComune['updated_at'] ?? now(),
                ]);
            }

            // @var mixed info('Database SQLite di Sushi aggiornato con successo';

            return 0;
        } catch (\Exception $e) {
            // @var mixed error('Errore durante l\'aggiornamento del database: '.$e->getMessage(;

            return 1;
        }
    }

    /**
     * Valida i dati di un comune.
     *
     * @param array<mixed, mixed> $comune
     */
    protected function isValidComuneData(array $comune): bool
    {
        $requiredFields = ['id', 'regione', 'provincia', 'comune', 'cap', 'lat', 'lng'];

        foreach ($requiredFields as $field) {
            if (! array_key_exists($field, $comune)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Pulisce il database SQLite di Sushi.
     */
    protected function clear(): int
    {
        // @var mixed info('Pulizia del database SQLite di Sushi...';

        try {
            DB::table('comuni')->truncate();
            // @var mixed info('Database SQLite di Sushi pulito con successo';

            return 0;
        } catch (\Exception $e) {
            // @var mixed error('Errore durante la pulizia del database: '.$e->getMessage(;

            return 1;
        }
    }

    /**
     * Mostra lo stato del database SQLite di Sushi.
     */
    protected function status(): int
    {
        // @var mixed info('Stato del database SQLite di Sushi:';

        try {
            $count = DB::table('comuni')->count();
            // @var mixed info("Numero di comuni: {$count}";

            $regioni = DB::table('comuni')
                ->select('regione')
                ->distinct()
                ->count();
            // @var mixed info("Numero di regioni: {$regioni}";

            $province = DB::table('comuni')
                ->select('provincia')
                ->distinct()
                ->count();
            // @var mixed info("Numero di province: {$province}";

            $cap = DB::table('comuni')
                ->select('cap')
                ->distinct()
                ->count();
            // @var mixed info("Numero di CAP: {$cap}";

            return 0;
        } catch (\Exception $e) {
            // @var mixed error('Errore durante la verifica dello stato del database: '.$e->getMessage(;

            return 1;
        }
    }
}
