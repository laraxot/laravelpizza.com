<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Models;

use Modules\Gdpr\Database\Factories\ConsentFactory;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\Gdpr\Tests\TestCase $this */
    gdprAssertDatabaseAvailable();
});

test('gdpr consent can be created', function () {
    $consent = ConsentFactory::new()->createOne([
        'type' => 'privacy_policy',
        'accepted_at' => now()->toDateTimeString(),
        'ip_address' => '192.168.1.1',
    ]);

    Assert::assertInstanceOf(Consent::class, $consent);
    Assert::assertSame('privacy_policy', $consent->type);
    Assert::assertSame('192.168.1.1', $consent->ip_address);
    Assert::assertNotNull($consent->accepted_at);
});

test('gdpr consent has treatment relationship method', function () {
    $consent = new Consent();

    Assert::assertContains('treatment', get_class_methods($consent));
});

test('gdpr consent is not incrementing', function () {
    $consent = new Consent();

    Assert::assertFalse($consent->getIncrementing());
});

test('gdpr consent uses uuid trait', function () {
    $consent = new Consent();
    $traits = class_uses_recursive($consent);

    Assert::assertArrayHasKey('Illuminate\Database\Eloquent\Concerns\HasUuids', $traits);
});
