<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Models\Contracts\SmsActionContract;
use Safe\Exceptions\JsonException;
use Spatie\QueueableAction\QueueableAction;

use function Safe\json_decode;
use function Safe\mb_convert_encoding;

final class SendNetfunSMSAction implements SmsActionContract
{
    use QueueableAction;

    protected bool $debug;

    protected int $timeout;

    protected ?string $defaultSender = null;

    private string $token;

    private string $endpoint;

    /** @var array{status_code?: int, status_txt?: string} */
    private array $vars = [];

    /**
     * Create a new action instance.
     *
     * @return void
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
        $this->token = $token;
        $endpoint = config('sms.drivers.netfun.api_url', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');
        $this->endpoint = is_string($endpoint) ? $endpoint : 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json';
        // Parametri a livello di root
        $sender = config('sms.from');
        $this->defaultSender = is_string($sender) ? $sender : null;
        $this->debug = (bool) config('sms.debug', false);
        $this->timeout = is_numeric(config('sms.timeout', 30)) ? (int) config('sms.timeout', 30) : 30;
    }

    /**
     * Execute the action.
     *
     * @param  SmsData  $smsData  I dati del messaggio SMS
     * @return array{status_code: int, status_txt: string} Risultato dell'operazione
     *
     * @throws Exception In caso di errore durante l'invio
     */
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
            'api_token' => $this->token,
            'sender' => $smsData->from ?: $this->defaultSender,
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
            $response = $client->post($this->endpoint, [
                'json' => $body,
            ]);
        } catch (ClientException $clientException) {
            throw new Exception(
                $clientException->getMessage().'['.__LINE__.']['.class_basename($this).']',
                $clientException->getCode(),
                $clientException,
            );
        }

        $this->vars['status_code'] = $response->getStatusCode();
        $this->vars['status_txt'] = $response->getBody()->getContents();

        if (! $this->isSuccessfulResponse($this->vars['status_code'], $this->vars['status_txt'])) {
            $redactedRequest = $body;
            $redactedRequest['api_token'] = '***redacted***';

            Log::channel('daily')->error('Netfun SMS response', [
                'request' => $redactedRequest,
                'status_code' => $this->vars['status_code'],
                'status_txt' => $this->vars['status_txt'],
            ]);
        }

        return $this->vars;
    }

    /**
     * Netfun risponde sempre con HTTP 200 su richiesta accettata: l'esito reale
     * dell'invio è nel campo `error` del body JSON (`0`/assente = ok, valorizzato
     * = errore), non nello status HTTP.
     */
    private function isSuccessfulResponse(int $statusCode, string $statusTxt): bool
    {
        if ($statusCode < 200 || $statusCode >= 300) {
            return false;
        }

        try {
            $decoded = json_decode($statusTxt, true);
        } catch (JsonException) {
            return false;
        }

        if (! is_array($decoded)) {
            return false;
        }

        $error = $decoded['error'] ?? null;

        return in_array($error, [null, 0, '0', false], true);
    }
}
