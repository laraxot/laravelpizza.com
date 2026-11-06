<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\Aws;

use Aws\Exception\AwsException;
use Spatie\QueueableAction\QueueableAction;

class TestIamCredentialsAction
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
                'status' => 'success',
                'message' => 'IAM credentials verified successfully',
                'details' => [
                    'Account' => $result['Account'] ?? 'Unknown',
                    'ARN' => $result['Arn'] ?? 'Unknown',
                    'User ID' => $result['UserId'] ?? 'Unknown',
                ],
            ];
        } catch (AwsException $exception) {
            $errorCode = $exception->getAwsErrorCode() ?? 'UnknownError';

            return [
                'status' => 'error',
                'message' => 'IAM credentials error: '.$errorCode,
                'details' => [
                    'Error' => $exception->getMessage(),
                    'Solution' => 'Check AWS access keys and secret',
                ],
            ];
        }
    }
}
