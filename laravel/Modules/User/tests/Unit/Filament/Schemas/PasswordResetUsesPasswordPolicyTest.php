<?php

declare(strict_types=1);

use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Modules\User\Filament\Resources\UserResource\Schemas\UserForm;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * La registrazione applica `Password::defaults()` (maiuscole, minuscole, numeri, simboli: `PasswordData`). Il reset password aveva solo
 * `minLength(8)`: `12345678` e `aaaaaaaa` passavano la validazione del form (audit 2026-11-11, E-01), cioe' chi resetta la password puo'
 * sceglierne una piu' debole di quella con cui si e' registrato. I due schemi del reset (con e senza token nell'URL) devono avere la stessa policy.
 */
dataset('schemi del reset password', [
    'reset con token' => ['getResetPasswordFormSchema'],
    'conferma reset' => ['getPasswordResetConfirmFormSchema'],
]);

test('il campo password del reset applica la policy della registrazione', function (string $schema): void {
    // La policy include `uncompromised` (HIBP): senza fake la prova dipenderebbe dalla rete e da quanto e' nota la password di prova.
    Http::fake();
    $fields = match ($schema) {
        'getResetPasswordFormSchema' => UserForm::getResetPasswordFormSchema(),
        default => UserForm::getPasswordResetConfirmFormSchema(),
    };
    $field = $fields['password'];
    Assert::assertInstanceOf(TextInput::class, $field);
    // `getValidationRules()` chiede il container del form (per `same()`): qui si leggono le regole dichiarate, senza montare il form.
    $declared = (new ReflectionProperty($field, 'rules'))->getValue($field);
    Assert::assertIsArray($declared);
    $policyRules = array_values(array_filter(
        array_map(static fn (mixed $entry): mixed => is_array($entry) ? ($entry[0] ?? null) : null, $declared),
        static fn (mixed $rule): bool => $rule instanceof Password,
    ));

    Assert::assertCount(1, $policyRules, 'nessuna regola Password::defaults() sul campo password del reset');

    foreach (['12345678', 'aaaaaaaa', 'abc'] as $weak) {
        Assert::assertTrue(Validator::make(['password' => $weak], ['password' => $policyRules])->fails(), $weak.' deve essere rifiutata');
    }
    Assert::assertFalse(Validator::make(['password' => 'Zq7!velocePasta'], ['password' => $policyRules])->fails());
})->with('schemi del reset password');
