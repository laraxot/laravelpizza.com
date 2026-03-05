<?php

declare(strict_types=1);

use Modules\Geo\Enums\AddressItemEnum;
use Modules\Geo\Enums\AddressTypeEnum;

describe('AddressItemEnum', function () {
    test('has expected cases', function () {
        $cases = AddressItemEnum::cases();

        expect($cases)->toBeArray()
            ->and(count($cases))->toBeGreaterThan(15);

        $values = array_map(fn ($case) => $case->value, $cases);

        expect(in_array('phone', $values))->toBeTrue();
        expect(in_array('name', $values))->toBeTrue();
        expect(in_array('route', $values))->toBeTrue();
        expect(in_array('locality', $values))->toBeTrue();
        expect(in_array('postal_code', $values))->toBeTrue();
        expect(in_array('latitude', $values))->toBeTrue();
        expect(in_array('longitude', $values))->toBeTrue();
    });

    test('getSearchable returns all case values', function () {
        $searchable = AddressItemEnum::getSearchable();

        expect($searchable)->toBeArray()
            ->and(count($searchable))->toBe(count(AddressItemEnum::cases()));

        expect(in_array('phone', $searchable))->toBeTrue();
        expect(in_array('locality', $searchable))->toBeTrue();
    });

    test('getColumnNames returns all case values', function () {
        $columnNames = AddressItemEnum::getColumnNames();

        expect($columnNames)->toBeArray()
            ->and(count($columnNames))->toBe(count(AddressItemEnum::cases()));

        expect(in_array('phone', $columnNames))->toBeTrue();
        expect(in_array('email', $columnNames))->toBeTrue();
    });

    test('PHONE case has expected value', function () {
        expect(AddressItemEnum::PHONE->value)->toBe('phone');
    });

    test('LOCALITY case has expected value', function () {
        expect(AddressItemEnum::LOCALITY->value)->toBe('locality');
    });

    test('cases are string backed', function () {
        foreach (AddressItemEnum::cases() as $case) {
            expect(is_string($case->value))->toBeTrue();
        }
    });

    test('implements required interfaces', function () {
        expect(class_implements(AddressItemEnum::class))->toHaveKey('Filament\Support\Contracts\HasColor');
        expect(class_implements(AddressItemEnum::class))->toHaveKey('Filament\Support\Contracts\HasIcon');
        expect(class_implements(AddressItemEnum::class))->toHaveKey('Filament\Support\Contracts\HasLabel');
    });

    test('has specific address field cases', function () {
        expect(AddressItemEnum::tryFrom('phone'))->not->toBeNull();
        expect(AddressItemEnum::tryFrom('email'))->not->toBeNull();
        expect(AddressItemEnum::tryFrom('route'))->not->toBeNull();
        expect(AddressItemEnum::tryFrom('locality'))->not->toBeNull();
        expect(AddressItemEnum::tryFrom('postal_code'))->not->toBeNull();
        expect(AddressItemEnum::tryFrom('country'))->not->toBeNull();
    });
});

describe('AddressTypeEnum', function () {
    test('has expected cases', function () {
        $cases = AddressTypeEnum::cases();

        expect($cases)->toBeArray()
            ->and(count($cases))->toBe(6);

        $values = array_map(fn ($case) => $case->value, $cases);

        expect(in_array('home', $values))->toBeTrue();
        expect(in_array('work', $values))->toBeTrue();
        expect(in_array('billing', $values))->toBeTrue();
        expect(in_array('shipping', $values))->toBeTrue();
        expect(in_array('legal', $values))->toBeTrue();
        expect(in_array('other', $values))->toBeTrue();
    });

    test('HOME case has expected value', function () {
        expect(AddressTypeEnum::HOME->value)->toBe('home');
    });

    test('label method returns correct labels', function () {
        expect(AddressTypeEnum::HOME->label())->toBe('Casa');
        expect(AddressTypeEnum::WORK->label())->toBe('Lavoro');
        expect(AddressTypeEnum::BILLING->label())->toBe('Fatturazione');
        expect(AddressTypeEnum::SHIPPING->label())->toBe('Spedizione');
        expect(AddressTypeEnum::LEGAL->label())->toBe('Sede legale');
        expect(AddressTypeEnum::OTHER->label())->toBe('Altro');
    });

    test('options returns all key-value pairs', function () {
        $options = AddressTypeEnum::options();

        expect($options)->toBeArray()
            ->and(count($options))->toBe(6);

        expect($options['home'])->toBe('Casa');
        expect($options['work'])->toBe('Lavoro');
        expect($options['billing'])->toBe('Fatturazione');
        expect($options['shipping'])->toBe('Spedizione');
        expect($options['legal'])->toBe('Sede legale');
        expect($options['other'])->toBe('Altro');
    });

    test('is string backed enum', function () {
        foreach (AddressTypeEnum::cases() as $case) {
            expect(is_string($case->value))->toBeTrue();
        }
    });
});
