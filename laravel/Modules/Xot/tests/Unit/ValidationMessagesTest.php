<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

use function Safe\preg_match;

uses(TestCase::class);

/**
 * Il 2026-10-13 si e' visto che in italiano, tedesco e spagnolo il validatore di Laravel restituiva la chiave grezza
 * (`validation.required`) invece del messaggio: la cartella `laravel/lang` non aveva il gruppo `validation` (solo l'inglese, che
 * arriva dal framework) mentre `Modules/Xot/lang/<lingua>/validation.php` ha gia' il set completo. Un cittadino italiano che
 * sbaglia un campo non deve leggere una chiave.
 */
it('translates the validation group instead of returning the raw key', function (string $locale, string $rule, string $value): void {
    app()->setLocale($locale);

    $message = Validator::make(['campo' => $value], ['campo' => $rule])->errors()->first('campo');

    Assert::assertNotSame('', $message);
    Assert::assertStringNotContainsString('validation.', $message, "Messaggio non tradotto in '{$locale}': {$message}");
})->with(function (): array {
    $cases = [];
    foreach (['it', 'en', 'de', 'es'] as $locale) {
        $cases["{$locale} required"] = [$locale, 'required', ''];
        $cases["{$locale} numeric"] = [$locale, 'numeric', 'abc'];
        $cases["{$locale} accepted"] = [$locale, 'accepted', 'no'];
    }

    return $cases;
});

/*
 * DCP-146: le regole che il set di Xot non ha (gt, lt, password.*, uuid, starts_with...) ricadevano sulla lingua di ripiego (italiano):
 * in /de una password debole produceva "Il campo password deve contenere almeno una lettera maiuscola e una minuscola".
 * Inoltre `Modules/User/lang/{en,de}/validation.php` (namespace `user::validation`) erano copie byte per byte del file italiano.
 * Il messaggio deve essere nella lingua della pagina: gruppo globale `validation` e gruppo `user::validation`.
 */
function italianLeak(string $message): bool
{
    return preg_match('/\b(Il campo|Il formato|La password|La conferma|La data|La conferma|Questa email|Il nome|L\'email|Il numero|è obbligatori[oa]|deve essere|deve contenere|non è valid[oa]|non corrisponde|già utilizzata|precedente ad oggi|fornito è apparso)\b/u', $message) === 1;
}

$replace = ['attribute' => 'campo-x', 'value' => 3, 'values' => 'a, b', 'date' => '2026-01-01', 'min' => 3, 'max' => 5, 'other' => 'altro'];

it('does not fall back to Italian for the global validation rules', function (string $locale, string $key) use ($replace): void {
    $message = trans('validation.'.$key, $replace, $locale);

    Assert::assertNotSame('validation.'.$key, $message, "Chiave non tradotta in '{$locale}': {$key}");
    Assert::assertFalse(italianLeak($message), "Testo italiano nel messaggio '{$key}' in '{$locale}': {$message}");
})->with(function (): array {
    $keys = ['required', 'accepted', 'email', 'min.string', 'max.string', 'gt.numeric', 'gte.string', 'lt.array', 'lte.file',
        'password.letters', 'password.mixed', 'password.numbers', 'password.symbols', 'password.uncompromised', 'uuid', 'starts_with', 'ipv4', 'multiple_of'];
    $cases = [];
    foreach (['en', 'de', 'es'] as $locale) {
        foreach ($keys as $key) {
            $cases["{$locale} {$key}"] = [$locale, $key];
        }
    }

    return $cases;
});

/*
 * DCP-378: Livewire legge `validation.uploaded` quando un upload fallisce (es. foto oltre il limite del server); senza la chiave
 * italiana usava il suo testo inglese di riserva «The image failed to upload».
 */
it('translates the failed upload message in every locale', function (string $locale): void {
    // Livewire passa il nome interno del campo (`data.images.f...`): la frase intera non lo deve mostrare al cittadino
    $message = trans('validation.uploaded', ['attribute' => 'data.images.f1'], $locale);

    Assert::assertNotSame('validation.uploaded', $message, "Chiave non tradotta in '{$locale}'");
    Assert::assertStringNotContainsString(':attribute', $message);
    Assert::assertStringNotContainsString('data.images', $message, "Il nome interno del campo trapela in '{$locale}'");
})->with(['it', 'en', 'de', 'es']);

it('speaks the language of the page in the User module validation messages', function (string $locale, string $key) use ($replace): void {
    $message = trans('user::validation.'.$key, $replace, $locale);

    Assert::assertNotSame('user::validation.'.$key, $message, "Chiave non tradotta in '{$locale}': {$key}");
    Assert::assertFalse(italianLeak($message), "Testo italiano nel messaggio '{$key}' in '{$locale}': {$message}");
})->with(function (): array {
    $keys = ['email_already_taken', 'password_confirmation', 'password_current_required', 'password_current_incorrect', 'name_required',
        'email_required', 'email_format', 'phone_format', 'birth_date_before', 'required', 'password.mixed'];
    $cases = [];
    foreach (['en', 'de', 'es'] as $locale) {
        foreach ($keys as $key) {
            $cases["{$locale} {$key}"] = [$locale, $key];
        }
    }

    return $cases;
});

/*
 * Foto dalla fotocamera: quando PHP scarta il file (limite di dimensione) Livewire risponde 422 con `validation.uploaded`
 * e il cittadino leggeva la chiave grezza in italiano e una frase inglese in `validation.file` (it, de). Le due regole
 * del caricamento devono parlare la lingua della pagina.
 */
it('translates the upload rules in the language of the page', function (string $locale, string $key) use ($replace): void {
    // `fallback_locale = it`: senza hasForLocale una chiave mancante in de/es tornerebbe in italiano e passerebbe a vuoto
    Assert::assertTrue(app('translator')->hasForLocale('validation.'.$key, $locale), "Chiave assente in '{$locale}': {$key}");
    $message = trans('validation.'.$key, $replace, $locale);

    Assert::assertNotSame('validation.'.$key, $message, "Chiave non tradotta in '{$locale}': {$key}");
    Assert::assertSame(0, preg_match('/\b(The|must|failed|field)\b/', $message), "Testo inglese nel messaggio '{$key}' in '{$locale}': {$message}");
})->with(function (): array {
    $cases = [];
    foreach (['it', 'de', 'es'] as $locale) {
        foreach (['uploaded', 'file', 'distinct', 'mimetypes'] as $key) {
            $cases["{$locale} {$key}"] = [$locale, $key];
        }
    }

    return $cases;
});
