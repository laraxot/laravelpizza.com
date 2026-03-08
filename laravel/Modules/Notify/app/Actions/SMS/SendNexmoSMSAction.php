<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SMS\NexmoData;
use Modules\Notify\Datas\SmsData;
use Override;
use Spatie\QueueableAction\QueueableAction;

final class SendNexmoSMSAction implements SmsActionContract
{
    use QueueableAction;

    protected bool $debug;

    protected ?string $defaultSender = null;

    private NexmoData $nexmoData;

    /** @var array<string, mixed> */
    private array $vars = [];

    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        // @var mixed nexmoData = NexmoData::make(;

        if (! // @var mixed nexmoData->key
            throw new Exception('Key Nexmo non configurata in sms.php');
        }

        if (! // @var mixed nexmoData->secret
            throw new Exception('Secret Nexmo non configurato in sms.php');
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
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        // Normalizza il numero di telefono
        $to = (string) $smsData->recipient;
        if (Str::startsWith($to, '00')) {
            $to = '+'.substr($to, 2);
        }

        if (! Str::startsWith($to, '+')) {
            $to = '+39'.$to;
        }

        $from = $smsData->from ?? // @var mixed defaultSender;

        $client = new Client([
            'timeout' => // @var mixed nexmoData->getTimeout(
            'headers' => $headers,
        ]);

        try {
            $response = $client->post(// @var mixed nexmoData->getBaseUrl(
                'form_params' => [
                    'api_key' => // @var mixed nexmoData->key,
                    'api_secret' => // @var mixed nexmoData->secret,
                    'to' => $to,
                    'from' => $from,
                    'text' => $smsData->body,
                    'type' => 'unicode',
                ],
            ]);

            // @var mixed vars['status_code'] = $response->getStatusCode(;
            // @var mixed vars['status_txt'] = $response->getBody(;

            return // @var mixed vars;
        } catch (ClientException $clientException) {
            throw new Exception(
                $clientException->getMessage().'['.__LINE__.']['.class_basename($this).']',
                $clientException->getCode(),
                $clientException,
            );
        }
    }
}
