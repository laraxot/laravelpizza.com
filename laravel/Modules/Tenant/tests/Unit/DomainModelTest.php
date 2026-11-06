<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Mockery\MockInterface;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Domain Model', function (): void {
    test('_domain_model_can_be_instantiated', function (): void {
        $domain = new Domain;

        Assert::assertSame(Domain::class, $domain::class);
    });

    test('_get_rows_method_works_correctly', function (): void {
        TestCase::mockAppService(GetDomainsArrayAction::class, static function (MockInterface $mock): void {
            $mock->allows([
                'execute' => [
                    ['id' => 1, 'name' => 'test-domain.com'],
                    ['id' => 2, 'name' => 'example.org'],
                ],
            ]);
        });

        $domain = new Domain;
        $rows = $domain->getRows();

        Assert::assertCount(2, $rows);
        Assert::assertSame('test-domain.com', $rows[0]['name']);
        Assert::assertSame('example.org', $rows[1]['name']);
    });
});
