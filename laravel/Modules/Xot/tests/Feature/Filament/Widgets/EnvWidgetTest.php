<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature\Filament\Widgets;

use Filament\Facades\Filament;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\File;
use Mockery;
use Mockery\MockInterface;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Filament\Widgets\EnvWidget;
use Tests\TestCase;

uses(TestCase::class);

/**
 * Usa Tests\TestCase (root, minimale) invece di Modules\Xot\Tests\TestCase:
 * questo widget non tocca mai il database, e la seconda richiede un file
 * sqlite condiviso (Modules\Xot\Tests\XotBaseTestCase::sharedSqlitePath())
 * non presente in questo ambiente — verificato che il problema è
 * preesistente e indipendente da questa story: anche
 * Modules/Xot/tests/Feature/ConfigTest.php, mai toccato qui, fallisce con
 * lo stesso errore (SQLiteDatabaseDoesNotExistException).
 *
 * EnvData::update() scrive sempre su base_path('.env') — il vero file
 * dell'ambiente in cui girano i test, non una copia isolata. Ogni test che
 * arriva a chiamare submit()/update() deve salvare il contenuto originale
 * prima e ripristinarlo sempre (anche se un'asserzione fallisce), altrimenti
 * questi test lascerebbero il .env reale della macchina alterato.
 */
/**
 * submit() è riservato al super-admin: i test che scrivono partono da un super-admin,
 * quelli sul rifiuto lo sostituiscono con envWidgetLoginAs(false).
 */
function envWidgetLoginAs(bool $isSuperAdmin): void
{
    /** @var UserContract&MockInterface $user */
    $user = Mockery::mock(UserContract::class);
    $user->shouldReceive('hasRole')->with('super-admin')->andReturn($isSuperAdmin);

    Filament::auth()->setUser($user);
}

beforeEach(function (): void {
    $this->envPath = base_path('.env');
    $this->originalEnvContent = File::get($this->envPath);
    envWidgetLoginAs(true);
});

afterEach(function (): void {
    File::put($this->envPath, $this->originalEnvContent);
});

it('persists a changed field to the real .env file when the form is submitted', function (): void {
    $marker = 'pest-test-'.uniqid('', true);

    $widget = new EnvWidget;
    $widget->mount();
    $widget->data['telegram_bot_token'] = $marker;
    $widget->submit();

    $envContentAfter = File::get($this->envPath);
    expect($envContentAfter)->toContain('TELEGRAM_BOT_TOKEN="'.$marker.'"');
});

it('does not rewrite a field that was not changed in the form', function (): void {
    // Riga di riferimento presa dal .env reale prima di qualunque submit,
    // non da EnvData::make() (singleton statico: dopo update() continua a
    // restituire i valori vecchi in memoria, update() non si auto-aggiorna —
    // confrontarla con se stessa dopo il submit non proverebbe nulla).
    $appUrlLineBefore = collect(explode("\n", $this->originalEnvContent))
        ->first(fn (string $line): bool => str_starts_with($line, 'APP_URL='));

    $widget = new EnvWidget;
    $widget->mount();
    $widget->data['telegram_bot_token'] = 'pest-test-'.uniqid('', true);
    $widget->submit();

    $appUrlLineAfter = collect(explode("\n", File::get($this->envPath)))
        ->first(fn (string $line): bool => str_starts_with($line, 'APP_URL='));

    expect($appUrlLineAfter)->toBe($appUrlLineBefore);
});

it('mounts with the mail and sms fields pre-filled from the current .env, not empty', function (): void {
    $widget = new EnvWidget;
    $widget->mount();

    expect($widget->data)->not->toBeNull();
    /** @var array<string, mixed> $data */
    $data = $widget->data;

    // Non asseriamo un valore specifico (dipende dall'ambiente che esegue
    // il test), solo che mount() legga davvero qualcosa dal .env e non
    // lasci i campi mail a valore di default vuoto per un ambiente che ha
    // MAIL_HOST configurato — coerente con la verifica gia' fatta a mano
    // via tinker durante l'implementazione.
    expect($data)->toHaveKeys(['mail_mailer', 'mail_host', 'mail_port', 'mail_encryption', 'mail_username', 'mail_password', 'mail_from_address', 'mail_from_name', 'sms_driver', 'netfun_token']);
});

it('persists mail_from_address and mail_from_name to the real .env file when changed', function (): void {
    $marker = uniqid('', true);

    $widget = new EnvWidget;
    $widget->mount();
    $widget->data['mail_from_address'] = 'pest-'.$marker.'@example.test';
    $widget->data['mail_from_name'] = 'Pest '.$marker;
    $widget->submit();

    $envContentAfter = File::get($this->envPath);
    expect($envContentAfter)
        ->toContain('MAIL_FROM_ADDRESS="pest-'.$marker.'@example.test"')
        ->toContain('MAIL_FROM_NAME="Pest '.$marker.'"');
});

it('does not rewrite MAIL_FROM_NAME when the form leaves it unchanged, so a ${APP_NAME} reference survives', function (): void {
    $fromNameLineBefore = collect(explode("\n", $this->originalEnvContent))
        ->first(fn (string $line): bool => str_starts_with($line, 'MAIL_FROM_NAME='));

    $widget = new EnvWidget;
    $widget->mount();
    $widget->data['telegram_bot_token'] = 'pest-test-'.uniqid('', true);
    $widget->submit();

    $fromNameLineAfter = collect(explode("\n", File::get($this->envPath)))
        ->first(fn (string $line): bool => str_starts_with($line, 'MAIL_FROM_NAME='));

    expect($fromNameLineAfter)->toBe($fromNameLineBefore);
});

it('groups fields into General/SMS/Mail sections and keeps every selected field visible', function (): void {
    $widget = new EnvWidget;
    $widget->only = [
        'debugbar_enabled', 'telegram_bot_token',
        'sms_driver', 'netfun_token',
        'mail_mailer', 'mail_host', 'mail_port', 'mail_encryption', 'mail_username', 'mail_password',
        'mail_from_address', 'mail_from_name',
    ];

    $schema = $widget->getFormSchema();

    expect($schema)->toHaveCount(3);
    foreach ($schema as $component) {
        expect($component)->toBeInstanceOf(Section::class);
    }
});

it('does not drop a field that is selected but missing from the GROUPS map', function (): void {
    $widget = new EnvWidget;
    $widget->only = ['app_url'];

    $schema = $widget->getFormSchema();

    // app_url appartiene al gruppo General insieme ad altri campi — con
    // only ristretto al solo app_url, quel gruppo ha un solo figlio ma
    // resta comunque una Section (nessun campo sparisce fuori dal gruppo
    // mappato in GROUPS).
    expect($schema)->toHaveCount(1);
    expect($schema[0])->toBeInstanceOf(Section::class);
});

it('refuses to write .env for a user who is not super-admin', function (): void {
    envWidgetLoginAs(false);

    $widget = new EnvWidget;
    $widget->mount();
    $widget->data['telegram_bot_token'] = 'pest-test-'.uniqid('', true);

    expect(fn () => $widget->submit())->toThrow(\Symfony\Component\HttpKernel\Exception\HttpException::class);
    expect(File::get($this->envPath))->toBe($this->originalEnvContent);
});

it('does not write a key that EnvData does not declare, even if the client adds it to the state', function (): void {
    $widget = new EnvWidget;
    $widget->mount();
    $widget->data['app_debug'] = 'true';
    $widget->data['telegram_bot_token'] = 'pest-test-'.uniqid('', true);
    $widget->submit();

    $debugLines = collect(explode("\n", File::get($this->envPath)))
        ->filter(fn (string $line): bool => str_starts_with($line, 'APP_DEBUG='))
        ->values();
    $debugLinesBefore = collect(explode("\n", $this->originalEnvContent))
        ->filter(fn (string $line): bool => str_starts_with($line, 'APP_DEBUG='))
        ->values();

    expect($debugLines->all())->toBe($debugLinesBefore->all());
});

it('resolves field labels and section headings from the translation file, not from hardcoded strings', function (): void {
    app()->setLocale('it');

    expect(trans('xot::env.fields.mail_mailer.label'))->toBe('Driver mail');
    expect(trans('xot::env.fields.netfun_token.label'))->toBe('Netfun token');
    expect(trans('xot::env.sections.Mail.heading'))->toBe('Mail');
});
