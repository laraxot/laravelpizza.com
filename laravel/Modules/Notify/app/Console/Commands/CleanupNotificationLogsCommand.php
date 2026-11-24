<?php

declare(strict_types=1);

namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Modules\Notify\Datas\NotifyConfigData;
use Modules\Notify\Enums\NotificationLogStatusEnum;
use Modules\Notify\Models\NotificationLog;

class CleanupNotificationLogsCommand extends Command
{
    /**
     * Il nome e la firma del comando console.
     *
     * @var string
     */
    protected $signature = 'notify:cleanup-logs {--days= : Elimina i log più vecchi di X giorni (default: impostazione cleanup_older_than_days)} {--batch= : Dimensione del batch per l\'eliminazione (default: impostazione cleanup_batch_size)}';

    /**
     * La descrizione del comando console.
     *
     * @var string
     */
    protected $description = 'Elimina i log delle notifiche più vecchi del periodo specificato';

    /**
     * Esegue il comando console.
     */
    public function handle(): int
    {
        $settings = NotifyConfigData::make();

        if (! $settings->cleanup_enabled) {
            $this->warn('La pulizia automatica dei log è disabilitata nella configurazione.');

            return Command::FAILURE;
        }

        $days = (int) filter_var($this->option('days') ?? $settings->cleanup_older_than_days, FILTER_VALIDATE_INT);
        $batchSize = (int) filter_var($this->option('batch') ?? $settings->cleanup_batch_size, FILTER_VALIDATE_INT);
        $keepFailed = $settings->cleanup_keep_failed;

        $this->info("Inizio pulizia dei log delle notifiche più vecchi di {$days} giorni...");

        $query = NotificationLog::where('created_at', '<', now()->subDays($days));

        // Se configurato, mantiene i log delle notifiche fallite
        if ($keepFailed) {
            $query->where('status', '!=', NotificationLogStatusEnum::FAILED);
        }

        $totalDeleted = 0;
        $query->chunkById($batchSize, function (Collection $logs) use (&$totalDeleted): void {
            $count = $logs->count();
            $logs->each->delete();
            $totalDeleted += $count;
            $this->info("Eliminati {$count} log...");
        });

        $this->info("Pulizia completata. Eliminati {$totalDeleted} log.");

        return Command::SUCCESS;
    }
}
