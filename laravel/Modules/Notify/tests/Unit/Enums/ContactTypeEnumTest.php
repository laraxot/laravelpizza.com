<?php

declare(strict_types=1);

uses(\Modules\Notify\Tests\TestCase::class);

use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Notify\Enums\ContactTypeEnum;

it('has correct cases', function (): void {
    expect(ContactTypeEnum::cases())->toHaveCount(6);

    expect(ContactTypeEnum::PHONE->value)->toBe('phone');
    expect(ContactTypeEnum::MOBILE->value)->toBe('mobile');
    expect(ContactTypeEnum::EMAIL->value)->toBe('email');
    expect(ContactTypeEnum::PEC->value)->toBe('pec');
    expect(ContactTypeEnum::WHATSAPP->value)->toBe('whatsapp');
    expect(ContactTypeEnum::FAX->value)->toBe('fax');
});

it('implements filament contracts', function (): void {
    expect(ContactTypeEnum::PHONE)->toBeInstanceOf(HasLabel::class);
    expect(ContactTypeEnum::PHONE)->toBeInstanceOf(HasIcon::class);
    expect(ContactTypeEnum::PHONE)->toBeInstanceOf(HasColor::class);
});

it('has trans trait', function (): void {
    $reflection = new ReflectionClass(ContactTypeEnum::class);
    $traits = $reflection->getTraitNames();

    expect($traits)->toContain('Modules\\Xot\\Filament\\Traits\\TransTrait');
});

it('has required methods', function (): void {
    expect(method_exists(ContactTypeEnum::class, 'getLabel'))->toBeTrue();
    expect(method_exists(ContactTypeEnum::class, 'getColor'))->toBeTrue();
    expect(method_exists(ContactTypeEnum::class, 'getIcon'))->toBeTrue();
    expect(method_exists(ContactTypeEnum::class, 'getDescription'))->toBeTrue();
    expect(method_exists(ContactTypeEnum::class, 'getSearchable'))->toBeTrue();
    expect(method_exists(ContactTypeEnum::class, 'getFormSchema'))->toBeTrue();
});

it('getSearchable returns all values', function (): void {
    $searchable = ContactTypeEnum::getSearchable();

    expect($searchable)->toBeArray();
    expect($searchable)->toHaveCount(6);
    expect($searchable)->toContain('phone', 'mobile', 'email', 'pec', 'whatsapp', 'fax');
});

it('getFormSchema returns TextInput components', function (): void {
    $schema = ContactTypeEnum::getFormSchema();

    expect($schema)->toBeArray();
    expect($schema)->toHaveCount(6);

    foreach ($schema as $component) {
        expect($component)->toBeInstanceOf(TextInput::class);
    }
});

it('each case has a unique value', function (): void {
    $values = array_map(static fn (ContactTypeEnum $case): string => $case->value, ContactTypeEnum::cases());
    $uniqueValues = array_unique($values);

    expect($uniqueValues)->toHaveCount(count($values));
});
