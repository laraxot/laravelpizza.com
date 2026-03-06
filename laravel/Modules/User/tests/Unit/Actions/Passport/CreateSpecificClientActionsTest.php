<?php

declare(strict_types=1);

use Modules\User\Actions\Passport\CreateGenericClientAction;
use Modules\User\Actions\Passport\CreatePasswordClientAction;
use Modules\User\Actions\Passport\CreatePersonalAccessClientAction;
use Modules\User\Models\OauthClient;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('Create specific passport client actions', function (): void {
    it('delegates password client creation to generic action', function (): void {
        $expectedClient = new OauthClient();

        $genericAction = Mockery::mock(CreateGenericClientAction::class);
        $genericAction->shouldReceive('execute')->once()->andReturn($expectedClient);

        app()->instance(CreateGenericClientAction::class, $genericAction);

        $result = app(CreatePasswordClientAction::class)->execute(
            name: 'Password Client',
            redirect: 'https://example.test/callback',
        );

        expect($result)->toBe($expectedClient);
    });

    it('delegates personal access client creation to generic action', function (): void {
        $expectedClient = new OauthClient();

        $genericAction = Mockery::mock(CreateGenericClientAction::class);
        $genericAction->shouldReceive('execute')->once()->andReturn($expectedClient);

        app()->instance(CreateGenericClientAction::class, $genericAction);

        $result = app(CreatePersonalAccessClientAction::class)->execute(
            name: 'Personal Client',
            redirect: 'https://example.test/callback',
        );

        expect($result)->toBe($expectedClient);
    });
});

