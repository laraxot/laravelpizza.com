---
title: "Gdpr — Fondazione BMAD + PHPStan zero"
id: "gdpr.001-foundation"
module: Gdpr
type: story
status: todo
priority: high
created: 2026-11-04
---

# Gdpr.001 — Fondazione BMAD

## Contesto

Il modulo Gdpr ha molti test feature (RegistrationTest, GdprBusinessLogicTest,
RegisterPageFeatureTest, RegisterWidgetTest, ecc.) ma zero stories BMAD.
Esiste documentazione in `docs/` ma non organizzata secondo il pattern BMAD.

## Obiettivo

Formalizzare le stories BMAD per il modulo Gdpr.

## Acceptance criteria

- [ ] PHPStan zero errori su `Modules/Gdpr`
- [ ] `docs/bmad/prd.md` creato con requisiti GDPR compliance
- [ ] Coverage Pest ≥ 70%
- [ ] Tutti i test esistenti passano green
- [ ] Wiki aggiornata con schema consensi

## Note tecniche

- Modulo gestisce registrazione utente con consensi GDPR
- Non duplicare scope User per autenticazione
- Consent data va in `Datas/ConsentData.php` (spatie/laravel-data)
