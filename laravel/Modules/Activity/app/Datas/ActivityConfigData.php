<?php

declare(strict_types=1);

namespace Modules\Activity\Datas;

use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/**
 * Impostazioni di Activity del tenant corrente: `config/{tenant}/activity.php`.
 *
 * Si modificano dalla SettingPage del modulo (solo super-admin).
 */
class ActivityConfigData extends Data
{
    use MakesFromTenantConfig;

    /** Abilita la registrazione delle attività (prima ACTIVITY_LOGGER_ENABLED). */
    public bool $enabled = true;

    /** Giorni di conservazione dei log (usato da activitylog:clean). */
    public int $clean_after_days = 365;

    /** Nome del log predefinito quando non specificato. */
    public string $default_log_name = 'default';

    /** Mostra i soggetti cancellati con soft delete. */
    public bool $include_soft_deleted_subjects = true;
}
