<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Override;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SMS\SmsFactorData;
use Modules\Notify\Datas\SmsData;
use Spatie\QueueableAction\QueueableAction;

final class SendSmsFactorSMSAction implements SmsActionContract
{
    use QueueableAction;

    /** @var SmsFactorData */
    private SmsFactorData $smsFactorData;

    /** @var array<string, mixed> */
    private array $vars = [];

    /** @var bool */
    protected bool $debug;

    /** @var string|null */
    protected null|string $defaultSender = null;

    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        $this->smsFactorData = SmsFactorData::make();

        if (!$this->smsFactorData->token) {
            throw new Exception('Token SMSFactor non configurato in sms.php');
        }

        // Parametri a livello di root
        $sender = config('sms.from');
        $this->defaultSender = is_string($sender) ? $sender : null;
        $this->debug = (bool) config('sms.debug', false);
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
        $headers = $this->smsFactorData->getAuthHeaders();

        // Normalizza il numero di telefono
        $to = (string) $smsData->to;
        if (Str::startsWith($to, '00')) {
            $to = $to !== '' ? ('+' . substr($to, 2)) : $to;
        }

        if (!Str::startsWith($to, '+')) {
            $to = '+39' . $to;
        }

        $body = [
            'text' => $smsData->body,
            'sender' => $smsData->from ?? $this->defaultSender,
            'recipients' => [
                [
                    'phone' => $to,
                ],
            ],
            'type' => 'sms',
        ];

        $client = new Client([
            'timeout' => $this->smsFactorData->getTimeout(),
            'headers' => $headers,
        ]);

        try {
            $response = $client->post($this->smsFactorData->getBaseUrl() . '/messages', ['json' => $body]);
            $this->vars['status_code'] = $response->getStatusCode();
            $this->vars['status_txt'] = $response->getBody()->getContents();

            return $this->vars;
        } catch (ClientException $clientException) {
            throw new Exception(
                $clientException->getMessage() . '[' . __LINE__ . '][' . class_basename($this) . ']',
                $clientException->getCode(),
                $clientException,
            );
        }
    }
}
