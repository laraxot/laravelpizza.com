---
type: decision-log
title: "Decision Log: Notify"
links: {github_issue: "#XXX", discussion: "#XXX"}
status: draft
updated: 2026-10-08
tags: [docs, notify]
qmd: "decision log   notify notify"
---
# Decision Log: Notify

## Decisions

### 2026-10-08: Riallineamento dell'intero modulo all'ultimo commit buono `ad85f0b08`
- **Choose**: Confronto a tre vie dell'intero modulo (app, config, routes, resources, lang, database, tests) con l'ultimo commit buono prima degli eventi del 07/10, `ad85f0b08` (07/10 06:38, story `phpstan-cleanup-notify`, enum `NotificationStatusEnum`/`NotificationLogStatusEnum`).
- **Over**: Ripristino file per file rispetto allo stato del monorepo al 06/10, come nelle due voci precedenti: non vedeva le modifiche fatte nel sotto-repo dopo il 06/10 (per Notify contava 34 file regrediti, erano 338).
- **Because**: Il 07/10 la linea buona è stata fusa con una copia vecchia (`6d3d7794a` + merge `29f6307a3`, 11:13) e poi re-importata da zero (`89ae0b10a`, 12:12). Classificazione dei file diversi da `ad85f0b08`:
  - 322 toccati solo da quegli eventi: riportati ad `ad85f0b08`. Per 138 resta una differenza di solo permesso (`100755` nel commit), con `core.fileMode=false` non modificabile dal working tree.
  - 16 aggiunti solo dalle copie vecchie: eliminati (`app/Phpstan/TraitProbes.php`, la cartella legacy `resources/lang`, `lang/{de,en}/test_smtp.php`, `tests/Unit/Traits/NotifyTraitTestDoubles.php`).
  - 13 eliminati da Marco l'08/10 (`5db42bf06`: `Services/*`, `NotificationFacade`, `PushNotificationPlatformDelivery`, ...): restano eliminati, refactoring voluto.
  - 34 con lavoro nuovo (`5db42bf06` di Marco, `6b444a296` del ripristino di stamattina): merge a tre vie, base = versione prima del commit nuovo, conflitti risolti a favore della versione più recente. `5db42bf06` rifaceva sulla copia vecchia lo stesso lavoro di `ad85f0b08` (enum, stati, targeting push).
  - Eccezione: `TestSmtpPage`, `NotifyThemeableBusinessLogicTest`, `MailTemplateTest` presi interi da `ad85f0b08`. `5db42bf06` toglieva solo variabili inutilizzate nella copia vecchia, che in `ad85f0b08` sono usate: il merge le lasciava non definite (22 errori PHPStan).
- **Restano**: `getRecord()`, guard SMS vuoti, `SmsChannel` con `toSms()` nullo; `SmsChannelSendTest` di `ad85f0b08` si aspetta proprio il salto del `null`.
- **Verifica**: `php -l` pulito, nessun marcatore di conflitto; PHPStan su `Modules/Notify` senza errori. Suite Notify + test Quaeris di listener e `SendInviteAction`, prima e dopo, confronto JUnit test per test: 0 peggiorati, 1 migliorato, 5 test nuovi. I 401 fallimenti presenti in entrambi gli stati sono di bootstrap (*Target class [config] does not exist*: `tests/Pest.php` del modulo non viene caricato lanciando dalla root).

### 2026-10-08: Ripristino traduzioni e SendNetfunSMSAction regrediti dal re-import del 07/10
- **Choose**: Ripristinare dallo stato del monorepo al 06/10 `lang/it/{send_push_notification,send_whats_app,send_spatie_email,send_aws_email}.php` e `Actions/SMS/SendNetfunSMSAction.php` (torna `isSuccessfulResponse()`).
- **Over**: Tenere le versioni del commit `13c52bb06` (07/10 13:02, senza genitori).
- **Because**: Stesso re-import della voce precedente su `RecordNotification`/`SmsChannel`. Le traduzioni avevano perso da 1 a 39 voci, `send_aws_email` aveva il refuso "(AWS]". Nessun lavoro successivo sui file. Criterio: contenuto attuale identico byte per byte a una versione più vecchia già sostituita; per ogni file controllata la storia completa (`--full-history`) per non perdere commit successivi.
- **Verifica**: `php -l`; PHPStan su `Modules` senza errori in Notify; test prima/dopo identici.

### 2026-10-08: Ripristino fix inviti/SMS persi nel re-import del 07/10
- **Choose**: Ripristinare verbatim `Notifications/RecordNotification.php` da `db4fc2482` (06/10) e `Channels/SmsChannel.php` da `b265a033c` (24/09), le ultime versioni con i fix.
- **Over**: Riscrivere i fix a mano, o adattare `UpdateContactInviteCountersListener` (Quaeris) a una firma senza `getRecord()`.
- **Because**: Il re-import `89ae0b10a` (07/10, nuovo commit radice, 4875 file) partiva da una copia vecchia e ha tolto:
  - `RecordNotification::getRecord()`: il listener Quaeris su `NotificationSent` andava in errore fatale *dopo* l'invio. Contatori `mail_count`/`sms_count`/`*_sent_at` mai scritti, filtro anti-doppio-invio di `SendInviteAction` cieco, job fallito con email già partita.
  - Il guard `trim($smsBody) === ''` in `toSms()`: un survey senza `sms_template` spediva un SMS vuoto al gateway (Difetto 17/AC7, story Quaeris `quaeris-send-invite-migrate-to-record-notification.md`).
- **Nota**: la metà `SmsChannel` dello stesso Difetto 17 (`$smsData === null` → `return null`) mancava già dal 24/09, anche in `db4fc2482`: con il solo guard, l'SMS vuoto non partiva ma il job lanciava *toSms method must return an instance of SmsData*. Vanno insieme.
- **Rispetto al file corrente**: in `RecordNotification` torna anche `$fallbackTo` (camelCase del 21/09); in `SmsChannel` il diff è solo il blocco `null`.
- **Verifica**: `php -l` e PHPStan puliti, sparito il `method.notFound` del listener Quaeris; `SmsChannel::send()` con `toSms()` = `null` restituisce `null` senza eccezione; test Quaeris del listener e di `SendInviteAction` verdi. I test Unit di Notify lanciati dalla root falliscono per bootstrap (*Target class [config] does not exist*): `tests/Pest.php` del modulo non viene caricato, indipendente da questo fix.
- **Rischio aperto**: il fix vive nel working tree finché non arriva su `laraxot/module_notify_fila5`; un nuovo pull lo ricancella. È la terza perdita (29/09 e 07/10 le precedenti). Il resto del re-import non è stato verificato.

## Open Questions

