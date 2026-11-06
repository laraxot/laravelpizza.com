<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\S3;

use Aws\Exception\AwsException;
use Modules\Media\Actions\Diagnostic\Aws\CreateFilesystemS3ClientAction;
use Spatie\QueueableAction\QueueableAction;

use function Safe\json_decode;
use function Safe\json_encode;

class CheckBucketPolicyAction
{
    use QueueableAction;

    /**
     * @return array<string, mixed>
     */
    public function execute(): array
    {
        try {
            $s3 = app(CreateFilesystemS3ClientAction::class)->execute();
            $policy = $s3->getBucketPolicy(['Bucket' => app(CreateFilesystemS3ClientAction::class)->bucket()]);
            $policyValue = $policy['Policy'] ?? null;
            $decodedPolicy = is_string($policyValue) ? json_decode($policyValue) : null;

            return [
                'title' => '📜 Bucket Policy',
                'status' => 'info',
                'data' => [
                    'Policy Exists' => '✅ Yes',
                    'Policy' => json_encode($decodedPolicy, JSON_PRETTY_PRINT),
                ],
            ];
        } catch (AwsException $exception) {
            if (($exception->getAwsErrorCode() ?? '') === 'NoSuchBucketPolicy') {
                return [
                    'title' => '📜 Bucket Policy',
                    'status' => 'info',
                    'data' => [
                        'Policy Exists' => 'ℹ️ No (This is usually OK)',
                    ],
                ];
            }

            return [
                'title' => '📜 Bucket Policy',
                'status' => 'error',
                'data' => [
                    'Error' => $exception->getAwsErrorCode() ?? 'UnknownError',
                    'Message' => $exception->getMessage(),
                ],
            ];
        }
    }
}
