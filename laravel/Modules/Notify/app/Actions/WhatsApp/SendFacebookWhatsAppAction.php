<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\WhatsApp;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Datas\WhatsAppData;
use Spatie\QueueableAction\QueueableAction;

use function Safe\json_decode;

final class SendFacebookWhatsAppAction
{
    use QueueableAction;

    private string $accessToken;
    private string $phoneNumberId;
    private string $baseUrl = 'https://graph.facebook.com/v17.0';
    /** @var array<string, mixed> */
    private array $vars = [];
    protected bool $debug;
    protected int $timeout;

    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        $accessToken = config('services.facebook.access_token');
        if (!is_string($accessToken)) {
            throw new Exception(
                'put [FACEBOOK_ACCESS_TOKEN] variable to your .env and config [services.facebook.access_token]',
            );
        }
        $this->accessToken = $accessToken;

        $phoneNumberId = config('services.facebook.phone_number_id');
        if (!is_string($phoneNumberId)) {
            throw new Exception(
                'put [FACEBOOK_PHONE_NUMBER_ID] variable to your .env and config [services.facebook.phone_number_id]',
            );
        }
        $this->phoneNumberId = $phoneNumberId;

        // Parametri a livello di root
        $this->debug = (bool) config('whatsapp.debug', false);
        $this->timeout = is_numeric(config('whatsapp.timeout', 30)) ? (int) config('whatsapp.timeout', 30) : 30;
    }

    /**
     * Execute the action.
     *
     * @param WhatsAppData $whatsAppData I dati del messaggio WhatsApp
     * @return array<string, mixed> Risultato dell'operazione
     * @throws Exception In caso di errore durante l'invio
     */
    public function execute(WhatsAppData $whatsAppData): array
    {
        // Log di debug se abilitato
        if ($this->debug) {
            Log::debug('Invio WhatsApp Facebook', [
                'to' => $whatsAppData->to,
                'message_length' => strlen($whatsAppData->body),
                'type' => $whatsAppData->type,
            ]);
        }

        $client = new Client([
            'timeout' => $this->timeout,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
        ]);

        $endpoint = $this->baseUrl . '/' . $this->phoneNumberId . '/messages';

        $payload = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $whatsAppData->to,
        ];

        // Gestione diversi tipi di messaggi
        if ($whatsAppData->type === 'text') {
            $payload['type'] = 'text';
            $payload['text'] = [
                'preview_url' => false,
                'body' => $whatsAppData->body,
            ];
        } elseif ($whatsAppData->type === 'template' && !empty($whatsAppData->template)) {
            $payload['type'] = 'template';
            $payload['template'] = $whatsAppData->template;
        } elseif ($whatsAppData->type === 'media' && !empty($whatsAppData->media)) {
            $payload['type'] = 'image'; // o video, document, audio
            $payload['image'] = [
                'link' => $whatsAppData->media[0],
            ];
        }

        try {
            $response = $client->post($endpoint, [
                'json' => $payload,
            ]);

            $statusCode = $response->getStatusCode();
            $responseContent = $response->getBody()->getContents();
            /** @var array<string, mixed> $responseData */
            $responseData = json_decode($responseContent, true) ?: [];

            // Salva i dati della risposta nelle variabili dell'azione
            $this->vars['status_code'] = $statusCode;
            $this->vars['status_txt'] = $responseContent;
            $this->vars['response_data'] = $responseData;

            Log::info('WhatsApp Facebook inviato con successo', [
                'to' => $whatsAppData->to,
                'response_code' => $statusCode,
            ]);

            /** @var array<string, mixed>|null $messages */
            $messages = $responseData['messages'] ?? null;
            /** @var array<string, mixed>|null $firstMessage */
            $firstMessage = (is_array($messages) && isset($messages[0]) && is_array($messages[0])) ? $messages[0] : null;
            /** @var string|null $messageId */
            $messageId = (is_array($firstMessage) && isset($firstMessage['id']) && is_string($firstMessage['id']))
                ? $firstMessage['id']
                : null;

            return [
                'success' => $statusCode >= 200 && $statusCode < 300,
                'message_id' => $messageId,
                'response' => $responseData,
                'vars' => $this->vars,
            ];
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            /** @var array<string, mixed> $responseBody */
            $responseBody = json_decode($response->getBody()->getContents(), true) ?: [];

            // Salva i dati dell'errore nelle variabili dell'azione
            $this->vars['error_code'] = $statusCode;
            $this->vars['error_message'] = $e->getMessage();
            $this->vars['error_response'] = $responseBody;

            Log::warning('Errore invio WhatsApp Facebook', [
                'to' => $whatsAppData->to,
                'status' => $statusCode,
                'response' => $responseBody,
            ]);

            /** @var array<string, mixed>|null $error */
            $error = $responseBody['error'] ?? null;
            /** @var string $errorMessage */
            $errorMessage = (is_array($error) && isset($error['message']) && is_string($error['message']))
                ? $error['message']
                : 'Errore sconosciuto';

            return [
                'success' => false,
                'error' => $errorMessage,
                'status_code' => $statusCode,
                'vars' => $this->vars,
            ];
        }
    }
}
