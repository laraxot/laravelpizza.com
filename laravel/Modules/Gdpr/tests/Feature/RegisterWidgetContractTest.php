<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ViewErrorBag;
use Livewire\Livewire;
use Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget;
use Modules\Gdpr\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\preg_match;
use function Safe\preg_match_all;

uses(TestCase::class);

/*
 * Cosa possiede il modulo nella registrazione, indipendentemente dal tema che ospita la pagina.
 *
 * @see Modules/Gdpr/docs/register-widget-copy-ownership.md
 */

const GDPR_REGISTER_LOCALES = ['it', 'en', 'de', 'es'];

const GDPR_REGISTER_MODELS = [
    'first_name', 'last_name', 'email', 'password', 'password_confirmation',
    'privacy_accepted', 'terms_accepted', 'marketing_consent',
];

/**
 * Chiavi che ogni vista del widget (tema o modulo) deve rendere.
 *
 * @return list<string>
 *
 * @see Modules/Gdpr/docs/register-widget-copy-ownership.md
 */
function gdprRegisterContractKeys(): array
{
    return [
        'gdpr::register.fields.first_name.label',
        'gdpr::register.fields.last_name.label',
        'gdpr::register.fields.email.label',
        'gdpr::register.fields.password.label',
        'gdpr::register.fields.password_confirmation.label',
        'gdpr::register.consents.privacy_policy_label',
        'gdpr::register.consents.terms_label',
        'gdpr::register.consents.marketing_label',
        'gdpr::register.consents.privacy_policy_link',
        'gdpr::register.consents.terms_link',
    ];
}

/**
 * @see Modules/Gdpr/docs/register-widget-copy-ownership.md
 */
function gdprAssertRegisterContract(string $html): void
{
    Assert::assertStringContainsString('wire:submit="submit"', $html);
    foreach (GDPR_REGISTER_MODELS as $model) {
        Assert::assertStringContainsString('wire:model="'.$model.'"', $html, 'manca wire:model="'.$model.'"');
    }
    foreach (gdprRegisterContractKeys() as $key) {
        $text = __($key);
        Assert::assertIsString($text);
        Assert::assertNotSame($key, $text, 'chiave non tradotta: '.$key);
        Assert::assertStringContainsString(e($text), $html, 'testo assente: '.$key);
    }
    Assert::assertStringNotContainsString('gdpr::register.', $html);
}

/**
 * @param  array<array-key, mixed>  $values
 * @return array<string, mixed>
 *
 * @see Modules/Gdpr/docs/register-widget-copy-ownership.md
 */
function gdprFlattenLang(array $values, string $prefix = ''): array
{
    $flat = [];
    foreach ($values as $key => $value) {
        if (is_array($value)) {
            $flat += gdprFlattenLang($value, $prefix.$key.'.');

            continue;
        }
        $flat[$prefix.$key] = $value;
    }

    return $flat;
}

it('renders the contract with the view the widget resolves', function (string $locale): void {
    app()->setLocale($locale);

    gdprAssertRegisterContract(Livewire::test(RegisterWidget::class)->html());
})->with(GDPR_REGISTER_LOCALES);

it('renders the contract with the module fallback view', function (string $locale): void {
    app()->setLocale($locale);

    $html = view('gdpr::filament.widgets.auth.register', [
        'show_password' => false,
        'errors' => new ViewErrorBag,
    ])->render();

    gdprAssertRegisterContract($html);
    // Il pulsante della vista di riserva e' del modulo.
    Assert::assertStringContainsString(e((string) __('gdpr::register.form.submit')), $html);
})->with(GDPR_REGISTER_LOCALES);

it('has the same register keys in every language', function (): void {
    $keysByLocale = [];
    foreach (GDPR_REGISTER_LOCALES as $locale) {
        /** @var array<string, mixed> $values */
        $values = require module_path('Gdpr', 'lang/'.$locale.'/register.php');
        $keys = array_keys(gdprFlattenLang($values));
        // Impalcatura di navigazione: non e' testo della registrazione.
        $keys = array_values(array_filter($keys, static fn (string $key): bool => preg_match('/^(navigation\.|label$|plural_label$)/', $key) !== 1));
        sort($keys);
        $keysByLocale[$locale] = $keys;
    }

    foreach ($keysByLocale as $locale => $keys) {
        Assert::assertSame($keysByLocale['en'], $keys, 'chiavi diverse da en in '.$locale);
    }
});

it('has no copy of a specific project in its language files', function (): void {
    $pattern = '/pizza|🍕|meetup|laravel|credit card|carta di credito|tarjeta de cr|kreditkarte|carte de cr|nome progetto/iu';

    foreach (File::allFiles(module_path('Gdpr', 'lang')) as $file) {
        $content = File::get($file->getPathname());
        Assert::assertSame(0, preg_match($pattern, $content, $match), $file->getRelativePathname().': '.($match[0] ?? ''));
    }
});

it('translates every register key used by the module code in every language', function (): void {
    $used = [];
    foreach ([module_path('Gdpr', 'app'), module_path('Gdpr', 'resources/views')] as $dir) {
        foreach (File::allFiles($dir) as $file) {
            preg_match_all("/gdpr::register\\.([a-z0-9_.]+[a-z0-9_])['\"]/", File::get($file->getPathname()), $matches);
            $used = [...$used, ...$matches[1]];
        }
    }
    $used = array_values(array_unique($used));
    Assert::assertNotEmpty($used);

    foreach (GDPR_REGISTER_LOCALES as $locale) {
        foreach ($used as $key) {
            Assert::assertTrue(trans()->has('gdpr::register.'.$key, $locale, false), 'manca gdpr::register.'.$key.' in '.$locale);
        }
    }
});
