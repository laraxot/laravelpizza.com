<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions;

use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('get tenant name action returns correct tenant name from server name', function (): void {
    $_SERVER['SERVER_NAME'] = 'myapp.example.com';

    $action = new GetTenantNameAction;
    $result = $action->execute();

    Assert::assertSame('com/example/myapp', $result);
});

test('get tenant name action handles www prefix correctly', function (): void {
    $_SERVER['SERVER_NAME'] = 'www.myapp.example.com';

    $action = new GetTenantNameAction;
    $result = $action->execute();

    Assert::assertSame('com/example/myapp', $result);
});

test('get tenant name action falls back to default when server name is localhost', function (): void {
    $_SERVER['SERVER_NAME'] = '127.0.0.1';

    $action = new GetTenantNameAction;
    $result = $action->execute();

    Assert::assertSame('localhost', $result);
});

test('get tenant name action uses app url config when server name not set', function (): void {
    unset($_SERVER['SERVER_NAME']);
    config(['app.url' => 'https://myapp.test']);

    $action = new GetTenantNameAction;
    $result = $action->execute();

    Assert::assertSame('test/myapp', $result);
});

test('get tenant name action handles empty app url config', function (): void {
    unset($_SERVER['SERVER_NAME']);
    config(['app.url' => '']);

    $action = new GetTenantNameAction;
    $result = $action->execute();

    Assert::assertSame('localhost', $result);
});
