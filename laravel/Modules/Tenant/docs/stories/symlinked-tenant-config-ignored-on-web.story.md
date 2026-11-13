---
title: "Config del tenant ignorata via web (symlink eu/fixcity) e pulizia del log errori"
type: story
bmad: true
status: done
created: 2026-11-12
owner: module:Tenant
module: Tenant
related:
  - ../../../Notify/docs/stories/mail-server-send-receive.story.md
tags: [tenant, config, symlink, regression, database, log, livewire]
---

# Config del tenant ignorata via web e pulizia del log

## Sintomo

`GET /it/tickets/1` da utente loggato: 500 `Table 'fixcity_data.ticket_subscribers' doesn't exist (Connection: user, Database: fixcity_data)`.
Da CLI la connessione `user` era corretta (`fixcity_user`): il guasto c'era solo nelle richieste web.

## Causa radice

1. Via web `SERVER_NAME=fixcity.eu` -> tenant `eu/fixcity`; da CLI `APP_URL=http://fixcity.local` -> `local/fixcity`.
2. `config/eu/fixcity` e' un **symlink** a `config/local/fixcity`. `LoadConfiguration` usa Symfony Finder, che **non
   segue i symlink**: `config('eu.fixcity.database')` e' `null`, quindi via web **nessuna** config del tenant
   (database, mail, services, xra...) veniva applicata; `user` ricadeva sulla config base -> `fixcity_data`.
3. Il fix esisteva: `GetTenantNameAction::tenantNameFromPath()` (2026-10-19, `2faa45e745`) restituisce il path reale
   (`local/fixcity`). Il commit "chore: mirror al root di moduli e temi" `9fd38b4912` (2026-11-10) l'ha sovrascritto con
   una versione upstream piu' vecchia. Le test del modulo erano state cancellate in blocco (`483080dcac`, ~10.000 file),
   quindi nessun test ha fermato la regressione.

## Fix

- `Modules/Tenant/app/Actions/GetTenantNameAction.php`: riscritta in avanti la versione di `2faa45e745` (realpath del
  tenant, `getenv('SERVER_NAME')` durante `LoadConfiguration`).
- Guardia: `Modules/Tenant/tests/Unit/GetTenantNameActionSymlinkTest.php` (`SERVER_NAME=fixcity.eu` -> `local/fixcity`,
  config del tenant caricata).
- Verifica: `SERVER_NAME=fixcity.eu php artisan tinker` -> tenant `local/fixcity`, `user` = `fixcity_user`,
  `ticket_subscribers` presente. PHPStan 0. Pest non eseguibile su questo host (`Access denied` sul DB di test).

## Altri errori del log risolti nella stessa sessione

| Errore | Causa | Fix |
|---|---|---|
| `Cannot update locked property: [pageSlug]/[data]` (295) | payload Livewire manomessi (raffiche da 6, orari casuali): `#[Locked]` funziona, ma rispondeva 500 + ERROR | `bootstrap/app.php`: `dontReport` + 403. Guardia `Modules/Xot/tests/Feature/LockedPropertyTamperingTest.php` |
| `Vite manifest not found ... assets/geo` (21) | manca il symlink `public_html/assets/geo` richiesto da `deploy.sh` | creato `-> ../../laravel/Modules/Geo/public` |
| `unexpected token "<<"`, `Log [] is not defined` | marker di merge committati dal sync in `config/services.php` | conflitti risolti (story Notify) |
| `users.deleted_at`, `devices`, `socialite_users`, `Csv`, `Resend`, `mailtrap-sdk`, `Mailgun`, `preserveLegacyValues`, `notify:test-mailtrap`, `example.com`, symlink `Fixcity/public/svg`, guardia `user_id` posts | gia' risolti da altre sessioni: verificati uno per uno sullo stato attuale | solo rimossi dal log |

Rimozione dal log: solo errori verificati come risolti, entry intera (intestazione + stack). Backup prima:
`storage/logs/*.before-prune-2026-11-12.gz`. 500 entry tolte; `laravel.log` 23,0 -> 16,3 MB.

## Restano nel log (non risolti o non verificabili)

- Pulse `Cannot assign array to property ...` + `corrupt data` (ultimo 2026-11-09): stesso schema dei payload manomessi; da verificare.
- `XotBaseWidget::$icon/$title` (ultimo 2026-11-04): non riprodotto.
- Resend `fixcity.eu domain is not verified`, Mailtrap `401`/`pending approval`: stato degli account provider, vedi story Notify.
- `Aborted`, `db:table-metadata`: comandi CLI lanciati male, non bug.
- 3 migrazioni **pending** (`add_metadata_to_consents`, `create_socialite_users`, `create_inbound_emails`): non lanciate
  (dati sacri: decide l'utente).
