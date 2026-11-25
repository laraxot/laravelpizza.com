---
title: "Topic implementation"
type: digest
status: active
qmd: "digest ceiling 100 implementation"
---

# Topic implementation

Sintesi automatica di 3 documenti (chiave `implementation`).

## Implementazione di un Sistema Bancario con Event Sourcing

_Fonte: `use_cases/bank/implementation.md`_

# Implementazione di un Sistema Bancario con Event Sourcing

## Introduzione

Questo documento fornisce una guida pratica per implementare un sistema bancario ispirato a Larabank nel modulo `Activity`, utilizzando l'Event Sourcing. L'obiettivo è tracciare operazioni finanziarie o di budget con tracciabilità completa e regole di business automatizzate.

## Prerequisiti

- Laravel 11.x o 12.x
- Pacchetto `spatie/laravel-event-sourcing` per gestire aggregate, eventi e proiettori.
- Conoscenza di base di Event Sourcing e CQRS.

## Passo 1: Configurazione dell'Ambiente

Seguendo le istruzioni di Larabank, configuriamo l'ambiente di sviluppo:

1. Clona il repository o crea una nuova struttura di progetto.
2. Copia `.env.example` in `.env` e imposta le variabili di ambiente relative al database (`DB_*`).
3. Crea un database con il nome specificato in `DB_DATABASE`.
4. Esegui `composer install` per installare le dipendenze.
5. Esegui `yarn` e `yarn run dev` (o equivalenti npm) per compilare gli asset frontend.
6. Esegui `php artisan migrate:fresh --seed` per migrare e popolare il database.
7. Puoi ora accedere con l'utente di esempio (es. `user@larabank.com`, password `secret`).

## Passo 2: Definizione degli Eventi

Definisci gli eventi che rappresentano le azioni nel sistema bancario:

- `AccountOpened`: Per la creazione di un nuovo conto.

## Implementazione del <nome progetto>ion Market

_Fonte: `use_cases/prediction_market/implementation.md`_

# Implementazione del <nome progetto>ion Market

Questa guida fornisce i passaggi per implementare un <nome progetto>ion market nel modulo `Activity` utilizzando l'Event Sourcing.

## Passaggi Principali

1. **Definizione dei Modelli e delle Tabelle di Proiezione**
   - Creare modelli per le proiezioni come `MarketSummary`, `UserBet` e `PayoutReport`.
   - Definire migration per le tabelle corrispondenti (`market_summaries`, `user_bets`, `payout_reports`).

2. **Creazione degli Eventi**
   - Definire classi per ogni evento (`MarketCreated`, `BetPlaced`, `MarketUpdated`, `MarketResolved`, `PayoutDistributed`).
   - Assicurarsi che ogni evento contenga i dati necessari per aggiornare lo stato.

3. **Implementazione della Radice Aggregate**
   - Creare `<nome progetto>ionMarketAggregateRoot` per gestire la logica di business.
   - Garantire che la radice aggregate impedisca operazioni non valide (es. scommesse su mercati chiusi).

4. **Sviluppo dei Proiettori**
   - Implementare proiettori per aggiornare le viste di lettura (`MarketSummaryProjector`, `UserBetProjector`, `PayoutReportProjector`).
   - Testare i proiettori per garantire che gestiscano correttamente gli eventi.

5. **Integrazione con l'Interfaccia Utente**
   - Creare controller per gestire le richieste degli utenti (es. creazione mercato, piazzamento scommesse).
   - Utilizzare la radice aggregate per registrare eventi in risposta alle azioni degli utenti.
   - Mostrare dati in tempo reale utilizzando le proiezion

## Implementazione di un Carrello della Spesa

_Fonte: `use_cases/shop/implementation.md`_

# Implementazione di un Carrello della Spesa

## Introduzione

Questa guida fornisce i passaggi per implementare un carrello della spesa basato su Event Sourcing, ispirandosi ai progetti di Spatie. L'obiettivo è creare un sistema tracciabile e scalabile per gestire ordini nel modulo `Activity`.

## Passaggi per l'Implementazione

### 1. Configurazione dell'Ambiente

- Installa il pacchetto `spatie/laravel-event-sourcing` nel tuo progetto Laravel.
- Configura il database per salvare gli eventi.

```bash
composer require spatie/laravel-event-sourcing
php artisan vendor:publish --provider="Spatie\EventSourcing\EventSourcingServiceProvider" --tag="migrations"
php artisan migrate
```

### 2. Definizione degli Eventi

Crea classi per ogni evento rilevante, come `CartItemAdded`, `CartItemRemoved`, `CartCheckedOut`. Questi eventi devono implementare `ShouldBeStored`.

```php
namespace App\Domain\Cart\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CartItemAdded extends ShouldBeStored
