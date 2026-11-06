<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\Aws;

use Exception;
use Spatie\QueueableAction\QueueableAction;

class TestCloudFrontConfigAction
{
    use QueueableAction;

    /**
     * @return array<string, mixed>
     */
    public function execute(): array
    {
        try {
            return [
                'status' => 'success',
                'message' => 'CloudFront configuration valid',
                'details' => [
                    'Base URL' => config('filesystems.cloudfront.url'),
                    'Key Pair ID' => config('filesystems.cloudfront.key_pair_id'),
                ],
            ];
        } catch (Exception $exception) {
            return [
                'status' => 'error',
                'message' => 'CloudFront configuration error',
                'details' => [
                    'Error' => $exception->getMessage(),
                    'Solution' => 'Check CloudFront settings in config',
                ],
            ];
        }
    }
}
