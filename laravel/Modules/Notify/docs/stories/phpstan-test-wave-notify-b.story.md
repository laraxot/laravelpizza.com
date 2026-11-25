---
title: "PHPStan test wave Notify, lane notify-b (solo test)"
type: story
module: Notify
phase: implementazione, quality gate
status: done
priority: high
tags: [phpstan, pest, test, notify, regressione]
created: 2026-10-20
updated: 2026-11-23
issues: []
discussions: []
related:
  - ../../../Xot/docs/stories/phpstan-test-wave-regression.story.md
  - ./4.32.notify-phpstan-swarm-internal-errors.story.md
  - ./4.31.phpstan-swarm-already-clean.story.md
qmd: "phpstan test wave notify b story"
---

# PHPStan test wave Notify: lane notify-b

## Fase BMAD

Build + Measure. Perimetro: i 32 file di test del bucket `notify-b` (colonne errori/path, ordine mescolato). La lane `notify-a` possiede i file di produzione e i test restanti. Config PHPStan immutata, nessun ignore, nessuna baseline, nessun commit.

## Misura

| Momento | Errori sui 32 file |
|---|---|
| Baseline 2026-10-20 09:00 (run su tutto `Modules`) | 1175 |
| Ri-misura mirata prima di editare (batch da 8 file) | 1028 |
| Fine lane | **0** |

Verifica: `cd laravel && ./vendor/bin/phpstan analyse <32 file> --memory-limit=2G --no-progress` a batch da 8, `php -l` su tutti i file, nessun errore. Pest non e' stato eseguito: `phpunit.xml` del modulo richiede coverage e il DB di test non esiste (vedi `notify-pest-suite-database-resolver-broken.story.md`).

## Causa del salto, vista da Notify

Il pull del 2026-10-20 ha riespanso nei test del bucket due lignaggi diversi. Parte dei file (`Unit/Models/*`, `Unit/Enums/*`, `Feature/*BusinessLogic*`) e' tornata nella forma PHPUnit a classe (`extends TestCase`, `$this->assertEquals`, `Model::factory()->create()`), con corpi scritti prima che il codice di produzione prendesse la forma attuale. Il commit `f49605a37` (2026-09-24) conserva la conversione Pest tipizzata della stessa suite (`XotBasePest`, `Assert`, `Safe\`). Il `TestCase` e il `Pest.php` del working tree erano invece la versione corta e priva degli helper che quei test chiamano.

## Cause corrette, per radice

| Causa | Errori | Correzione alla sorgente |
|---|---|---|
| Specifica fantasma su `Theme` e `EmailTemplate` (tabelle `themes` e `email_templates` senza migration, colonne oltre `$fillable`, nessun consumatore in produzione) | 530 (317 + 213) | Neutralizzati i due file, vedi sotto |
| `MailTemplate::factory()` assente: il model estende il model Spatie e non aveva `HasFactory`, quindi `create()` su `mixed` a cascata su `$id`, `fresh()`, `update()` | 83 (su `MailTemplateLogBusinessLogicTest`, `MailTemplateVersionBusinessLogicTest`, `Pest.php`; il resto del cascata viveva nei due file neutralizzati) | `app/Models/MailTemplate.php`: `/** @use HasFactory<MailTemplateFactory> */ use HasFactory;` (una riga, factory risolta dal `guessFactoryNamesUsing` di Xot) |
| Helper statici di `Tests\TestCase` mancanti (`notifyReflectionSource`, `notifyArrayGet`, `assertNotifyArray`, `notifyReflectionPropertyNames`) | circa 120 | Aggiunti da `notify-a` in `tests/TestCase.php` mentre lavoravo: non duplicati |
| Forma PHPUnit a classe di quattro suite di model (stessi test, stessi dati del form Pest di `f49605a37`) | 142 | `NotifyThemeTest`, `MailTemplateLogTest`, `NotifyThemeableTest`, `NotificationTypeTest` riallineati al form Pest tipizzato di `f49605a37` (zero perdita di test: stessi nomi e stessi letterali, verificato) |
| Funzioni globali `assertFirstModel` / `assertFreshModel` non definite | 22 chiamate (48 errori con la cascata su `mixed`) | Chiamate instradate su `XotBasePest::assertFirstModel` / `assertFreshModel` (helper condivisi per autoload, nessuna funzione globale): `ContactTestPartOneTest`, `ContactTestPartTwoTest`, `NotificationTypeTest` |
| `array<string, mixed>\|null` annidato su `MailTemplateLog::$data` e `$metadata`, `config()` su `mixed`, `Carbon\|null` | 47 (24 accessi riscritti) | `data_get($log->data, 'a.b')` in `MailTemplateLogBusinessLogicTest`; `config()->string()` per i `.` con `config()`; `Assert::assertNotNull` sui quattro timestamp prima di `lt()` / `lte()` |
| `Pest.php` con espettazioni e helper senza chiamanti (`toBeNotification`, `toBeMailTemplate`, `createNotification`, `makeNotification`, `createMailTemplate`, `makeMailTemplate`) | 10 | Rimossi: nessuno li usa. Restano il bind `pest()->extend(TestCase::class)->in('Feature', 'Unit')` e il commento sul perche' non ci sono funzioni globali |
| Meccanico: `Safe\json_decode`, redundant/alreadyNarrowed su enum e `BaseModelTest`, `jsoncomponentstest.php` | 19 | Enum e `BaseModelTest` riportati al form Pest di `f49605a37`; `jsoncomponentstest.php` allineato al gemello `JsonComponentsTest.php` gia' corretto da `notify-a` |

## File riscritti perche' il test non diceva il vero sul prodotto

- `tests/Feature/MailTemplateVersionBusinessLogicTest.php` (64 errori): da PHPUnit a Pest. Il vecchio corpo chiamava `$version->restore()` (e' `SoftDeletes::restore()`, restituisce `bool`; il ripristino vero e' `restoreTemplate()`), scriveva versioni semver stringa (`'1.5.2'`) su una colonna `version` integer, usava una colonna `mailable` e una relazione `$template->versions` che non esistono. Portati i test validi (creazione, relazione, ripristino tramite `restoreTemplate()`, eccezione senza template, metadata, html/testo con variabili, coerenza variabili, soft delete, campi nullable). Non portati: storico via `versions`, gestione `mailable`, numerazione semver.
- `tests/Unit/Models/NotificationTemplateVersionTest.php` (9 errori): il vecchio test pretendeva `restore()`, `HasUuids`, `Modules\Xot\Traits\HasFactory` e `HasMedia` come trait. Il model usa `Updater`, `HasXotFactory`, `InteractsWithMedia`, implementa l'interfaccia `HasMedia` e ripristina con `restoreTemplate()`. Riscritto in Pest allineato.
- `tests/Unit/Enums/ContactTypeEnumTest.php`: asseriva il trait `Modules\Xot\Filament\Traits\TransTrait`, l'enum usa `Modules\Xot\Traits\EnumTrait`. Riportato al form `f49605a37`.
- `MailTemplateLogBusinessLogicTest.php`: `now()` e' mutabile e `$now->addMinutes()` mutava lo stesso oggetto passato a tutti e quattro i timestamp, quindi `sent_at < delivered_at < opened_at < clicked_at` non poteva essere vero. Ora `$now->copy()->addMinutes(n)`. Rimosso `->and($log->mailable())->toBeInstanceOf(MorphTo::class)`, ridondante (la firma dichiara gia' `MorphTo`).

## File neutralizzati (specifica fantasma)

| File | Motivo | Corpo originale |
|---|---|---|
| `tests/Feature/ThemeManagementBusinessLogicTest.php` | 20 test su `Modules\Notify\Models\Theme` e su una tabella `themes` che Notify non migra (`2020_01_01_000007_create_notify_themes_table` crea `notify_themes` per `NotifyTheme`); colonne spacing, shadows, breakpoints, utilities, transitions, animations, components, changelog, metadata, settings, archived_at assenti dal model | `git -C Modules/Notify show 13f2cb04f:tests/Feature/ThemeManagementBusinessLogicTest.php` |
| `tests/Feature/TemplateManagementBusinessLogicTest.php` | 17 test su `EmailTemplate` e `Theme`, tabelle `email_templates` e `themes` senza migration, colonne oltre `$fillable`; i template reali sono `MailTemplate` e `NotificationTemplate` | `git -C Modules/Notify show 13f2cb04f:tests/Feature/TemplateManagementBusinessLogicTest.php` |

Forma: intestazione che spiega + `it('...')->skip('... not implemented')`. Conferma indipendente in [`../scopo.md`](../scopo.md): `Theme` ed `EmailTemplate` sono modelli orfani con gemello reale (`NotifyTheme`, `MailTemplate`).

## Decisioni aperte (per l'utente o per `notify-a`)

1. **`MailTemplateVersion` usa `template_id`, le migration `mail_template_id`.** `$fillable` e `template()` puntano a `template_id`; le tre migration di `mail_template_versions` creano `mail_template_id` con FK. A runtime la relazione non puo' funzionare finche' uno dei due non cambia. Non toccato (produzione, lane `notify-a`).
2. **`mail_template_logs` non ha migration attiva.** L'unica e' `2024_04_10_000002_add_mail_template_logs_and_versions_tables.php.no` (disabilitata). I test di `MailTemplateLog` restano, tipizzati, ma senza tabella non girano.
3. **`Theme` ed `EmailTemplate`: cancellare** (come propone `scopo.md`) **oppure implementare** con migration. Finche' restano, i due file di test sono `skip`.
4. **Duplicati di nome** tra file di test, non cancellati: `jsoncomponentstest.php`, `JsonComponentsTest.php`, `JsonComponentTest.php`; `emailtemplatestest.php` / `EmailTemplatesTest.php`. Pest li esegue tutti.
5. **Factory resolver di Xot** (`XotServiceProvider::registerFactoryNameResolver`, aggiunto da `user-b` durante il run): ri-misurato, il bucket resta a 0. `HasFactory<MailTemplateFactory>` su `MailTemplate` serve comunque, perche' non estende `XotBaseModel` (quindi niente `HasXotFactory`). `Theme` non ha `HasFactory` e non l'ho aggiunto: i suoi test sono `skip`, nessun chiamante di `Theme::factory()` resta nel bucket.
6. Le checklist `optimization-recommendations.md` / `optimization_recommendations.md` (e le copie in `wiki/integrations/optimization-consolidated.md`) dicono `TemplateManagementBusinessLogicTest.php - DA FARE`: ora il file e' neutralizzato, non "da fare". Duplicati tra loro, non modificati.

## Docs aggiornate

- `docs/scopo.md`: i due rimandi a `ThemeManagementBusinessLogicTest.php:15` descrivevano il vecchio messaggio dello stub; aggiornati allo stato attuale.
- `docs/testing.md`: sezione "File Pest" allineata a come sono fatti davvero `Pest.php` e gli helper (metodi statici, non funzioni globali).
- `docs/00-INDEX.md`: aggiunto il link a questa story.
