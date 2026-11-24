<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\Aws;

use Aws\Exception\AwsException;
use Spatie\QueueableAction\QueueableAction;

class TestS3PermissionsAction
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

            $s3->listObjectsV2(['Bucket' => $bucket, 'MaxKeys' => 1]);

            return [
                'status' => 'success',
                'message' => 'S3 permissions verified successfully',
                'details' => [
                    'ListObjects' => 'OK',
                    'Bucket' => $bucket,
                ],
            ];
        } catch (AwsException $exception) {
            $errorCode = $exception->getAwsErrorCode() ?? 'UnknownError';

            return [
                'status' => 'error',
                'message' => 'S3 permissions error: '.$errorCode,
                'details' => [
                    'Error' => $exception->getMessage(),
                    'Solution' => app(ResolveAwsS3ErrorSolutionAction::class)->execute($errorCode),
                ],
            ];
        }
    }
}
