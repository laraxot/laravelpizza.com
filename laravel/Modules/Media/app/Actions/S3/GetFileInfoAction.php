<?php

declare(strict_types=1);

namespace Modules\Media\Actions\S3;

use Aws\S3\Exception\S3Exception;
use Spatie\QueueableAction\QueueableAction;

class GetFileInfoAction extends BaseS3Action
{
    use QueueableAction;

    /**
     * Get detailed file information from S3
     *
     * @return array<string, mixed>
     */
    public function execute(string $key): array
    {
        try {
            $result = $this->s3Client->headObject([
                'Bucket' => $this->bucketName,
                'Key' => $key,
            ]);

            $metadata = $result['@metadata'] ?? [];
            $effectiveUri = is_array($metadata)
                && isset($metadata['effectiveUri'])
                && is_string($metadata['effectiveUri'])
                ? $metadata['effectiveUri']
                : null;

            $fileInfo = [
                'exists' => true,
                'key' => $key,
                'effectiveUri' => $effectiveUri,
                'contentLength' => $result['ContentLength'] ?? null,
                'contentType' => $result['ContentType'] ?? null,
                'lastModified' => $result['LastModified'] ?? null,
                'etag' => $result['ETag'] ?? null,
                'metadata' => $result['Metadata'] ?? [],
            ];

            $this->logger->info('File info retrieved successfully', [
                'key' => $key,
                'size' => $fileInfo['contentLength'],
            ]);

            return $fileInfo;
        } catch (S3Exception $exception) {
            $this->logger->error('Error getting file info from S3', [
                'key' => $key,
                'error' => $exception->getMessage(),
                'statusCode' => $exception->getStatusCode(),
            ]);

            return [
                'exists' => false,
                'key' => $key,
                'error' => $exception->getMessage(),
                'errorCode' => $exception->getStatusCode(),
            ];
        }
    }
}
