<?php

declare(strict_types=1);

namespace Modules\Pdnd\Filament\Clusters\Test\Pages;

use Exception;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;

use function Safe\json_decode;
use function Safe\json_encode;

/**
 * @property Schema $emailForm
 */
class CurlProxyPage extends XotBasePage
{
    use NavigationLabelTrait;

    // public ?array $data = [];

    /** @var array<string, mixed>|null */
    public ?array $testResults = null;

    public ?float $responseTime = null;

    public ?int $statusCode = null;

    public ?string $errorMessage = null;

    public Schema $form;

    protected string $view = 'pdnd::filament.pages.guzzle-proxy-test';

    protected static ?string $cluster = Test::class;

    public function mount(): void
    {
        $this->form->fill([
            'target_url' => 'https://httpbin.org/ip',
            'proxy_host' => '127.0.0.1',
            'proxy_port' => '8080',
            'proxy_username' => '',
            'proxy_password' => '',
            'timeout' => 30,
            'method' => 'GET',
        ]);
    }

    protected function getHeaderActions(): array
    {
        // Types are inferred by Filament v4
        return [
            Action::make('testConnection')
                ->icon('heroicon-o-play')
                ->color('success')
                ->action('executeTest'),

            Action::make('clearResults')
                ->icon('heroicon-o-trash')
                ->color('gray')
                ->action('clearResults')
                ->visible(fn (): bool => $this->testResults !== null),
        ];
    }

    public function executeTest(): void
    {
        $this->validate();

        $data = $this->form->getState();

        try {
            $startTime = microtime(true);

            // Configurazione del client Guzzle
            $clientConfig = [
                'timeout' => $data['timeout'],
                'verify' => $data['verify_ssl'] ?? true,
            ];

            // Configurazione proxy
            $proxyTypeRaw = $data['proxy_type'] ?? 'http';
            assert(is_string($proxyTypeRaw));
            $proxyType = $proxyTypeRaw;

            $proxyHostRaw = $data['proxy_host'] ?? '';
            assert(is_string($proxyHostRaw));
            $proxyHost = $proxyHostRaw;

            $proxyPortRaw = $data['proxy_port'] ?? '';
            $proxyPort = is_string($proxyPortRaw) || is_int($proxyPortRaw) ? (string) $proxyPortRaw : '';

            $proxyUsernameRaw = $data['proxy_username'] ?? '';
            assert(is_string($proxyUsernameRaw));
            $proxyUsername = $proxyUsernameRaw;

            $proxyPasswordRaw = $data['proxy_password'] ?? '';
            assert(is_string($proxyPasswordRaw));
            $proxyPassword = $proxyPasswordRaw;

            $proxyUrl = $proxyType.'://';

            if ($proxyUsername !== '' && $proxyPassword !== '') {
                $proxyUrl .= $proxyUsername.':'.$proxyPassword.'@';
            }

            $proxyUrl .= $proxyHost.':'.$proxyPort;

            $clientConfig['proxy'] = [
                'http' => $proxyUrl,
                'https' => $proxyUrl,
            ];

            $client = new Client($clientConfig);

            // Preparazione headers
            $headers = [
                'User-Agent' => 'Filament-Guzzle-Test/1.0',
            ];

            if (! empty($data['headers'])) {
                $headersRaw = $data['headers'];
                assert(is_string($headersRaw));
                /** @var array<string, mixed> $additionalHeaders */
                $additionalHeaders = json_decode($headersRaw, true);
                if (is_array($additionalHeaders)) {
                    $headers = array_merge($headers, $additionalHeaders);
                }
            }

            // Preparazione opzioni richiesta
            $requestOptions = [
                'headers' => $headers,
            ];

            // Aggiunta body per richieste POST/PUT/PATCH
            $methodRaw = $data['method'] ?? 'GET';
            assert(is_string($methodRaw));
            $method = $methodRaw;

            if (in_array($method, ['POST', 'PUT', 'PATCH']) && ! empty($data['request_body'])) {
                $requestOptions['body'] = $data['request_body'];
            }

            // Esecuzione richiesta
            $targetUrlRaw = $data['target_url'] ?? '';
            assert(is_string($targetUrlRaw));
            $targetUrl = $targetUrlRaw;
            $response = $client->request($method, $targetUrl, $requestOptions);

            $endTime = microtime(true);
            $this->responseTime = round(($endTime - $startTime) * 1000, 2);

            $this->statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            // Tentativo di formattare JSON per una migliore visualizzazione
            /** @var array<string, mixed>|null $decodedBody */
            $decodedBody = json_decode($responseBody, true);
            if (is_array($decodedBody)) {
                $responseBody = json_encode($decodedBody, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }

            $this->testResults = [
                'success' => true,
                'status_code' => $this->statusCode,
                'response_time' => $this->responseTime,
                'headers' => $response->getHeaders(),
                'body' => $responseBody,
                'proxy_used' => $proxyUrl,
            ];

            $this->errorMessage = null;

            Notification::make()
                ->title('Test completato con successo!')
                ->body("Status: {$this->statusCode} | Tempo: {$this->responseTime}ms")
                ->success()
                ->send();

            // Log del test
            Log::info('Guzzle Proxy Test executed successfully', [
                'url' => $data['target_url'],
                'proxy' => $proxyUrl,
                'status' => $this->statusCode,
                'response_time' => $this->responseTime,
            ]);
        } catch (RequestException $e) {
            $this->handleRequestException($e);
        } catch (Exception $e) {
            $this->handleGenericException($e);
        }
    }

    private function handleRequestException(RequestException $e): void
    {
        $this->testResults = [
            'success' => false,
            'error_type' => 'Request Exception',
            'proxy_used' => $this->buildProxyUrl(),
        ];

        $this->errorMessage = $e->getMessage();

        if ($e->hasResponse()) {
            $response = $e->getResponse();
            if ($response !== null) {
                $this->statusCode = $response->getStatusCode();
                $this->testResults['status_code'] = $this->statusCode;
                $this->testResults['response_body'] = $response->getBody()->getContents();
            }
        }

        Notification::make()
            ->title('Errore nella richiesta')
            ->body($this->errorMessage)
            ->danger()
            ->send();

        Log::error('Guzzle Proxy Test failed with RequestException', [
            'error' => $this->errorMessage,
            'proxy' => $this->buildProxyUrl(),
        ]);
    }

    private function handleGenericException(Exception $e): void
    {
        $this->testResults = [
            'success' => false,
            'error_type' => 'Generic Exception',
            'proxy_used' => $this->buildProxyUrl(),
        ];

        $this->errorMessage = $e->getMessage();

        Notification::make()
            ->title('Errore generico')
            ->body($this->errorMessage)
            ->danger()
            ->send();

        Log::error('Guzzle Proxy Test failed with Exception', [
            'error' => $this->errorMessage,
            'proxy' => $this->buildProxyUrl(),
        ]);
    }

    private function buildProxyUrl(): string
    {
        /** @var array<string, mixed> $data */
        $data = $this->form->getState();

        $proxyTypeRaw = $data['proxy_type'] ?? 'http';
        $proxyType = is_string($proxyTypeRaw) ? $proxyTypeRaw : 'http';

        $proxyHostRaw = $data['proxy_host'] ?? '';
        $proxyHost = is_string($proxyHostRaw) ? $proxyHostRaw : '';

        $proxyPortRaw = $data['proxy_port'] ?? '';
        $proxyPort = is_string($proxyPortRaw) || is_int($proxyPortRaw) ? (string) $proxyPortRaw : '';

        $proxyUsernameRaw = $data['proxy_username'] ?? '';
        $proxyUsername = is_string($proxyUsernameRaw) ? $proxyUsernameRaw : '';

        $proxyPasswordRaw = $data['proxy_password'] ?? '';
        $proxyPassword = is_string($proxyPasswordRaw) ? $proxyPasswordRaw : '';

        $proxyUrl = $proxyType.'://';

        if ($proxyUsername !== '' && $proxyPassword !== '') {
            $proxyUrl .= $proxyUsername.':***@';
        }

        $proxyUrl .= $proxyHost.':'.$proxyPort;

        return $proxyUrl;
    }

    public function clearResults(): void
    {
        $this->testResults = null;
        $this->responseTime = null;
        $this->statusCode = null;
        $this->errorMessage = null;

        Notification::make()
            ->title('Risultati cancellati')
            ->success()
            ->send();
    }
}
