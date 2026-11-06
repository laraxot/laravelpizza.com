<?php

declare(strict_types=1);
use Modules\User\Actions\User\CreateUserAction;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('CreateUserAction', function (): void {
    test('action is accessible via app', function (): void {
        Assert::assertInstanceOf(CreateUserAction::class, app(CreateUserAction::class));
    });

    test('action has execute method', function (): void {
        $action = app(CreateUserAction::class);

        Assert::assertTrue(method_exists($action, 'execute'));
    });

    test('execute method accepts array parameter', function (): void {
        $action = app(CreateUserAction::class);

        $reflection = new ReflectionMethod($action, 'execute');
        $params = $reflection->getParameters();

        Assert::assertCount(1, $params);
        Assert::assertSame('data', $params[0]->getName());
    });
});
