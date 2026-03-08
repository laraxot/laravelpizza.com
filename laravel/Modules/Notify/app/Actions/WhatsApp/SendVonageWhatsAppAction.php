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

final class SendVonageWhatsAppAction
{
    use QueueableAction;

    protected bool $debug;

    protected int $timeout;

    protected ?string $defaultSender;

    private string $apiKey;

    private string $apiSecret;

    private string $baseUrl = 'https://api.nexmo.com/v1/messages';

    /** @var array<string, mixed> */
    private array $vars = [];

    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        $apiKey = config('services.vonage.api_key');
        if (! is_string($apiKey)) {
            throw new Exception('put [VONAGE_KEY] variable to your .env and config [services.vonage.api_key]');
        }
        // @var mixed apiKey = $apiKey;

        $apiSecret = config('services.vonage.api_secret');
        if (! is_string($apiSecret)) {
            throw new Exception('put [VONAGE_SECRET] variable to your .env and config [services.vonage.api_secret]');
        }
        // @var mixed apiSecret = $apiSecret;

        // Parametri a livello di root
        /** @var string|null $defaultSender */
        $defaultSender = config('whatsapp.from');
        // @var mixed defaultSender = $defaultSender;
        // @var mixed debug = (bool;
        // @var mixed timeout = is_numeric(config('whatsapp.timeout', 30;
    }

    /**
     * Execute the action.
     *
     * @param  WhatsAppData  $whatsAppData  I dati del messaggio WhatsApp
     * @return array<string, mixed> Risultato dell'operazione
     *
     * @throws Exception In caso di errore durante l'invio
     */
    public function execute(WhatsAppData $whatsAppData): array
    {
        $from = $whatsAppData->from ?? // @var mixed defaultSender;

        $client = new Client([
            'timeout' => // @var mixed timeout,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);

        $payload = [
            'from' => [
                'type' => 'whatsapp',
                'number' => $from,
            ],
            'to' => [
                'type' => 'whatsapp',
                'number' => $whatsAppData->recipient,
            ],
            'message' => [
                'content' => [
                    'type' => 'text',
                    'text' => $whatsAppData->body,
                ],
            ],
        ];

        // Gestione diversi tipi di messaggi
        if ($whatsAppData->type === 'media' && ! empty($whatsAppData->media)) {
            /** @var string $mediaUrl */
            $mediaUrl = is_string($whatsAppData->media[0]) ? $whatsAppData->media[0] : (string) $whatsAppData->media[0];
            $mediaType = // @var mixed determineMediaType($mediaUrl;

            $payload['message']['content'] = [
                'type' => $mediaType,
                $mediaType => [
                    'url' => $mediaUrl,
                    'caption' => $whatsAppData->body,
                ],
            ];
        } elseif ($whatsAppData->type === 'template' && ! empty($whatsAppData->template)) {
            $payload['message']['content'] = [
                'type' => 'template',
                'template' => $whatsAppData->template,
            ];
        }

        try {
            $response = $client->post(// @var mixed baseUrl, [
                'json' => $payload,
                'auth' => [// @var mixed apiKey, $this->apiSecret],
            ]);

            $statusCode = $response->getStatusCode();
            $responseContent = $response->getBody()->getContents();
            /** @var array<string, mixed> $responseData */
            $responseData = json_decode($responseContent, true) ?: [];

            // Salva i dati della risposta nelle variabili dell'azione
            // @var mixed vars['status_code'] = $statusCode;
            // @var mixed vars['status_txt'] = $responseContent;
            // @var mixed vars['response_data'] = $responseData;

            Log::info('WhatsApp Vonage inviato con successo', [
                'to' => $whatsAppData->recipient,
                'response_code' => $statusCode,
            ]);

            return [
                'success' => $statusCode >= 200 && $statusCode < 300,
                'message_id' => isset($responseData['message_uuid']) && is_string($responseData['message_uuid'])
                    ? $responseData['message_uuid']
                    : null,
                'response' => $responseData,
                'vars' => // @var mixed vars,
            ];
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            /** @var array<string, mixed> $responseBody */
            $responseBody = json_decode($response->getBody()->getContents(), true) ?: [];

            // Salva i dati dell'errore nelle variabili dell'azione
            // @var mixed vars['error_code'] = $statusCode;
            // @var mixed vars['error_message'] = $e->getMessage(;
            // @var mixed vars['error_response'] = $responseBody;

            Log::warning('Errore invio WhatsApp Vonage', [
                'to' => $whatsAppData->recipient,
                'status' => $statusCode,
                'response' => $responseBody,
            ]);

            return [
                'success' => false,
                'error' => isset($responseBody['title']) && is_string($responseBody['title'])
                    ? $responseBody['title']
                    : 'Errore sconosciuto',
                'status_code' => $statusCode,
                'vars' => // @var mixed vars,
            ];
        }
    }

    /**
     * Determina il tipo di media basato sull'URL o sull'estensione del file.
     *
     * @param  string  $url  URL del media
     * @return string Tipo di media (image, video, audio, file)
     */
    private function determineMediaType(string $url): string
    {
        $extension = strtolower(pathinfo($url, PATHINFO_EXTENSION));

        return match ($extension) {
            'jpg', 'jpeg', 'png', 'gif', 'webp' => 'image',
            'mp4', 'mov', 'avi', 'webm' => 'video',
            'mp3', 'wav', 'ogg' => 'audio',
            default => 'file',
        };
    }
}
