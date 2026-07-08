---
description:
globs:
alwaysApply: false
---
# Relazioni tra moduli

## Relazione utenti-team (doctor_team)
- Vedi dettaglio in @User/docs/te attuale:**
- id (PK, autoincrement)
- user_id (string, 36)
- team_id (string, 36)
- timestamps

**Motivazione:**
- UUID per compatibilità multi-db
- Nessuna foreign key diretta per portabilità e performance
- Gestione centralizzata dei timestamps tramite XotBaseMigration

---

Altre relazioni da documentare qui secondo le regole di progetto.
# Regole generali sulle relazioni tra moduli

## Tabelle pivot e relazioni many-to-many

Le tabelle pivot devono:
- Seguire la convenzione di naming `<modulo>_<relazione>`
- Essere gestite tramite migrazioni che estendono `XotBaseMigration`
- Essere documentate con file `.mdc` nel modulo specifico
- Utilizzare chiave primaria `id` e campi di relazione come stringhe (36 caratteri), senza chiavi composte

## Esempio: relazione utenti-team

Vedi la documentazione dettagliata in:
- @Relazione utenti-tearelati
- @Migrazioni del databarientadutea
