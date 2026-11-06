<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;
use Modules\User\Actions\Auth\GetPostLoginUrlAction;
use Modules\User\Actions\Auth\RememberLoginReturnUrlAction;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Filament\Widgets\Auth\LoginWidget;
use Modules\User\Filament\Widgets\Auth\ResetPasswordWidget;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

use function Safe\json_encode;

uses(TestCase::class);

/*
 * Flusso di accesso nel front office (story auth-flow-redirects-reset-token).
 * 1. Dopo login e registrazione si va all'area personale localizzata: `/it/dashboard` risponde 404, perche' la pagina Folio
 *    del tema `[container0]` la intercetta prima del modulo User.
 * 2. Il link della mail di reset porta a una pagina che monta `ResetPasswordWidget` con il token, e la password si salva
 *    con un solo hash.
 * 3. Il link "Accedi" di una pagina del sito riporta a quella pagina dopo il login, senza open redirect.
 */
/**
 * Same check as Livewire's `assertSeeLivewire` macro, which static analysis does not see on `TestResponse`.
 *
 * @param  class-string  $component
 */
function livewireMarker(string $component): string
{
    return trim(htmlspecialchars(json_encode(['name' => $component])), '{}');
}

beforeEach(function (): void {
    config(['activitylog.enabled' => false]);
    app()->setLocale('it');
});

test('the post-login url is the localized personal area', function (): void {
    expect(app(GetPostLoginUrlAction::class)->execute())->toBe(url('/it/area-personale'));
});

test('the old dashboard url answers 404 and the personal area redirects', function (): void {
    $this->actingAs(UserFactory::new()->createOne(['email_verified_at' => now()]));

    $this->get('/it/dashboard')->assertNotFound();
    $this->get('/it/area-personale')->assertRedirect(url('/it/area-personale/pratiche'));
});

test('login without an intended url goes to the personal area', function (): void {
    $email = 'auth-flow-'.uniqid('', true).'@example.test';
    UserFactory::new()->createOne(['email' => $email, 'password' => Hash::make('SecretPass123!')]);

    $component = Livewire::test(LoginWidget::class)
        ->set('data.email', $email)
        ->set('data.password', 'SecretPass123!')
        ->call('login');

    $component->assertHasNoErrors();
    $component->assertRedirect(url('/it/area-personale'));
});

test('login goes back to the intended url', function (): void {
    $email = 'auth-flow-'.uniqid('', true).'@example.test';
    UserFactory::new()->createOne(['email' => $email, 'password' => Hash::make('SecretPass123!')]);
    session()->put('url.intended', url('/it/blog/una-notizia'));

    Livewire::test(LoginWidget::class)
        ->set('data.email', $email)
        ->set('data.password', 'SecretPass123!')
        ->call('login')
        ->assertRedirect(url('/it/blog/una-notizia'));
});

test('the login page remembers a same-host return url', function (string $source, string $value, string $expected): void {
    $request = $source === 'query'
        ? Request::create('http://fixcity.local/it/auth/login', 'GET', ['redirect' => $value])
        : Request::create('http://fixcity.local/it/auth/login', 'GET', [], [], [], ['HTTP_REFERER' => $value]);
    session()->forget('url.intended');

    app(RememberLoginReturnUrlAction::class)->execute($request);

    expect(session('url.intended'))->toBe($expected);
})->with([
    'referer ticket' => ['referer', 'http://fixcity.local/it/tickets/42', 'http://fixcity.local/it/tickets/42'],
    'referer blog' => ['referer', 'http://fixcity.local/it/blog/una-notizia?x=1', 'http://fixcity.local/it/blog/una-notizia?x=1'],
    'query relative event' => ['query', '/it/events/festa', 'http://fixcity.local/it/events/festa'],
    'query absolute same host' => ['query', 'http://fixcity.local/it/events/festa', 'http://fixcity.local/it/events/festa'],
]);

test('the login page refuses an unsafe return url', function (string $source, string $value): void {
    $request = $source === 'query'
        ? Request::create('http://fixcity.local/it/auth/login', 'GET', ['redirect' => $value])
        : Request::create('http://fixcity.local/it/auth/login', 'GET', [], [], [], ['HTTP_REFERER' => $value]);
    session()->forget('url.intended');

    app(RememberLoginReturnUrlAction::class)->execute($request);

    expect(session()->has('url.intended'))->toBeFalse();
})->with([
    'other host' => ['query', 'https://evil.example/it/tickets'],
    'protocol relative' => ['query', '//evil.example/it/tickets'],
    'backslash' => ['query', '/\\evil.example'],
    'javascript scheme' => ['query', 'javascript:alert(1)'],
    'referer other host' => ['referer', 'https://evil.example/it/blog/x'],
    'referer auth page' => ['referer', 'http://fixcity.local/it/auth/register'],
    'query auth page' => ['query', '/it/auth/login'],
    'empty' => ['query', ''],
]);

test('opening the login page from a ticket remembers the ticket', function (): void {
    $response = $this->withHeader('Referer', url('/it/tickets/42'))->get('/it/auth/login');

    $response->assertOk();
    $response->assertSee(livewireMarker(LoginWidget::class), false);
    $response->assertSessionHas('url.intended', url('/it/tickets/42'));
});

test('opening the login page from another site remembers nothing', function (): void {
    $this->withHeader('Referer', 'https://evil.example/it/tickets/42')
        ->get('/it/auth/login?redirect=https://evil.example/x')
        ->assertOk()
        ->assertSessionMissing('url.intended');
});

test('the referer does not replace an url saved by the auth middleware', function (): void {
    session()->put('url.intended', 'http://fixcity.local/it/tickets/create');
    $request = Request::create('http://fixcity.local/it/auth/login', 'GET', [], [], [], ['HTTP_REFERER' => 'http://fixcity.local/it/tickets']);

    app(RememberLoginReturnUrlAction::class)->execute($request);

    expect(session('url.intended'))->toBe('http://fixcity.local/it/tickets/create');
});

test('the reset link page mounts the reset widget with the token', function (): void {
    $token = 'tok'.bin2hex(random_bytes(8));

    $response = $this->get('/it/auth/password/'.$token);

    $response->assertOk();
    $response->assertSee(livewireMarker(ResetPasswordWidget::class), false);
    $response->assertSee($token, false);
});

test('reset password stores a single hash of the new password', function (): void {
    $email = 'auth-reset-'.uniqid('', true).'@example.test';
    $user = UserFactory::new()->createOne(['email' => $email, 'password' => Hash::make('OldSecret123!')]);
    $this->assertInstanceOf(User::class, $user);
    $token = Password::createToken($user);

    Livewire::test(ResetPasswordWidget::class, ['token' => $token])
        ->assertSet('data.token', $token)
        ->set('data.email', $email)
        ->set('data.password', 'NewSecret456!')
        ->set('data.password_confirmation', 'NewSecret456!')
        ->call('resetPassword')
        ->assertHasNoErrors();

    $hash = $user->fresh()?->getAuthPassword();
    expect($hash)->toBeString();
    expect(Hash::check('NewSecret456!', (string) $hash))->toBeTrue();
});
