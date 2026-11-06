<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Artisan;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Spatie\QueueableAction\QueueableAction;

use function Safe\define;
use function Safe\fopen;

/**
 * Replaces Modules\Xot\Services\ArtisanService::exe().
 *
 * Runs a single artisan command via the Artisan facade and returns its
 * output wrapped in a `<pre>` block, or the exception message on failure.
 */
class RunArtisanCommandAction
{
    use QueueableAction;

    /**
     * @param  array<string, bool|int|string|list<string>>  $arguments
     */
    public function execute(string $command, array $arguments = []): string
    {
        $this->ensureStdin();

        try {
            Artisan::call($command, $arguments);

            return '[<pre>'.Artisan::output().'</pre>]';
        } catch (Exception $exception) {
            return '[<pre>'.$exception->getMessage().'</pre>]';
        }
    }

    /**
     * Con SAPI web `STDIN` non esiste e il QuestionHelper di Symfony lo legge senza guardia
     * (`$inputStream ??= \STDIN`): un comando con conferma (migrate, key:generate) andrebbe in fatal.
     * Il guard era in testa a ArtisanService/ArtisanAction ed era stato perso nella migrazione ad Action.
     */
    private function ensureStdin(): void
    {
        if (! \defined('STDIN')) {
            define('STDIN', fopen('php://stdin', 'r'));
        }
    }
}
