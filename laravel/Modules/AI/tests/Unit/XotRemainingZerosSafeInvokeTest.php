<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Casts\PhoneCast;
use Modules\Xot\Models\Cache;
use Modules\Xot\Tests\TestCase;
use Modules\Xot\ValueObjects\PhoneValueObject;

uses(TestCase::class)->group('no-xot-db');

test('phone cast round-trips a validated value object', function (): void {
    $cast = new PhoneCast;
    $phone = PhoneValueObject::fromString('+15551234567');
    $model = new Cache;

    expect($cast->set($model, 'phone', $phone, []))->toBe('+15551234567')
        ->and($cast->get($model, 'phone', '+15551234567', [])->toString())->toBe('+15551234567');
});

test('phone cast rejects storage values without the domain type', function (): void {
    expect(fn (): string => (new PhoneCast)->set(new Cache, 'phone', null, []))
        ->toThrow(\InvalidArgumentException::class);
});
