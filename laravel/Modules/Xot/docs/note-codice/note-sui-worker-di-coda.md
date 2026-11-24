---
title: "Note sui worker di coda"
type: archive
tags: [archivio, queue, worker, supervisor]
created: 2026-11-20
updated: 2026-11-20
qmd: "note worker coda queue restart daemon supervisor processo vivo"
issues: [247]
discussions: []
---

# Note sui worker di coda

Stava in `Modules/Xot/app/Jobs/links.md`, cioe' in una cartella di codice, dove
un `.md` non ha niente da fare — ed era uno dei due file per cui quella cartella
sopravviveva alla regola che vieta `app/Jobs/` (base_quaeris_fila5#247).

Sono appunti di qualcuno su come tenere in piedi un worker di coda: link, due
righe di `$schedule->command(...)` e uno `osProcessIsRunning()` che cerca il
processo in `ps aux`. Non descrivono come funzionano le cose in questo progetto,
sono materiale di studio. Tenuti perche' costano niente e un link perso non si
recupera.

Da leggere con cautela: `App\Console\Kerner.php` nel testo e' un errore di
battitura per `Kernel.php`, e `queue:work --daemon` e' un'opzione rimossa da
Laravel 5.3 — il comando oggi e' `queue:work` e basta.

---

https://stackoverflow.com/questions/28623001/how-to-keep-laravel-queue-system-running-on-server/45582479
https://gist.github.com/BenCavens/810758e74718a981c4cd2d2cf532407e

App\Console\Kerner.php

$schedule->command('queue:restart')->everyFiveMinutes();
$schedule->command('queue:work --daemon')->everyMinute()->withoutOverlapping();


protected function osProcessIsRunning($needle)
    {
        // get process status. the "-ww"-option is important to get the full output!
        exec('ps aux -ww', $process_status);

        // search $needle in process status
        $result = array_filter($process_status, function($var) use ($needle) {
            return strpos($var, $needle);
        });

        // if the result is not empty, the needle exists in running processes
        if (!empty($result)) {
            return true;
        }
        return false;
    }



https://github.com/orobogenius/sansdaemon



namespace App\Providers;

use App\System\Queue\Console\DatabaseQueueMonitorCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class QueueServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Queue::failing(function (JobFailed $event) {
            report($event);
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                DatabaseQueueMonitorCommand::class,
            ]);
        }

        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping(10);
            $schedule->command('queue:restart')->hourly();
            $schedule->command('queue:db-monitor')->everyTenMinutes();
        });
    }

    public function register()
    {
        //
    }
}



https://papertank.com/blog/903/setup-laravel-queue-on-shared-hosting/



https://github.com/spatie/laravel-cronless-schedule



//---- per limitare utilizzo 
https://github.com/spatie/laravel-rate-limited-job-middleware

