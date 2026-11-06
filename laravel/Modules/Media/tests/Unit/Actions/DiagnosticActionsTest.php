<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Actions;

use Aws\S3\S3Client;
use Aws\Sts\StsClient;
use Modules\Media\Actions\Diagnostic\Aws\CreateFilesystemS3ClientAction;
use Modules\Media\Actions\Diagnostic\Aws\CreateFilesystemStsClientAction;
use Modules\Media\Actions\Diagnostic\Aws\ResolveAwsS3ErrorSolutionAction;
use Modules\Media\Tests\TestCase;

uses(TestCase::class)->group('no-media-db');

it('keeps diagnostic AWS actions queueable after semantic migration', function (): void {
    foreach ([
        CreateFilesystemS3ClientAction::class,
        CreateFilesystemStsClientAction::class,
        ResolveAwsS3ErrorSolutionAction::class,
    ] as $action) {
        TestCase::assertMediaUsesQueueableAction($action);
        TestCase::assertMediaDeclaresStrictTypes($action);
    }
});

it('keeps diagnostic AWS client factories returning their SDK clients', function (): void {
    expect((new CreateFilesystemS3ClientAction)->execute()::class)->toBe(S3Client::class);
    expect((new CreateFilesystemStsClientAction)->execute()::class)->toBe(StsClient::class);
});

it('keeps AWS S3 error solution behavior', function (): void {
    $action = new ResolveAwsS3ErrorSolutionAction;

    expect($action->execute(null))->toBe('Unknown error - check AWS credentials and configuration');
    expect($action->execute('AccessDenied'))->toBe('Check IAM permissions for S3 access');
    expect($action->execute('UnknownCode'))->toBe('Consult AWS documentation for error: UnknownCode');
});
