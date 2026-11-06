---
title: "decision-log.md"
type: concept
status: active
module: "Tenant"
tags: [docs, tenant, bmad]
created: 2026-10-06
updated: 2026-10-19
qmd: "decision log - modulo tenant tenant"
---

# Decision Log - Modulo Tenant

## Formato

- **Data:** YYYY-MM-DD
- **Decisione:** Breve descrizione della decisione presa
- **Stato:** PROPOSTA, APPROVATA, RIFIUTATA, OBSOLETA
- **Impatto:** Alto/Medio/Basso
- **Alternatives considerate:** Elenco delle alternative valutate
- **Conseguenze:** Implicazioni della decisione

## Registro delle decisioni

### 2026-10-19
**Decisione:** un host il cui config è un symlink usa il path reale come nome tenant.
**Stato:** APPROVATA
**Impatto:** Alto
**Alternatives considerate:**
- Caricare anche `eu.fixcity.*` oltre a `local.fixcity.*`
- Aggiungere colonne mancanti su `fixcity_data.users`
**Conseguenze:**
- `fixcity.eu` risolve `local/fixcity` e la connessione `user` resta `fixcity_user`
- La registrazione scrive `users.type` nel database degli utenti



### 2026-09-29
**Decisione:** [Esempio: Utilizzare Filament Widget invece di Livewire per i componenti di UI]
**Stato:** APPROVATA
**Impatto:** Alto
**Alternatives considerate:** 
- Mantenere Livewire
- Utilizzare componenti Blade tradizionali
**Conseguenze:** 
- Migliore integrazione con Filament
- Riduzione della complessità del codice
- Necessità di migrare componenti esistenti

### 2026-09-30
**Decisione:** [Esempio: Adottare la convenzione "una chiave per riga" per gli array PHP]
**Stato:** APPROVATA
**Impatto:** Medio
**Alternatives considerate:** 
- Array inline
- Array multi-linea senza convenzione fissa
**Conseguenze:** 
- Migliore leggibilità e gestione dei conflitti in git
- Necessità di refactor esistente
