<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Actions\User;

use Modules\User\Actions\User\CreateUserAction;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('CreateUserAction', function (): void {
    test('action is accessible via app', function (): void {
        expect(app(CreateUserAction::class))->toBeInstanceOf(CreateUserAction::class);
    });

    test('action has execute method', function (): void {
        $action = app(CreateUserAction::class);
        expect(method_exists($action, 'execute'))->toBeTrue();
    });

    test('execute method accepts array parameter', function (): void {
        $action = app(CreateUserAction::class);

        $reflection = new \ReflectionMethod($action, 'execute');
        $params = $reflection->getParameters();

        expect(count($params))->toBe(1)
            ->and($params[0]->getName())->toBe('data');
    });
});
