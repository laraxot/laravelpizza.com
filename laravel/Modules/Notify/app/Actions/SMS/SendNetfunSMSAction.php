<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Override;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Notify\Contracts\SmsActionContract;
use Modules\Notify\Datas\SmsData;
use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_replace;

final class SendNetfunSMSAction implements SmsActionContract
{
    use QueueableAction;

    /** @var string */
    private string $token;

    /** @var string */
    private string $endpoint;

    /** @var array<string, mixed> */
    private array $vars = [];

    /** @var bool */
    protected bool $debug;

    /** @var int */
    protected int $timeout;

    /** @var string|null */
    protected null|string $defaultSender = null;

    /**
     * Create a new action instance.
     *
     * @throws Exception Se il token API non è configurato
     */
    public function __construct()
    {
        // Recupera la configurazione specifica per il provider Netfun dalla sezione drivers
        $token = config('sms.drivers.netfun.token');
        if (!is_string($token)) {
            throw new Exception('put [NETFUN_TOKEN] variable to your .env and config [sms.drivers.netfun.token]');
        }
        $this->token = $token;
        $endpoint = config('sms.drivers.netfun.api_url', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');
        $this->endpoint = is_string($endpoint) ? $endpoint : 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json';
        // Parametri a livello di root
        $sender = config('sms.from');
        $this->defaultSender = is_string($sender) ? $sender : null;
        $this->debug = (bool) config('sms.debug', false);
        $this->timeout = is_numeric(config('sms.timeout', 30)) ? ((int) config('sms.timeout', 30)) : 30;
    }

    /**
     * Execute the action.
     *
     * @param SmsData $smsData I dati del messaggio SMS
     * @return array Risultato dell'operazione
     * @throws Exception In caso di errore durante l'invio
     */
    #[Override]
    public function execute(SmsData $smsData): array
    {
        $headers = [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'application/json',
        ];

        // Normalizza il numero di telefono
        $to = (string) $smsData->to;
        if (Str::startsWith($to, '00')) {
            $to = $to !== '' ? ('+' . mb_substr($to, 2)) : $to;
        }
        if (!Str::startsWith($to, '+')) {
            $to = '+39' . $to;
        }

        $body = [
            'api_token' => $this->token,
            'sender' => $smsData->from ?? $this->defaultSender,
            'text_template' => $smsData->body,
            'async' => true,
            'utf8_enabled' => true,
            'destinations' => [
                [
                    'number' => $to,
                ],
            ],
        ];

        $client = new Client($headers);
        try {
            $response = $client->post($this->endpoint, ['json' => $body]);
        } catch (ClientException $clientException) {
            throw new Exception(
                $clientException->getMessage() . '[' . __LINE__ . '][' . class_basename($this) . ']',
                $clientException->getCode(),
                $clientException,
            );
        }

        $this->vars['status_code'] = $response->getStatusCode();
        $this->vars['status_txt'] = $response->getBody()->getContents();

        return $this->vars;
    }

    /**
     * Normalizza il numero di telefono nel formato E.164
     *
     * @param string $phoneNumber Numero di telefono da normalizzare
     * @return string Numero di telefono normalizzato in formato E.164
     */
    /**
     * Normalizza il numero di telefono nel formato E.164
     *
     * @param string $phoneNumber Numero di telefono da normalizzare
     * @return string Numero di telefono normalizzato in formato E.164
     */
    protected function normalizePhoneNumber(string $phoneNumber): string
    {
        // Rimuovi tutti i caratteri non numerici tranne il +
        $cleaned = preg_replace('/[^0-9+]/', '', $phoneNumber);

        // Se preg_replace restituisce null (non dovrebbe succedere con input string)
        if (!is_string($cleaned) || $cleaned === '') {
            $cleaned = '';
        }

        // Se il numero non inizia con '+'
        if (!Str::startsWith($cleaned, '+')) {
            $cleaned = '+39' . ltrim($cleaned, '0');
        }

        return $cleaned;
    }
}
