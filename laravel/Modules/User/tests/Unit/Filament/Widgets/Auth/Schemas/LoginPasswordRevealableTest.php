<?php

declare(strict_types=1);

use function Safe\file_get_contents;

uses(PHPUnit\Framework\TestCase::class);

/**
 * Contratto Filament Blueprint: password login = TextInput::password()->revealable().
 *
 * Source-contract (no Laravel bootstrap): evita BindingResolutionException su
 * translator quando si istanzia lo schema fuori dal container.
 *
 * @see https://filamentphp.com/docs/5.x/forms/text-input#revealable-password-inputs
 * @see laravel/Modules/User/docs/bmad/filament-blueprint.md
 */
test('login form schema source keeps password revealable filament chain', function (): void {
    $source = (string) file_get_contents(
        dirname(__DIR__, 6).'/app/Filament/Widgets/Auth/Schemas/UserForm.php'
    );

    expect($source)
        ->toContain('function getLoginFormSchema(): array')
        ->toMatch('/\'password\'\s*=>\s*TextInput::make\(\'password\'\)[\s\S]*?->password\(\)[\s\S]*?->revealable\(\)/');
});
