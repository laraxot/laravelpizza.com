<?php

declare(strict_types=1);

use Modules\Geo\Actions\Address\FormatAddressAction;
use Modules\Geo\Models\Address;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('i codici ISTAT del form diventano comune e sigla della provincia', function (): void {
    $address = new Address([
        'route' => 'Viale delle Nazioni',
        'street_number' => '12',
        'locality' => '39014',
        'administrative_area_level_2' => '39',
        'administrative_area_level_1' => '8',
        'postal_code' => '48122',
    ]);

    Assert::assertSame('Viale delle Nazioni 12, 48122 Ravenna (RA)', app(FormatAddressAction::class)->execute($address));
    Assert::assertSame('Viale delle Nazioni 12, 48122 Ravenna (RA)', $address->full_address);
});

test('un indirizzo scritto per nome resta com\'era', function (): void {
    $address = new Address([
        'route' => 'Via Roma',
        'street_number' => '123',
        'locality' => 'Milano',
        'administrative_area_level_2' => 'Lombardia',
        'postal_code' => '20100',
        'country' => 'Italia',
    ]);

    Assert::assertSame('Via Roma 123, 20100 Milano, Lombardia, Italia', app(FormatAddressAction::class)->execute($address));
});
