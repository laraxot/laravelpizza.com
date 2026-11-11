<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Emails;

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Emails\SpatieEmail;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
/**
 * Story quaeris-send-invite-migrate-to-record-notification.md, Difetto 16
 * (2026-09-15): `SpatieEmail::__construct()` crea un `MailTemplate` al volo
 * (`firstOrCreate()`) per uno slug non ancora esistente, ma i default di
 * creazione non valorizzavano `html_layout_path` — `getHtmlLayout()` lo
 * pretende come stringa non-null e lanciava `Assert::string(null)` al primo
 * invio reale. Riprodotto dal vivo testando "Invia Spatie Email" su un
 * contatto senza token (survey `vivaservizi`, template id 161 in produzione).
 *
 * Nessuna chiamata reale possibile qui: `getHtmlLayout()` legge solo un file
 * locale del tema attivo (`Themes/<tema>/resources/mail-layouts/base.html`),
 * nessun mailer/gateway coinvolto. `$record` e' un `Model` anonimo non
 * salvato, stesso pattern gia' usato in
 * `NotifyGapAttackCoverageTest.php`/`NotificationsCoverageTest.php` per
 * `RecordNotification` — `SpatieEmail` non richiede altro dal record oltre
 * ai suoi attributi.
 */
it('sets html_layout_path on a freshly auto-created MailTemplate (Difetto 16)', function (): void {
    $slug = 'pest-spatie-email-auto-create-'.uniqid();

    $record = new class extends Model
    {
        protected $guarded = [];
    };

    $email = new SpatieEmail($record, $slug);

    $template = MailTemplate::query()
        ->where('mailable', SpatieEmail::class)
        ->where('slug', $slug)
        ->first();

    Assert::assertNotNull($template, 'SpatieEmail avrebbe dovuto auto-creare il MailTemplate per questo slug');
    Assert::assertSame('base.html', $template->html_layout_path);

    $layout = $email->getHtmlLayout();
    Assert::assertNotSame('', $layout, 'getHtmlLayout() non deve lanciare ne\' restituire un layout vuoto');
});

it('does not overwrite html_layout_path on a MailTemplate that already exists', function (): void {
    $slug = 'pest-spatie-email-existing-'.uniqid();

    MailTemplate::query()->create([
        'mailable' => SpatieEmail::class,
        'slug' => $slug,
        'subject' => 'Pest existing subject',
        'html_template' => '<p>Pest existing</p>',
        'html_layout_path' => 'base.html',
    ]);

    $record = new class extends Model
    {
        protected $guarded = [];
    };

    new SpatieEmail($record, $slug);

    $template = MailTemplate::query()
        ->where('mailable', SpatieEmail::class)
        ->where('slug', $slug)
        ->first();

    Assert::assertNotNull($template);
    Assert::assertSame('Pest existing subject', $template->subject);
});
