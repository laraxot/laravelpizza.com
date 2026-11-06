<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Models;

use Mockery\MockInterface;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Models\TenantDomain;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Domain sushi models', function (): void {
    test('domain model exposes rows from GetDomainsArrayAction', function (): void {
        TestCase::mockAppService(GetDomainsArrayAction::class, static function (MockInterface $mock): void {
            $mock->allows([
                'execute' => [
                    ['id' => 'tenant.example.com', 'name' => 'tenant.example.com'],
                ],
            ]);
        });

        $rows = (new Domain)->getRows();

        Assert::assertCount(1, $rows);
        Assert::assertSame('tenant.example.com', $rows[0]['name']);
    });

    test('tenant domain model mirrors domain registry rows', function (): void {
        TestCase::mockAppService(GetDomainsArrayAction::class, static function (MockInterface $mock): void {
            $mock->allows([
                'execute' => [
                    ['id' => 'primary.example.com', 'name' => 'primary.example.com'],
                    ['id' => 'alias.example.com', 'name' => 'alias.example.com'],
                ],
            ]);
        });

        $rows = (new TenantDomain)->getRows();

        Assert::assertCount(2, $rows);
        Assert::assertSame('alias.example.com', $rows[1]['name']);
    });

    test('tenant domain sushi query resolves host by name column', function (): void {
        TestCase::mockAppService(GetDomainsArrayAction::class, static function (MockInterface $mock): void {
            $mock->allows([
                'execute' => [
                    ['id' => 'secure.example.com', 'name' => 'secure.example.com'],
                ],
            ]);
        });

        $found = TenantDomain::query()->where('name', 'secure.example.com')->first();

        Assert::assertNotNull($found);
        Assert::assertSame('secure.example.com', $found->name);
    });
});
