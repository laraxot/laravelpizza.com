<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Modules\Notify\Actions\Push\SendPushToPlatformAction;
use Modules\Notify\Actions\Push\SendPushToTopicAction;
use Modules\Notify\Console\Commands\CleanupNotificationLogsCommand;
use Modules\Notify\Filament\Pages\SettingPage;
use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/**
 * Impostazioni di Notify del tenant corrente: `config/{tenant}/notify.php`.
 *
 * Si modificano dalla SettingPage del modulo (solo super-admin). I default sono i valori che
 * prima erano scritti nel codice: nulla cambia finche' nessuno salva. `fcm.server_key` non e'
 * qui: e' un segreto e resta in `.env`/`services` (EnvWidget della pagina).
 *
 * @see SettingPage
 * @see CleanupNotificationLogsCommand
 * @see SendPushToPlatformAction
 * @see SendPushToTopicAction
 */
class NotifyConfigData extends Data
{
    use MakesFromTenantConfig;

    /** Abilita `notify:cleanup-logs`; spenta, il comando rifiuta di girare (prima `config('notify.cleanup.enabled')`, NULL). */
    public bool $cleanup_enabled = false;

    /** Giorni di storico dei log delle notifiche, se `--days` non e' passato. */
    public int $cleanup_older_than_days = 30;

    /** Righe eliminate per batch, se `--batch` non e' passato. */
    public int $cleanup_batch_size = 1000;

    /** La pulizia conserva i log delle notifiche fallite. */
    public bool $cleanup_keep_failed = true;

    /** Endpoint FCM legacy usato dalle Action push. */
    public string $fcm_url = 'https://fcm.googleapis.com/fcm/send';
}
