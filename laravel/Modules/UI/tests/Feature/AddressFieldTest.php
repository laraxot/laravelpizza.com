<?php

declare(strict_types=1);

use Modules\UI\Filament\Forms\Components\AddressField;

it('verifies that AddressField class exists', function (): void {
    expect(class_exists(AddressField::class))->toBeTrue();
});

// Il tipo restituito da make() e' gia' garantito dalla firma (`static`): un
// toBeInstanceOf() qui e' ridondante, e PHPStan lo segnala. Si verifica il nome.
it('creates the AddressField with the given name', function (): void {
    $field = AddressField::make('address');

    expect($field->getName())->toEqual('address');
});

it('returns the relationship set with relationship()', function (): void {
    $field = AddressField::make('address')->relationship('user_address');

    expect($field->getRelationship())->toEqual('user_address');
});

it('falls back to the field name when no relationship is set', function (): void {
    $field = AddressField::make('address');

    expect($field->getRelationship())->toEqual('address');
});
