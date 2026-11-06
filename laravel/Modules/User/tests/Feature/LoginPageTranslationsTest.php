<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

/**
 * Regressione pagine auth (login, register, reset, logout) in it/en/de/es: chiavi `user::...` mostrate grezze all'utente
 * perche' mancavano nei lang file (login.php svuotato, auth.login_page assente).
 * Legge i file lang direttamente: nessun bootstrap app, nessun DB.
 */
test('le chiavi delle pagine auth esistono in tutte le lingue', function (string $key, string $locale): void {
    [$file, $path] = explode('.', str_replace('user::', '', $key), 2);

    $lines = require dirname(__DIR__, 2).'/lang/'.$locale.'/'.$file.'.php';
    if (! is_array($lines)) {
        throw new RuntimeException("Invalid translation file: {$file}.php");
    }

    expect(Arr::has($lines, $path))->toBeTrue("manca {$key} in {$locale}");
})->with([
    'user::login.no_account',
    'user::login.register_now',
    'user::login.forgot_password_text',
    'user::login.reset_it',
    'user::login.actions.login.label',
    'user::auth.login_page.meta_title',
    'user::auth.login_page.kicker',
    'user::auth.login_page.title',
    'user::auth.login_page.description',
    'user::auth.login_page.support_title',
    'user::auth.login_page.support_item_email',
    'user::auth.login_page.support_item_password',
    'user::auth.login_page.support_item_help',
    'user::auth.register_page.title',
    'user::auth.register_page.subtitle',
    'user::auth.register_page.description',
    'user::auth.register_page.support_title',
    'user::auth.register_page.help_email',
    'user::auth.register_page.help_password',
    'user::auth.register_page.help_support',
    'user::registration.actions.register.label',
    'user::registration.actions.register.error',
    'user::registration.already_registered',
    'user::login.logout_in_progress',
    'user::login.password_reset_page.title',
    'user::login.password_reset_page.intro',
    'user::login.password_reset_page.email_label',
    'user::login.password_reset_page.submit',
    'user::login.password_reset_page.return_to_login',
    'user::user_form.fields.first_name.label',
    'user::user_form.fields.password.helper_text',
])->with(['it', 'en', 'de', 'es']);
