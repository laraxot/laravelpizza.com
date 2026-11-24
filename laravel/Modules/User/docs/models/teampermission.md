---
title: "TeamPermission"
type: concept
tags: [teampermission]
created: 2026-07-14
updated: 2026-07-14
qmd: "teampermission teampermission"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./base-classes-hierarchy.md"
  - "./baseuser.md"
  - "./readme.md"
  - "./team.md"
  - "./xotbaivot-migration.md"
  - "./xotbasepivot-migration.md"
---

# TeamPermission

Il modello `TeamPermission` rappresenta i permessi specifici di un utente all'interno di un team.

## Proprietà

- `id` - UUID del permesso
- `team_id` - ID del team
- `user_id` - ID dell'utente
- `permission` - Nome del permesso
- `created_at` - Data di creazione
- `updated_at` - Data di ultimo aggiornamento

## Relazioni

- `team` - BelongsTo con `Team`, rappresenta il team a cui appartiene il permesso
- `user` - BelongsTo con `User`, rappresenta l'utente a cui è assegnato il permesso

## Note Importanti

- Il modello utilizza la connessione 'user'
- I campi fillable sono:
  - `team_id`
  - `user_id`
  - `permission`

## Collegamenti Correlati

- [[Team]]
- [[User]]
- [[HasTeamsContract]]
