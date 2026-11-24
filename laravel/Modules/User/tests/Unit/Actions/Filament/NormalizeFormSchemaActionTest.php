<?php

declare(strict_types=1);

use Filament\Forms\Components\TextInput;
use Modules\User\Actions\Filament\NormalizeFormSchemaAction;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('conserva componenti e chiavi quando lo schema e valido', function (): void {
    $name = TextInput::make('name');
    $email = TextInput::make('email');

    $result = app(NormalizeFormSchemaAction::class)->execute(['name' => $name, 0 => $email]);

    expect($result)->toBe(['name' => $name, 0 => $email]);
});

test('restituisce array vuoto se un elemento non e un componente', function (): void {
    $result = app(NormalizeFormSchemaAction::class)->execute(['name' => TextInput::make('name'), 'bad' => 'stringa']);

    expect($result)->toBe([]);
});

test('schema vuoto resta vuoto', function (): void {
    expect(app(NormalizeFormSchemaAction::class)->execute([]))->toBe([]);
});
