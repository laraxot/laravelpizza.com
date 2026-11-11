<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\S3;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Actions\CloudFront\GetCloudFrontSignedUrlAction;
use Spatie\QueueableAction\QueueableAction;

class RunS3SaveTestAction
{
    use QueueableAction;

    /**
     * @return array<string, mixed>
     */
    public function execute(?string $attachmentPath, string $testFilePrefix = 'test-upload-'): array
    {
        $filename = $testFilePrefix.time().'.txt';
        Storage::disk('s3')->put($filename, 'Hello World from Filament Test');

        $cloudFrontUrl = app(GetCloudFrontSignedUrlAction::class)->execute($filename, 5);

        /** @var FilesystemAdapter $s3Disk */
        $s3Disk = Storage::disk('s3');
        $temporaryUrl = $s3Disk->temporaryUrl($filename, now()->addMinutes(5));

        $results = [
            'test_file' => [
                'path' => $filename,
                'cloudfront_url' => $cloudFrontUrl,
                'temporary_url' => $temporaryUrl,
            ],
            'uploaded_file' => null,
        ];

        if ($attachmentPath !== null && $attachmentPath !== '') {
            $results['uploaded_file'] = [
                'path' => $attachmentPath,
                'cloudfront_url' => app(GetCloudFrontSignedUrlAction::class)->execute($attachmentPath, 30),
                'temporary_url' => $s3Disk->temporaryUrl($attachmentPath, now()->addMinutes(30)),
            ];
        }

        Storage::disk('s3')->delete($filename);

        return $results;
    }
}
