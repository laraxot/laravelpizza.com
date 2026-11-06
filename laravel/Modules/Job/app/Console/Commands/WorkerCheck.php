<?php

declare(strict_types=1);
/**
 * @see https://gist.github.com/ivanvermeyen/b72061c5d70c61e86875
 * @see https://gist.github.com/BenCavens/810758e74718a981c4cd2d2cf532407e
 */

namespace Modules\Job\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Modules\Job\Actions\BuildQueueWorkerCommandAction;

use function Safe\exec;

class WorkerCheck extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'worker:check';

    /**
     * The console command description.
     */
    protected $description = 'Ensure that the queue listener is running.';

    private string $filename = 'queue.pid';

    /**
     * Create a new command instance.
     */

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (! $this->isQueueListenerRunning()) {
            $pid = $this->startQueueListener();
            $this->comment('Queue listener is being started. pid['.$pid.']');
            $this->saveQueueListenerPID($pid);
        }

        $this->comment('Queue listener is running.');
    }

    /**
     * Check if the queue listener is running.
     */
    private function isQueueListenerRunning(): bool
    {
        $pid = $this->getLastQueueListenerPID();
        if (! is_string($pid) || ! ctype_digit($pid) || in_array($pid, ['0'], true)) {
            return false;
        }

        $processCommand = sprintf('ps -p %s -opid=,cmd=', $pid);
        $this->comment($processCommand);
        $output = null;
        $process = exec($processCommand, $output);
        // $processIsQueueListener = str_contains($process, 'queue:listen'); // 5.1
        // if ($process === false) {
        // DISABILITATO PER SBLOCCARE MODULE JOB
        // throw new Exception('['.__LINE__.']['.class_basename($this).']');
        // }

        $this->comment($process);

        // $processIsQueueListener = ! empty($process); // 5.6 - see comments
        return str_contains($process, mb_substr(base_path(), 0, 30));
    }

    /**
     * Get any existing queue listener PID.
     */
    private function getLastQueueListenerPID(): string|bool|null
    {
        if (! Storage::disk('cache')->exists($this->filename)) {
            return false;
        }

        return Storage::disk('cache')->get($this->filename);
    }

    /**
     * Save the queue listener PID to a file.
     */
    private function saveQueueListenerPID(string $pid): void
    {
        Storage::disk('cache')->put($this->filename, $pid);
        $path = Storage::disk('cache')->path($this->filename);
        $size = Storage::disk('cache')->size($this->filename);
        $this->comment('saved on ['.$path.'] size ['.$size.']');
    }

    /*
     * Start the queue listener.
     *
     * @return string
     * @method Modules\Job\Console\Commands\WorkerCheck::restartQueue() is unused
     *
     * private function restartQueue() {
     * // $command = 'php-cli ' . base_path() . '/artisan queue:listen --timeout=60 --sleep=5 --tries=3 > /dev/null & echo $!'; // 5.1
     * // $command = 'php-cli '.base_path().'/artisan queue:work --timeout=60 --sleep=5 --tries=3 > /dev/null & echo //$!'; // 5.6 - see comments
     *
     * $command = ' /usr/local/bin/php '.base_path().'/artisan queue:restart --timeout=60 --sleep=5 --tries=3 > /dev/null & echo $!';
     * // $this->comment($command);
     *
     * $pid = exec($command);
     * $this->comment($pid);
     *
     * return is_string($pid) ? $pid : (string) $pid;
     * }
     */
    /**
     * Start the queue listener.
     */
    private function startQueueListener(): string
    {
        // timeout, sleep e tries vengono dalle impostazioni del modulo (JobConfigData, SettingPage).
        $pid = exec(app(BuildQueueWorkerCommandAction::class)->execute());
        // if ($pid === false) {
        //    throw new Exception('['.__LINE__.']['.class_basename($this).']');
        // }

        $this->comment($pid);

        return $pid;
    }
}