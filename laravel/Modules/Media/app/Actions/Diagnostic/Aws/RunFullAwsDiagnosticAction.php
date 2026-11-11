<?php

declare(strict_types=1);

namespace Modules\Media\Actions\Diagnostic\Aws;

use Spatie\QueueableAction\QueueableAction;

class RunFullAwsDiagnosticAction
{
    use QueueableAction;

    /**
     * @return array<string, mixed>
     */
    public function execute(): array
    {
        return [
            's3' => app(TestS3ConnectionAction::class)->execute(),
            's3_permissions' => app(TestS3PermissionsAction::class)->execute(),
            's3_operations' => app(TestS3FileOperationsAction::class)->execute(),
            'cloudfront' => app(TestCloudFrontConfigAction::class)->execute(),
            'cloudfront_signed' => app(TestCloudFrontSignedUrlsAction::class)->execute(),
            'iam_credentials' => app(TestIamCredentialsAction::class)->execute(),
            'iam_policies' => app(TestIamPoliciesAction::class)->execute(),
        ];
    }
}
