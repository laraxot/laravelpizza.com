<?php

/**
 * @see https://www.freshleafmedia.co.uk/blog/streaming-laravel-command-output-to-the-browser
 */

declare(strict_types=1);

namespace Modules\Job\Filament\Widgets;

use Exception;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Symfony\Component\Console\Output\StreamOutput;

use function Safe\fopen;

class QueueListenWidget extends Widget
{
    /** @var string */
    public $time = '---';

    public bool $run = false;

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

    public function beginStream(): void
    {
        $this->run = ! $this->run;
        // $output = new BufferedOutput();
        /*
         * $output = new class() extends StreamOutput {
         * public function __construct()
         * {
         * parent::__construct(fopen('php://output', 'w'));
         * }
         *
         * protected function doWrite(string $message, bool $newline): void
         * {
         * if ('' != $message) {
         * dddx($message);
         * }
         *
         * $message = str_replace("\n", '<br>', $message);
         *
         * if ($newline) {
         * $message .= '<br>';
         * }
         *
         * parent::doWrite($message, false);
         * }
         * };
         */
        $resource = fopen('php://stdout', 'w');
        if ($resource === false) {
            throw new Exception('['.__LINE__.']['.class_basename($this).']');
        }
        $output = new StreamOutput($resource);
        // $output = new StreamOutput(fopen('/path/to/output.log', 'a', false));

        Artisan::call('route:list', [], $output);
        dddx($output);

        // dddx($output);
        // dddx($output->fetch());
        /*
         * while ($this->run) {
         * // Stream the current count to the browser...
         * $this->stream(
         * to: 'count',
         * content: $this->time,
         * replace: true,
         * );
         *
         * // Pause for 1 second between numbers...
         * sleep(1);
         *
         * // Decrement the counter...
         * // $this->time = (string) Carbon::now()->format('H:i:s');
         * $this->time = $output->fetch().PHP_EOL;
         * }
         */
    }
}
