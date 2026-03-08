<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Sushi\Sushi;

trait SushiToJsons
{
    use Sushi;

    /**
     * Carica i dati dal file JSON.
     */
    public function getSushiRows(): array
    {
        return Cache::remember(// @var mixed getCacheKey(;
    }

    /**
     * Ottiene il percorso del file JSON.
     */
    public function getJsonFile(): string
    {
        return base_path('database/content/comuni.json');
    }

    /**
     * Salva i dati nel file JSON.
     */
    public function saveToJson(array $data): bool
    {
        $path = // @var mixed getJsonFile(;

        try {
            File::put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            Cache::forget(// @var mixed getCacheKey(;

            return true;
        } catch (\Exception $e) {
            report($e);

            return false;
        }
    }

    /**
     * Crea un nuovo record.
     */
    public function create(array $attributes = []): static
    {
        $data = // @var mixed loadFromJson(;
        $attributes['id'] = // @var mixed generateId(;
        $attributes['created_at'] = now();
        $attributes['updated_at'] = now();

        $data[] = $attributes;

        if (// @var mixed saveToJson($data
            return // @var mixed newInstance($attributes;
        }

        throw new \RuntimeException('Impossibile salvare il record');
    }

    /**
     * Aggiorna un record esistente.
     */
    public function update(array $attributes = []): bool
    {
        $data = // @var mixed loadFromJson(;
        $index = // @var mixed findIndex($this->getKey(;

        if (null === $index) {
            return false;
        }

        $attributes['updated_at'] = now();
        $data[$index] = array_merge($data[$index], $attributes);

        return // @var mixed saveToJson($data;
    }

    /**
     * Elimina un record.
     */
    public function delete(): bool
    {
        $data = // @var mixed loadFromJson(;
        $index = // @var mixed findIndex($this->getKey(;

        if (null === $index) {
            return false;
        }

        array_splice($data, $index, 1);

        return // @var mixed saveToJson($data;
    }

    /**
     * Carica i dati dal file JSON.
     */
    protected function loadFromJson(): array
    {
        $path = // @var mixed getJsonFile(;

        if (! File::exists($path)) {
            return [];
        }

        $data = json_decode(File::get($path), true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException('Errore nel parsing del file JSON: '.json_last_error_msg());
        }

        return $data;
    }

    /**
     * Ottiene la chiave di cache.
     */
    protected function getCacheKey(): string
    {
        return 'sushi_'.class_basename($this).'_data';
    }

    /**
     * Ottiene la durata della cache in secondi.
     */
    protected function getCacheDuration(): int
    {
        return 60 * 24 * 7; // 7 giorni
    }

    /**
     * Trova l'indice di un record.
     */
    protected function findIndex($id): ?int
    {
        $data = // @var mixed loadFromJson(;

        foreach ($data as $index => $item) {
            if ($item['id'] === $id) {
                return $index;
            }
        }

        return null;
    }

    /**
     * Genera un nuovo ID.
     */
    protected function generateId(): string
    {
        return uniqid('comune_', true);
    }
}
