---
tags: [documentation, architecture, refactoring, dependency]
created: 2026-10-21
updated: 2026-10-21
issues: []
discussions: []
title: "User Module Independent of Comment: Architecture Clarification"
type: story
module: User
epic: architecture
story_id: "user-comment-dependency-clarification"
status: done
track: quality/fleet
qmd: "user comment dependency decouple architecture bm ad blueprint"
related:
  - ../../architecture/user-gdpr-decoupling.md
  - ../../../../../../docs/wiki/rules/00-TRIGGER_MAP.md
  - ./../Xot/docs/bmad/architecture.md
---
# User Module Independent of Comment: Architecture Clarification

## Perché User può vivere senza Comment

### Scopo
Verificare se il modulo User ha una dipendenza reale dal modulo Comment e documentare l'architettura attuale.

### Analisi delle dipendenze

1. **Composer.json** (`laravel/Modules/User/composer.json`):
   - `require`: **NON include Comment**
   - `repositories`: include `"url": "../Comment"` come **solo per sviluppo locale** (path-based repository)
   - Questo è un pattern comune: i commenti dipendenti sono opzionali

2. **Ricerca nel codice** (`grep -rn "Comment" laravel/Modules/User/app/`):
   - **Nessun risultato**: User non fa mai riferimento a classi del modulo Comment

3. **Responsabilità di User**
   - Autenticazione e Authorization
   - Gestione ruoli e team
   - Supporto multi-tenant
   - Integrazione OAuth/Socialite
   - Gestione profilo utente

4. **Comment (se presente)**
   - Modulo opzionale per commenti su record
   - Non è una dipendenza logica di User
   - Se Comment non esiste, User funziona completamente

### Conclusione
**Il modulo User è completamente indipendente da Comment**. La configurazione `repositories["../Comment"]` serve solo a sviluppo locale quando si vuole installare Comment come dipendenza opzionale.

### Azioni consigliate

1. **Aggiornare documentazione**: chiareggiare che Comment è opzionale
2. **Verificare tests**: assicurarsi che i test User non richiedano Comment
3. **Architettura pulita**: mantenere User senza dipendenza da Comment

### Artefatti prodotti
- [x] Analisi composer.json
- [x] Ricerca codice Comment references
- [x] Documentazione architettura
- [ ] Consolidamento docs User (work in progress)