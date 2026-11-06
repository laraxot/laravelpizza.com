<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Widgets;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Modules\Job\Actions\DummyAction;
use Modules\Job\Models\FailedJob;
use Modules\Job\Models\Job;
use Modules\Job\Models\JobBatch;
use Modules\Xot\Filament\Traits\SuperAdminOnlyTrait;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Webmozart\Assert\Assert;

use function Safe\preg_match;
use function Safe\putenv;

/**
 * Gemello Filament del ritirato Http\Livewire\Job\Status.
 *
 * Monta la stessa dashboard (contatori queue, selettore connessione,
 * comandi queue:*, dummy action) dentro Modules\Job\Filament\Pages\JobMonitor,
 * sostituendo il tag <livewire:job.status>.
 */
class JobStatusWidget extends XotBaseWidget
{
    use SuperAdminOnlyTrait;

    /** @var array<string, string> */
    public array $form_data = [];

    public string $out = '';

    #[Locked]
    public string $old_value = '';

    /** @var view-string */
    protected string $view = 'job::filament.widgets.job-status';

    protected int|string|array $columnSpan = 'full';

    public function mount(): void
    {
        Artisan::call('queue:monitor', ['queues' => 'default,queue01,emails']);
        $this->out .= Artisan::output();
        Artisan::call('worker:check');
        $this->out .= Artisan::output();

        $this->out .= '<br/>['.Job::count().'] Jobs';
        $this->out .= '<br/>['.FailedJob::count().'] Failed Jobs';
        $this->out .= '<br/>['.JobBatch::count().'] Job Batch';

        $queueConn = getenv('QUEUE_CONNECTION');
        if ($queueConn === false) {
            throw new Exception('['.__LINE__.']['.class_basename($this).']');
        }

        $this->old_value = $queueConn;
        $this->form_data['conn'] = $queueConn;
    }

    /**
     * Nascosto ai non super-admin quando il widget e' registrato in un pannello/dashboard.
     */
    public static function canView(): bool
    {
        return static::canAccess();
    }

    /**
     * @throws AuthorizationException se l'utente non e' super-admin
     */
    public function artisan(string $cmd): void
    {
        $this->authorizeSuperAdmin();

        if (! in_array($cmd, $this->getAllowedCommands(), true)) {
            return;
        }

        $this->out .= '<hr/>';
        Artisan::call('queue:'.$cmd);
        $this->out .= e(Artisan::output());
        $this->out .= '<hr/>';
    }

    public function updatedFormData(string $value, string $key): void
    {
        if ($key === 'conn') {
            $this->saveEnv();
        }
    }

    /**
     * Scrive QUEUE_CONNECTION in .env. Richiamabile dal client Livewire (anche via form_data):
     * l'autorizzazione super-admin e la validazione del valore stanno qui, non nella vista.
     *
     * @throws AuthorizationException se l'utente non e' super-admin
     */
    public function saveEnv(): void
    {
        $this->authorizeSuperAdmin();

        $conn = $this->form_data['conn'] ?? null;
        if (! is_string($conn) || ! in_array($conn, $this->getAllowedConnections(), true)) {
            $this->form_data['conn'] = $this->old_value;

            return;
        }

        $envFile = $this->envFilePath();
        $newContent = Str::replace(
            'QUEUE_CONNECTION='.$this->old_value,
            'QUEUE_CONNECTION='.$conn,
            File::get($envFile),
        );
        Assert::string($newContent, '['.__LINE__.']['.class_basename($this).']');
        File::put($envFile, $newContent, true);
        putenv('QUEUE_CONNECTION='.$conn);
        $this->old_value = $conn;
    }

    /**
     * Connessioni queue accettate: le chiavi di config('queue.connections') fatte solo di [A-Za-z0-9_-]
     * (un valore con a capo o '=' non puo' aggiungere righe a .env).
     *
     * @return list<string>
     */
    public function getAllowedConnections(): array
    {
        $connections = config('queue.connections');
        Assert::isArray($connections);

        $allowed = [];
        foreach (array_keys($connections) as $name) {
            if (is_string($name) && preg_match('/^[A-Za-z0-9_-]+$/D', $name) === 1) {
                $allowed[] = $name;
            }
        }

        return $allowed;
    }

    /**
     * I metodi pubblici sono richiamabili dal client Livewire anche se la vista non mostra il pulsante.
     *
     * @throws AuthorizationException se l'utente non e' super-admin
     */
    protected function authorizeSuperAdmin(): void
    {
        if (! static::canAccess()) {
            throw new AuthorizationException();
        }
    }

    protected function envFilePath(): string
    {
        return base_path('.env');
    }

    /**
     * @throws AuthorizationException se l'utente non e' super-admin
     */
    public function dummyAction(): void
    {
        $this->authorizeSuperAdmin();

        for ($i = 0; $i < 1000; $i++) {
            app(DummyAction::class)->onQueue()->execute();
        }

        session()->flash('message', '1000 dummy Action');
    }

    /**
     * Comandi queue:* esposti dal pannello (whitelist, invariata rispetto
     * al componente Livewire originale).
     *
     * @return array<int, string>
     */
    public function getAllowedCommands(): array
    {
        return [
            'clear',
            'failed',
            'flush',
            'prune-batches',
            'prune-failed',
            'restart',
            'retry',
        ];
    }
}
