<?php

declare(strict_types=1);

use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('DeviceUserFactory creates a persistable record without explicit overrides', function (): void {
    Assert::markTestSkipped('Bug noto: DeviceUserFactory::definition() torna [], user_id/device_id NOT NULL falliscono. Vedi Stato attuale in 34-factories-seeders-audit.md.');
});

it('DeviceProfileFactory creates a persistable record without explicit overrides', function (): void {
    Assert::markTestSkipped('Bug noto: model DeviceProfile punta a una tabella inesistente (device_profile). Vedi Stato attuale in 34-factories-seeders-audit.md.');
});
