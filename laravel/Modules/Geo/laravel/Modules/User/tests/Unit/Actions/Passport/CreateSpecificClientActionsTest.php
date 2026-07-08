<?php

declare(strict_types=1);

use Mockery;
use Modules\User\Actions\Passport\CreateGenericClientAction;
use Modules\User\Actions\Passport\CreatePasswordClientAction;
use Modules\User\Actions\Passport\CreatePersonalAccessClientAction;
use Modules\User\Models\OauthClient;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

describe('Create specific passport client actions', function (): void {
    afterEach(function (): void {
        Mockery::close();
        app()->forgetInstance(CreateGenericClientAction::class);
        app()->forgetInstance(CreatePasswordClientAction::class);
        app()->forgetInstance(CreatePersonalAccessClientAction::class);
    });

    it('delegates password client creation to generic action', function (): void {
        $expectedClient = new OauthClient();

        $genericAction = \typedMock(CreateGenericClientAction::class);
        $genericAction->allows(['execute' => $expectedClient]);

        app()->instance(CreateGenericClientAction::class, $genericAction);

        $result = app(CreatePasswordClientAction::class)->execute(
            name: 'Password Client',
            redirect: 'https://example.test/callback',
        );

        Assert::assertSame($expectedClient, $result);
    });

    it('delegates personal access client creation to generic action', function (): void {
        $expectedClient = new OauthClient();

        $genericAction = \typedMock(CreateGenericClientAction::class);
        $genericAction->allows(['execute' => $expectedClient]);

        app()->instance(CreateGenericClientAction::class, $genericAction);

        $result = app(CreatePersonalAccessClientAction::class)->execute(
            name: 'Personal Client',
            redirect: 'https://example.test/callback',
        );

        Assert::assertSame($expectedClient, $result);
    });
});
