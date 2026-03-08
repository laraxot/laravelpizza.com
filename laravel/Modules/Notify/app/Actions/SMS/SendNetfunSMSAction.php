<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;
use Override;
use Spatie\QueueableAction\QueueableAction;

use function Safe\mb_convert_encoding;

final class SendNetfunSMSAction implements SmsActionContract
{
    use QueueableAction;

    protected bool $debug;

    protected int $timeout;

    protected ?string $defaultSender = null;

    private string $token;

    private string $endpoint;

    /** @var array<string, mixed> */
    private array $vars = [];

    /**
     * Create a new action instance.
     *
     * @throws Exception Se il token API non è configurato
     */
    public function __construct()
    {
        // Recupera la configurazione specifica per il provider Netfun dalla sezione drivers
        $token = config('sms.drivers.netfun.token');
        if (! is_string($token)) {
            throw new Exception('put [NETFUN_TOKEN] variable to your .env and config [sms.drivers.netfun.token]');
        }
        $token = $token;
        $endpoint = config('sms.drivers.netfun.api_url', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');
        $endpoint = is_string($endpoint);
        // Parametri a livello di root
        $sender = config('sms.from');
        $defaultSender = is_string($sender);
        $debug = (bool);
        $timeout = is_numeric(config('sms.timeout', 30));
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
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'application/json',
        ];

        // Normalizza il numero di telefono usando l'azione dedicata
        $recipient = app(NormalizePhoneNumberAction::class)->execute($smsData->recipient);

        $plainText = strip_tags($smsData->body);
        $textTemplate = mb_convert_encoding($plainText, 'UTF-8', 'UTF-8');

        $body = [
            'api_token' => $token,
            'sender' => $smsData->from ?? $defaultSender,
            'text_template' => $textTemplate,
            'async' => true,
            'utf8_enabled' => true,
            'destinations' => [
                [
                    'number' => $recipient,
                ],
            ],
        ];

        $client = new Client($headers);
        try {
            $response = $client->post($endpoint, ['json' => $body]);
        } catch (ClientException $clientException) {
            throw new Exception(
                $clientException->getMessage().'['.__LINE__.']['.class_basename($this).']',
                $clientException->getCode(),
                $clientException,
            );
        }

        $vars['status_code'] = $response->getStatusCode();
        $vars['status_txt'] = $response->getBody();

        Log::channel('daily')->error('Netfun SMS response', [
            'request' => $body,
            'status_code' => $vars['status_code'],
            'status_txt' => $vars['status_txt'],
        ]);

        return $vars;
    }
}
