<?php

declare(strict_types=1);
// File: Laravel/Modules/CloudStorage/Services/GoogleDriveService.php

namespace Modules\CloudStorage\Services;

use Modules\Xot\Datas\XotData;
use Exception;
use Google\Client;
use Google\Service\Drive;
use Webmozart\Assert\Assert;

class GoogleDriveService
{
    protected Client $client;

    protected Drive $driveService;

    public function __construct()
    {
        $this->client = new Client;
        Assert::string($client_id = config('services.google.client_id'));
        Assert::string($client_secret = config('services.google.client_secret'));
        Assert::string($redirect = config('services.google.redirect'));
        Assert::isArray($scopes = config('services.google.scopes'));

        $this->client->setClientId($client_id);
        $this->client->setClientSecret($client_secret);
        $this->client->setRedirectUri($redirect);
        $this->client->setScopes($scopes);
        $this->client->setAccessType('offline');

        $user = auth()->user();
        if ($user === null) {
            throw new Exception('Utente non autenticato');
        }

        // Usa XotData per ottenere la classe utente corretta
        $userClass = XotData::make()->getUserClass();
        Assert::isInstanceOf($user, $userClass);

        // Type narrowing per il metodo getProviderField
        if (method_exists($user, 'getProviderField')) {
            $token = $user->getProviderField('google', 'token');
            if (is_string($token) || is_array($token)) {
                $this->client->setAccessToken($token);
            }
        }

        $this->driveService = new Drive($this->client);
    }

    /**
     * Summary of getFiles.
     *
     * @return array<int, mixed>
     */
    public function getFiles(): array
    {
        $filesResource = $this->driveService->files;
        if (! is_object($filesResource)) {
            return [];
        }

        if (! method_exists($filesResource, 'listFiles')) {
            return [];
        }

        $result = $filesResource->listFiles([
            'fields' => 'files(id, name, mimeType, modifiedTime, size)',
            'q' => "'root' in parents and trashed = false",
        ]);

        if (! is_object($result) || ! method_exists($result, 'getFiles')) {
            return [];
        }

        $filesList = $result->getFiles();
        if (! is_array($filesList)) {
            return [];
        }

        /** @var array<int, mixed> */
        return $filesList;
    }
}
