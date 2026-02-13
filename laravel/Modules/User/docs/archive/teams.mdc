---
description:
globs:
alwaysApply: false
---
# Relazione utenti-team: tabella pivot `doctor_team`

## Contesto
Questa documentazione descrive la relazione many-to-many tra utenti e team nel modulo User. La tabella pivot `doctor_team` collega utenti e team secondo le convenzioni del progetto.

## Struttura della tabella
- `id`: PK
- `user_id`: string(36)
- `team_id`: string(36)
- `timestamps`: tracciamento creazione/modifica

## Motivazione
Permette di assegnare più team a uno stesso utente (es. dottori in più team) e gestire i permessi in modo flessibile.

## Migrazione
La migrazione estende `XotBaseMigration` e utilizza i metodi helper per garantire compatibilità multi-tenant e sicurezza. La tabella viene creata con chiave primaria `id` e campi `user_id` e `team_id` come stringhe di 36 caratteri, senza chiave composta.

## Collegamenti
- [Migrazioni del database](mdc:../../../docs/database-migrations.md)
- [Relazioni generali tra moduli](mdc:../../Xot/docs/relazioni.mdc)
- [Pattern di ereditarietà dei modelli](mdc:../../../docs/model-inheritance-patterns.md)
- [Gestione degli utenti](mdc:../../../docs/user-management.md)
- [Gestione delle traduzioni](mdc:../../../docs/translation-management.md)

---

**Collegamento bidirezionale:** Aggiornare anche la documentazione generale per puntare a questo file.

