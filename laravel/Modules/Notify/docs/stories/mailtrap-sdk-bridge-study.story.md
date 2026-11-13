---
title: "Mailtrap SDK Laravel bridge — studio e integrazione"
type: story
tags: [notify, mail, mailtrap, email, integration]
created: 2026-11-13
status: review
issues: []
discussions: []
related:
  - "./send-test-mail-wrong-location.story.md"
---

# Mailtrap SDK Laravel bridge — studio e integrazione

## Contesto

Fixcity deve inviare email da `fixcity.eu` (DNS Mailtrap già verificati).
Il progetto richiede `railsware/mailtrap-php ^3.18` in root `composer.json` e
`Modules/Notify/composer.json`; il pacchetto 3.18.0 è ora installato e
autoscoperto da Laravel.

Studio del bridge ufficiale:
<https://github.com/mailtrap/mailtrap-php/tree/main/src/Bridge/Laravel>

## Come funziona il bridge

- `Mailtrap\Bridge\Laravel\MailtrapSdkProvider` (ServiceProvider) fa due cose:
  - `register()`: `mergeConfigFrom(config/mailtrap-sdk.php, 'services')` →
    chiavi `services.mailtrap-sdk.{host,apiKey,sandboxId,inboxId}` lette da
    `MAILTRAP_HOST`, `MAILTRAP_API_KEY`, `MAILTRAP_SANDBOX_ID`,
    `MAILTRAP_INBOX_ID` (deprecated → usare solo `sandboxId`).
  - `boot()`: `Mail::extend('mailtrap-sdk', ...)` crea
    `MailtrapSdkTransportFactory` con DSN `mailtrap+sdk://{apiKey}@{host}`.
- `MailtrapSdkTransportFactory` mappa l'host al layer API:
  - `send.api.mailtrap.io` → transactional sending
  - `bulk.api.mailtrap.io` → bulk sending
  - `sandbox.api.mailtrap.io` → sandbox (richiede `sandboxId`, altrimenti
    `RuntimeException`)
- Host sconosciuti → `UnsupportedHostException`. Opzioni `sandboxId` e
  `inboxId` con valori diversi → `InvalidArgumentException`.
- Header extra possibili su `Mailable` via `Envelope::using`:
  `X-Message-Source`, `X-Mailer`, `CategoryHeader`, `CustomVariableHeader`.

## Stato attuale del progetto

- `config/mail.php` espone il mailer `mailtrap-sdk`; il default resta controllato
  da `MAIL_MAILER`, così locale e test non vengono forzati a inviare email esterne.
- `config/services.php` espone anche `mailtrap-sdk` con le chiavi attese dalla
  bridge; `MAILTRAP_API_KEY` non viene mai salvata nei file versionati.
- `config/services.php` ha la chiave `mailtrap` (api_key, test_recipient) —
  **diversa** da `mailtrap-sdk` attesa dal bridge. Se si definisce una entry
  `mailtrap-sdk` custom in services.php, sostituisce del tutto quella del
  package (host/apiKey/sandboxId vanno ripetuti).
- `Modules/Notify/app/Console/Commands/TestMailtrap.php` usa
  `MailtrapClient::initSendingEmails()` direttamente (layer API), non il
  transport Symfony: non è toccato dal bridge.
- Il mittente globale non deve ricadere sui placeholder Laravel `hello@example.com`
  / `Example`: il fallback applicativo è `noreply@fixcity.eu` / `FixCity`.
  In produzione `MAIL_FROM_ADDRESS` deve comunque essere valorizzato con un
  indirizzo del dominio verificato in Mailtrap.
- Package in lock: `railsware/mailtrap-php 3.18.0`.

## Decisione / piano di integrazione

1. ✅ `composer install`: installato `railsware/mailtrap-php 3.18.0`.
2. ✅ Verificata l'autodiscovery di `MailtrapSdkProvider` tramite
   `extra.laravel.providers` del package.
3. ✅ `config/mail.php`: aggiunto il mailer
   `'mailtrap-sdk' => ['transport' => 'mailtrap-sdk']`.
4. `.env` produzione: `MAIL_MAILER=mailtrap-sdk`, `MAILTRAP_HOST`,
   `MAILTRAP_API_KEY`, `MAILTRAP_SANDBOX_ID` (solo per sandbox).
5. `php artisan optimize:clear && config:cache` dopo aver impostato i secret.
6. ✅ Verificato localmente che `Mail::mailer('mailtrap-sdk')` costruisce
   `MailtrapSdkTransport`; resta da fare un invio reale controllato con secret
   production/sandbox.
7. Verifica: `notify:test-mailtrap` (API diretta) + un `Mailable` reale via
   `Mail::mailer('mailtrap-sdk')` in locale con `MAILTRAP_HOST=sandbox.api.mailtrap.io`.

## Open point

- Quale host in produzione: `send.api.mailtrap.io` (reale) vs
  `sandbox.api.mailtrap.io` (test) — decidere prima del go-live.
- Il bridge è un transport Symfony Mailer: le code queue/notify esistenti
  (SendMailCommand, template Spatie) continuano a funzionare invariati.

## Incidente production: Mailtrap 412

Se Mailtrap segnala `From: example.com` mentre il destinatario è `gmail.com`,
il processo PHP sta usando una `.env` o una config cache precedente. Il mittente
production deve essere un indirizzo del dominio verificato `fixcity.eu`:

```dotenv
MAIL_MAILER=mailtrap-sdk
MAILTRAP_HOST=send.api.mailtrap.io
MAILTRAP_API_KEY=...
MAIL_FROM_ADDRESS=noreply@fixcity.eu
MAIL_FROM_NAME=FixCity
```

Dopo l’aggiornamento della configurazione sul server:

```bash
php artisan optimize:clear
php artisan config:cache
php artisan queue:restart
```

Questo corregge il mittente, ma non aggira la limitazione dell’account Mailtrap
in attesa di approvazione: finché l’account è pending, anche `noreply@fixcity.eu`
non può inviare a `gmail.com` se i domini non coincidono. Per l’invio reale agli
utenti occorre completare l’approvazione Mailtrap (oppure usare un provider
transactional già approvato); per un test pending usare un destinatario
`@fixcity.eu`.

Verificare senza stampare la chiave:

```bash
php artisan tinker --execute="
dump(config('mail.default'));
dump(config('mail.from.address'));
dump(config('mail.mailers.mailtrap-sdk.transport'));
dump(config('services.mailtrap-sdk.host'));
dump((bool) config('services.mailtrap-sdk.apiKey'));
"
```
