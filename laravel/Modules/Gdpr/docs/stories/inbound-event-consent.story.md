---
id: IM-GDPR-001
title: "Consenso separato per iscrizione a evento"
type: story
module: Gdpr
epic: "I Governance editoriale"
status: blocked
priority: P1
owner: module:Gdpr
scope: "laravel/Modules/Gdpr/docs/"
created: 2026-10-15
updated: 2026-10-15
tags: [bmad, gdpr, event, consent]
qmd: "evento iscrizione consenso separato revoca GDPR"
related: [IM-BLOG-001, IM-NOTIFY-001]
issues: []
discussions: []
---
# Consenso separato per iscrizione a evento

## Richiesta / scopo
Come partecipante voglio iscrivermi a un evento con informativa chiara, consenso separato e revoca possibile.

## Acceptance Criteria
- [ ] Iscrizione operativa e consenso marketing sono separati.
- [ ] Finalità, titolare, conservazione e revoca sono visibili prima dell'invio.
- [ ] Il sistema non invia nurture senza base giuridica e consenso registrato.
- [ ] La revoca è tracciabile e non cancella la prova necessaria.

## Tasks / Subtasks
- [ ] Mappare contratti Gdpr esistenti.
- [ ] Definire record/evidenza senza duplicare consenso.
- [ ] Testare opt-in, rifiuto, revoca e locale.

## Owned File / Module Scope
Contratti e documentazione Gdpr; integrazione implementativa in owner successiva.

## Testing / Verifica
Pest privacy e audit dei dati esposti; review DPO obbligatoria.

## Dipendenze
IM-BLOG-001. Blocca IM-NOTIFY-001.
