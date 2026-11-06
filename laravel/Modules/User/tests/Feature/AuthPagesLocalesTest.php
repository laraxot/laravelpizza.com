<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

/**
 * Regressione /{en,de,es}/auth/{login,register}: testo italiano di fallback o etichette grezze
 * (`email`, `remember`...) perche' mancavano chiavi o l'auto-writer aveva scritto il nome del campo come valore.
 * Legge i lang file direttamente: nessun bootstrap app, nessun DB.
 */
$load = static fn (string $loc, string $file): array => (array) require dirname(__DIR__, 2)."/lang/{$loc}/{$file}.php";

$pageKeys = [
    'auth.login_page.meta_title', 'auth.login_page.kicker', 'auth.login_page.title', 'auth.login_page.description',
    'auth.login_page.support_title', 'auth.login_page.support_item_email', 'auth.login_page.support_item_password',
    'auth.login_page.support_item_help',
    'auth.register_page.title', 'auth.register_page.subtitle', 'auth.register_page.description',
    'auth.register_page.support_title', 'auth.register_page.help_email', 'auth.register_page.help_password',
    'auth.register_page.help_support',
    'login.no_account', 'login.register_now', 'login.forgot_password_text', 'login.reset_it',
    'login.actions.login.label', 'login.actions.login.error',
    'registration.already_registered', 'registration.actions.register.label',
    // DCP-377 A-04: il tooltip dell'occhio sul campo password mostrava il nome della chiave in inglese
    'user_form.actions.showPassword.label', 'user_form.actions.showPassword.tooltip',
    'user_form.actions.hidePassword.label', 'user_form.actions.hidePassword.tooltip',
];

$cases = [];
foreach (['en', 'de', 'es'] as $loc) {
    foreach ($pageKeys as $key) {
        $cases["{$loc} {$key}"] = [$loc, $key];
    }
    foreach (['email', 'password', 'remember', 'first_name', 'last_name', 'password_confirmation'] as $field) {
        $cases["{$loc} user_form.fields.{$field}.label"] = [$loc, "user_form.fields.{$field}.label"];
    }
}

test('le pagine auth hanno testo tradotto, non italiano ne nome-chiave', function (string $loc, string $key) use ($load): void {
    [$file, $path] = explode('.', $key, 2);

    $value = Arr::get($load($loc, $file), $path);
    $italian = Arr::get($load('it', $file), $path);
    $leaf = (string) Arr::last(explode('.', $path));
    $field = (string) (explode('.', $path)[1] ?? '');

    expect($value)->toBeString("manca {$loc}/{$key}")
        ->not->toBe('')
        ->not->toBe($leaf, "{$loc}/{$key} e' un valore grezzo")
        ->not->toBe($field, "{$loc}/{$key} e' il nome del campo");

    if (is_string($italian) && mb_strlen($italian) > 12) {
        expect($value)->not->toBe($italian, "{$loc}/{$key} e' ancora in italiano");
    }
})->with($cases);
