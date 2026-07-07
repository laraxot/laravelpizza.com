<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Mockery;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Tests\TestCase;

uses(TestCase::class);

test('domain model can be instantiated', function (): void {
    $domain = new Domain;

    expect($domain)->toBeInstanceOf(Domain::class);
});

test('get rows method works correctly', function (): void {
    $mock = Mockery::mock(GetDomainsArrayAction::class);
    tenantMockExpectation($mock, 'execute')
        ->once()
        ->andReturn([
            ['id' => 1, 'name' => 'test-domain.com'],
            ['id' => 2, 'name' => 'example.org'],
        ]);
    app()->instance(GetDomainsArrayAction::class, $mock);

    $domain = new Domain;
    $rows = $domain->getRows();

    expect($rows)->toBeArray();
    expect($rows)->toHaveCount(2);
    expect($rows[0]['name'])->toBe('test-domain.com');
    expect($rows[1]['name'])->toBe('example.org');
});
