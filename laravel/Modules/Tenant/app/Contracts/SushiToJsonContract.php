<?php

declare(strict_types=1);

namespace Modules\Tenant\Contracts;

/**
 * Contratto per modelli che usano il trait SushiToJson.
 * Permette a PHPStan di risolvere i metodi del trait nelle closure di boot.
 *
 * @see \Modules\Tenant\Models\Traits\SushiToJson
 */
interface SushiToJsonContract
{
    /**
     * Ottiene il percorso del file JSON per il modello corrente.
     */
    public function getJsonFile(): string;

    /**
     * Carica i dati esistenti dal file JSON.
     *
     * @return array<int, array<string, mixed>>
     */
    public function loadExistingData(): array;

    /**
     * Ottiene l'ID dell'utente autenticato per i campi di audit.
     */
    public function authId(): int|string|null;

    /**
     * Assicura che la directory per il file JSON esista.
     */
    public function ensureDirectoryExists(string $filePath): void;

    /**
     * Salva i dati nel file JSON.
     *
     * @param  array<int, array<string, mixed>>  $data
     */
    public function saveToJson(array $data): bool;

    /**
     * Trova l'indice del record nell'array dato un id.
     *
     * @param  array<int, array<string, mixed>>  $rows
     */
    public function findRowIndexById(array $rows, int $id): ?int;
}
