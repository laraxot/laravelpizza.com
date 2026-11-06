---
title: "log"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "log"
issues: []
discussions: []
status: draft
---

## [2026-10-14] docs | Ingressi rivisti sul codice (DOC-010, DOC-002)

- `README.md` della cartella: aggiunte mappa del codice e limiti verificati con `ls`/`grep`; elenco modelli portato da 9 a 14; blocco frontmatter duplicato a meta' file reso commento; riferimenti a `Ptv` (modulo assente dal repo) e a file inesistenti ridotti a testo.
- `00-INDEX.md`: tolta la "Module Version 2.1.0" senza fonte; dichiarate directory canoniche/evidence/legacy con conteggi (3.465 file, 1.552 nella radice); famiglie dei 1.551 `.md` della radice per nome file; corrette le descrizioni errate (roadmap.md e' del FixCity Design System, `SendNotificationBulkAction` e `TrackNotificationEventAction` non esistono, consolidamento SMS non corrisponde al codice).
- `INDEX.md`, `index.md`, `wiki/00-INDEX.md`, `wiki/00-index.md`, `wiki/INDEX.md`, `wiki/index.md` marcati `stale` con la ragione; nessun file spostato o cancellato.
- Verifica oggi su voci di questo log: la voce 2026-09-11 (compliance) dice rimosso il duplicato `app/Contracts/SmsActionContract.php`; il 2026-10-14 `SmsActionContract.php` esiste in tre posizioni (`app/Contracts/`, `app/Contracts/SMS/`, `app/Models/Contracts/`).
- Story: [2026-10-14-docs-ingressi-notify](../stories/docs-ingressi-notify.story.md). Nota durevole: `bashscripts/ai/wiki/memories/docs-notify-activity-media-job-studio.md`.

## [2026-09-11] fix | invito automatico: Difetto 11/12, regola un-canale

- **Difetto 11 (bloccante SMS)**: `SendRecordNotificationAction` instradava l'SMS con `Notification::route(SmsChannel::class, …)` (FQCN come chiave), ma `RecordNotification::via()`/`toSms()` cercano il recapito sotto `'sms'` → `via()` tornava `[]` → l'SMS dell'invito automatico non partiva, in silenzio. Fix: `Notification::route($channelEnum->value, …)`. Commit `f150a9a54`.
- **Difetto 12 (pagina di test)**: `SendNetfunSmsPage::sendSms` ≠ blade `sendSMS` (Livewire `MethodNotFoundException`); `SmsNotification::via()` → `['sms']` alias non registrato → `Driver [sms] not supported`. Fix: `sendSMS`, `SmsNotification::via()` → `[SmsChannel::class]`. Commit `bb340eec0`. SMS reale via Netfun ricevuto dalla pagina sistemata.
- `SendInviteAction` (Quaeris) ora sceglie **un solo canale** (priorità mail), come il legacy `Contact::getNotificationData()`. Commit `a492c917c`.
- Verifica end-to-end (tinker): mail lancia `TypeError getHtmlTemplate(): null` per 22/40 template `survey-pdf-*` (senza `html_template`/`subject`); SMS instrada ok ma `config('sms.default')` = `smsfactor` non configurato (manca `SMS_DRIVER=netfun` in `.env`, anche prod). Dettaglio: story `../../../Quaeris/docs/stories/quaeris-send-invite-migrate-to-record-notification.md` §"Stato dell'invio automatico"; log progetto `docs/wiki/log.md` voce `2026-09-11 (2)`.

## [2026-09-11] compliance | `SmsActionContract` → `Models/Contracts/`, `SmsData` → Spatie Data

- Violazioni `start.md §3` corrette: `SmsActionContract` spostato da `app/Contracts/SMS/` a `app/Models/Contracts/` (namespace `Modules\Notify\Models\Contracts`), duplicato morto `app/Contracts/SmsActionContract.php` rimosso; `SmsData` ora `extends Spatie\LaravelData\Data`. 9 `Send*SMSAction` + `SmsActionFactory` + ~12 test aggiornati. PHPStan 0 errori, phpmd pulito.
- Concept: [concepts/sms-channel-driver-selection.md](concepts/sms-channel-driver-selection.md) §"Posizione contratto e forma di SmsData". Log di progetto: `docs/wiki/log.md` voce `2026-09-11`.

## [2026-09-10] feature | `SmsChannel` config-driven + `sms_from` (Difetto 9/10 story invito Quaeris)

- `SmsChannel` non più cablato su SMSFactor (regressione `b8321c567`): sceglie il driver da `config('sms.default')` via `SmsActionFactory` (mappa esplicita). `SMS_DRIVER=netfun` → inviti SMS via Netfun.
- `MailTemplate.sms_from` (mittente SMS per template) + `SpatieEmail::buildSmsFrom()` + wiring in `RecordNotification::toSms()`. `MailTemplate::getSlugOptions()->preventOverwrite()` (Difetto 10: `SpatieEmail::__construct()` corrompeva lo slug).
- Concept: [concepts/sms-channel-driver-selection.md](concepts/sms-channel-driver-selection.md), [concepts/mail-template-slug-prevent-overwrite.md](concepts/mail-template-slug-prevent-overwrite.md). Story: `../../../Quaeris/docs/stories/quaeris-send-invite-migrate-to-record-notification.md`.

## [2026-08-27] quality | PHPStan `Modules/Notify/app`: XOT-5.43

- `GenericNotification::via()`: PHPDoc `@param object` allineato al type hint nativo
- `HasNotificationTracking` / `HasTenantNotifications`: `@phpstan-ignore trait.unused` (trait composable, coverage in `tests/Unit/Traits/`)
- Doc: [concepts/phpstan-pest-test-doubles.md](concepts/phpstan-pest-test-doubles.md) §2b

## [2026-06-10] schema | notifications owner Notify: XotBaseMigration

- Canonico: `2026_06_10_133000_create_notifications_table.php`
- Vietato `create_notifications_table` in User/
- Doc: [concepts/notifications-database-contract.md](concepts/notifications-database-contract.md)

## [2026-06-05] docs | HackerNoon harness: tips 001-022 in wiki locale

- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md), [llm-wiki.txt](../../../../../bashscripts/tools/prompts/llm-wiki.txt)
- GitHub: [#272](https://github.com/laraxot/base_fixcity_fila5/issues/272) / [D#273](https://github.com/laraxot/base_fixcity_fila5/discussions/273)
- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-laraxot-map.md), [llm-wiki.txt](../../../../../bashscripts/tools/prompts/llm-wiki.txt)
- GitHub: [#272](https://github.com/laraxot/platform/issues/272) / [D#273](https://github.com/laraxot/platform/discussions/273)

---
- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md), `llm-wiki.txt` (file `bashscripts/tools/prompts/llm-wiki.txt` non presente il 2026-10-14)
- GitHub: [#272](https://github.com/laraxot/base_fixcity_fila5/issues/272) / [D#273](https://github.com/laraxot/base_fixcity_fila5/discussions/273)
- Stub/checklist: second-brain → canon Xot, ai-harness, hackernoon map (`docs/wiki/concepts/hackernoon-ai-coding-tips-laraxot-map.md`: file non presente il 2026-10-14), `llm-wiki.txt` (non presente)
- GitHub: [#272](https://github.com/laraxot/platform/issues/272) / [D#273](https://github.com/laraxot/platform/discussions/273)

---
module: "Notify"
---

# Notify - Wiki Activity Log

## [2026-05-11] Wiki Structure Created

- Created wiki structure: rules/, skills/, commands/, memories/, concepts/
- Created INDEX.md for each section
- Created index.md for each section
- Created module index.md
- Ready for on-demand loading via QMD


- 2026-06-10: boundary Notify schema / User runtime: vietato create_notifications in User (XotBaseMigration only)

## 2026-06-10: notifications schema owner

- Unica `create_notifications_table` in Notify; `model_class` = `User\Models\Notification`
- Solo `XotBaseMigration`: mai `extends Migration`
- Vietato duplicato in User/ (es. pattern `2026_07_02_*` con bigint morphs)
## [2026-10-14] docs | confine delivery notifiche

- Aggiunta `concepts/notification-delivery-boundary.md`.
- Esplicitata la separazione tra notifiche transazionali e marketing con decisione Gdpr al dispatch.
