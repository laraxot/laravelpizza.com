<?php

/**
 * Trait SushiToJsons.
 *
 * Questo trait permette ai modelli di utilizzare il pacchetto Sushi per leggere
 * dati da file JSON con isolamento per tenant. Ogni tenant ha i propri file JSON
 * nella directory config/{tenant_name}/database/content/.
 *
 * @see https://dev.to/hasanmn/automatically-update-createdby-and-updatedby-in-laravel-using-bootable-traits-28g9.
 *
 * @method string getJsonFile() Ottiene il percorso del file JSON per il modello corrente
 * @method array<int, array<string, mixed>> getSushiRows() Ottiene i dati dal file JSON per il modello Sushi
 */

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;
use Modules\Tenant\Contracts\SushiToJsonsContract;
use Modules\Tenant\Services\TenantService;
use Sushi\Sushi;

use function Safe\json_encode;
use function Safe\unlink;

trait SushiToJsons
{
    use Sushi;

    public function getJsonFile(): string
    {
        $tbl = $this->getTable();
        $id = $this->getKey();

        $stringId = is_string($id) || is_numeric($id) ? (string) $id : 'unknown';
        $stringTbl = is_string($tbl) ? $tbl : 'unknown';

        $filename = 'database/content/'.$stringTbl.'/'.$stringId.'.json';

        return TenantService::filePath($filename);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getSushiRows(): array
    {
        $tbl = $this->getTable();
        $path = TenantService::filePath('database/content/'.$tbl);

        $files = File::glob($path.'/*.json');

        /** @var array<int, array<string, mixed>> $rows */
        $rows = [];

        foreach ($files as $id => $file) {
            if (! is_string($file)) {
                continue;
            }

            $json = File::json($file);

            /** @var array<string, mixed> $item */
            $item = [];

            // Ensure schema is an array
            $schema = $this->schema ?? [];

            /** @var array<string, mixed> $schema */
            foreach ($schema as $name => $type) {
                $value = $json[$name] ?? null;
                if (is_array($value)) {
                    $value = json_encode($value, JSON_PRETTY_PRINT);
                }
                $item[$name] = $value;
            }
            $rows[] = $item;
        }

        return $rows;
    }

    /**
     * @return ?string
     */
    public function getConnectionName()
    {
        return parent::getConnectionName();
    }

    /**
     * bootUpdater function.
     */
    protected static function bootSushiToJsons(): void
    {
        /*
         * During a model create Eloquent will also update the updated_at field so
         * need to have the updated_by field here as well.
         */
        static::creating(function ($model): void {
            if (! $model instanceof Model) {
                throw new InvalidArgumentException('Model must be an instance of Illuminate\Database\Eloquent\Model');
            }
            if (! $model instanceof SushiToJsonsContract) {
                throw new InvalidArgumentException('Model must implement '.SushiToJsonsContract::class);
            }
            /** @var Model&SushiToJsonsContract $model */

            // PHPStan Level 10: Type-safe max() call
            $maxId = $model->max('id');
            $newId = is_numeric($maxId) ? (int) $maxId + 1 : 1;

            // PHPStan Level 10: Use setAttribute for type safety
            $model->setAttribute('id', $newId);
            $model->setAttribute('updated_at', now());
            $model->setAttribute('updated_by', authId());
            $model->setAttribute('created_at', now());
            $model->setAttribute('created_by', authId());

            /** @var array<string, mixed> $data */
            $data = $model->toArray();
            $item = [];

            // PHPStan Level 10: Type-safe schema access
            if (! isset($model->schema) || ! is_iterable($model->schema)) {
                throw new Exception('Schema property must be iterable');
            }

            /** @var iterable<string, mixed> $schema */
            $schema = $model->schema;
            foreach ($schema as $name => $type) {
                $value = $data[$name] ?? null;
                $item[$name] = $value;
            }

            $content = json_encode($item, JSON_PRETTY_PRINT);

            $file = $model->getJsonFile();
            $dir = \dirname($file);

            if (! File::exists($dir)) {
                File::makeDirectory($dir, 0o755, true, true);
            }
            File::put($file, $content);
        });
        /*
         * updating.
         */
        static::updating(function ($model): void {
            if (! $model instanceof Model) {
                throw new InvalidArgumentException('Model must be an instance of Illuminate\Database\Eloquent\Model');
            }
            if (! $model instanceof SushiToJsonsContract) {
                throw new InvalidArgumentException('Model must implement '.SushiToJsonsContract::class);
            }
            /** @var Model&SushiToJsonsContract $model */
            $file = $model->getJsonFile();
            $model->setAttribute('updated_at', now());
            $model->setAttribute('updated_by', authId());

            $content = $model->toJson(JSON_PRETTY_PRINT);

            File::put($file, $content);
        });
        // -------------------------------------------------------------------------------------
        /*
         * Deleting a model is slightly different than creating or deleting.
         * For deletes we need to save the model first with the deleted_by field
         */

        static::deleting(function ($model): void {
            if (! $model instanceof Model) {
                throw new InvalidArgumentException('Model must be an instance of Illuminate\Database\Eloquent\Model');
            }
            if (! $model instanceof SushiToJsonsContract) {
                throw new InvalidArgumentException('Model must implement '.SushiToJsonsContract::class);
            }
            /** @var Model&SushiToJsonsContract $model */
            $file = $model->getJsonFile();
            unlink($file);
        });

        // ----------------------
    }

    // end function boot
}

// end trait Updater
