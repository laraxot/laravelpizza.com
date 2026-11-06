<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\S3;

use Exception;
use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;

use function Safe\file_put_contents;
use function Safe\unlink;

class TestFileUploadDownloadAction
{
    use QueueableAction;

    /**
     * @return array<string, mixed>
     */
    public function execute(): array
    {
        try {
            $testData = 'This is a test file content for S3 upload/download test.';
            $testFileName = 'test-file-'.time().'.txt';
            $localTestPath = sys_get_temp_dir().'/'.$testFileName;

            file_put_contents($localTestPath, $testData);

            $uploadResult = Storage::disk('s3')->put($testFileName, $testData);
            if (! $uploadResult) {
                return $this->errorResult('Failed to upload test file to S3', ['file' => $testFileName]);
            }

            $downloadedContent = Storage::disk('s3')->get($testFileName);
            if ($downloadedContent !== $testData) {
                return $this->errorResult('Downloaded content does not match uploaded content', [
                    'expected_length' => strlen($testData),
                    'actual_length' => strlen($downloadedContent ?? ''),
                ]);
            }

            $exists = Storage::disk('s3')->exists($testFileName);
            $size = Storage::disk('s3')->size($testFileName);

            Storage::disk('s3')->delete($testFileName);
            unlink($localTestPath);

            return [
                'status' => 'success',
                'message' => 'File upload/download test completed successfully',
                'details' => [
                    'file_uploaded' => true,
                    'file_downloaded' => true,
                    'content_verified' => true,
                    'file_exists_check' => $exists,
                    'file_size' => $size,
                    'cleanup_completed' => true,
                    'test_file' => $testFileName,
                ],
            ];
        } catch (Exception $exception) {
            return $this->errorResult('File operations test failed: '.$exception->getMessage(), [
                'error_class' => get_class($exception),
                'error_file' => $exception->getFile(),
                'error_line' => $exception->getLine(),
            ]);
        }
    }

    /**
     * @param  array<string, mixed>  $details
     * @return array<string, mixed>
     */
    private function errorResult(string $message, array $details): array
    {
        return [
            'status' => 'error',
            'message' => $message,
            'details' => $details,
        ];
    }
}
