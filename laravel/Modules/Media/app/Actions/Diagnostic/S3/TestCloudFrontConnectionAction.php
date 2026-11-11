<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\S3;

use Exception;
use Modules\Media\Actions\CloudFront\GetCloudFrontSignedUrlAction;
use Spatie\QueueableAction\QueueableAction;

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

            if (! $baseUrl || ! $keyPairId || ! $privateKey) {
                return $this->incompleteConfiguration($baseUrl, $keyPairId, $privateKey);
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
     * @return array<string, mixed>
     */
    private function incompleteConfiguration(mixed $baseUrl, mixed $keyPairId, mixed $privateKey): array
    {
        return [
            'title' => '☁️ CloudFront',
            'status' => 'error',
            'data' => [
                'Configuration' => '❌ Incomplete',
                'Missing' => collect([
                    'Base URL' => ! $baseUrl,
                    'Key Pair ID' => ! $keyPairId,
                    'Private Key' => ! $privateKey,
                ])
                    ->filter()
                    ->keys()
                    ->implode(', '),
            ],
        ];
    }
}
