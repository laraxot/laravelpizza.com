<?php

declare(strict_types=1);

use Modules\Xot\Actions\Config\GetYearOptionsAction;
use Modules\Xot\Actions\Config\ResolveModuleConfigDataAction;
use Modules\Xot\Datas\XotConfigData;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

// Il modulo e' il PRIMO segmento dopo `Modules\`: con Str::between (che taglia all'ultimo
// separatore) `Modules\X\Filament\Pages\P` dava `X\Filament\Pages` e nessuna Data veniva trovata.
test('module without a config data resolves to null', function (string $class): void {
    expect(ResolveModuleConfigDataAction::dataClassFor($class))->toBeNull()
        ->and(app(ResolveModuleConfigDataAction::class)->execute($class))->toBeNull();
})->with([
    'modulo che non esiste' => ['Modules\\Inesistente\\Filament\\Pages\\Pagina'],
    'classe fuori dai moduli' => ['App\\Models\\User'],
    'stringa vuota' => [''],
]);

test('a nested class resolves the config data of the first segment after Modules', function (): void {
    expect(ResolveModuleConfigDataAction::dataClassFor('Modules\\Xot\\Filament\\Pages\\XotBasePage'))
        ->toBe(XotConfigData::class);
});

test('shared components fall back to their historical years when the module has none', function (): void {
    expect(app(GetYearOptionsAction::class)->execute('Modules\\Xot\\Models\\Module', [2023, 2024]))
        ->toBe([
            2024 => '2024',
            2023 => '2023',
        ]);
});
