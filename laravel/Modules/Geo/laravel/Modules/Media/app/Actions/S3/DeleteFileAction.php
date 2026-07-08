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
            $result = $this->s3Client->deleteObject([
                'Bucket' => $this->bucketName,
                'Key' => $key,
            ]);

            $this->logger->info('File deleted successfully from S3', [
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
            $this->logger->error('Error deleting file from S3', [
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
