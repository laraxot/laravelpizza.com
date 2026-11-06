---
title: "Best Practices per il Sistema Email"
type: concept
tags: [email, best, practices]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-best-practices-1 best practices per il sistema email"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: superseded
superseded_by: ../../email-best-practices.md
---

# Best Practices per il Sistema Email

## Migrazioni Database

### Struttura Standard
- Utilizzare sempre `XotBaseMigration` come base
- Implementare modifiche nella sezione `tableUpdate`
- Non creare nuove migrazioni per modifiche a tabelle esistenti

### Gestione Campi
- Verificare l'esistenza delle colonne prima di modificarle
- Utilizzare i metodi helper forniti da `XotBaseMigration`
- Documentare tutte le modifiche alle strutture

### Compatibilità
- Mantenere la retrocompatibilità
- Gestire correttamente i rollback
- Testare le migrazioni in ambiente di sviluppo 
