<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\S3;

use Spatie\QueueableAction\QueueableAction;

class BuildConfigDebugDataAction
{
    use QueueableAction;

    /**
     * @return array<string, mixed>
     */
    public function execute(): array
    {
        $accessKeyId = config('filesystems.disks.s3.key', '');

        return [
            'title' => '📋 Configuration',
            'status' => 'info',
            'data' => [
                'AWS_ACCESS_KEY_ID' => is_string($accessKeyId)
                    ? substr($accessKeyId, 0, 8).'...'
                    : '',
                'AWS_SECRET_ACCESS_KEY' => config('filesystems.disks.s3.secret') ? '✅ Present' : '❌ Missing',
                'AWS_DEFAULT_REGION' => config('filesystems.disks.s3.region'),
                'AWS_BUCKET' => config('filesystems.disks.s3.bucket'),
                'AWS_USE_PATH_STYLE_ENDPOINT' => config('filesystems.disks.s3.use_path_style_endpoint', 'false'),
                'CLOUDFRONT_BASE_URL' => config('services.cloudfront.base_url'),
                'CLOUDFRONT_KEYPAIR_ID' => config('services.cloudfront.key_pair_id'),
                'CLOUDFRONT_PRIVATE_KEY' => config('services.cloudfront.private_key')
                    ? '✅ Present'
                    : '❌ Missing',
            ],
        ];
    }
}
