<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\Aws;

use Spatie\QueueableAction\QueueableAction;

class ResolveAwsS3ErrorSolutionAction
{
    use QueueableAction;

    public function execute(?string $errorCode): string
    {
        if ($errorCode === null) {
            return 'Unknown error - check AWS credentials and configuration';
        }

        $solutions = [
            'SignatureDoesNotMatch' => 'Verify your AWS_SECRET_ACCESS_KEY in .env',
            'AccessDenied' => 'Check IAM permissions for S3 access',
            'NoSuchBucket' => 'Verify bucket name and region',
            'InvalidAccessKeyId' => 'Check AWS_ACCESS_KEY_ID',
            'BucketRegionError' => 'Update AWS_DEFAULT_REGION to match bucket region',
        ];

        return $solutions[$errorCode] ?? ('Consult AWS documentation for error: '.$errorCode);
    }
}
