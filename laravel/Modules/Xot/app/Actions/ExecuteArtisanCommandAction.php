<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Process;
use RuntimeException;
use Spatie\QueueableAction\QueueableAction;
use Throwable;
use Webmozart\Assert\Assert;

/**
 * Classe per eseguire comandi Artisan in modo sicuro.
 */
class ExecuteArtisanCommandAction
{
    use QueueableAction;

    /**
     * Lista dei comandi consentiti per motivi di sicurezza.
     *
     * @var array<int, string>
     */
    private array $allowedCommands = [
        'migrate',
        'filament:upgrade',
        'filament:optimize',
        'view:cache',
        'config:cache',
        'route:cache',
        'event:cache',
        'queue:restart',
    ];

    /**
     * Esegue un comando Artisan e restituisce i risultati.
     *
     * @param  string  $command  Il comando Artisan da eseguire (senza "php artisan")
     * @return array{
     *     command: string,
     *     output: array<int, string>,
     *     status: 'completed'|'failed',
     *     exitCode: int
     * } Array con informazioni sull'esecuzione del comando
     *
     * @throws RuntimeException Se il comando non è consentito o si verifica un errore
     */
    public function execute(string $command): array
    {
        Assert::stringNotEmpty($command, 'Il comando non può essere vuoto');

        if (! $this->isCommandAllowed($command)) {
            throw new RuntimeException("Comando non consentito: {$command}");
        }

        /** @var array<int, string> $output */
        $output = [];
        $status = 'running';

        Event::dispatch('artisan-command.started', [$command]);

        try {
            $process = Process::path(base_path())
                ->command("php artisan {$command}")
                ->timeout(300)
                ->start();

            // Cattura l'output in tempo reale
            while ($process->running()) {
                $data = $process->latestOutput();
                if (! empty($data)) {
                    $formattedData = trim($data);
                    if (! empty($formattedData)) {
                        $output[] = $formattedData;
                        Event::dispatch('artisan-command.output', [$command, $formattedData]);
                    }
                }

                $errorData = $process->latestErrorOutput();
                if (! empty($errorData)) {
                    $formattedError = trim($errorData);
                    if (! empty($formattedError)) {
                        $output[] = '[ERROR] '.$formattedError;
                        Event::dispatch('artisan-command.output', [$command, '[ERROR] '.$formattedError]);
                    }
                }

                usleep(50000); // 50ms di pausa per evitare sovraccarico della CPU
            }

            $result = $process->wait();

            // Cattura qualsiasi output residuo
            $finalOutput = trim($result->output());
            if (! empty($finalOutput)) {
                $output[] = $finalOutput;
                Event::dispatch('artisan-command.output', [$command, $finalOutput]);
            }

            $finalErrorOutput = trim($result->errorOutput());
            if (! empty($finalErrorOutput)) {
                $output[] = '[ERROR] '.$finalErrorOutput;
                Event::dispatch('artisan-command.output', [$command, '[ERROR] '.$finalErrorOutput]);
            }

            if ($result->successful()) {
                $status = 'completed';
                Event::dispatch('artisan-command.completed', [$command]);
            } else {
                $status = 'failed';
                Event::dispatch('artisan-command.failed', [$command, $finalErrorOutput]);
            }

            return [
                'command' => $command,
                'output' => $output,
                'status' => $status,
                'exitCode' => $result->exitCode() ?? 0,
            ];
        } catch (Throwable $e) {
            Event::dispatch('artisan-command.error', [$command, $e->getMessage()]);
            throw new RuntimeException(
                "Errore durante l'esecuzione del comando {$command}: {$e->getMessage()}",
                (int) $e->getCode(),
                $e,
            );
        }
    }

    /**
     * Verifica se un comando è presente nella lista dei comandi consentiti.
     *
     * @param  string  $command  Il comando da verificare
     * @return bool True se il comando è consentito, false altrimenti
     */
    private function isCommandAllowed(string $command): bool
    {
        Assert::stringNotEmpty($command, 'Il comando non può essere vuoto');

        return in_array($command, $this->allowedCommands, true);
    }
}
