<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\WithFaker;
use Modules\Geo\Actions\Geocoding\GeocodeAddressAction;
use Tests\TestCase;

uses(TestCase::class, WithFaker::class);

beforeEach(function () {
    $this->action = app(GeocodeAddressAction::class);
});

describe('GeocodeAddressAction', function () {
    it('throws RuntimeException for unimplemented geocoding', function () {
        expect(fn () => $this->action->execute('Via Roma 1, Milano'))
            ->toThrow(RuntimeException::class, 'Geocoding non ancora implementato');
    });

    it('accepts string address parameter', function () {
        $address = 'Piazza del Duomo, 20121 Milano MI';

        expect(fn () => $this->action->execute($address))
            ->toThrow(RuntimeException::class);
    });

    it('handles empty address string', function () {
        expect(fn () => $this->action->execute(''))
            ->toThrow(RuntimeException::class);
    });

    it('handles special characters in address', function () {
        $address = "Via dell'Arte, 10 - 20123 Milano (MI)";

        expect(fn () => $this->action->execute($address))
            ->toThrow(RuntimeException::class);
    });
});
