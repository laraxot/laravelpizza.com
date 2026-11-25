---
title: "Notify — PHPStan bootstrap: marker merge PHP"
type: story
status: review
module: Notify
epic: quality
story_id: phpstan-bootstrap-merge-markers
created: 2026-11-25
updated: 2026-11-25
tags:
  - notify
  - phpstan
  - git-conflict
  - bootstrap
qmd: "notify phpstan bootstrap merge markers traits lang mailjet zero"
related:
  - ./0016-phpstan-conflict-markers-bootstrap.story.md
  - ./0011-git-status-fleet-merge-markers-notify.story.md
  - ./0014-netfun-conflict-markers.story.md
  - ../../../Xot/docs/bmad/stories/phpstan-modules-zero-swarm.story.md
---
# phpstan-bootstrap-merge-markers (Notify)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Scopo / perché

Marker `<<<<<<<` nei PHP di Notify (trait rate-limit/tracking/tenant, lang
sms/template, test Mailjet) bloccano il parser e il bootstrap di
`phpstan analyse Modules`. Dominio: template mail/notifica + limiti invio —
il conflitto irrisolto rompe analisi e (per i lang) runtime UI.

## Lock

`bashscripts/lock/phpstan-zero-20261125-Notify.lock`

## Ambito

- `app/Traits/HasNotification{RateLimiting,Tracking}.php`
- `app/Traits/HasTenantNotifications.php`
- `lang/{en,it}/{sms,template}.php`
- `tests/Unit/Actions/Mail/MailjetTransportTest.php`

Fuori scope: massa `.md` docs con marker (debito docs).

## Acceptance criteria

1. [x] Zero `<<<<<<<` in PHP Notify (app/tests/lang).
2. [x] `php -l` verde su tutti i file toccati.
3. [ ] PHPStan `Modules/Notify` exit 0 (gate in corso).
4. [x] Story BMAD + riga diario sprint-status.
5. [ ] Pest mirato Mailjet se comportamento toccato.

## Strategia (source-first)

- **No** `--apply` globale di `resolve-merge-markers.sh` sul modulo: dry-run
  proponeva RESTORE_HIST su migliaia di docs; rischio empty-file noto.
- Lang: restore blob pulito `4fbbc4f1` (formato one-key-per-line HEAD) +
  chiavi mancanti usate dal codice (`sms.notifications.*`, `template.preview.*`).
- Trait: restore body tipizzato (Assert/generics) + docblock dominio unito.
- Mailjet test: restore senza marker; `(new Email)` chaining invariato.

## Diario 2026-11-25

- Marker PHP iniziali: **8** file; `php -l` FAIL su 5 (4 lang + Mailjet).
- Post-fix: marker PHP **0**; chiavi lang Netfun/preview ripristinate.
- Tool: restore selettivo da git show (zsh: usare `${REF}:path`, mai `$REF:path`).
- MANUAL residue: solo docs `.md` (fuori scope).


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
