<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Modules\Gdpr\Models\Event;
use Modules\Gdpr\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('event_fillable_attributes', function (): void {
    $event = new Event;
    $fillable = $event->getFillable();

    assertFillableContains([
        'id',
        'action',
        'treatment_id',
        'consent_id',
        'subject_id',
        'payload',
    ], $fillable);
});

test('event_has_consent_relationship_method', function (): void {
    $event = new Event;

    Assert::assertTrue((new \ReflectionClass($event))->hasMethod('consent'));
});

test('event_table_name_is_gdpr_events', function (): void {
    $event = new Event;

    Assert::assertSame('gdpr_events', $event->getTable());
});

test('event_is_not_incrementing', function (): void {
    $event = new Event;

    Assert::assertFalse($event->getIncrementing());
});

test('event_is_uuid', function (): void {
    $event = new Event;
    $traits = class_uses_recursive($event);

    Assert::assertArrayHasKey(HasUuids::class, $traits);
});

test('event_has_set_payload_attribute', function (): void {
    $event = new Event;

    Assert::assertTrue((new \ReflectionClass($event))->hasMethod('setPayloadAttribute'));
});

test('event_has_set_ip_attribute', function (): void {
    $event = new Event;

    Assert::assertTrue((new \ReflectionClass($event))->hasMethod('setIpAttribute'));
});
