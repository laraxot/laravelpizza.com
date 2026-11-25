---
title: "Topic event-sourcing"
type: digest
status: active
qmd: "digest ceiling 100 event-sourcing"
---

# Topic event-sourcing

Sintesi automatica di 10 documenti (chiave `event-sourcing`).

## Event Sourcing in Laravel

_Fonte: `event-sourcing-duplicate.md`_

# Event Sourcing in Laravel

Questo documento fornisce una guida completa sull'implementazione dell'**Event Sourcing** in Laravel, basata sul libro *Event Sourcing in Laravel* di Brent Roose, pubblicato da Spatie nel 2021. Include concetti fondamentali, pattern avanzati, sfide, casi d'uso pratici e consigli per migliorare il codice esistente nel contesto del modulo `Activity`.

## Introduzione all'Event Sourcing

L'Event Sourcing è un approccio architetturale in cui ogni cambiamento allo stato di un'applicazione viene catturato in un oggetto evento. Questi eventi sono memorizzati in sequenza, rappresentando la storia completa delle modifiche, a differenza dell'approccio CRUD tradizionale dove solo lo stato finale viene salvato.

### Vantaggi
- **Tracciabilità Completa**: Ogni azione è registrata come evento, fornendo un audit trail dettagliato.
- **Flessibilità**: Nuove funzionalità possono essere aggiunte rigiocando eventi su nuovi proiettori senza modificare i dati esistenti.
- **Ricostruzione dello Stato**: Gli eventi permettono di ricostruire stati passati per debugging o analisi.

### Sfide
- **Complessità**: La gestione di eventi e proiezioni è più complessa rispetto a CRUD.
- **Performance**: Rigiocare molti eventi può essere lento, richiedendo snapshot.
- **Versionamento**: Gli eventi devono essere versionati per gestire cambiamenti nella struttura dei dati.

## Concetti Fondamentali

### 1. Design Orientato agli Eventi
Il design orientato agli eventi si concentra sul

## Practical Event Sourcing Examples for Healthcare

_Fonte: `event-sourcing-examples-duplicate.md`_

# Practical Event Sourcing Examples for Healthcare

## Table of Contents
- [Patient Management](#patient-management)
- [Appointment Scheduling](#appointment-scheduling)
- [Medical Records](#medical-records)
- [Billing and Insurance](#billing-and-insurance)
- [Pharmacy and Prescriptions](#pharmacy-and-prescriptions)
- [Integration Patterns](#integration-patterns)
- [Testing Strategies](#testing-strategies)

## Patient Management

### 1. Patient Registration

**Event**: `PatientRegistered`
```php
class PatientRegistered implements ShouldBeStored
{
    public function __construct(
        public string $patientId,
        public string $firstName,
        public string $lastName,
        public string $email,
        public DateTimeImmutable $registeredAt
    ) {}
}

// Usage in Aggregate
public function registerPatient(

## Table of Contents

_Fonte: `event-sourcing-examples.md`_

## Table of Contents
- [Patient Management](#patient-management)
- [Appointment Scheduling](#appointment-scheduling)
- [Medical Records](#medical-records)
- [Billing and Insurance](#billing-and-insurance)
- [Pharmacy and Prescriptions](#pharmacy-and-prescriptions)
- [Integration Patterns](#integration-patterns)
- [Testing Strategies](#testing-strategies)

## Patient Management

### 1. Patient Registration

**Event**: `PatientRegistered`
```php
class PatientRegistered implements ShouldBeStored
{
    public function __construct(
        public string $patientId,
        public string $firstName,
        public string $lastName,
        public string $email,
        public DateTimeImmutable $registeredAt
    ) {}
}

// Usage in Aggregate
public function registerPatient(
    string $patientId,

## Event Sourcing in `<nome progetto>`

_Fonte: `event-sourcing-introduction-duplicate.md`_

# Event Sourcing in `<nome progetto>`

## Introduction to Event Sourcing
Event Sourcing is an architectural pattern where application state is derived from a sequence of events. Instead of storing the current state in a database, the application stores all events that led to the current state. This approach is particularly beneficial in a healthcare context like `<nome progetto>` for tracking patient activities, medical records, and system interactions with full auditability.
# Event Sourcing in `<nome progetto>`

## Introduction to Event Sourcing
Event Sourcing is an architectural pattern where application state is derived from a sequence of events. Instead of storing the current state in a database, the application stores all events that led to the current state. This approach is particularly beneficial in a healthcare context like `<nome progetto>` for tracking patient activities, medical records, and system interactions with full auditability.

### Key Concepts
- **Events**: Discrete actions or changes in the system (e.g., `PatientRegistered`, `AppointmentScheduled`).
- **Event Store**: A database or log where all events are stored in sequence.
- **Aggregates**: Domain objects that handle commands and produce events (e.g., a `Patient` aggregate).
- **Projectors**: Components that listen to events and build read models or projections for querying.
- **Reactors**: Components that react to events to trigger side effects (e.g., sending notifications).

### Benefits for Health

## Event Sourcing in `saluteora`

_Fonte: `event-sourcing-introduction.md`_

# Event Sourcing in `saluteora`

## Introduction to Event Sourcing
Event Sourcing is an architectural pattern where application state is derived from a sequence of events. Instead of storing the current state in a database, the application stores all events that led to the current state. This approach is particularly beneficial in a healthcare context like `saluteora` for tracking patient activities, medical records, and system interactions with full auditability.

### Key Concepts
- **Events**: Discrete actions or changes in the system (e.g., `PatientRegistered`, `AppointmentScheduled`).
- **Event Store**: A database or log where all events are stored in sequence.
- **Aggregates**: Domain objects that handle commands and produce events (e.g., a `Patient` aggregate).
- **Projectors**: Components that listen to events and build read models or projections for querying.
- **Reactors**: Components that react to events to trigger side effects (e.g., sending notifications).

### Benefits for Healthcare Applications
- **Audit Trail**: Every action is recorded, crucial for compliance with healthcare regulations.
- **Reconstruction**: Ability to reconstruct past states for debugging or analysis.
- **Flexibility**: Easy to extend with new features by adding new event types and projectors.
- **Accuracy**: Ensures data integrity by replaying events to validate current state.

## Spatie Laravel Event Sourcing
The `spatie/laravel-event-sourcing` package provides a robust implementation of 

## event-sourcing

_Fonte: `event-sourcing.md`_

See canonical documentation: ../../../Themes/docs/shared-components/event-sourcing-duplicate.md

## event sourcing comprehensive guide

_Fonte: `guides/archive/event-sourcing.md`_

# event sourcing comprehensive guide

## introduction to event sourcing

event sourcing is an architectural approach where every change to application state is captured in an event object. these events are stored in sequence, representing the complete history of changes, unlike the traditional crud approach where only the final state is saved.

### advantages
- **complete traceability**: every action is recorded as an event, providing detailed audit trail
- **flexibility**: new features can be added by replaying events on new projectors without modifying existing data
- **state reconstruction**: events allow reconstructing past states for debugging or analysis

### challenges
- **complexity**: managing events and projections is more complex than crud
- **performance**: replaying many events can be slow, requiring snapshots
- **versioning**: events must be versioned to handle changes in data structure

## fundamental concepts

### 1. event-oriented design
event-oriented design focuses on modeling around events rather than final state. for example, instead of updating a "balance" field, events like `deposit_made` or `withdrawal_made` are recorded.

### 2. events
events represent something that happened in the system (e.g., `activity_logged`, `user_registered`). they must be specific and contain relevant data.

### 3. aggregate roots
aggregate roots encapsulate business logic for a specific entity, ensuring state consistency. for example, an `activity_aggregate_root` could handl

## introduction to event sourcing

_Fonte: `guides/event-sourcing.md`_

See canonical documentation: ../../../../Themes/docs/shared-components/event-sourcing.mdtopic: event-sourcing
canonical: ../../../../Themes/docs/shared-components/event-sourcing.md
---

See canonical documentation: ../../../../Themes/docs/shared-components/event-sourcing.md
topic: event-sourcing
canonical: ../../../../Themes/docs/shared-components/event-sourcing.md
---

## introduction to event sourcing

event sourcing is an architectural approach where every change to application state is captured in an event object. these events are stored in sequence, representing the complete history of changes, unlike the traditional crud approach where only the final state is saved.

### advantages
- **complete traceability**: every action is recorded as an event, providing detailed audit trail
- **flexibility**: new features can be added by replaying events on new projectors without modifying existing data
- **state reconstruction**: events allow reconstructing past states for debugging or analysis

### challenges
- **complexity**: managing events and projections is more complex than crud
- **performance**: replaying many events can be slow, requiring snapshots
- **versioning**: events must be versioned to handle changes in data structure

## fundamental concepts

### 1. event-oriented design
event-oriented design focuses on modeling around events rather than final state. for example, instead of updating a "balance" field, events like `deposit_made` or `withdrawal_made` are recorded.



## Event Sourcing con Laravel: Analisi del Repository di cnastasi

_Fonte: `use_cases/shop/event-sourcing-cnastasi.md`_

# Event Sourcing con Laravel: Analisi del Repository di cnastasi

## Introduzione

Questo documento analizza il repository [https://github.com/cnastasi/event-sourcing-with-laravel](https://github.com/cnastasi/event-sourcing-with-laravel) creato da cnastasi, che presenta una demo live sull'implementazione di Event Sourcing con Laravel, come illustrato nel talk al Laravel Day 2023. L'obiettivo è integrare le lezioni apprese da questo repository nella nostra documentazione per il caso d'uso `Shop` nel modulo `Activity`, arricchendo la nostra comprensione dell'Event Sourcing applicato a un sistema di gestione del magazzino e degli ordini.

## Panoramica del Repository

Il repository `event-sourcing-with-laravel` offre un esempio pratico di come implementare Event Sourcing in un'applicazione Laravel per gestire un magazzino di prodotti e gli ordini. Si concentra su un approccio minimalista e didattico, mostrando come tracciare eventi per operazioni come la registrazione di prodotti, l'acquisto e il rifornimento del magazzino.

### Struttura del Progetto

Il repository segue la struttura standard di un progetto Laravel, con directory chiave come:
- `app`: Contiene la logica di business, probabilmente con aggregate, eventi e proiettori.
- `database`: Per le migrazioni che configurano le tabelle degli eventi.
- `routes`: Per eventuali endpoint API o web.

Questa struttura è simile a quella vista nei progetti Spatie (`laravel-shop-main` e `laravel-shop-command-bus`), ma è più semplifi

## Advanced Event Sourcing Patterns for Healthcare Applications

_Fonte: `wiki/concepts/event-sourcing-patterns.md`_

# Advanced Event Sourcing Patterns for Healthcare Applications

## Table of Contents
- [Introduction](#introduction)
- [Core Concepts](#core-concepts)
- [Implementation in Healthcare](#implementation-in-healthcare)
- [Practical Examples](#practical-examples)
- [Performance Considerations](#performance-considerations)
- [Best Practices](#best-practices)
- [Real-world Use Cases](#real-world-use-cases)

## Introduction

Event Sourcing is particularly valuable in healthcare applications like `saluteora` where data integrity, audit trails, and historical tracking are crucial. This document expands on the basic concepts with advanced patterns and practical implementations.
Event Sourcing is particularly valuable in healthcare applications like `<nome progetto>` where data integrity, audit trails, and historical tracking are crucial. This document expands on the basic concepts with advanced patterns and practical implementations.
Event Sourcing is particularly valuable in healthcare applications like `<nome progetto>` where data integrity, audit trails, and historical tracking are crucial. This document expands on the basic concepts with advanced patterns and practical implementations.
Event Sourcing is particularly valuable in healthcare applications like `saluteora` where data integrity, audit trails, and historical tracking are crucial. This document expands on the basic concepts with advanced patterns and practical implementations.
Event Sourcing is particularly valuable in heal
