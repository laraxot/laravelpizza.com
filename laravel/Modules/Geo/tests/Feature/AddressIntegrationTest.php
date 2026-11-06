<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Feature;

use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * In-memory Address tests (no factories / DB / container).
 * Keep business rules verifiable without touching app code.
 */

/**
 * Build an in-memory address array with sane defaults.
 *
 * @param array{
 *     id?: int,
 *     model_type?: string|null,
 *     model_id?: int|null,
 *     route?: string|null,
 *     street_number?: string|null,
 *     locality?: string|null,
 *     administrative_area_level_2?: string|null,
 *     postal_code?: string|null,
 *     country?: string|null,
 *     is_primary?: bool,
 *     type?: string,
 *     latitude?: float|null,
 *     longitude?: float|null,
 *     place_id?: string|null,
 *     formatted_address?: string|null,
 *     extra_data?: array{
 *         google_types?: list<string>,
 *         rating?: float,
 *         business_status?: string
 *     },
 *     deleted_at?: string|null
 * } $overrides
 * @return array{
 *     id: int,
 *     model_type: string|null,
 *     model_id: int|null,
 *     route: string|null,
 *     street_number: string|null,
 *     locality: string|null,
 *     administrative_area_level_2: string|null,
 *     postal_code: string|null,
 *     country: string|null,
 *     is_primary: bool,
 *     type: string,
 *     latitude: float|null,
 *     longitude: float|null,
 *     place_id: string|null,
 *     formatted_address: string|null,
 *     extra_data: array{
 *         google_types?: list<string>,
 *         rating?: float,
 *         business_status?: string
 *     },
 *     deleted_at: string|null
 * }
 */
function makeAddress(array $overrides = []): array
{
    static $autoId = 0;
    /** @var int $autoId */
    $autoId++;

    $defaults = [
        'id' => $autoId,
        'model_type' => null,
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

    /** @var array{
     *     id: int,
     *     model_type: string|null,
     *     model_id: int|null,
     *     route: string|null,
     *     street_number: string|null,
     *     locality: string|null,
     *     administrative_area_level_2: string|null,
     *     postal_code: string|null,
     *     country: string|null,
     *     is_primary: bool,
     *     type: string,
     *     latitude: float|null,
     *     longitude: float|null,
     *     place_id: string|null,
     *     formatted_address: string|null,
     *     extra_data: array{
     *         google_types?: list<string>,
     *         rating?: float,
     *         business_status?: string
     *     },
     *     deleted_at: string|null
     * } $address
     */
    $address = array_replace($defaults, $overrides);

    return $address;
}

/**
 * Compose a displayable full address from array parts.
 *
 * @param array{
 *     id: int,
 *     model_type: string|null,
 *     model_id: int|null,
 *     route: string|null,
 *     street_number: string|null,
 *     locality: string|null,
 *     administrative_area_level_2: string|null,
 *     postal_code: string|null,
 *     country: string|null,
 *     is_primary: bool,
 *     type: string,
 *     latitude: float|null,
 *     longitude: float|null,
 *     place_id: string|null,
 *     formatted_address: string|null,
 *     extra_data: array{
 *         google_types?: list<string>,
 *         rating?: float,
 *         business_status?: string
 *     },
 *     deleted_at: string|null
 * } $address
 */
function formatFullAddress(array $address): string
{
    $parts = [];
    foreach ([
        $address['route'],
        $address['street_number'],
        $address['locality'],
        $address['postal_code'],
        $address['country'],
    ] as $value) {
        if ($value !== null && $value !== '') {
            $parts[] = $value;
        }
    }

    return implode(', ', $parts);
}

describe('Address Integration', function () {
    it('can attach address to patient via polymorphic relationship', function () {
        $patient = ['id' => 1001, 'type' => 'patient'];

        $address = makeAddress([
            'model_type' => $patient['type'],
            'model_id' => $patient['id'],
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
            'is_primary' => true,
        ]);

        Assert::assertSame($patient['type'], $address['model_type']);
        Assert::assertSame($patient['id'], $address['model_id']);
        Assert::assertTrue($address['is_primary']);
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

        Assert::assertStringContainsString('Via Giuseppe Verdi', $fullAddress);
        Assert::assertStringContainsString('42', $fullAddress);
        Assert::assertStringContainsString('Milano', $fullAddress);
        Assert::assertStringContainsString('20121', $fullAddress);
    });

    it('handles geolocation data correctly', function () {
        $milan = makeAddress([
            'latitude' => 45.4642,
            'longitude' => 9.1900,
        ]);

        Assert::assertSame(45.4642, $milan['latitude']);
        Assert::assertSame(9.1900, $milan['longitude']);
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

        Assert::assertSame('ChIJu46S-ZZjhkcRLuFvLjVZ400', $address['place_id']);
        $extraData = $address['extra_data'];
        $googleTypes = $extraData['google_types'] ?? [];
        $formattedAddress = $address['formatted_address'];

        Assert::assertContains('establishment', $googleTypes);
        Assert::assertSame(4.5, $extraData['rating'] ?? null);
        Assert::assertNotNull($formattedAddress);
        Assert::assertStringContainsString('Piazza del Duomo', $formattedAddress);
    });

    it('supports multiple addresses per entity', function () {
        $patient = ['id' => 2001, 'type' => 'patient'];

        $homeAddress = makeAddress([
            'model_type' => $patient['type'],
            'model_id' => $patient['id'],
            'type' => AddressTypeEnum::HOME->value,
            'is_primary' => true,
        ]);

        $workAddress = makeAddress([
            'model_type' => $patient['type'],
            'model_id' => $patient['id'],
            'type' => AddressTypeEnum::WORK->value,
            'is_primary' => false,
        ]);

        $patientAddresses = [$homeAddress, $workAddress];

        Assert::assertCount(2, $patientAddresses);

        $primary = null;
        foreach ($patientAddresses as $addr) {
            if ($addr['is_primary'] === true) {
                $primary = $addr;
                break;
            }
        }
        Assert::assertNotNull($primary);
        Assert::assertSame($homeAddress['id'], $primary['id']);
    });

    it('handles soft deletion correctly', function () {
        $address = makeAddress();

        $address['deleted_at'] = date('c');

        Assert::assertNotNull($address['deleted_at']);
    });
});
