---
title: "Use Case <nome progetto>ion Market – Event Sourcing e Console Commands"
type: index
status: draft
updated: 2026-10-23
tags: [docs, activity, use_cases]
qmd: "use case <nome progetto>ion market   event sourcing e console commands activity"
---
# Use Case <nome progetto>ion Market – Event Sourcing e Console Commands

## Introduzione
Questo modulo implementa un <nome progetto>ion market tramite event sourcing, aggregate root e proiezioni, ispirandosi alle best practice di progetti open source come [event-sourcing-with-laravel](https://github.com/cnastasi/event-sourcing-with-laravel).

## Obiettivi
- Tracciabilità completa delle modifiche a mercati, scommesse e payout
- Separazione della logica di business tramite eventi e aggregate
- Audit trail e rollback garantiti
- Performance e scalabilità tramite proiezioni ottimizzate

## Console Commands Principali
- `activity:market:create {title} {description} {endDate}` – Crea un nuovo mercato
- `activity:market:place-bet {marketUuid} {userId} {<nome progetto>ion} {amount}` – Piazza una scommessa
- `activity:market:resolve {marketUuid} {outcome}` – Risolve un mercato
- Altri: gestione payout, reportistica, audit (vedi esempi nei file dedicati)

## Esempi di Utilizzo
```bash
php artisan activity:market:create "Elezioni 2024" "Prevedi il vincitore" "2024-11-30"
php artisan activity:market:place-bet market_xxx 12345 "Candidato A" 100
php artisan activity:market:resolve market_xxx "Candidato A"

# 🎯 <nome progetto>ion Market Module

## 📚 Introduzione
Il modulo <nome progetto>ion Market implementa un sistema completo di mercati predittivi utilizzando l'Event Sourcing in Laravel. Permette agli utenti di scommettere sull'esito di eventi futuri, con funzionalità avanzate di gestione dei mercati, calcolo delle quote e distribuzione dei pagamenti.

## 🎯 Funzionalità Principali

| Lingua | Link |
|--------|------|
| 🇮🇹 Presentazione | Questo file (`README.md`) |
| 🇬🇧 Business card | [docs/readme-en.md](../../readme-en.md) |
| 📚 Wiki tecnica | [./docs/wiki/](../..) |

---
**Questa documentazione è neutra e riutilizzabile, senza riferimenti a progetti specifici, e segue le regole di neutralità e modularità.**