---
title: "[STORY] PHPStan cleanup — Gdpr"
type: story
module: Gdpr
status: done
priority: medium
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, gdpr]
---

# [STORY] PHPStan cleanup — Gdpr

## User Request

«sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalità, non sull'errore; aumenta la qualità del codice; usa enum al posto delle costanti».

Perimetro: segnalazioni PHPStan (level max) del modulo Gdpr. Errori di partenza: 4 `variable.unused` nei test (GdprBusinessLogicTest x3, RegisterWidgetTest x1). Nessuna modifica al codice applicativo.

## Analysis

**Scopo del codice.** Il modulo gestisce consensi (`Consent`), trattamenti (`Treatment`) ed eventi di audit (`Event`); `SaveGdprConsentsAction` salva i consensi della
registrazione mappando `privacy_accepted -> privacy_policy`, `terms_accepted -> terms_conditions`, `marketing_consent -> marketing_consent`.

- **`GdprBusinessLogicTest`** ('can track gdpr audit trail', 'can handle consents with different treatments'): le righe `Consent::create()` servono solo per
  l'effetto sul DB, poi i test interrogano `Consent::where(...)`. Le variabili non servivano: ora le create non assegnano nulla (nel working tree era stato aggiunto il prefisso `$_`,
  che zittisce PHPStan senza correggere nulla).
- **`RegisterWidgetTest`** ('saves gdpr consents for a user when treatments exist'): il trattamento `terms_conditions` veniva creato e `terms_accepted => true` passato all'action, ma l'esito
  del consenso "terms" **non veniva mai verificato** (solo privacy e marketing). Aggiunta l'asserzione: il consenso terms e' accettato (`accepted_at` valorizzato), con lo stesso
  schema condizionale dei due controlli esistenti.

## Acceptance Criteria

- [x] Nessuna variabile inutilizzata nei test segnalati ne' prefissi `$_` usati per zittire PHPStan
- [x] Il test di `SaveGdprConsentsAction` verifica anche il consenso `terms_conditions`
- [x] PHPStan: 0 errori sul modulo Gdpr (run per path e run completo)

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO

Dev story: [phpstan-cleanup-gdpr.dev.md](./phpstan-cleanup-gdpr.dev.md)
