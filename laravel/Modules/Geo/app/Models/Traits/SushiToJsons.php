<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

use function Safe\json_decode;
use function Safe\json_encode;

use Sushi\Sushi;

/** @phpstan-ignore trait.unused */
trait SushiToJsons
{
    use Sushi;

    /**
     * Carica i dati dal file JSON.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getSushiRows(): array
    {
        return Cache::remember($this->getCacheKey(), $this->getCacheDuration(), fn (): array => $this->loadFromJson());
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
     *
     * @param array<int, array<string, mixed>> $data
     */
    public function saveToJson(array $data): bool
    {
        $path = $this->getJsonFile();

        try {
            File::put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            Cache::forget($this->getCacheKey());

            return true;
        } catch (\Exception $e) {
            report($e);

            return false;
        }
    }

    /**
     * Crea un nuovo record.
     *
     * @param array<string, mixed> $attributes
     */
    public function create(array $attributes = []): static
    {
        $data = $this->loadFromJson();
        $attributes['id'] = $this->generateId();
        $attributes['created_at'] = now();
        $attributes['updated_at'] = now();

        $data[] = $attributes;

        if ($this->saveToJson($data)) {
            return $this->newInstance($attributes);
        }

        throw new \RuntimeException('Impossibile salvare il record');
    }

    /**
     * Aggiorna un record esistente.
     *
     * @param array<string, mixed> $attributes
     */
    public function update(array $attributes = [], array $options = []): bool
    {
        $data = $this->loadFromJson();
        $index = $this->findIndex($this->getKey());

        if (null === $index) {
            return false;
        }

        $attributes['updated_at'] = now();
        $itemData = $data[$index];
        if (! is_array($itemData)) {
            return false;
        }
        /* @var array<string, mixed> $itemData */
        $data[$index] = array_merge($itemData, $attributes);

        return $this->saveToJson($data);
    }

    /**
     * Elimina un record.
     */
    public function delete(): bool
    {
        $data = $this->loadFromJson();
        $index = $this->findIndex($this->getKey());

        if (null === $index) {
            return false;
        }

        array_splice($data, $index, 1);

        return $this->saveToJson($data);
    }

    /**
     * Carica i dati dal file JSON.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function loadFromJson(): array
    {
        $path = $this->getJsonFile();

        if (! File::exists($path)) {
            return [];
        }

        $content = File::get($path);
        if (! is_string($content)) {
            return [];
        }
        $data = json_decode($content, true);
        if (! is_array($data)) {
            return [];
        }

        /** @var array<int, array<string, mixed>> $result */
        $result = $data;

        return $result;
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
    protected function findIndex(mixed $id): ?int
    {
        $data = $this->loadFromJson();

        foreach ($data as $index => $item) {
            if (is_array($item) && array_key_exists('id', $item) && $item['id'] === $id) {
                /* @var int $index */
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
