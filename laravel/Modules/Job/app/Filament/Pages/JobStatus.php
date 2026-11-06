<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Pages;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Artisan;
use InvalidArgumentException;
use Modules\Job\Actions\Console\AssertAllowedArtisanCommandAction;
use Modules\Job\Filament\Widgets\ClockWidget;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Traits\SuperAdminOnlyTrait;

class JobStatus extends XotBasePage
{
    use SuperAdminOnlyTrait;

    public string $out = '';

    protected string $view = 'job::filament.pages.job-status';

    public function getHeaderWidgets(): array
    {
        return [
            ClockWidget::make(),
        ];
    }

    /**
     * Esegue solo i comandi esposti dai pulsanti (match esatto, nessun argomento libero).
     *
     * canAccess() protegge l'apertura della pagina, non le chiamate Livewire gia' montate:
     * l'autorizzazione va quindi ripetuta qui.
     *
     * @throws AuthorizationException se l'utente non e' super-admin
     */
    public function artisan(string $cmd): void
    {
        if (! static::canAccess()) {
            throw new AuthorizationException();
        }

        $this->out = '';

        try {
            app(AssertAllowedArtisanCommandAction::class)->execute($cmd, $this->getAllowedCommands());
        } catch (InvalidArgumentException) {
            return;
        }

        Artisan::call($cmd);
        $this->out .= Artisan::output();
    }

    /**
     * @return list<string>
     */
    public function getAllowedCommands(): array
    {
        return array_values(array_map(static fn (object $act): string => $act->name, $this->getActs()));
    }

    public function getViewData(): array
    {
        return [
            'acts' => $this->getActs(),
        ];
    }

    /**
     * @return array<int, object{name: string, label: string}>
     */
    public function getActs(): array
    {
        return [
            /*
             * (object) [
             * 'name' => 'batches-table',
             * 'label' => 'Create a migration for the batches database table',
             * ],
             * (object) [
             * 'name' => 'failed-table',
             * 'label' => ' Create a migration for the failed queue jobs database table',
             * ],
             * (object) [
             * 'name' => 'table',
             * 'label' => 'Create a migration for the queue jobs database table',
             * ],
             */
            (object) [
                'name' => 'queue:clear',
                'label' => 'Delete all of the jobs from the specified queue',
            ],
            (object) [
                'name' => 'queue:failed',
                'label' => 'List all of the failed queue jobs',
            ],
            (object) [
                'name' => 'queue:flush',
                'label' => 'Flush all of the failed queue jobs',
            ],
            /* -- VUOLE ID
             * (object) [
             * 'name' => 'forget',
             * 'label' => 'Delete a failed queue job',
             * ],
             */
            /* --- RIMANE APPESO
             * (object) [
             * 'name' => 'listen',
             * 'label' => 'Listen to a given queue',
             * ],
             */
            /*manca parametro
             * (object) [
             * 'name' => 'monitor',
             * 'label' => 'Monitor the size of the specified queues',
             * ],
             */
            (object) [
                'name' => 'queue:prune-batches',
                'label' => 'Prune stale entries from the batches database',
            ],
            (object) [
                'name' => 'queue:prune-failed',
                'label' => ' Prune stale entries from the failed jobs table',
            ],
            (object) [
                'name' => 'queue:restart',
                'label' => 'Restart queue worker daemons after their current job',
            ],
            (object) [
                'name' => 'queue:retry',
                'label' => 'Retry a failed queue job',
            ],
            /*-- vuole parametro
             * (object) [
             * 'name' => 'retry-batch',
             * 'label' => 'Retry the failed jobs for a batch',
             * ],
             */
            /*-- rimane appeso
             * (object) [
             * 'name' => 'work',
             * 'label' => 'Start processing jobs on the queue as a daemon',
             * ],
             */
            (object) [
                'name' => 'worker:check',
                'label' => 'Ensure that the queue listener is running.',
            ],
            (object) [
                'name' => 'route:list',
                'label' => 'Route list',
            ],
        ];
    }
}
