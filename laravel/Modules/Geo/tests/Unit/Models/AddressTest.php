<?php

declare(strict_types=1);


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Geo\Models\Address;
use Modules\Geo\Models\Comune;
use Modules\Geo\Models\Province;

beforeEach(function () {
    $this->address = Address::factory()->create();
});

test('address can be created', function () {
    expect($this->address)->toBeInstanceOf(Address::class);
});

test('address has fillable attributes', function () {
    $fillable = $this->address->getFillable();

    expect($fillable)->toContain('street');
    expect($fillable)->toContain('number');
    expect($fillable)->toContain('postal_code');
    expect($fillable)->toContain('city');
});

test('address has casts defined', function () {
    $casts = $this->address->getCasts();

    expect($casts)->toHaveKey('created_at');
    expect($casts)->toHaveKey('updated_at');
    expect($casts)->toHaveKey('coordinates');
});

test('address has proper table name', function () {
    expect($this->address->getTable())->toBe('addresses');
});

test('address belongs to comune', function () {
    $comune = Comune::factory()->create();
    $this->address->update(['comune_id' => $comune->id]);

    expect($this->address->fresh()->comune)->toBeInstanceOf(Comune::class);
    expect($this->address->fresh()->comune->id)->toBe($comune->id);
});

test('address belongs to province', function () {
    $province = Province::factory()->create();
    $this->address->update(['province_id' => $province->id]);

    expect($this->address->fresh()->province)->toBeInstanceOf(Province::class);
    expect($this->address->fresh()->province->id)->toBe($province->id);
});

test('address can get full address', function () {
    $this->address->update([
        'street' => 'Via Roma',
        'number' => '123',
        'postal_code' => '00100',
        'city' => 'Roma',
    ]);

    $fullAddress = $this->address->getFullAddressAttribute();

    expect($fullAddress)->toBe('Via Roma, 123 - 00100 Roma');
});

test('address can be searched by street', function () {
    $searchResult = Address::search('test')->get();

    expect($searchResult)->toHaveCount(1);
    expect($searchResult->first()->id)->toBe($this->address->id);
});

test('address can be filtered by city', function () {
    $cityAddresses = Address::byCity('test')->get();

    expect($cityAddresses)->toHaveCount(1);
    expect($cityAddresses->first()->id)->toBe($this->address->id);
});

test('address can be filtered by postal code', function () {
    $postalCodeAddresses = Address::byPostalCode('test')->get();

    expect($postalCodeAddresses)->toHaveCount(1);
    expect($postalCodeAddresses->first()->id)->toBe($this->address->id);
});

test('address has proper relationships', function () {
    expect($this->address->comune())->toBeInstanceOf(BelongsTo::class);
    expect($this->address->province())->toBeInstanceOf(BelongsTo::class);
});

test('address can validate coordinates', function () {
    $this->address->update(['coordinates' => ['lat' => 41.9028, 'lng' => 12.4964]]);

    expect($this->address->fresh()->hasValidCoordinates())->toBeTrue();

    $this->address->update(['coordinates' => null]);

    expect($this->address->fresh()->hasValidCoordinates())->toBeFalse();
});
