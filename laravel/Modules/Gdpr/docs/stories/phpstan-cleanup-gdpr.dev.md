---
title: "[DEV] PHPStan cleanup — Gdpr"
type: dev
module: Gdpr
story: "./phpstan-cleanup-gdpr.story.md"
status: done
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, gdpr]
---

# [DEV] PHPStan cleanup — Gdpr

## Technical Plan

- Nessun cambiamento al codice di produzione
- Distinguere variabili davvero superflue (create solo per effetto) da quelle che indicavano un'asserzione mancante

## Files to Modify

- `tests/Feature/GdprBusinessLogicTest.php`, `tests/Feature/RegisterWidgetTest.php`
- `docs/00-index.md` (write-back)

## Implementation Steps

- [x] Letta `SaveGdprConsentsAction` per confermare la mappatura `terms_accepted -> terms_conditions`
- [x] Tolte le assegnazioni inutili in `GdprBusinessLogicTest`
- [x] Aggiunta l'asserzione sul consenso terms in `RegisterWidgetTest`
- [x] PHPStan + `php -l`

## Testing

Test eseguiti: nessuno (i test Gdpr usano la connessione `gdpr`; il DB di test non e' garantito isolato e `.env.testing` punta a MySQL).

## Verification

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Tenant Modules/Activity Modules/Media Modules/AI Modules/UI Modules/Job Modules/Gdpr Modules/TechPlanner Modules/Seo --memory-limit=-1 --no-progress
php -l <file toccati>

```

Esito: 0 errori sui 9 moduli del gruppo (anche con run completo `./vendor/bin/phpstan analyse` senza argomenti).

## Lessons Learned

- Il prefisso `$_` e' un modo per zittire PHPStan, non una correzione: va sostituito da (a) nessuna assegnazione se serve solo l'effetto, (b) l'uso della variabile se mancava un controllo.
- Segnalazione NON mia nel working tree (pre-esistente, non toccata): `tests/PestHelpers.php` ha `// @phpstan-ignore-next-line` trasformato in `/* @phpstan-ignore-next-line ... */` (vietato dal brief; il file non e' in questa lista di errori).
- Dato che il file di test era stato modificato da un altro processo durante il lavoro (rinomina in `$_x`), le modifiche vanno sempre fatte rileggendo lo stato attuale del file.
