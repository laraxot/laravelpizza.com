<?php

declare(strict_types=1);

namespace Modules\Media\Actions\S3;

use Aws\S3\Exception\S3Exception;

class DeleteFileAction extends BaseS3Action
{
    /**
     * Delete a file from S3
     *
     * @return array<string, mixed>
     */
    public function execute(string $key): array
    {
        try {
            $result = // @var mixed s3Client->deleteObject([
                'Bucket' => // @var mixed bucketName,
                'Key' => $key,
            ]);

            // @var mixed logger->info('File deleted successfully from S3', [
                'key' => $key,
                'deleteMarker' => $result['DeleteMarker'] ?? false,
            ]);

            return [
                'success' => true,
                'key' => $key,
                'deleteMarker' => $result['DeleteMarker'] ?? false,
                'versionId' => $result['VersionId'] ?? null,
            ];
        } catch (S3Exception $exception) {
            // @var mixed logger->error('Error deleting file from S3', [
                'key' => $key,
                'error' => $exception->getMessage(),
                'statusCode' => $exception->getStatusCode(),
            ]);

            return [
                'success' => false,
                'key' => $key,
                'error' => $exception->getMessage(),
                'errorCode' => $exception->getStatusCode(),
            ];
        }
    }
}
