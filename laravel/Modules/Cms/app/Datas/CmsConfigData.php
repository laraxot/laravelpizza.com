<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Modules\Cms\Filament\Pages\SettingPage;
use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/**
 * Impostazioni di Cms del tenant corrente.
 *
 * Il tema pubblico vive nel file `xra` del tenant (`config/{tenant}/xra.php`), che `XotData`
 * legge per tutto il resto del progetto: salvarlo in un `cms.php` non cambierebbe il tema
 * effettivo. Per questo `tenantConfigName()` punta a `xra`; il merge di `SaveTenantConfigAction`
 * conserva le altre chiavi del file.
 *
 * Fuori dalla pagina, di proposito: `primary_lang` (e' di Xot, `XotConfigData`, che scrive lo stesso file),
 * `page_middleware_allowlist` e `container0_models`
 * (superficie di sicurezza, restano nel config del modulo) e `adm_theme` (nessuno registra
 * il namespace `adm_theme` e le Action che lo leggono non hanno chiamanti).
 *
 * @see SettingPage
 */
class CmsConfigData extends Data
{
    use MakesFromTenantConfig;

    /** Tema del front office: una cartella di `Themes/` (letto da `XotData::make()->pub_theme`). */
    public string $pub_theme = '';

    /** Registra viste e traduzioni del tema pubblico (letto da `CmsServiceProvider`, default di `XotData`). */
    public bool $register_pub_theme = false;

    public static function tenantConfigName(): string
    {
        return 'xra';
    }
}
