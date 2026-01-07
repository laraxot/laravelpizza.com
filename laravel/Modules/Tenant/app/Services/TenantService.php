<?php

declare(strict_types=1);

namespace Modules\Tenant\Services;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
use Modules\Tenant\Actions\Config\GetTenantConfigNamesAction;
use Modules\Tenant\Actions\Config\GetTenantConfigPathAction;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Actions\Models\ResolveTenantModelClassAction;
use Modules\Tenant\Actions\Models\ResolveTenantModelInstanceAction;
use Modules\Tenant\Actions\Modules\GetTenantModulesAction;
use Modules\Tenant\Actions\Translations\TranslateTenantKeyAction;
use ReflectionException;

/**
 * TenantService - Facade sottile per operazioni tenant-aware.
 *
 * Questo service funge da facade centralizzata che delega tutta la business logic
 * a Actions dedicate (Spatie QueueableAction), seguendo il pattern architetturale Laraxot.
 *
 * Pattern: Service Locator / Facade Pattern
 * - API pubblica stabile e leggibile
 * - Business logic delegata alle Actions
 * - Facilita test, refactor e queue/offload
 *
 * @see \Modules\Tenant\docs\configuration.md Per dettagli architetturali
 */
class TenantService
{
    /**
     * Ottiene il nome del tenant corrente basato sul server name.
     *
     * @return string Il nome del tenant identificato
     */
    public static function getName(): string
    {
        return app(GetTenantNameAction::class)->execute();
    }

    /**
     * Costruisce il percorso completo per un file tenant-specific.
     *
     * @param  string  $filename  Nome del file relativo alla directory tenant
     * @return string Percorso completo del file
     */
    public static function filePath(string $filename): string
    {
        return app(GetTenantFilePathAction::class)->execute($filename);
    }

    /**
     * Risolve un valore di configurazione tenant-aware.
     *
     * Merge tra configurazione globale e tenant-specific, con supporto per default.
     *
     * @param  string  $key  Chiave di configurazione (es. 'app.name')
     * @param  string|int|array|null  $default  Valore di default se la chiave non esiste
     * @return float|int|string|array|null Valore risolto della configurazione
     */
    public static function config(string $key, string|int|array|null $default = null): float|int|string|array|null
    {
        return app(ResolveTenantConfigValueAction::class)->execute($key, $default);
    }

    /**
     * Ottiene il percorso del file di configurazione per una chiave specifica.
     *
     * @param  string  $key  Chiave di configurazione
     * @return string Percorso completo del file di configurazione
     */
    public static function getConfigPath(string $key): string
    {
        return app(GetTenantConfigPathAction::class)->execute($key);
    }

    /**
     * Carica un intero array di configurazione tenant-specific.
     *
     * @param  string  $name  Nome del file di configurazione (senza estensione)
     * @return array<string, mixed> Array di configurazione completo
     */
    public static function getConfig(string $name): array
    {
        return app(GetTenantConfigArrayAction::class)->execute($name);
    }

    /**
     * Salva un array di configurazione tenant-specific su file.
     *
     * @param  string  $name  Nome del file di configurazione (senza estensione)
     * @param  array<string, mixed>  $data  Dati di configurazione da salvare
     */
    public static function saveConfig(string $name, array $data): void
    {
        app(SaveTenantConfigAction::class)->execute($name, $data);
    }

    /**
     * Ottiene i nomi di tutte le configurazioni disponibili.
     *
     * @return array<int, array{id: int, name: string}>
     */
    public static function getConfigNames(): array
    {
        // Must add the use Modules\Tenant\Actions\Config\GetTenantConfigNamesAction;
        return app(GetTenantConfigNamesAction::class)->execute();
    }

    /**
     * Risolve il nome completo della classe di un modello tenant-aware.
     *
     * @param  string  $name  Nome breve del modello (es. 'user', 'patient')
     * @return string|null Nome completo della classe o null se non trovato
     */
    public static function modelClass(string $name): ?string
    {
        return app(ResolveTenantModelClassAction::class)->execute($name);
    }

    /**
     * Risolve e restituisce un'istanza di modello tenant-aware.
     *
     * @param  string  $name  Nome breve del modello (es. 'user', 'patient')
     * @return Model Istanza del modello risolto
     *
     * @throws ReflectionException Se la classe del modello non può essere istanziata
     */
    public static function model(string $name): Model
    {
        return app(ResolveTenantModelInstanceAction::class)->execute($name);
    }

    /**
     * Traduce una chiave di traduzione nel contesto tenant corrente.
     *
     * @param  string  $key  Chiave di traduzione (es. 'common.welcome')
     * @return string Stringa tradotta o la chiave stessa se la traduzione non esiste
     */
    public static function trans(string $key): string
    {
        return app(TranslateTenantKeyAction::class)->execute($key);
    }

    /**
     * Ottiene tutti i moduli abilitati per il tenant corrente.
     *
     * @return array<int, string> Array di nomi moduli abilitati
     */
    public static function allModules(): array
    {
        return app(GetTenantModulesAction::class)->execute();
    }
}
