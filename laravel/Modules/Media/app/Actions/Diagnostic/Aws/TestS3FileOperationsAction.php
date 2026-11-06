<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\Aws;

use Aws\Exception\AwsException;
use Spatie\QueueableAction\QueueableAction;

class TestS3FileOperationsAction
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
            $testFileName = 'test-file-'.now()->timestamp.'.txt';
            $testContent = 'Test file content for AWS S3 operations';

            $s3->putObject([
                'Bucket' => $bucket,
                'Key' => $testFileName,
                'Body' => $testContent,
                'ContentType' => 'text/plain',
            ]);

            $s3->getObject(['Bucket' => $bucket, 'Key' => $testFileName]);
            $s3->deleteObject(['Bucket' => $bucket, 'Key' => $testFileName]);

            return [
                'status' => 'success',
                'message' => 'S3 file operations completed successfully',
                'details' => [
                    'Upload' => 'OK',
                    'Download' => 'OK',
                    'Delete' => 'OK',
                    'Test File' => $testFileName,
                ],
            ];
        } catch (AwsException $exception) {
            $errorCode = $exception->getAwsErrorCode() ?? 'UnknownError';

            return [
                'status' => 'error',
                'message' => 'S3 file operations error: '.$errorCode,
                'details' => [
                    'Error' => $exception->getMessage(),
                    'Solution' => app(ResolveAwsS3ErrorSolutionAction::class)->execute($errorCode),
                ],
            ];
        }
    }
}
