---
type: note
tags: [documentation]
issues: []
discussions: []
id: "notify-netfun-conflict-markers"
title: "Notify: marker in SendNetfunSMSAction + lang"
status: review
scope: module:Notify
created: 2026-09-22
updated: 2026-09-22
qmd: "notify netfun conflict markers json_decode redact token isSuccessfulResponse"
related:
  - ../livewire-inventory.md
  - ../../../../Xot/docs/bmad/stories/cleanup-all-modules.story.md
---

# Notify — marker committati in PHP (git status pulito)

**Perché.** HEAD compilava a metà: `SendNetfunSMSAction.php` aveva marker tra import HEAD (solo QueueableAction) e laraxot/dev (Safe `json_decode` + check `error` nel JSON). Netfun risponde HTTP 200 anche in errore; loggare sempre il body con `api_token` in chiaro è un leak.

## Scelta

Tenere il lato **laraxot/dev**: `isSuccessfulResponse`, redact token, `Safe\json_decode`. Array PHP una chiave per riga. Lang: lato espanso (vietato nested inline). Test unitari del helper tenuti.

## File

- `app/Actions/SMS/SendNetfunSMSAction.php`
- `tests/Unit/Actions/SMS/SendNetfunSMSActionTest.php`
- `lang/it/send_whats_app.php`, `send_aws_email.php`, `send_spatie_email.php`, `send_push_notification.php`

## Gate

PHPStan `Modules/Notify`: 0 errori. Pest skip (`DB_HOST=10.100.200.53`). Commit deferred.
