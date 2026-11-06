<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\Aws;

use Exception;
use Spatie\QueueableAction\QueueableAction;

class TestCloudFrontSignedUrlsAction
{
    use QueueableAction;

    /**
     * @return array<string, mixed>
     */
    public function execute(): array
    {
        try {
            $privateKey = config('filesystems.cloudfront.private_key');
            $keyPairId = config('filesystems.cloudfront.key_pair_id');
            $baseUrl = config('filesystems.cloudfront.url');

            if (! $privateKey || ! $keyPairId || ! $baseUrl) {
                throw new Exception('Missing CloudFront configuration');
            }

            return [
                'status' => 'success',
                'message' => 'CloudFront signed URL configuration valid',
                'details' => [
                    'Base URL' => $baseUrl,
                    'Key Pair ID' => $keyPairId,
                    'Private Key' => 'Configured',
                ],
            ];
        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'message' => 'CloudFront signed URL error',
                'details' => [
                    'Error' => $exception->getMessage(),
                    'Solution' => 'Check CloudFront private key and configuration',
                ],
            ];
        }
    }
}
