<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SMS\PlivoData;
use Modules\Notify\Datas\SmsData;
use Override;
use Spatie\QueueableAction\QueueableAction;

final class SendPlivoSMSAction implements SmsActionContract
{
    use QueueableAction;

    protected bool $debug;

    protected ?string $defaultSender = null;

    private PlivoData $plivoData;

    /** @var array<string, mixed> */
    private array $vars = [];

    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        // @var mixed plivoData = PlivoData::make(;

        if (! // @var mixed plivoData->auth_id
            throw new Exception('Auth ID Plivo non configurato in sms.php');
        }

        if (! // @var mixed plivoData->auth_token
            throw new Exception('Auth Token Plivo non configurato in sms.php');
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
            $to = '+'.substr($to, 2);
        }

        if (! Str::startsWith($to, '+')) {
            $to = '+39'.$to;
        }

        $from = $smsData->from ?? // @var mixed defaultSender;

        // Plivo richiede l'autenticazione Basic
        $client = new Client([
            'timeout' => // @var mixed plivoData->getTimeout(
            'auth' => [// @var mixed plivoData->auth_id, $this->plivoData->auth_token],
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $endpoint = // @var mixed plivoData->getBaseUrl(;

        try {
            $response = $client->post($endpoint, [
                'json' => [
                    'src' => $from,
                    'dst' => $to,
                    'text' => $smsData->body,
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
