<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\Aws;

use Aws\Exception\AwsException;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/test-s3-connection-action.md
 *
 * @contract docs/contracts/test-s3-connection-action.md
 */
class TestS3ConnectionAction
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

            return [
                'status' => 'success',
                'message' => 'Successfully connected to S3 bucket',
                'details' => [
                    'Bucket' => $bucket,
                    'Region' => config('filesystems.disks.s3.region'),
                ],
            ];
        } catch (AwsException $exception) {
            $errorCode = $exception->getAwsErrorCode() ?? 'UnknownError';

            return [
                'status' => 'error',
                'message' => $errorCode,
                'details' => [
                    'Error' => $exception->getMessage(),
                    'Solution' => app(ResolveAwsS3ErrorSolutionAction::class)->execute($errorCode),
                ],
            ];
        }
    }
}
