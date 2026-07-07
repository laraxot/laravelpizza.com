# Database Migrations Documentation

## Overview
Questa sezione contiene la documentazione delle migrazioni del database utilizzate nel progetto.

## Migrazioni Principali

### Sistema di Autorizzazione
- [Model Has Roles Migration](Modules/User/docs/database/migrations/model-has-roles.md)
  - Gestisce la relazione polimorfica tra modelli e ruoli
  - Supporta il multi-tenant con team
  - Implementa il sistema di autorizzazione

## Best Practices
- Utilizzare UUID per gli ID
- Implementare indici appropriati
- Gestire correttamente le relazioni
- Documentare le modifiche strutturali

## Struttura
Le migrazioni sono organizzate per modulo e seguono la convenzione di denominazione di Laravel:
```
database/migrations/
├── YYYY_MM_DD_HHMMSS_create_table_name_table.php
└── ...
```

## Recent Changes
- Aggiunta documentazione per model-has-roles
- Migliorata la struttura degli indici
- Ottimizzata la gestione delle relazioni 