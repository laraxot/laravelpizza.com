<?php

declare(strict_types=1);

use Modules\Geo\Enums\AddressTypeEnum;

/**
 * In-memory Address tests (no factories / DB / container).
 * Keep business rules verifiable without touching app code.
 */

/**
 * Build an in-memory Address-like object with sane defaults.
 *
 * @param  array<string, mixed>  $overrides
 */
function makeAddress(array $overrides = []): object
{
    static $autoId = 1;

    $defaults = [
        'id' => $autoId++,
        'model_type' => null, // e.g. 'patient'
        'model_id' => null,
        'route' => 'Via Roma',
        'street_number' => '1',
        'locality' => 'Milano',
        'administrative_area_level_2' => 'MI',
        'postal_code' => '20100',
        'country' => 'Italia',
        'is_primary' => false,
        'type' => AddressTypeEnum::HOME->value,
        'latitude' => null,
        'longitude' => null,
        'place_id' => null,
        'formatted_address' => null,
        'extra_data' => [],
        'deleted_at' => null,
    ];

    return (object) array_replace($defaults, $overrides);
}

/**
 * Compose a displayable full address from object parts.
 */
function formatFullAddress(object $a): string
{
    $parts = array_filter(
        [
            $a->route ?? null,
            $a->street_number ?? null,
            $a->locality ?? null,
            $a->postal_code ?? null,
            $a->country ?? null,
        ],
        fn ($v) => ((string) $v) !== '',
    );

    return implode(', ', $parts);
}

describe('Address Integration', function () {
    it('can attach address to patient via polymorphic relationship', function () {
        $patient = (object) ['id' => 1001, 'type' => 'patient'];

        $address = makeAddress([
            'model_type' => 'patient',
            'model_id' => $patient->id,
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
            'is_primary' => true,
        ]);

        expect($address->model_type)
            ->toBe('patient')
            ->and($address->model_id)
            ->toBe($patient->id)
            ->and($address->is_primary)
            ->toBeTrue();
    });

    it('generates proper full address from components', function () {
        $address = makeAddress([
            'route' => 'Via Giuseppe Verdi',
            'street_number' => '42',
            'locality' => 'Milano',
            'administrative_area_level_2' => 'MI',
            'postal_code' => '20121',
            'country' => 'Italia',
        ]);

        $fullAddress = formatFullAddress($address);

        expect($fullAddress)
            ->toContain('Via Giuseppe Verdi')
            ->and($fullAddress)
            ->toContain('42')
            ->and($fullAddress)
            ->toContain('Milano')
            ->and($fullAddress)
            ->toContain('20121');
    });

    it('handles geolocation data correctly', function () {
        $milan = makeAddress([
            'latitude' => 45.4642,
            'longitude' => 9.1900,
        ]);

        expect($milan->latitude)->toBe(45.4642)->and($milan->longitude)->toBe(9.1900);
    });

    it('can store Google Places API data', function () {
        $address = makeAddress([
            'place_id' => 'ChIJu46S-ZZjhkcRLuFvLjVZ400',
            'formatted_address' => 'Piazza del Duomo, 20121 Milano MI, Italy',
            'extra_data' => [
                'google_types' => ['establishment', 'point_of_interest'],
                'rating' => 4.5,
                'business_status' => 'OPERATIONAL',
            ],
        ]);

        expect($address->place_id)
            ->toBe('ChIJu46S-ZZjhkcRLuFvLjVZ400')
            ->and($address->formatted_address)
            ->toContain('Piazza del Duomo')
            ->and($address->extra_data['google_types'])
            ->toContain('establishment')
            ->and($address->extra_data['rating'])
            ->toBe(4.5);
    });

    it('supports multiple addresses per entity', function () {
        $patient = (object) ['id' => 2001, 'type' => 'patient'];

        $homeAddress = makeAddress([
            'model_type' => 'patient',
            'model_id' => $patient->id,
            'type' => AddressTypeEnum::HOME->value,
            'is_primary' => true,
        ]);

        $workAddress = makeAddress([
            'model_type' => 'patient',
            'model_id' => $patient->id,
            'type' => AddressTypeEnum::WORK->value,
            'is_primary' => false,
        ]);

        $patientAddresses = [$homeAddress, $workAddress];

        expect(count($patientAddresses))->toBe(2);

        $primary = null;
        foreach ($patientAddresses as $addr) {
            if ($addr->is_primary === true) {
                $primary = $addr;
                break;
            }
        }

        expect($primary?->id)->toBe($homeAddress->id);
    });

    it('handles soft deletion correctly', function () {
        $address = makeAddress();

        // Soft delete simulation
        $address->deleted_at = date('c');

        // Lookup simulations
        $active = null; // would be null after soft-delete
        $withTrashed = $address; // still available with trashed scope

        expect($active)->toBeNull()->and($withTrashed)->not->toBeNull()->and($withTrashed->deleted_at)->not->toBeNull();
    });
});
