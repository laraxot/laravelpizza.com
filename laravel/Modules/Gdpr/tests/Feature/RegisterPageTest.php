<?php

declare(strict_types=1);

use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * Pagina /<lingua>/auth/register e form di registrazione (RegisterWidget).
 *
 * Il modulo Gdpr e' condiviso tra progetti: i testi si controllano con le chiavi di traduzione, mai con le frasi di
 * un sito (ogni progetto le sostituisce in lang/vendor/gdpr). La registrazione e' un widget Livewire: non esiste un
 * POST classico su /auth/register, quindi validazione e salvataggio si provano sul widget.
 */

const GDPR_TEST_PASSWORD = 'Str0ng-Passw0rd!2026';

/**
 * @param  array<string, mixed>  $overrides
 * @return Testable<RegisterWidget>
 */
function gdprRegisterForm(array $overrides = []): Testable
{
    $data = array_merge([
        'first_name' => 'Giulia',
        'last_name' => 'Bianchi',
        'email' => 'giulia.'.uniqid().'@example.test',
        'password' => GDPR_TEST_PASSWORD,
        'password_confirmation' => GDPR_TEST_PASSWORD,
        'privacy_accepted' => true,
        'terms_accepted' => true,
        'marketing_consent' => false,
    ], $overrides);

    $component = Livewire::test(RegisterWidget::class);
    foreach ($data as $field => $value) {
        $component->set($field, $value);
    }

    return $component;
}

it('renders the registration page with the translated texts', function (string $locale): void {
    gdprSkipUnlessLocaleSupported($locale);
    app()->setLocale($locale);

    gdprGet('/'.$locale.'/auth/register')
        ->assertOk()
        ->assertSee('lang="'.$locale.'"', false)
        ->assertSee(e(__('gdpr::register.fields.first_name.label')), false)
        ->assertSee(e(__('gdpr::register.fields.last_name.label')), false)
        ->assertSee(e(__('gdpr::register.fields.email.label')), false)
        ->assertSee(e(__('gdpr::register.fields.password_confirmation.label')), false)
        ->assertSee(e(__('gdpr::register.consents.privacy_policy_label')), false)
        ->assertSee('wire:model="privacy_accepted"', false)
        ->assertSee('wire:model="terms_accepted"', false)
        ->assertSee('wire:model="marketing_consent"', false);
})->with(['it', 'en', 'de', 'es']);

it('never shows a raw translation key on the registration page', function (string $locale): void {
    app()->setLocale($locale);

    gdprGet('/'.$locale.'/auth/register')
        ->assertOk()
        ->assertDontSee('gdpr::register.', false);
})->with(['it', 'en']);

it('links the registration page to the login page in the same language', function (): void {
    gdprGet('/en/auth/register')
        ->assertOk()
        ->assertSee('/en/auth/login', false);
});

it('requires every personal field', function (string $field): void {
    gdprRegisterForm([$field => ''])
        ->call('submit')
        ->assertHasErrors([$field => 'required']);
})->with(['first_name', 'last_name', 'email', 'password']);

it('rejects an invalid email', function (): void {
    gdprRegisterForm(['email' => 'not-an-email'])
        ->call('submit')
        ->assertHasErrors(['email' => 'email']);
});

it('rejects an email that is already registered', function (): void {
    $existing = UserFactory::new()->createOne(['email' => 'taken.'.uniqid().'@example.test']);

    gdprRegisterForm(['email' => $existing->email])
        ->call('submit')
        ->assertHasErrors(['email' => 'unique']);
});

it('rejects a password confirmation that does not match', function (): void {
    gdprRegisterForm(['password_confirmation' => 'Another-Passw0rd!2026'])
        ->call('submit')
        ->assertHasErrors(['password_confirmation' => 'same']);
});

it('rejects a weak password', function (string $weak): void {
    gdprRegisterForm(['password' => $weak, 'password_confirmation' => $weak])
        ->call('submit')
        ->assertHasErrors(['password']);
})->with([
    'too short' => 'Ab1!',
    'no uppercase' => 'lowercase-only-1!',
    'no number' => 'No-Numbers-Here!',
]);

it('requires the privacy and terms consents with a translated message', function (string $consent, string $key): void {
    gdprRegisterForm([$consent => false])
        ->call('submit')
        ->assertHasErrors([$consent => 'accepted']);

    Assert::assertNotSame($key, __($key));
})->with([
    'privacy' => ['privacy_accepted', 'gdpr::register.consents.privacy_policy_required'],
    'terms' => ['terms_accepted', 'gdpr::register.consents.terms_required'],
]);

it('creates the user with a hashed password when everything is valid', function (bool $marketing): void {
    $email = 'nuovo.'.uniqid().'@example.test';

    gdprRegisterForm(['email' => $email, 'marketing_consent' => $marketing])
        ->call('submit')
        ->assertHasNoErrors();

    $user = User::query()->where('email', $email)->first();
    Assert::assertNotNull($user);
    Assert::assertSame('Giulia Bianchi', $user->name);
    Assert::assertNotSame(GDPR_TEST_PASSWORD, $user->password);
    Assert::assertTrue(password_verify(GDPR_TEST_PASSWORD, (string) $user->password));
})->with([
    'without marketing' => false,
    'with marketing' => true,
]);

it('does not show the form to a user who is already logged in', function (): void {
    Assert::assertTrue(RegisterWidget::canView());

    $this->actingAs(UserFactory::new()->createOne());

    Assert::assertFalse(RegisterWidget::canView());
});
