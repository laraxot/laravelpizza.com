<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\Aws;

use Spatie\QueueableAction\QueueableAction;

class GetAwsConfigSnapshotAction
{
    use QueueableAction;

    private const int KEY_PREVIEW_LENGTH = 8;

    /**
     * @return array<string, mixed>
     */
    public function execute(): array
    {
        $accessKeyId = config('filesystems.disks.s3.key', '');

        return [
            'AWS_ACCESS_KEY_ID' => is_string($accessKeyId)
                ? substr($accessKeyId, 0, self::KEY_PREVIEW_LENGTH).'...'
                : '',
            'AWS_DEFAULT_REGION' => config('filesystems.disks.s3.region'),
            'AWS_BUCKET' => config('filesystems.disks.s3.bucket'),
            'CLOUDFRONT_URL' => config('filesystems.cloudfront.url'),
            'CLOUDFRONT_KEY_PAIR_ID' => config('filesystems.cloudfront.key_pair_id'),
        ];
    }
}
