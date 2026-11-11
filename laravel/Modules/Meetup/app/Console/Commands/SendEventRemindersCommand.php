<?php

declare(strict_types=1);

namespace Modules\Meetup\Console\Commands;

use Illuminate\Console\Command;
use Modules\Meetup\Actions\Event\SendEventRemindersAction;

/**
 * Pianificato ogni ora in routes/console.php: richiede lo scheduler attivo (`* * * * * php artisan schedule:run`).
 */
class SendEventRemindersCommand extends Command
{
    protected $signature = 'meetup:send-reminders';

    protected $description = 'Invia il promemoria agli iscritti degli eventi che iniziano nelle prossime 24 ore';

    public function handle(SendEventRemindersAction $action): int
    {
        $sent = $action->execute();
        $this->info("Promemoria inviati: {$sent}");

        return self::SUCCESS;
    }
}
