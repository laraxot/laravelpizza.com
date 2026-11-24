<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\S3;

use Exception;
use Modules\Media\Actions\CloudFront\GetCloudFrontSignedUrlAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/test-cloud-front-connection-action.md
 *
 * @contract docs/contracts/test-cloud-front-connection-action.md
 */
class TestCloudFrontConnectionAction
{
    use QueueableAction;

    private const int URL_PREVIEW_LENGTH = 100;

    /**
     * @return array<string, mixed>
     */
    public function execute(string $testFile = 'test-file.txt'): array
    {
        try {
            $baseUrl = config('services.cloudfront.base_url');
            $keyPairId = config('services.cloudfront.key_pair_id');
            $privateKey = config('services.cloudfront.private_key');

            $missing = array_keys(array_filter([
                'Base URL' => ! $baseUrl,
                'Key Pair ID' => ! $keyPairId,
                'Private Key' => ! $privateKey,
            ]));

            if ($missing !== []) {
                return $this->incompleteConfiguration($missing);
            }

            $testUrl = app(GetCloudFrontSignedUrlAction::class)->execute($testFile, 5);

            return [
                'title' => '☁️ CloudFront',
                'status' => 'success',
                'data' => [
                    'Configuration' => '✅ Complete',
                    'Base URL' => $baseUrl,
                    'Key Pair ID' => $keyPairId,
                    'Signed URL Test' => '✅ Success',
                    'Sample URL' => substr((string) $testUrl, 0, self::URL_PREVIEW_LENGTH).'...',
                ],
            ];
        } catch (Exception $exception) {
            return [
                'title' => '☁️ CloudFront',
                'status' => 'error',
                'data' => [
                    'Error' => $exception->getMessage(),
                ],
            ];
        }
    }

    /**
     * Risultato di errore quando mancano chiavi di configurazione CloudFront.
     *
     * @param  list<string>  $missing  etichette delle chiavi mancanti
     * @return array{title: string, status: string, data: array<string, string>}
     */
    private function incompleteConfiguration(array $missing): array
    {
        return [
            'title' => '☁️ CloudFront',
            'status' => 'error',
            'data' => [
                'Configuration' => '❌ Incomplete',
                'Missing' => implode(', ', $missing),
            ],
        ];
    }
}
