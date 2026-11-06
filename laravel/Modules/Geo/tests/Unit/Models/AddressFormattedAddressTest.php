<?php

declare(strict_types=1);

use Modules\Geo\Models\Address;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);

/*
 * Address::getFormattedAddressAttribute(): righe dell'indirizzo composte dai campi,
 * se `formatted_address` non e' salvato. Fissa il comportamento prima del refactor
 * per la complessita' del 2026-11-03.
 */

/**
 * @param  array<string, mixed>  $attributes
 */
function geoAddressWith(array $attributes): Address
{
    $address = new Address;
    $address->forceFill($attributes);

    return $address;
}

test('il valore salvato in formatted_address vince sui campi', function (): void {
    $address = geoAddressWith([
        'formatted_address' => 'Indirizzo salvato',
        'route' => 'Via Roma',
        'street_number' => '10',
    ]);

    Assert::assertSame('Indirizzo salvato', $address->formatted_address);
});

test('un indirizzo italiano completo ha via, localita con sigla, regione e paese', function (): void {
    $address = geoAddressWith([
        'route' => 'Via Roma',
        'street_number' => '10',
        'postal_code' => '00184',
        'locality' => 'Roma',
        'country' => 'IT',
        'administrative_area_level_3' => 'Roma',
        'administrative_area_level_2' => 'Lazio',
        'administrative_area_level_1' => 'Italia',
        'extra_data' => [
            'provincia_sigla' => 'RM',
        ],
    ]);

    Assert::assertSame("Via Roma 10\n00184 Roma (RM)\nLazio\nITALIA", $address->formatted_address);
});

test('senza numero civico la via non compare e fuori dall Italia la sigla non compare', function (): void {
    $address = geoAddressWith([
        'route' => 'Rue de Rivoli',
        'locality' => 'Paris',
        'country' => 'FR',
        'administrative_area_level_3' => 'Paris',
        'extra_data' => [
            'provincia_sigla' => 'PA',
        ],
    ]);

    Assert::assertSame("Paris\nFR", $address->formatted_address);
});

test('senza localita la sigla della provincia non compare', function (): void {
    $address = geoAddressWith([
        'postal_code' => '20121',
        'country' => 'IT',
        'administrative_area_level_3' => 'Milano',
        'extra_data' => [
            'provincia_sigla' => 'MI',
        ],
    ]);

    Assert::assertSame("20121\nIT", $address->formatted_address);
});

test('un indirizzo senza campi da una stringa vuota', function (): void {
    Assert::assertSame('', geoAddressWith([])->formatted_address);
});
