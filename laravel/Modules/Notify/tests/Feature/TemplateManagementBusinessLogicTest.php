<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

uses(\Modules\Notify\Tests\TestCase::class);

/**
 * Template Management Business Logic: specifica non implementata.
 *
 * Il corpo originale (17 test) esercita `Modules\Notify\Models\EmailTemplate` e
 * `Modules\Notify\Models\Theme` su tabelle `email_templates` e `themes` che Notify non
 * migra, con colonne (permissions, metadata, workflow, analytics, compatibility,
 * archived_at...) assenti da `$fillable`. Nessun codice di produzione usa i due model: i
 * template mail reali sono `MailTemplate` e `NotificationTemplate`, coperti dai loro test.
 *
 * Quando i template email di Notify verranno modellati con queste funzioni (migration +
 * colonne nel model), ripristinare il corpo da git:
 * `git -C Modules/Notify show 13f2cb04f:tests/Feature/TemplateManagementBusinessLogicTest.php`.
 *
 * @see Modules/Notify/docs/stories/phpstan-test-wave-notify-b.story.md
 */
it('template management business logic')->skip('email_templates and themes tables not implemented');