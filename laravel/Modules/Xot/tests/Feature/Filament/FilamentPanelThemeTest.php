<?php

declare(strict_types=1);

use Filament\Facades\Filament;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

/*
 * Aspetto del pannello: font e larghezze sidebar fissati dal provider del pannello.
 * Il brand name dipende dal tenant (metatag.php del dominio): si verifica solo che esista,
 * non un valore cablato di un singolo ambiente.
 */
test('il tema di filament è configurato correttamente', function (): void {
    expect(Filament::getFontFamily())
        ->toBe('Inter Variable')
        ->and(Filament::getSidebarWidth())
        ->toBe('20rem')
        ->and(Filament::getCollapsedSidebarWidth())
        ->toBe('4.5rem')
        ->and(Filament::getBrandName())
        ->toBeString()
        ->not->toBeEmpty();
});
