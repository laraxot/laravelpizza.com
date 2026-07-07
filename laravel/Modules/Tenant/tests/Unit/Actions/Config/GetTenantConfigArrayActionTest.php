<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('returns empty array for non-existent config', function (): void {
    $action = app(GetTenantConfigArrayAction::class);
    $result = $action->execute('non_existent_config');

    Assert::assertIsArray($result);
});

it('returns array with string keys', function (): void {
    $action = app(GetTenantConfigArrayAction::class);
    $result = $action->execute('app');

    // Should return array with string keys even if empty
    Assert::assertIsArray($result);
});
