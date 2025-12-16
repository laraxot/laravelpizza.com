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

    private string $apiKey;
    private string $apiSecret;
    private string $baseUrl = 'https://api.nexmo.com/v1/messages';
    /** @var array<string, mixed> */
    private array $vars = [];
    protected bool $debug;
    protected int $timeout;
    protected ?string $defaultSender;

    /**
     * Create a new action instance.
     */
    public function __construct()
    {
        $apiKey = config('services.vonage.api_key');
        if (!is_string($apiKey)) {
            throw new Exception('put [VONAGE_KEY] variable to your .env and config [services.vonage.api_key]');
        }
        $this->apiKey = $apiKey;

        $apiSecret = config('services.vonage.api_secret');
        if (!is_string($apiSecret)) {
            throw new Exception('put [VONAGE_SECRET] variable to your .env and config [services.vonage.api_secret]');
        }
        $this->apiSecret = $apiSecret;

        // Parametri a livello di root
        /** @var string|null $defaultSender */
        $defaultSender = config('whatsapp.from');
        $this->defaultSender = $defaultSender;
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
        $from = $whatsAppData->from ?? $this->defaultSender;

        // Log di debug se abilitato
        if ($this->debug) {
            Log::debug('Invio WhatsApp Vonage', [
                'to' => $whatsAppData->to,
                'from' => $from,
                'message_length' => strlen($whatsAppData->body),
            ]);
        }

        $client = new Client([
            'timeout' => $this->timeout,
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
                'number' => $whatsAppData->to,
            ],
            'message' => [
                'content' => [
                    'type' => 'text',
                    'text' => $whatsAppData->body,
                ],
            ],
        ];

        // Gestione diversi tipi di messaggi
        if ($whatsAppData->type === 'media' && !empty($whatsAppData->media)) {
            /** @var string $mediaUrl */
            $mediaUrl = is_string($whatsAppData->media[0]) ? $whatsAppData->media[0] : (string) $whatsAppData->media[0];
            $mediaType = $this->determineMediaType($mediaUrl);

            $payload['message']['content'] = [
                'type' => $mediaType,
                $mediaType => [
                    'url' => $mediaUrl,
                    'caption' => $whatsAppData->body,
                ],
            ];
        } elseif ($whatsAppData->type === 'template' && !empty($whatsAppData->template)) {
            $payload['message']['content'] = [
                'type' => 'template',
                'template' => $whatsAppData->template,
            ];
        }

        try {
            $response = $client->post($this->baseUrl, [
                'json' => $payload,
                'auth' => [$this->apiKey, $this->apiSecret],
            ]);

            $statusCode = $response->getStatusCode();
            $responseContent = $response->getBody()->getContents();
            /** @var array<string, mixed> $responseData */
            $responseData = json_decode($responseContent, true) ?: [];

            // Salva i dati della risposta nelle variabili dell'azione
            $this->vars['status_code'] = $statusCode;
            $this->vars['status_txt'] = $responseContent;
            $this->vars['response_data'] = $responseData;

            Log::info('WhatsApp Vonage inviato con successo', [
                'to' => $whatsAppData->to,
                'response_code' => $statusCode,
            ]);

            return [
                'success' => $statusCode >= 200 && $statusCode < 300,
                'message_id' => isset($responseData['message_uuid']) && is_string($responseData['message_uuid'])
                    ? $responseData['message_uuid']
                    : null,
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

            Log::warning('Errore invio WhatsApp Vonage', [
                'to' => $whatsAppData->to,
                'status' => $statusCode,
                'response' => $responseBody,
            ]);

            return [
                'success' => false,
                'error' => isset($responseBody['title']) && is_string($responseBody['title'])
                    ? $responseBody['title']
                    : 'Errore sconosciuto',
                'status_code' => $statusCode,
                'vars' => $this->vars,
            ];
        }
    }

    /**
     * Determina il tipo di media basato sull'URL o sull'estensione del file.
     *
     * @param string $url URL del media
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
