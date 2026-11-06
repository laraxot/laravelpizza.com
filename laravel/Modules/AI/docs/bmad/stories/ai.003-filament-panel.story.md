---
title: "AI — Filament panel: prompt management e request log"
id: "ai.003-filament-panel"
module: AI
type: story
status: todo
priority: medium
created: 2026-11-04
---

# AI.003 — Filament Panel AI

## Contesto

Il modulo AI non ha un pannello Filament. L'operatore non può gestire i prompt
né vedere lo storico delle richieste AI dall'interfaccia admin.

## Obiettivo

Creare il pannello Filament AI con gestione prompt e log richieste.

## Filament Blueprint

```
AdminPanelProvider (app/Providers/Filament/AdminPanelProvider.php)
│
├── Resources
│   ├── PromptResource         → CRUD template prompt
│   └── AiRequestLogResource   → storico richieste (read-only)
│
└── Pages
    └── AiDashboard            → statistiche utilizzo (token, costo, errori)
```

## Acceptance criteria

- [ ] `AdminPanelProvider` creato con `$name = 'AI'`
- [ ] `PromptResource` con lista, create, edit, delete
- [ ] `AiRequestLogResource` read-only con filtri per data/azione/utente
- [ ] Tutte le classi Filament estendono XotBase*
- [ ] PHPStan zero errori sul pannello
- [ ] Test Pest per le pagine Filament principali

## Note tecniche

- `AiRequestLog` model con migrazione `create_ai_request_logs_table`
- Nessun token/chiave API mostrato nell'interfaccia
- Paginazione obbligatoria su log (max 50/pagina)
