<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\S3;

use Aws\Exception\AwsException;
use Modules\Media\Actions\Diagnostic\Aws\CreateFilesystemS3ClientAction;
use Modules\Media\Actions\Diagnostic\Aws\ResolveAwsS3ErrorSolutionAction;
use Spatie\QueueableAction\QueueableAction;

class TestConnectionDetailsAction
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

            $location = $s3->getBucketLocation(['Bucket' => $bucket]);
            $bucketRegion = $location['LocationConstraint'] ?: 'us-east-1';
            $regionMatch = $bucketRegion === config('filesystems.disks.s3.region');

            return [
                'title' => '☁️ S3 Connection',
                'status' => 'success',
                'data' => [
                    'Bucket Accessible' => '✅ Yes',
                    'Bucket Region' => $bucketRegion,
                    'Config Region' => config('filesystems.disks.s3.region'),
                    'Region Match' => $regionMatch ? '✅ Yes' : '⚠️ No - This might cause issues',
                ],
            ];
        } catch (AwsException $exception) {
            return [
                'title' => '☁️ S3 Connection',
                'status' => 'error',
                'data' => [
                    'Bucket Accessible' => '❌ No',
                    'Error Code' => $exception->getAwsErrorCode() ?? 'UnknownError',
                    'Message' => $exception->getMessage(),
                    'Solution' => app(ResolveAwsS3ErrorSolutionAction::class)->execute($exception->getAwsErrorCode()),
                ],
            ];
        }
    }
}
