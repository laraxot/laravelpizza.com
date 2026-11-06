<?php

declare(strict_types=1);

namespace Modules\Job\Datas;

use Modules\Job\Actions\BuildQueueWorkerCommandAction;
use Modules\Job\Filament\Pages\SettingPage;
use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/**
 * Impostazioni di Job del tenant corrente: come `worker:check` avvia il worker della coda.
 *
 * I tre valori erano scritti nel comando (`queue:work --timeout=60 --sleep=5 --tries=3`) e restano
 * i default: finche' nessuno salva, il comando e' identico a prima.
 *
 * Fuori dalla pagina, di proposito: `cache.enabled|store|key` (letti come `job::cache.*`, chiavi che
 * non esistono; il livello di cache non ha chiamanti, vedi la story) e `jobs.pruning.*` (nessun
 * comando di prune sul modello). Un flag `enabled` non avrebbe nessun lettore.
 *
 * @see SettingPage
 * @see BuildQueueWorkerCommandAction
 */
class JobConfigData extends Data
{
    use MakesFromTenantConfig;

    /** `--tries`: tentativi per job prima di finire in `failed_jobs`. */
    public int $max_attempts = 3;

    /** `--timeout`: secondi massimi di un job; deve restare sotto `retry_after` della connessione. */
    public int $timeout_seconds = 60;

    /** `--sleep`: secondi di attesa quando la coda e' vuota. */
    public int $sleep_seconds = 5;
}
