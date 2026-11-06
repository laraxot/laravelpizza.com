<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Feature;

use Mockery\MockInterface;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\TenantDomain;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Tenant domain routing (sushi registry)', function (): void {
    beforeEach(function (): void {
        TestCase::mockAppService(GetDomainsArrayAction::class, static function (MockInterface $mock): void {
            $mock->allows([
                'execute' => [
                    ['id' => 'tenant.example.com', 'name' => 'tenant.example.com'],
                    ['id' => 'alias.example.com', 'name' => 'alias.example.com'],
                    ['id' => 'secure.example.com', 'name' => 'secure.example.com'],
                ],
            ]);
        });
    });

    it('identifies host by primary domain name', function (): void {
        $found = TenantDomain::query()->where('name', 'tenant.example.com')->first();

        Assert::assertNotNull($found);
        Assert::assertSame('tenant.example.com', $found->id);
    });

    it('identifies alias domain in the same registry', function (): void {
        $alias = TenantDomain::query()->where('name', 'alias.example.com')->first();

        Assert::assertNotNull($alias);
        Assert::assertSame('alias.example.com', $alias->name);
    });

    it('returns null for unknown domain', function (): void {
        $found = TenantDomain::query()->where('name', 'unknown.example.com')->first();

        Assert::assertNull($found);
    });

    it('lists every configured host for routing', function (): void {
        $domains = TenantDomain::query()->get();

        Assert::assertCount(3, $domains);
    });
});
