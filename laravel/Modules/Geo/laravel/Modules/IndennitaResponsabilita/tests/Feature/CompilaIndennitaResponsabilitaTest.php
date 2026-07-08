<?php

declare(strict_types=1);

use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages\CompilaIndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('can instantiate page', function (): void {
    $page = new CompilaIndennitaResponsabilita();

    Assert::assertInstanceOf(CompilaIndennitaResponsabilita::class, $page);
});

test('has working back method', function (): void {
    $page = new CompilaIndennitaResponsabilita();

    // @phpstan-ignore staticMethod.alreadyNarrowedType
    Assert::assertIsCallable([$page, 'back']);
});

test('model has anno attribute', function (): void {
    $record = new IndennitaResponsabilita();
    $record->anno = 2024;
    $record->cognome = 'Test';
    $record->nome = 'User';
    $record->matr = 12345;

    Assert::assertSame(2024, $record->anno);
    Assert::assertSame('Test', $record->cognome);
    Assert::assertSame('User', $record->nome);
    Assert::assertSame(12345, $record->matr);
});

test('attributes to array includes regular fields', function (): void {
    $record = new IndennitaResponsabilita();
    $record->anno = 2024;
    $record->cognome = 'Test';
    $record->nome = 'User';

    $attributes = $record->attributesToArray();

    Assert::assertSame(2024, $attributes['anno']);
    Assert::assertSame('Test', $attributes['cognome']);
    Assert::assertSame('User', $attributes['nome']);
});
