<?php

declare(strict_types=1);

namespace Modules\Media\Actions\S3;

use Aws\S3\Exception\S3Exception;

class CheckFileExistsAction extends BaseS3Action
{
    /**
     * Check if a file exists in S3
     */
    public function execute(string $key): bool
    {
        try {
            $this->s3Client->headObject([
                'Bucket' => $this->bucketName,
                'Key' => $key,
            ]);

            $this->logger->info('File existence check completed', ['key' => $key, 'exists' => true]);

            return true;
        } catch (S3Exception $exception) {
            if ($exception->getStatusCode() === 404) {
                $this->logger->info('File existence check completed', ['key' => $key, 'exists' => false]);

                return false;
            }

            $this->logger->error('Error checking file existence in S3', [
                'key' => $key,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw $exception;
        }
    }
}
