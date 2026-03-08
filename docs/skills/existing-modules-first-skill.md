# Existing Modules First Skill

## Goal

Applicare la regola "usa moduli esistenti" in ogni task.

## Checklist rapida

1. Leggere `laravel/config/modules_statuses.json` e `laravel/modules_statuses.json`.
2. Mappare il requisito su un modulo esistente.
3. Aggiornare prima docs del modulo (`laravel/Modules/<Module>/docs`).
4. Implementare codice e test Pest nel modulo esistente.
5. Aggiornare GitHub Issue + GitHub Discussion con il mapping effettuato.

## Anti-pattern vietato

- Scaffolding di nuovi moduli per accelerare il lavoro senza approvazione architetturale.
