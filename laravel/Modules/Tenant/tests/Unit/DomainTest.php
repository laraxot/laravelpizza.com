<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Mockery;
use Mockery\Expectation;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

afterEach(function (): void {
    Mockery::close();
});

test('domain model can be instantiated', function (): void {
    Assert::assertSame(Domain::class, (new Domain)::class);
});

test('get rows method works correctly', function (): void {
    $mock = Mockery::mock(GetDomainsArrayAction::class);
    $expectation = $mock->shouldReceive('execute');
    assert($expectation instanceof Expectation);
    $expectation->andReturn([
        ['id' => 1, 'name' => 'test-domain.com'],
        ['id' => 2, 'name' => 'example.org'],
    ]);

    app()->instance(GetDomainsArrayAction::class, $mock);

    $domain = new Domain;
    $rows = $domain->getRows();

    expect($rows)->toHaveCount(2);
    expect($rows[0]['name'])->toBe('test-domain.com');
    expect($rows[1]['name'])->toBe('example.org');
});
