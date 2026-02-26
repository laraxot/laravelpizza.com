<?php

declare(strict_types=1);

namespace Modules\Notify\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notify\Models\NotificationLog;

class CleanupNotificationLogsCommand extends Command
{
    /**
     * Il nome e la firma del comando console.
     *
     * @var string
     */
    protected $signature = 'notify:cleanup-logs {--days=30 : Elimina i log più vecchi di X giorni} {--batch=1000 : Dimensione del batch per l\'eliminazione}';

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
        if (!config('notify.cleanup.enabled')) {
            $this->warn('La pulizia automatica dei log è disabilitata nella configurazione.');
            return Command::FAILURE;
        }

        $days = $this->option('days') ?? config('notify.cleanup.older_than_days', 30);
        $batchSize = $this->option('batch') ?? config('notify.cleanup.batch_size', 1000);
        $keepFailed = config('notify.cleanup.keep_failed', true);

        $this->info("Inizio pulizia dei log delle notifiche più vecchi di {$days} giorni...");

        $query = NotificationLog::where('created_at', '<', now()->subDays($days));

        // Se configurato, mantiene i log delle notifiche fallite
        if ($keepFailed) {
            $query->where('status', '!=', NotificationLog::STATUS_FAILED);
        }

        $totalDeleted = 0;
        $query->chunkById($batchSize, function ($logs) use (&$totalDeleted) {
            $count = $logs->count();
            $logs->each->delete();
            $totalDeleted += $count;
            $this->info("Eliminati {$count} log...");
        });

        $this->info("Pulizia completata. Eliminati {$totalDeleted} log.");

        return Command::SUCCESS;
    }
} 