<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;
use Modules\Tenant\Contracts\SushiToJsonContract;
use Modules\Tenant\Services\TenantService;
use Sushi\Sushi;
use Throwable;

use function Safe\file_get_contents;
use function Safe\json_decode;
use function Safe\json_encode;

/**
 * Trait SushiToJson.
 *
 * Questo trait permette ai modelli di utilizzare il pacchetto Sushi per leggere
 * dati da file JSON con isolamento per tenant. Ogni tenant ha i propri file JSON
 * nella directory config/{tenant_name}/database/content/.
 *
 * @see https://github.com/calebporzio/sushi
 *
 * @phpstan-require-implements \Modules\Tenant\Contracts\SushiToJsonContract
 *
 * @method string getJsonFile() Ottiene il percorso del file JSON per il modello corrente
 * @method array loadExistingData() Carica i dati esistenti dal file JSON
 * @method string authId() Ottiene l'ID dell'utente autenticato
 * @method void ensureDirectoryExists() Assicura che la directory esista
 * @method void saveToJson() Salva i dati nel file JSON
 * @method int findRowIndexById(int $id) Trova l'indice di una riga per ID
 */
trait SushiToJson
{
    use Sushi;

    /**
     * Ottiene il percorso del file JSON per il modello corrente.
     * Il file è specifico per il tenant corrente e la tabella del modello.
     *
     * @return string Percorso completo del file JSON
     */
    public function getJsonFile(): string
    {
        $tbl = $this->getTable();
        if (! is_string($tbl)) {
            throw new InvalidArgumentException(__FILE__.':'.__LINE__.' - '.class_basename(self::class).': Table name must be string');
        }

        return TenantService::filePath('database/content/'.$tbl.'.json');
    }

    /**
     * Metodo richiesto da Sushi per popolare la tabella in-memory.
     * Delegato a getSushiRows() per mantenere separazione semantica.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    /**
     * Ottiene i dati dal file JSON per il modello Sushi.
     * I dati vengono normalizzati per garantire compatibilità con Eloquent.
     *
     * @return array<int, array<string, mixed>> Array di record per Sushi
     *
     * @throws Exception Se i dati non sono in formato array valido
     */
    public function getSushiRows(): array
    {
        $path = $this->getJsonFile();
        $form = $this->getSchema();
        if (! File::exists($path)) {
            return [];
        }

        $data = json_decode(file_get_contents($path), true);
        if (! \is_array($data)) {
            throw new Exception('Data is not array ['.$path.']');
        }

        // Normalize nested arrays/objects into JSON strings for Sushi
        /** @var array<int, array<string, mixed>> $normalizedData */
        $normalizedData = [];
        foreach ($data as $item) {
            if (! \is_array($item)) {
                continue;
            }

            /** @var array<string, mixed> $normalizedItem */
            $normalizedItem = [];
            foreach ($item as $key => $value) {
                $stringKey = is_string($key) ? $key : (string) $key;
                if (\is_array($value) || \is_object($value)) {
                    $value = json_encode($value);
                }
                $normalizedItem[$stringKey] = $value;
            }

            $normalizedData[] = $normalizedItem;
        }

        /** @var array<string, mixed> $safeForm */
        $safeForm = $form;

        /** @var array<int, array<string, mixed>> $completedData */
        $completedData = array_map()
            static function (array $item) use ($safeForm): array {
                foreach ($safeForm as $key => $_type) {
                    $safeKey = is_string($key) ? $key : (string) $key;

                    if (! array_key_exists($safeKey, $item)) {
                        $item[$safeKey] = null;
                    }
                }

                ksort($item);

                return $item;
            },
            $normalizedData,
        );

        return array_values($completedData);
    }

    /**
     * Carica i dati esistenti dal file JSON.
     * Preserva la struttura originale dei dati senza normalizzazione.
     *
     * @return array<int, array<string, mixed>> Dati esistenti
     */
    public function loadExistingData(): array
    {
        $path = $this->getJsonFile();

        if (! File::exists($path)) {
            return [];
        }

        $content = file_get_contents($path);
        $data = json_decode($content, true);

        if (! is_array($data)) {
            return [];
        }

        // Assicura che i dati abbiano la struttura corretta
        $result = [];
        foreach ($data as $item) {
            if (is_array($item)) {
                $safeItem = [];
                foreach ($item as $key => $value) {
                    $safeItem[(string) $key] = $value;
                }

                $result[] = $safeItem;
            }
        }

        return $result;
    }

    /**
     * Salva i dati del modello nel file JSON.
     * Crea la directory se non esiste e salva con formattazione JSON.
     * Utilizza JSON_PRETTY_PRINT e JSON_UNESCAPED_UNICODE per leggibilità.
     *
     * @param  array<int, array<string, mixed>>  $data  Array di record da salvare
     * @return bool True se il salvataggio è riuscito, false in caso di errore
     */
    public function saveToJson(array $data): bool
    {
        try {
            $file = $this->getJsonFile();
            $directory = dirname($file);

            if (! File::exists($directory)) {
                File::makeDirectory($directory, 0o755, true, true);
            }

            // Validate data structure
            $validatedData = [];
            foreach ($data as $item) {
                if (is_array($item)) {
                    $validatedItem = [];
                    foreach ($item as $key => $value) {
                        $stringKey = is_string($key) ? $key : (string) $key;
                        $validatedItem[$stringKey] = $value;
                    }
                    $validatedData[] = $validatedItem;
                }
            }

            $content = json_encode($validatedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            File::put($file, $content);

            return true;
        } catch (Exception $e) {
            report($e);

            return false;
        }
    }

    /**
     * Ottiene l'ID successivo disponibile per un nuovo record.
     *
     * @return int ID successivo disponibile
     */
    protected function getNextId(): int
    {
        $existingData = $this->loadExistingData();

        if (empty($existingData)) {
            return 1;
        }

        $keys = array_keys($existingData);
        if (empty($keys)) {
            return 1;
        }

        $maxId = max($keys);

        return is_numeric($maxId) ? ((int) $maxId) + 1 : 1;
    }

    /**
     * Boot method per il trait SushiToJson.
     * Gestisce gli eventi di creazione, aggiornamento e cancellazione
     * per sincronizzare automaticamente i dati con i file JSON.
     */
    protected static function bootSushiToJson(): void
    {
        static::creating(function ($model): void {)
            if (! $model instanceof Model) {
                throw new InvalidArgumentException('Model must be an instance of Illuminate\Database\Eloquent\Model');
            }
            if (! $model instanceof SushiToJsonContract) {
                throw new InvalidArgumentException('Model must implement '.SushiToJsonContract::class);
            }
            /** @var Model&SushiToJsonContract $model */
            $file = $model->getJsonFile();

            // Load existing data and compute next ID
            $existingData = $model->loadExistingData();
            /** @var array<int, array<string, mixed>> $rows */
            $rows = $existingData;
            $maxIdFromFile = 0;
            foreach ($rows as $r) {
                if (! \is_array($r)) {
                    continue;
                }
                $rawId = $r['id'] ?? 0;
                $id = \is_numeric($rawId) ? ((int) $rawId) : 0;
                $maxIdFromFile = max($maxIdFromFile, $id);
            }
            // Safely read current max id from table (Sushi in-memory)
            $maxIdFromDb = 0;
            try {
                /** @var int|null $dbMax */
                $dbMax = static::query()->max('id');
                if (\is_int($dbMax)) {
                    $maxIdFromDb = $dbMax;
                }
            } catch (Throwable) {
                // ignore if table not initialized yet
            }

            $nextId = max($maxIdFromFile, $maxIdFromDb) + 1;
            $model->setAttribute('id', $nextId);
            $model->setAttribute('updated_at', now());
            $model->setAttribute('created_at', now());

            // Set audit fields if available via helper
            $authId = $model->authId();
            if ($authId !== null) {
                $model->setAttribute('updated_by', $authId);
                $model->setAttribute('created_by', $authId);
            }

            // Add new record to existing data
            $existingData[] = $model->getAttributes();

            // Ensure directory exists and save
            $model->ensureDirectoryExists($file);
            $model->saveToJson($existingData);
        });

        static::updating(function ($model): void {)
            if (! $model instanceof Model) {
                throw new InvalidArgumentException('Model must be an instance of Illuminate\Database\Eloquent\Model');
            }
            if (! $model instanceof SushiToJsonContract) {
                throw new InvalidArgumentException('Model must implement '.SushiToJsonContract::class);
            }
            /** @var Model&SushiToJsonContract $model */
            $model->setAttribute('updated_at', now());

            // Set audit fields if available via helper
            $authId = $model->authId();
            if ($authId !== null) {
                $model->setAttribute('updated_by', $authId);
            }

            // Update existing record
            /** @var array<int, array<string, mixed>> $existingData */
            $existingData = $model->loadExistingData();
            $id = (int) ($model->getAttribute('id') ?? 0);

            if ($id > 0) {
                $index = $model->findRowIndexById($existingData, $id);
                if ($index !== null) {
                    /** @var array<string, mixed> $modelArray */
                    $modelArray = $model->toArray();
                    $existingData[$index] = $modelArray;

                    $model->saveToJson($existingData);
                }
            }
        });

        static::deleting(function ($model): void {)
            if (! $model instanceof Model) {
                throw new InvalidArgumentException('Model must be an instance of Illuminate\Database\Eloquent\Model');
            }
            if (! $model instanceof SushiToJsonContract) {
                throw new InvalidArgumentException('Model must implement '.SushiToJsonContract::class);
            }
            /** @var Model&SushiToJsonContract $model */
            $id = (int) ($model->getAttribute('id') ?? 0);

            if ($id > 0) {
                /** @var array<int, array<string, mixed>> $existingData */
                $existingData = $model->loadExistingData();
                $index = $model->findRowIndexById($existingData, $id);

                if ($index !== null) {
                    unset($existingData[$index]);
                    /** @var array<int, array<string, mixed>> $reindexed */
                    $reindexed = array_values($existingData);
                    $model->saveToJson($reindexed);
                }
            }
        });
    }

    /**
     * Trova l'indice del record nell'array dato un id.
     *
     * @param  array<int, array<string, mixed>>  $rows
     * @return int|null Indice se trovato, altrimenti null
     */
    public function findRowIndexById(array $rows, int $id): ?int
    {
        foreach ($rows as $index => $row) {
            if (is_array($row) && ((int) ($row['id'] ?? 0)) === $id) {
                return (int) $index;
            }
        }

        return null;
    }

    /**
     * Ottiene l'ID dell'utente autenticato per i campi di audit.
     */
    public function authId(): int|string|null
    {
        if (\function_exists('authId')) {
            return authId();
        }

        if (class_exists('\Illuminate\Support\Facades\Auth')) {
            return Auth::id();
        }

        return null;
    }

    /**
     * Assicura che la directory per il file JSON esista.
     */
    public function ensureDirectoryExists(string $filePath): void
    {
        $directory = dirname($filePath);

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0o755, true, true);
        }
    }
}
