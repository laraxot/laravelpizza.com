<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Promemoria agli iscritti degli eventi del giorno dopo (Modules/Meetup SendEventRemindersAction): richiede
// il cron `* * * * * php artisan schedule:run` sul server (docs/deploy/runbook.md).
Schedule::command('meetup:send-reminders')->hourly()->withoutOverlapping()->onOneServer();
