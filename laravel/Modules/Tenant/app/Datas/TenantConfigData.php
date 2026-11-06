<?php

declare(strict_types=1);

namespace Modules\Tenant\Datas;

use Modules\Tenant\Filament\Pages\SettingPage;
use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/**
 * Impostazioni di identita' del tenant corrente: il file `metatag` (`config/{tenant}/metatag.php`).
 *
 * Il file lo legge `Modules\Xot\Datas\MetatagData::make()` (il lettore vivo: nome del brand nei pannelli Filament, nel `<head>`
 * di Cms e nei dati strutturati; altezza del logo nei pannelli). Questa Data non lo sostituisce: espone al form solo le chiavi
 * con un lettore vivo e che non possono rompere nulla, con gli stessi default di `MetatagData` (un test li confronta, cosi' non
 * divergono). Il merge di `SaveTenantConfigAction` conserva le altre chiavi del file.
 *
 * Fuori dalla pagina, di proposito:
 * - `description`: `MetatagData::make()` la sostituisce con la traduzione `metatag.description` del tenant
 *   (`config/{tenant}/lang/{lingua}/metatag.php`), quindi un valore salvato nel file non verrebbe mai letto;
 * - `sitename`, `subtitle`, `keywords`, `author`: li leggono solo le viste legacy `cms::components.metatags` e `ui::metatags`
 *   (`ThemeComposer::metatags()`), che nessun layout di questo repository include;
 * - `logo_header`, `logo_header_dark`, `favicon`: sono percorsi che `AssetAction` risolve e copia in `public/`, senza
 *   protezione da `..`; come testo libero sarebbero una superficie di scrittura, servirebbe una Select di asset noti;
 * - `colors`: li modifica gia' la `MetatagPage` di Xot e un esadecimale sbagliato colpisce ogni pannello;
 * - nessun interruttore sulla risoluzione del tenant: il tenant si sceglie da `SERVER_NAME` e dalle cartelle di `config/`
 *   (`GetTenantNameAction`) prima che questo file esista, quindi non puo' essere spento da qui e non deve poterlo essere.
 *
 * @see SettingPage
 */
class TenantConfigData extends Data
{
    use MakesFromTenantConfig;

    /** Nome del brand: pannelli Filament, `<title>` e `og:site_name` di Cms (dopo la traduzione del tema), dati strutturati. */
    public string $title = '';

    /** Altezza del logo nei pannelli Filament (lunghezza CSS). */
    public string $logo_height = '2em';

    public static function tenantConfigName(): string
    {
        return 'metatag';
    }
}
