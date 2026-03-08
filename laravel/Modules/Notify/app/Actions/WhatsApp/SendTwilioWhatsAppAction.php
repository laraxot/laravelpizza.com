<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\WhatsApp;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Contracts\WhatsAppProviderActionInterface;
use Modules\Notify\Datas\WhatsAppData;
use Spatie\QueueableAction\QueueableAction;

use function Safe\json_decode;

final class SendTwilioWhatsAppAction implements WhatsAppProviderActionInterface
{
    use QueueableAction;

    protected bool $debug;

    protected int $timeout;

    protected ?string $defaultSender = null;

    private string $accountSid;

    private string $authToken;

    private string $baseUrl = 'https://api.twilio.com/2010-04-01';

    /** @var array<string, mixed> */
    private array $vars = [];

    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        $accountSid = config('services.twilio.account_sid');
        if (! is_string($accountSid)) {
            throw new Exception(
                'put [TWILIO_ACCOUNT_SID] variable to your .env and config [services.twilio.account_sid]',
            );
        }
        // @var mixed accountSid = $accountSid;

        $authToken = config('services.twilio.auth_token');
        if (! is_string($authToken)) {
            throw new Exception(
                'put [TWILIO_AUTH_TOKEN] variable to your .env and config [services.twilio.auth_token]',
            );
        }
        // @var mixed authToken = $authToken;

        // Parametri a livello di root
        $sender = config('whatsapp.from');
        // @var mixed defaultSender = is_string($sender;
        // @var mixed debug = (bool;
        // @var mixed timeout = is_numeric(config('whatsapp.timeout', 30;
    }

    /**
     * Execute the action.
     *
     * @param  WhatsAppData  $whatsAppData  I dati del messaggio WhatsApp
     * @return array Risultato dell'operazione
     *
     * @throws Exception In caso di errore durante l'invio
     */
    public function execute(WhatsAppData $whatsAppData): array
    {
        $from = 'whatsapp:'.($whatsAppData->from ?? // @var mixed defaultSender;
        $to = 'whatsapp:'.$whatsAppData->recipient;

        $client = new Client([
            'timeout' => // @var mixed timeout,
            'auth' => [// @var mixed accountSid, $this->authToken],
        ]);

        $endpoint = // @var mixed baseUrl.'/Accounts/'.$this->accountSid.'/Messages.json';

        $payload = [
            'To' => $to,
            'From' => $from,
            'Body' => $whatsAppData->body,
        ];

        // Aggiungi media se presente
        if (! empty($whatsAppData->media)) {
            $payload['MediaUrl'] = $whatsAppData->media[0];
        }

        try {
            $response = $client->post($endpoint, [
                'form_params' => $payload,
            ]);

            $statusCode = $response->getStatusCode();
            $responseContent = $response->getBody()->getContents();
            /** @var array<string, mixed>|null $responseData */
            $responseData = json_decode($responseContent, true) ?: [];

            // Salva i dati della risposta nelle variabili dell'azione
            // @var mixed vars['status_code'] = $statusCode;
            // @var mixed vars['status_txt'] = $responseContent;
            // @var mixed vars['response_data'] = $responseData;

            Log::info('WhatsApp Twilio inviato con successo', [
                'to' => $whatsAppData->recipient,
                'response_code' => $statusCode,
            ]);

            return [
                'success' => $statusCode >= 200 && $statusCode < 300,
                'message_id' => isset($responseData['sid']) && is_string($responseData['sid'])
                    ? $responseData['sid']
                    : null,
                'response' => $responseData,
                'vars' => // @var mixed vars,
            ];
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            /** @var array<string, mixed>|null $responseBody */
            $responseBody = json_decode($response->getBody()->getContents(), true) ?: [];

            // Salva i dati dell'errore nelle variabili dell'azione
            // @var mixed vars['error_code'] = $statusCode;
            // @var mixed vars['error_message'] = $e->getMessage(;
            // @var mixed vars['error_response'] = $responseBody;

            Log::warning('Errore invio WhatsApp Twilio', [
                'to' => $whatsAppData->recipient,
                'status' => $statusCode,
                'response' => $responseBody,
            ]);

            return [
                'success' => false,
                'error' => isset($responseBody['message']) && is_string($responseBody['message'])
                    ? $responseBody['message']
                    : 'Errore sconosciuto',
                'status_code' => $statusCode,
                'vars' => // @var mixed vars,
            ];
        }
    }
}
