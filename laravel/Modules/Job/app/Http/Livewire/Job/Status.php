<?php

declare(strict_types=1);

namespace Modules\Job\Http\Livewire\Job;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;
use Modules\Job\Actions\DummyAction;
use Modules\Job\Models\FailedJob as FailedJobModel;
use Modules\Job\Models\Job as JobModel;
use Modules\Job\Models\JobBatch as JobBatchModel;
use Modules\Xot\Actions\GetViewAction;
use Webmozart\Assert\Assert;

use function Safe\putenv;

/**
 * Class RolePermission.
 */
class Status extends Component
{
    public array $form_data = [];

    public string $out = '';

    public string $old_value = '';

    public function mount(): void
    {
        Artisan::call('queue:monitor', ['queues' => 'default,queue01,emails']);
        $this->out .= Artisan::output();
        Artisan::call('worker:check');
        $this->out .= Artisan::output();

        $this->out .= '<br/>['.JobModel::count().'] Jobs';
        $this->out .= '<br/>['.FailedJobModel::count().'] Failed Jobs';
        $this->out .= '<br/>['.JobBatchModel::count().'] Job Batch';
        $queue_conn = getenv('QUEUE_CONNECTION');
        if ($queue_conn === false) {
            throw new Exception('['.__LINE__.']['.class_basename($this).']');
        }

        $this->old_value = $queue_conn;
        $this->form_data['conn'] = $queue_conn;

        // $env_file=base_path('.env');
        // dddx(getenv(base_path('')));
        // $env_file = getenv('LARAVEL_DIR').'/.env';
        // dddx();
    }

    public function render(): Renderable
    {
        $view = app(GetViewAction::class)->execute();

        $acts = [
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
                'name' => 'clear',
                'label' => 'Delete all of the jobs from the specified queue',
            ],
            (object) [
                'name' => 'failed',
                'label' => 'List all of the failed queue jobs',
            ],
            (object) [
                'name' => 'flush',
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
                'name' => 'prune-batches',
                'label' => 'Prune stale entries from the batches database',
            ],
            (object) [
                'name' => 'prune-failed',
                'label' => ' Prune stale entries from the failed jobs table',
            ],
            (object) [
                'name' => 'restart',
                'label' => 'Restart queue worker daemons after their current job',
            ],
            (object) [
                'name' => 'retry',
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
        ];

        $view_params = [
            'view' => $view,
            'acts' => $acts,
        ];

        return view($view, $view_params);
    }

    public function updatedFormData(string $value, string $key): void
    {
        // dddx([$value,$key,$this->form_data]);
        if ($key === 'conn') {
            // putenv ("QUEUE_CONNECTION=".$value);
            $this->saveEnv();
        }
    }

    public function saveEnv(): void
    {
        $env_file = base_path('.env');
        $env_content = File::get($env_file);

        $conn = $this->form_data['conn'] ?? null;
        Assert::string($conn, '['.__LINE__.']['.class_basename($this).']');

        $new_content = Str::replace(
            'QUEUE_CONNECTION='.$this->old_value,
            'QUEUE_CONNECTION='.$conn,
            $env_content,
        );
        putenv('QUEUE_CONNECTION='.$conn);
        Assert::string($new_content, '['.__LINE__.']['.class_basename($this).']');
        File::put($env_file, $new_content);
        $this->old_value = $conn;
    }

    public function artisan(string $cmd): void
    {
        $this->out .= '<hr/>';
        Artisan::call('queue:'.$cmd);
        $this->out .= Artisan::output();
        $this->out .= '<hr/>';
    }

    public function dummyAction(): void
    {
        for ($i = 0; $i < 1000; $i++) {
            app(DummyAction::class)->onQueue()->execute();
        }

        session()->flash('message', '1000 dummy Action');
    }
}
