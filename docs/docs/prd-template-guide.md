# Guida Template PRD - Product Requirements Document

> Best practices da Aha!, Atlassian, Pendo. Documento vivente, lean, problem-first.

## Struttura Consigliata

### 1. Overview & Strategy
- Executive summary
- Problem statement (cosa risolviamo)
- Target users / personas
- Goals e success metrics

### 2. Scope
- In scope (cosa costruiamo)
- Out of scope (cosa NON costruiamo) — critico per evitare scope creep

### 3. Requirements
- Functional requirements (prioritizzati P0, P1, P2)
- Non-functional requirements (performance, sicurezza, type safety)
- User stories / acceptance criteria (opzionale, per feature complesse)

### 4. Technical
- Architettura e dipendenze
- Integrazione con altri moduli
- Vincoli tecnici

### 5. Risks & Assumptions
- Assunzioni
- Rischi e mitigazioni

### 6. References
- Link a roadmap, docs correlate, PRD progetto

## Principi

- **Problem-first**: Capire il problema prima della soluzione
- **Lean**: Dettaglio sufficiente per stimare e validare, non eccessivo
- **Living document**: Aggiornare al variare di obiettivi
- **Explicit non-goals**: Dichiarare cosa non si fa

## Dove Creare PRD

- **Progetto**: `docs/prd.md`
- **Modulo**: `laravel/Modules/{Module}/docs/prd.md`
- **Tema**: `laravel/Themes/{Theme}/docs/prd.md`

## PRD Esistenti

- [PRD Progetto](../prd.md)
- Moduli: Activity, Cms, Geo, Gdpr, Job, Lang, Media, Meetup, Notify, Seo, Tenant, UI, User, Xot
- Temi: Meetup

## Collegamenti

- [PRD Progetto](../prd.md)
- [Documentation Consolidation Strategy](documentation-consolidation-strategy.md)
