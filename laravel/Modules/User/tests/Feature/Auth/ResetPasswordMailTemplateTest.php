<?php

declare(strict_types=1);

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Lang;
use Modules\Notify\Emails\SpatieEmail;
use Modules\Notify\Models\MailTemplate;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Tests\TestCase;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * DCP-285 (D-05): il template `reset-password` non e' seminato e `SpatieEmail` lo creava con il corpo di default valido per qualunque
 * slug ("La tua registrazione e' in attesa di approvazione"), senza il link e nella sola lingua corrente. Si prova passando dal
 * callback reale di `ResetPassword::toMailUsing`, registrato da `UserServiceProvider`.
 */

const DCP285_LOCALES = ['it', 'en', 'de', 'es'];

const DCP285_MAIL_KEYS = ['subject', 'greeting', 'intro', 'action', 'fallback', 'ignore'];

function dcp285ForgetResetTemplate(): void
{
    MailTemplate::query()->where('mailable', SpatieEmail::class)->where('slug', 'reset-password')->delete();
}

function dcp285ResetTemplate(): MailTemplate
{
    $template = MailTemplate::query()->where('mailable', SpatieEmail::class)->where('slug', 'reset-password')->first();
    Assert::assertInstanceOf(MailTemplate::class, $template, 'template reset-password non creato');

    return $template;
}

function dcp285Translation(MailTemplate $template, string $column, string $locale): string
{
    return SafeStringCastAction::cast($template->getTranslation($column, $locale, false));
}

function dcp285SendResetMail(string $token = 'dcp285token'): SpatieEmail
{
    $mail = (new ResetPassword($token))->toMail(UserFactory::new()->createOne());
    Assert::assertInstanceOf(SpatieEmail::class, $mail);

    return $mail;
}

it('creates the reset-password template with the link in every supported language', function (): void {
    dcp285ForgetResetTemplate();

    dcp285SendResetMail();
    $template = dcp285ResetTemplate();

    foreach (DCP285_LOCALES as $locale) {
        $html = dcp285Translation($template, 'html_template', $locale);
        $text = dcp285Translation($template, 'text_template', $locale);
        $subject = dcp285Translation($template, 'subject', $locale);

        Assert::assertStringContainsString('{{ reset_password_url }}', $html, "html {$locale}");
        Assert::assertStringContainsString('{{ reset_password_url }}', $text, "text {$locale}");
        Assert::assertNotSame('', $subject, "oggetto {$locale}");
        Assert::assertStringNotContainsString('in attesa di approvazione', $html, "html {$locale} ha il testo di registrazione");
        Assert::assertStringNotContainsString('registrazione', mb_strtolower($subject), "oggetto {$locale} parla di registrazione");
    }
});

it('does not create a second template when the mail is built again', function (): void {
    dcp285ForgetResetTemplate();

    dcp285SendResetMail();
    dcp285SendResetMail();

    Assert::assertSame(1, MailTemplate::query()->where('mailable', SpatieEmail::class)->where('slug', 'reset-password')->count());
});

it('keeps a body customised by an administrator and fills only the missing languages', function (): void {
    dcp285ForgetResetTemplate();
    $custom = '<p>Testo scelto dall\'ente: {{ reset_password_url }}</p>';
    MailTemplate::query()->create([
        'mailable' => SpatieEmail::class,
        'slug' => 'reset-password',
        'html_layout_path' => 'base.html',
        'subject' => ['it' => 'Oggetto dell\'ente'],
        'html_template' => ['it' => $custom],
        'text_template' => ['it' => 'Testo dell\'ente {{ reset_password_url }}'],
    ]);

    dcp285SendResetMail();
    $template = dcp285ResetTemplate();

    Assert::assertSame($custom, $template->getTranslation('html_template', 'it', false));
    Assert::assertSame('Oggetto dell\'ente', $template->getTranslation('subject', 'it', false));
    Assert::assertStringContainsString('{{ reset_password_url }}', dcp285Translation($template, 'html_template', 'de'));
});

it('replaces the registration default that SpatieEmail used to store for this slug', function (): void {
    dcp285ForgetResetTemplate();
    MailTemplate::query()->create([
        'mailable' => SpatieEmail::class,
        'slug' => 'reset-password',
        'html_layout_path' => 'base.html',
        'subject' => ['en' => 'Benvenuto, {{ first_name }}'],
        'html_template' => ['en' => '<p>Gentile {{ first_name }} {{ last_name }},</p><p>La tua registrazione è in attesa di approvazione. Ti contatteremo presto.</p>'],
        'text_template' => ['en' => 'Gentile {{ first_name }} {{ last_name }}, la tua registrazione è in attesa di approvazione. Ti contatteremo presto.'],
    ]);

    dcp285SendResetMail();
    $template = dcp285ResetTemplate();

    foreach (DCP285_LOCALES as $locale) {
        $html = dcp285Translation($template, 'html_template', $locale);
        Assert::assertStringContainsString('{{ reset_password_url }}', $html, "html {$locale}");
        Assert::assertStringNotContainsString('in attesa di approvazione', $html, "html {$locale}");
    }
    Assert::assertStringNotContainsString('Benvenuto', dcp285Translation($template, 'subject', 'en'));
});

it('has the mail texts in it, en, de and es and never reuses the Italian wording', function (): void {
    foreach (DCP285_MAIL_KEYS as $key) {
        $italian = Lang::get('user::reset_password_email.'.$key, [], 'it');
        Assert::assertNotSame('user::reset_password_email.'.$key, $italian, "manca {$key} in it");

        foreach (['en', 'de', 'es'] as $locale) {
            $value = Lang::get('user::reset_password_email.'.$key, [], $locale);
            Assert::assertNotSame('user::reset_password_email.'.$key, $value, "manca {$key} in {$locale}");
            Assert::assertNotSame($italian, $value, "{$key} in {$locale} e' uguale all'italiano");
        }
    }
});

it('renders the German mail with the reset link built from the token', function (): void {
    dcp285ForgetResetTemplate();
    app()->setLocale('de');

    $html = dcp285SendResetMail('dcp285token')->render();

    Assert::assertStringContainsString('dcp285token', $html);
    Assert::assertStringContainsString(SafeStringCastAction::cast(Lang::get('user::reset_password_email.action', [], 'de')), $html);
    Assert::assertStringNotContainsString('in attesa di approvazione', $html);
});
