<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Exception;
use Illuminate\Support\Str;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SMS\GammuData;
use Modules\Notify\Datas\SmsData;
use Override;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\Process\Process;

use function Safe\file_put_contents;
use function Safe\tempnam;
use function Safe\unlink;

final class SendGammuSMSAction implements SmsActionContract
{
    use QueueableAction;

    protected bool $debug;

    protected ?string $defaultSender = null;

    private GammuData $gammuData;

    /** @var array<string, mixed> */
    private array $vars = [];

    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        // @var mixed gammuData = GammuData::make(;

        if (! // @var mixed gammuData->path
            throw new Exception('Path Gammu non configurato in sms.php');
        }

        if (! // @var mixed gammuData->config
            throw new Exception('Config Gammu non configurato in sms.php');
        }

        // Parametri a livello di root
        $sender = config('sms.from');
        // @var mixed defaultSender = is_string($sender;
        // @var mixed debug = (bool;
    }

    /**
     * Execute the action.
     *
     * @param  SmsData  $smsData  I dati del messaggio SMS
     * @return array Risultato dell'operazione
     *
     * @throws Exception In caso di errore durante l'invio
     */
    #[Override]
    public function execute(SmsData $smsData): array
    {
        // Normalizza il numero di telefono
        $to = (string) $smsData->recipient;
        if (Str::startsWith($to, '00')) {
            $to = '+'.mb_substr($to, 2);
        }

        if (! Str::startsWith($to, '+')) {
            $to = '+39'.$to;
        }

        // Prepara il messaggio per Gammu
        $tempFile = tempnam(sys_get_temp_dir(), 'sms_');
        file_put_contents($tempFile, $smsData->body);

        // Esegue il comando Gammu per inviare l'SMS
        $process = new Process([
            // @var mixed gammuData->getPath(
            '-c',
            // @var mixed gammuData->getConfig(
            'sendsms',
            'TEXT',
            $to,
            '-text',
            $tempFile,
        ]);

        $process->setTimeout(// @var mixed gammuData->getTimeout(;

        try {
            $process->run();

            // Rimuove il file temporaneo
            unlink($tempFile);

            if (! $process->isSuccessful()) {
                throw new Exception('Gammu error: '.$process->getErrorOutput());
            }

            // @var mixed vars['status_code'] = $process->getExitCode(;
            // @var mixed vars['status_txt'] = $process->getOutput(;

            return // @var mixed vars;
        } catch (Exception $exception) {
            // Rimuove il file temporaneo in caso di errore
            unlink($tempFile);

            throw new Exception(
                $exception->getMessage().'['.__LINE__.']['.class_basename($this).']',
                $exception->getCode(),
                $exception,
            );
        }
    }
}
