<?php

declare(strict_types=1);

namespace Modules\Gdpr\Datas;

use Modules\Gdpr\Filament\Pages\SettingPage;
use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/**
 * Impostazioni di Gdpr del tenant corrente: `config/{tenant}/gdpr.php`.
 *
 * Si modificano dalla SettingPage del modulo (solo super-admin). I default sono i valori che
 * prima stavano in `config/config.php`: nulla cambia finche' nessuno salva. Si legge con
 * `GdprConfigData::make()` e non con `config('gdpr.config.…')`, perche' il config del modulo
 * sostituisce quel ramo e un valore del tenant non arriverebbe.
 *
 * Fuori dalla pagina, di proposito: `cookie.extra` (dichiarare un cookie non tecnico fa passare
 * il banner dall'informazione alla richiesta di consenso, lo fa il modulo che lo imposta) e i
 * testi dei consensi (contenuto legale, non preferenza).
 *
 * @see SettingPage
 */
class GdprConfigData extends Data
{
    use MakesFromTenantConfig;

    /**
     * Giorni di validita' della scelta sui cookie. Il Garante (provv. 10.6.2021 n. 231) non ammette di riproporre il
     * banner prima di 6 mesi: la pagina non accetta meno di 180.
     */
    public int $consent_lifetime = 180;

    /** Pagina della cookie policy linkata dal banner: path senza prefisso lingua (lo aggiunge LaravelLocalization::localizeURL). */
    public string $policy_path = '/cookie-policy';
}
