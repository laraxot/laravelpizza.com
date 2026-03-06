<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Actions\User;

use Modules\User\Actions\User\UpdateUserAction;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('UpdateUserAction', function (): void {
    test('action is accessible via app', function (): void {
        expect(app(UpdateUserAction::class))->toBeInstanceOf(UpdateUserAction::class);
    });

    test('action has execute method', function (): void {
        $action = app(UpdateUserAction::class);
        expect(method_exists($action, 'execute'))->toBeTrue();
    });

    test('execute method accepts user and data parameters', function (): void {
        $action = app(UpdateUserAction::class);
        
        $reflection = new \ReflectionMethod($action, 'execute');
        $params = $reflection->getParameters();
        
        expect(count($params))->toBe(2)
            ->and($params[0]->getName())->toBe('user')
            ->and($params[1]->getName())->toBe('data');
    });
});
