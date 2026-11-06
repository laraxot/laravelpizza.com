---
title: La suite Pest di Notify viene raccolta e gira
type: story
status: done
created: 2026-10-26
updated: 2026-10-26
module: Notify
related:
  - ../../../Xot/docs/stories/xot-test-harness-truth.story.md
  - ../testing.md
tags: [pest, test, notify, schema-drift]
---

# La suite Pest di Notify viene raccolta e gira

## Problema

La raccolta dei test si fermava con `Pest\Exceptions\TestCaseAlreadyInUse`:

> The test case [Tests\TestCase] may not be used here. The folder [.../Notify/tests/Feature/EmailTemplatesTest.php] is already bound to the test case [Modules\Notify\Tests\TestCase].

`tests/Pest.php` lega gia' `Feature` e `Unit` a `Modules\Notify\Tests\TestCase`. Due file (`Feature/EmailTemplatesTest.php`, `Feature/JsonComponentsTest.php`) dichiaravano anche `uses(Tests\TestCase::class)`. Pest vieta i due bind insieme: zero test Notify eseguiti.

## Correzioni

Raccolta:
- tolto `uses(Tests\TestCase::class)` dai due file (resta il bind unico di `Pest.php`).

Bug veri nel codice di Notify:
- `NotificationTemplate`, `Notification`: chiave UUID `char(36)` ma `$incrementing = true`; dopo l'insert l'id diventava `'0'`. Ora `$incrementing = false`.
- `NotifyThemeable`: `$fillable` ereditato non aveva `model_type`, `model_id`, `notify_theme_id`; `create()` salvava righe vuote.
- `NotifyTheme::linkable()`: `morphTo('post')` dava al relation il nome `post`; ora `morphTo(__FUNCTION__, 'post_type', 'post_id')`, stesse colonne.
- `NormalizePhoneNumberAction`: un numero `+1 ...` diventava `+39 1...`; un testo senza cifre diventava `+39`. Ora rispetta `+`/`00` e lancia se non ci sono cifre.
- `SendPushToPlatformAction`: FCM risponde 200 anche con token rifiutato; ora `failure > 0` e' un errore.
- `SpatieEmail`: il `MailTemplate` creato al volo ha `html_layout_path = base.html` (Difetto 16).

Test sbagliati:
- `toContain($ago, $messaggio)`: in Pest il secondo argomento e' un altro ago, non un messaggio (EmailTemplates, JsonComponents).
- conteggio fisso di `_components.json` (2) sostituito col numero di comandi nella cartella.
- colonna JSON confrontata come stringa (MySQL normalizza il JSON): nuovo `TestCase::assertNotifyJsonColumn()`.
- `mockExpectation()`/`typedMock()` erano funzioni globali mai caricate: ora metodi statici di `Modules\Notify\Tests\TestCase`.
- `NotificationManagerTest`: usava un mock di template mai collegato; ora crea il template vero con la factory.
- trait `QueueableAction`: test che lo negavano su azioni che lo usano (regola del progetto), o lo cercavano sulla Data invece che sull'Action.
- altri allineamenti puntuali: import di `BuildMailMessageAction`, livello di log (`debug`), `assertArray` usato su un array vuoto, `FirebaseNotificationData::$data` vuoto per costruzione, form schema letto dalla classe `*Form`, `getSlug()` sul mailable di prova, `Http::fake()` catch-all che vinceva sugli stub del singolo test (ora `Http::preventStrayRequests()`).

## Verifica

Dalla root del repo:

```bash
PEST_OUT=<scratch>/notify-N.txt bash bashscripts/tools/pest-scratch-db.sh --test-directory=Modules/Notify/tests Modules/Notify/tests
```

| Momento | Esito |
|---|---|
| Prima | raccolta abortita, 0 test eseguiti |
| Solo fix raccolta | 198 failed, 2 skipped, 596 passed |
| Fine | 151 failed, 2 skipped, 643 passed |

PHPStan sui 29 file toccati: 0 errori. Contenuto CMS (`config/local/fixcity/database/content`): checksum di `git status` uguale prima e dopo le ultime due run.

## Aperto

- Schema drift (125 failure, nessuna migrazione eseguita): tabelle mancanti `mail_template_logs` (34), `notification_template_versions` (4); colonne mancanti `mail_templates.type` (25), `notifications.message` (20) e `status` (2), `notification_types.slug` (16), `notify_themeables.themeable_type` (12), `notify_themes.json_path` (4), `contacts.email`/`survey_pdf_id`/`mobile_phone` (7), `mail_template_versions.template_id` (1).
- `NotificationApiTest` (8): le rotte `/api/notify/*` non esistono (404/405).
- `SpatieTranslatable...` (3): ruolo `notify::admin` assente nel DB di test clonato (solo struttura).
- `NotifyThemeableTest` (7): `Modules\Xot\Traits\Updater` sovrascrive `created_by`/`updated_by` con `authId()`; decidere in Xot.
- Liste `$fillable` attese datate (Contact 2, MailTemplateLog 2, NotificationType 1): il model ha campi che lo schema non ha; prima va scelta la fonte di verita'.
- `MailTemplate` senza `SoftDeletes` (commentato apposta) contro un test che lo pretende.
- `SendNotificationAction::handle()` ritorna `?Notification`, il test si aspetta `bool` (2).
