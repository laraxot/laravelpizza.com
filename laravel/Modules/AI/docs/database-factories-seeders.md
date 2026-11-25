---
title: "database factories seeders"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "database factories seeders"
issues: []
discussions: []
---

# AI — Stato Factory / Seeder / Migration

Obiettivo: ogni modello concreto ha migration + factory + seeder.

## Copertura modelli

| Modello | Tabella | Migration | Factory | Seeder |
|---|---|---|---|---|
| `AiThread` | `ai_threads` | OK | `AiThreadFactory` (nuovo) | `AiThreadSeeder` (nuovo) |
| `AiMessage` | `ai_messages` | OK | `AiMessageFactory` (nuovo) | `AiMessageSeeder` (nuovo) |
| `AiActionProposal` | `ai_action_proposals` | OK | `AiActionProposalFactory` (nuovo) | `AiActionProposalSeeder` (nuovo) |
| `AiToolLog` | `ai_tool_logs` | OK | `AiToolLogFactory` (nuovo) | `AiToolLogSeeder` (nuovo) |

Orchestratore: `AIDatabaseSeeder` chiama i 4 seeder in ordine (thread → message → proposal → tool log).

## Skip motivati

Nessuno skip. Tutti i modelli in `app/Models/` sono concreti, senza pivot/STI/tabelle condivise.

## Note

- I seeder sono idempotenti (early-return se la tabella ha già righe).
- I factory usano il pattern del repo (`Factory::new()->createOne()->id` per le relazioni), coerente con `WorkOrder`/`Bom`.
- `created_by_user_id` / `user_id` / `proposed_by_user_id` sono generati come interi fittizi: le migration NON dichiarano FK verso `users` (connessione diversa `user` vs `xot`, no FK cross-database), quindi non serve creare utenti reali.
- `XotBaseModel` è la base astratta (modulo `Xot`), non è un modello concreto e non rientra nel conteggio.
