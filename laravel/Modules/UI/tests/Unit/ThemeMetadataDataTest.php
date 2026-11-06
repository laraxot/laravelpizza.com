<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use Modules\UI\Datas\ThemeMetadataData;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('espone i colori passati al costruttore', function (): void {
    $data = new ThemeMetadataData('#112233', '#445566');

    Assert::assertSame('#112233', $data->primaryColorHex);
    Assert::assertSame('#445566', $data->secondaryColorHex);
});

it('applica le scale di spaziatura di default quando non vengono passate', function (): void {
    $data = new ThemeMetadataData('#000000', '#ffffff');

    Assert::assertSame(['sm' => '1rem', 'md' => '2rem', 'lg' => '4rem'], $data->spacingUnits);
    Assert::assertSame(['sm' => '640px', 'md' => '768px', 'lg' => '1024px'], $data->breakpoints);
});

it('accetta scale e breakpoint personalizzati', function (): void {
    $data = new ThemeMetadataData(
        '#000000',
        '#ffffff',
        ['xs' => '0.5rem'],
        ['xl' => '1280px'],
    );

    Assert::assertSame(['xs' => '0.5rem'], $data->spacingUnits);
    Assert::assertSame(['xl' => '1280px'], $data->breakpoints);
});

it('restituisce la spaziatura corrispondente alla chiave', function (): void {
    $data = new ThemeMetadataData('#000000', '#ffffff');

    Assert::assertSame('1rem', $data->getSpacing('sm'));
    Assert::assertSame('2rem', $data->getSpacing('md'));
    Assert::assertSame('4rem', $data->getSpacing('lg'));
});

it('solleva InvalidArgumentException su una chiave di spaziatura assente', function (): void {
    $data = new ThemeMetadataData('#000000', '#ffffff');

    try {
        $data->getSpacing('xxl');
        Assert::fail('getSpacing() doveva sollevare InvalidArgumentException per una chiave assente.');
    } catch (\InvalidArgumentException $exception) {
        // Il messaggio nomina la chiave: è quello che rende diagnosticabile l'errore.
        Assert::assertSame('Invalid spacing unit key: xxl', $exception->getMessage());
    }
});

it('cerca la chiave nella scala personalizzata, non in quella di default', function (): void {
    $data = new ThemeMetadataData('#000000', '#ffffff', ['xs' => '0.5rem']);

    Assert::assertSame('0.5rem', $data->getSpacing('xs'));

    try {
        $data->getSpacing('sm');
        Assert::fail('Una chiave di default non deve esistere quando la scala è stata sostituita.');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Invalid spacing unit key: sm', $exception->getMessage());
    }
});
