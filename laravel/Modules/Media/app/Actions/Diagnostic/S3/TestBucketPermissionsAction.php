<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\S3;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Exception;
use Modules\Media\Actions\Diagnostic\Aws\CreateFilesystemS3ClientAction;
use Spatie\QueueableAction\QueueableAction;

class TestBucketPermissionsAction
{
    use QueueableAction;

    private const string TITLE = '🔒 S3 Permissions';

    /**
     * @return array<string, mixed>
     */
    public function execute(string $testKeyPrefix = 'test-permissions-'): array
    {
        try {
            $client = app(CreateFilesystemS3ClientAction::class);
            $testKey = $testKeyPrefix.time().'.txt';

            return [
                'title' => self::TITLE,
                'status' => 'success',
                'data' => $this->probePermissions($client->execute(), $client->bucket(), $testKey),
            ];
        } catch (Exception $exception) {
            return [
                'title' => self::TITLE,
                'status' => 'error',
                'data' => ['Error' => $exception->getMessage()],
            ];
        }
    }

    /**
     * @return array<string, string>
     */
    private function probePermissions(S3Client $s3, string $bucket, string $testKey): array
    {
        $data = [];
        $data['ListBucket'] = $this->probeListBucket($s3, $bucket);
        $data = array_merge($data, $this->probeObjectCrud($s3, $bucket, $testKey));

        return $data;
    }

    private function probeListBucket(S3Client $s3, string $bucket): string
    {
        try {
            $s3->listObjectsV2(['Bucket' => $bucket, 'MaxKeys' => 1]);

            return '✅ OK';
        } catch (AwsException $exception) {
            return '❌ '.($exception->getAwsErrorCode() ?? 'UnknownError');
        }
    }

    /**
     * @return array<string, string>
     */
    private function probeObjectCrud(S3Client $s3, string $bucket, string $testKey): array
    {
        try {
            $s3->putObject([
                'Bucket' => $bucket,
                'Key' => $testKey,
                'Body' => 'Test permissions',
                'ACL' => 'private',
            ]);
        } catch (AwsException $exception) {
            return [
                'PutObject' => '❌ '.($exception->getAwsErrorCode() ?? 'UnknownError'),
                'GetObject' => 'Skipped (PutObject failed)',
                'DeleteObject' => 'Skipped (PutObject failed)',
            ];
        }

        return [
            'PutObject' => '✅ OK',
            'GetObject' => $this->probeGetObject($s3, $bucket, $testKey),
            'DeleteObject' => $this->probeDeleteObject($s3, $bucket, $testKey),
        ];
    }

    private function probeGetObject(S3Client $s3, string $bucket, string $testKey): string
    {
        try {
            $s3->getObject(['Bucket' => $bucket, 'Key' => $testKey]);

            return '✅ OK';
        } catch (AwsException $exception) {
            return '❌ '.($exception->getAwsErrorCode() ?? 'UnknownError');
        }
    }

    private function probeDeleteObject(S3Client $s3, string $bucket, string $testKey): string
    {
        try {
            $s3->deleteObject(['Bucket' => $bucket, 'Key' => $testKey]);

            return '✅ OK';
        } catch (AwsException $exception) {
            return '❌ '.($exception->getAwsErrorCode() ?? 'UnknownError');
        }
    }
}
