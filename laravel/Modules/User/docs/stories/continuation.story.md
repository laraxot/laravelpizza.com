---
id: story-continuation-user-module
title: "User Module — Table Audit and $model Property"
type: continuation
scope: module:User
github: {issues: "https://github.com/laraxot/module_xot_fila5/issues/115", discussions: "https://github.com/laraxot/module_xot_fila5/discussions/117"}
---
# User Module — Continuation Task

## Stato
Modulo con modifiche non ancora sincronizzate nel proprio .git.

## Task
1. Aggiungere `protected static string $model =` a tutte le table class mancanti
2. Audit `getTableColumns()` — verificare campi modello
3. Migliorare UI/UX (badge, toggleable, sortable)
4. `php -l` su tutti i file toccati
5. `git commit -m "BMAD: table audit"`

## Modelli attesi (da verificare)
- Tabella: `Modules\$m\Filament\Resources\*`
- Modello: `Modules\$m\Models\*`
