<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\Aws;

use Aws\Exception\AwsException;
use Spatie\QueueableAction\QueueableAction;

class TestIamPoliciesAction
{
    use QueueableAction;


    /**
     * @return array<string, mixed>
     */
    public function execute(): array
    {
        try {
            $s3 = app(CreateFilesystemS3ClientAction::class)->execute();
            $bucket = app(CreateFilesystemS3ClientAction::class)->bucket();

            $s3->headBucket(['Bucket' => $bucket]);
            $s3->listObjectsV2(['Bucket' => $bucket, 'MaxKeys' => 1]);

            return [
                'status' => 'success',
                'message' => 'IAM policies verified successfully',
                'details' => [
                    'S3 Access' => 'OK',
                    'List Objects' => 'OK',
                    'Bucket Access' => 'OK',
                ],
            ];
        } catch (AwsException $exception) {
            $errorCode = $exception->getAwsErrorCode() ?? 'UnknownError';

            return [
                'status' => 'error',
                'message' => 'IAM policies error: '.$errorCode,
                'details' => [
                    'Error' => $exception->getMessage(),
                    'Solution' => 'Check IAM user policies and permissions',
                ],
            ];
        }
    }
}
