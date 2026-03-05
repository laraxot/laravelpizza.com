<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions;

use Modules\Tenant\Actions\GetTenantNameAction;
use Tests\TestCase;

uses(TestCase::class);

it('returns tenant name from config', function (): void {
    config(['app.url' => 'https://myapp.example.com']);

    $action = app(GetTenantNameAction::class);
    $result = $action->execute();

    expect($result)->toBeString();
});

it('returns localhost when no server name', function (): void {
    $action = app(GetTenantNameAction::class);
    $result = $action->execute();

    expect($result)->toBeString();
});

it('removes www from domain', function (): void {
    config(['app.url' => 'https://www.example.com']);

    $action = app(GetTenantNameAction::class);
    $result = $action->execute();

    expect($result)->not->toContain('www');
});

it('handles local url', function (): void {
    config(['app.url' => 'http://localhost']);

    $action = app(GetTenantNameAction::class);
    $result = $action->execute();

    expect($result)->toBeString();
});

it('handles ip address', function (): void {
    config(['app.url' => 'http://127.0.0.1']);

    $action = app(GetTenantNameAction::class);
    $result = $action->execute();

    expect($result)->toBeString();
});
