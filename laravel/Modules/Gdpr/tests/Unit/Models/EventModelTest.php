<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Models;

uses(\Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Models\Event;

test('event_fillable_attributes', function () {
    $event = new Event();
    $fillable = $event->getFillable();

    expect($fillable)->toContain('id');
    expect($fillable)->toContain('action');
    expect($fillable)->toContain('treatment_id');
    expect($fillable)->toContain('consent_id');
    expect($fillable)->toContain('subject_id');
    expect($fillable)->toContain('payload');
});

test('event_has_consent_relationship_method', function () {
    $event = new Event();

    expect(method_exists($event, 'consent'))->toBeTrue();
});

test('event_table_name_is_gdpr_events', function () {
    $event = new Event();

    expect($event->getTable())->toBe('gdpr_events');
});

test('event_is_not_incrementing', function () {
    $event = new Event();

    expect($event->getIncrementing())->toBeFalse();
});

test('event_is_uuid', function () {
    $event = new Event();
    $traits = class_uses_recursive($event);

    expect($traits)->toHaveKey('Illuminate\Database\Eloquent\Concerns\HasUuids');
});

test('event_has_set_payload_attribute', function () {
    $event = new Event();

    expect(method_exists($event, 'setPayloadAttribute'))->toBeTrue();
});

test('event_has_set_ip_attribute', function () {
    $event = new Event();

    expect(method_exists($event, 'setIpAttribute'))->toBeTrue();
});
