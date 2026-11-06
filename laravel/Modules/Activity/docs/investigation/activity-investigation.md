---
type: investigation
title: "Investigation Activity Audit Log"
links: {github_issue: "#401"}
status: draft
updated: 2026-10-08
tags: [docs, activity, investigation]
qmd: "investigation: activity audit log activity"
---
# Investigation: Activity Audit Log

## Problem Statement
Il sistema Activity attualmente non dispone di un audit log completo per tracciare lo stato delle segnalazioni nel tempo. Sono presenti solo stati singoli senza tracciamento temporale intermedio.

## Current State
- Sono presenti documenti BMAD storici (STORY-401 in Fixcity) ma non nel modulo Activity
- Il modulo Activity ha architettura consolidata (Filament, Folio, Actions) ma manca la funzionalità audit trail temporale
- I competitor (FixMyStreet, SeeClickFix, Decoro Urbano) hanno tutti sistemi di timeline completi

## Root Cause Analysis
- Il modello dati non include timestamp per stati intermedi (solo stato finale `status` enum)
- Non esiste un'Action per registrare i cambiamenti di stato
- Non esiste una Folio page per visualizzare la timeline

## Proposed Solution
1. Aggiungere timestamp al modello Activity (created_at, updated_at per transizioni stato)
2. Creare un'Action `RecordStateChangeAction` che registra ogni cambio stato
3. Creare una Folio page `StateTimelinePage` per visualizzare la cronologia
4. Aggiornare i componenti Filament per mostrare stato con badge temporali

## Evidence
- Documenti Fixcity STORY-401 per riferimento architettura timeline
- Analisi competitor: FixMyStreet (questionario post-risoluzione a 2 settimane), SeeClickFix (stati open→acknowledged→closed con timestamps), Decoro Urbano (workflow in attesa→in carico→risolta), Ril.fe.de.ur (apertura→ricezione→verifica→inoltro→risoluzione)
- Regole architettura: no controller (usare Folio + Actions), no services layer, module providers manifest
