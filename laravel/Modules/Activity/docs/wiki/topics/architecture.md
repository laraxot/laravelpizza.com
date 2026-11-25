---
title: "Topic architecture"
type: digest
status: active
qmd: "digest ceiling 100 architecture"
---

# Topic architecture

Sintesi automatica di 4 documenti (chiave `architecture`).

## Architecture Documentation

_Fonte: `architecture.md`_

> Nota 2026-10-14 (docs-audit): il diagramma elenca Repositories, Services, Commands e Projections che non esistono in `app/` (cartelle reali: Actions, Adapters, Console, Contracts, Datas, Enums, Events, Exceptions, Filament, Http, Listeners, Models, Providers, Traits, View; `Support` assente, riverificato 2026-10-23). Il modulo non ha un layer Services (regola no-services). Fonte corretta: [README.md](./README.md) e [wiki/concepts/queueable-action-execute-entrypoint.md](./wiki/concepts/queueable-action-execute-entrypoint.md). Contenuto non riscritto, verificare prima di usarlo.

# Architecture Documentation
## Activity Module Architecture

### System Overview

The Activity module provides a comprehensive activity logging and event sourcing system for the Laraxot ecosystem. This document describes the module's architecture, components, and design patterns.

### Core Components

Vedi [wiki/concepts/queueable-action-execute-entrypoint.md](wiki/concepts/queueable-action-execute-entrypoint.md) per la mappa Actions attuale (no Services layer).

```
Activity Module Architecture
┌─────────────────────────────────────────────────────────────┐
│                     Activity Module                          │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │
│  │   Models     │  │ Repositories │  │  Services    │       │
│  │              │  │              │  │              │       │
│  │ ActivityLog  │  │ Act

## Activity — architettura BMAD

_Fonte: `bmad/architecture.md`_

# Activity — architettura BMAD

> **SUMMARY**: mappa reale del modulo `Modules/Activity` (alias `activity`): due
> sottosistemi distinti — audit delle azioni utente su Spatie Activity + event
> sourcing, e un visualizzatore dei log di file Laravel — con tre Resource
> Filament, 30 Action e 8 DTO (misura 2026-11-19; 7 DTO del log viewer + `ActivityConfigData`).

## Identita del modulo

Da `module.json`: alias `activity`, `requires: ["Xot", "User"]`, `order: 5`,
priority 0, `minimumCoreVersion 10.0`, `phpVersion ^8.1`. Da `config/config.php`:
rotte abilitate con middleware `web, auth`, navigation `sort: 20`.

## Modelli (`app/Models`)

| Classe | Base | Ruolo |
|---|---|---|
| `Activity` | `Spatie\Activitylog\Models\Activity` (`SpatieActivity`) | una riga di audit per azione su modello; `properties` castata a `SchemalessAttributes` |
| `StoredEvent` | `Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent` | evento persistito per replay; `meta_data` schemaless |
| `Snapshot` | `Spatie\EventSourcing\Snapshots\EloquentSnapshot` | snapshot Eloquent per proiezioni |
| `BaseModel` | — | base interna del modulo |
| `TestModel` | — | appoggio ai test (tabella `test_models`, migrazione 2026_03_05) |

Tutti i modelli di dominio usano `Modules\Xot\Models\Traits\HasXotFactory` e una
factory in `database/factories/` (`ActivityFactory`, `SnapshotFactory`,
`StoredEventFactory`). `app/Models/Contracts/ActivityRecorderContract.php`
e il **contratto pubblico** del modulo.

## Contratti e

## Architettura di Larabank con Event Sourcing

_Fonte: `use_cases/bank/architecture.md`_

# Architettura di Larabank con Event Sourcing

## Introduzione

Larabank è un'applicazione di esempio creata da Spatie per illustrare l'uso dell'Event Sourcing in Laravel attraverso aggregate e proiettori. Questa documentazione analizza l'architettura di Larabank per adattarla come caso d'uso nel modulo `Activity`.

## Componenti Principali

### 1. Radice Aggregate: AccountAggregateRoot

La radice aggregate incapsula la logica di business per un conto bancario. Garantisce che le operazioni rispettino le regole definite, come il limite di saldo di -5000.

- **Responsabilità**:
  - Gestione delle transazioni (depositi e prelievi).
  - Verifica dei limiti di saldo.
  - Registrazione degli eventi rilevanti.
- **Eventi Gestiti**:
  - `AccountCreated`
  - `MoneyDeposited`
  - `MoneyWithdrawn`
  - `LimitHit`
  - `LoanProposalSent`

### 2. Eventi

Gli eventi rappresentano azioni significative nel sistema bancario. Ogni evento è immutabile e cattura un cambiamento di stato.

- **AccountCreated**: Registra la creazione di un nuovo conto con un saldo iniziale.
- **MoneyDeposited**: Registra un deposito sul conto.

## 🏗️ Architettura del Modulo <nome progetto>ion Market

_Fonte: `use_cases/prediction_market/architecture.md`_

# 🏗️ Architettura del Modulo <nome progetto>ion Market

## 🌟 Panoramica dell'Architettura

L'architettura del modulo <nome progetto>ion Market è progettata seguendo i principi del **Domain-Driven Design (DDD)** e dell'**Event Sourcing**, garantendo scalabilità, manutenibilità e tracciabilità completa di tutte le operazioni.

## 🧱 Componenti Fondamentali

### 1. Dominio (Domain Layer)

#### Aggregate Roots

##### Market Aggregate
- **Responsabilità**:
  - Gestione del ciclo di vita del mercato (creazione, aggiornamento, chiusura)
  - Validazione delle operazioni in base allo stato corrente
  - Emissione di eventi di dominio
- **Regole di Business**:
  - Un mercato può accettare scommesse solo se nello stato `OPEN`
  - Le quote vengono ricalcolate ad ogni scommessa secondo la regola LMSR (Logarithmic Market Scoring Rule) per garantire prezzi dinamici e liquidità automatica
  - La risoluzione è consentita solo dopo la data di chiusura

##### UserBettingProfile Aggregate
- **Responsabilità**:
  - Gestione del saldo utente
  - Tracciamento delle scommesse attive
  - Validazione della capacità di scommessa

#### Value Objects
