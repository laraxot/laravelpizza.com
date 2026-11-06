<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\S3;

use Aws\Exception\AwsException;
use Modules\Media\Actions\Diagnostic\Aws\CreateFilesystemStsClientAction;
use Spatie\QueueableAction\QueueableAction;

class TestCredentialsAction
{
    use QueueableAction;


    /**
     * @return array<string, mixed>
     */
    public function execute(): array
    {
        try {
            $result = app(CreateFilesystemStsClientAction::class)->execute()->getCallerIdentity();

            return [
                'title' => '🔐 AWS Credentials',
                'status' => 'success',
                'data' => [
                    'Valid' => '✅ Yes',
                    'Account ID' => $result['Account'],
                    'User ARN' => $result['Arn'],
                ],
            ];
        } catch (AwsException $exception) {
            return [
                'title' => '🔐 AWS Credentials',
                'status' => 'error',
                'data' => [
                    'Valid' => '❌ No',
                    'Error' => $exception->getAwsErrorCode() ?? 'UnknownError',
                    'Message' => $exception->getMessage(),
                ],
            ];
        }
    }
}
