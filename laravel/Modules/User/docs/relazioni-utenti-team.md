---
description:
globs:
alwaysApply: false
related:
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
qmd: "relazioni utenti team relazione utentiteam tabella"
---
# Relazione utenti-team: tabella pivot `doctor_team`

## Contesto
Questa documentazione descrive la relazione many-to-many tra utenti e team nel modulo User. La tabella pivot `doctor_team` è necessaria per collegare utenti e team secondo le convenzioni del progetto.

## Errore riscontrato
**Errore:** Tabella `doctor_team` mancante nel database, causava QueryException nelle relazioni Eloquent.

## Soluzione
- Creata la migrazione per la tabella `doctor_team` estendendo `XotBaseMigration`.
- Seguite le best practice documentate in [docs/database-migrations.md](mdc:../../../../docs/database-migrations.md).

## Collegamenti
- [Documentazione generale sulle migrazioni](mdc:../../../../docs/database-migrations.md)
- [Best practice XotBaseMigration](migrations.md)

---

**Collegamento bidirezionale:** Aggiornare anche la documentazione generale per puntare a questo file.
