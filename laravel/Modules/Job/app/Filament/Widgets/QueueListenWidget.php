<?php

declare(strict_types=1);
/**
 * @see https://www.freshleafmedia.co.uk/blog/streaming-laravel-command-output-to-the-browser
 */

namespace Modules\Job\Filament\Widgets;

use Illuminate\Support\Facades\Process;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class QueueListenWidget extends XotBaseWidget
{
    public string $time = '---';

    public bool $run = false;

    /** @var view-string */
    protected string $view = 'job::filament.widgets.queue-listen';

    protected int|string|array $columnSpan = 'full';

    public function begin(): void
    {
        $this->beginProcess();
    }

    public function beginProcess(): void
    {
        $this->time = '';
        $process = Process::path(base_path())->start('php artisan queue:listen');
        while ($process->running()) {
            // ...
            $this->stream(
                to: 'count',
                content: $this->time,
                replace: true,
            );
            // Pause for 1 second between numbers...
            sleep(3);
            // se no troppe richieste

            $this->time .= $process->latestOutput();
        }

        $process->wait();
    }

    /**
     * Esperimento di streaming (blog freshleafmedia) mai completato: lo streaming reale e' beginProcess().
     * Nessun chiamante: la vista usa begin().
     */
    public function beginStream(): void
    {
        throw new \LogicException('QueueListenWidget::beginStream() non implementato');
    }
}
