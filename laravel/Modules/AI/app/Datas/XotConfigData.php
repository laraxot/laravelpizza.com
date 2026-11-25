<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Modules\Xot\Filament\Pages\SettingPage;
use Spatie\LaravelData\Data;

/**
 * Impostazioni di Xot, nel file tenant `config/{tenant}/xra.php` (quello che legge `XotData::make()`).
 *
 * Ogni proprieta' ha un lettore in produzione e il default di `XotData`, che resta l'unico runtime:
 * un sito che non salva nulla si comporta come prima (lo garantisce `XotConfigDataTest`).
 *
 * Esclusi di proposito:
 * - `pub_theme`, `register_pub_theme`: sono di Cms (`CmsConfigData`), che li scrive nello stesso file.
 * - `adm_theme`: nei tenant vale `AdminLTE`, un tema non installato, quindi non c'e' una scelta valida da offrire.
 * - `super_admin`: assegna privilegi, non si cambia da un form.
 * - `show_trans_key`, `login_verified`, `register_type`, `verification_type`, `search_action`,
 *   `disable_frontend_dynamic_route`, `disable_admin_dynamic_route`: dichiarate in `XotData` ma lette da nessuno.
 *
 * @see SettingPage
 */
class XotConfigData extends Data
{
    use MakesFromTenantConfig;

    /** Modulo il cui pannello e' quello predefinito (`XotBasePanelProvider`) e che da' il nome alle chiavi di traduzione. */
    public string $main_module = '';

    /** Lingua dei contenuti CMS quando manca la traduzione nella lingua corrente (`Cms\View\Components\PageContent`). */
    public string $primary_lang = 'it';

    /** Forza lo schema https negli URL generati (`XotServiceProvider::redirectSSL`); ignorato su localhost. */
    public bool $force_ssl = false;

    /** Disattiva la campanella delle notifiche nel pannello (`Notify\AdminPanelProvider`). */
    public bool $disable_database_notifications = true;

    public static function tenantConfigName(): string
    {
        return 'xra';
    }
}
