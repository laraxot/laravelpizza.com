---
title: "Gdpr — Filament panel: gestione consensi e audit"
id: "gdpr.003-filament-panel"
module: Gdpr
type: story
status: todo
priority: medium
created: 2026-11-04
---

# Gdpr.003 — Filament Panel Gdpr

## Filament Blueprint

```
AdminPanelProvider (app/Providers/Filament/AdminPanelProvider.php)
│
├── Resources
│   ├── ConsentTypeResource       → tipi di consenso (cookie, marketing, ecc.)
│   └── UserConsentLogResource    → storico consensi per utente (read-only)
│
└── Pages
    ├── DataExportRequestPage     → richiesta export dati personali
    └── DataRetentionSettingsPage → policy retention per tipo di dato
```

## Acceptance criteria

- [ ] `AdminPanelProvider` creato con `$name = 'Gdpr'`
- [ ] `ConsentTypeResource` con CRUD per tipi di consenso
- [ ] `UserConsentLogResource` read-only con filtri per utente/data/tipo
- [ ] `DataExportRequestPage` per richiedere export (triggera `ExportUserDataAction`)
- [ ] Tutte le classi Filament estendono XotBase*
- [ ] PHPStan zero errori sul pannello
- [ ] Test Pest per almeno 2 pagine

## Note tecniche

- Nessun dato personale in chiaro nell'interfaccia admin
- Export dati disponibile solo all'utente interessato (non all'admin)
- Log consensi immutabili: solo append, mai delete
