# Use Case Prediction Market – Event Sourcing e Console Commands

## Introduzione
Questo modulo implementa un prediction market tramite event sourcing, aggregate root e proiezioni, ispirandosi alle best practice di progetti open source come [event-sourcing-with-laravel](https://github.com/cnastasi/event-sourcing-with-laravel).

## Obiettivi
- Tracciabilità completa delle modifiche a mercati, scommesse e payout
- Separazione della logica di business tramite eventi e aggregate
- Audit trail e rollback garantiti
- Performance e scalabilità tramite proiezioni ottimizzate

## Console Commands Principali
- `activity:market:create {title} {description} {endDate}` – Crea un nuovo mercato
- `activity:market:place-bet {marketUuid} {userId} {prediction} {amount}` – Piazza una scommessa
- `activity:market:resolve {marketUuid} {outcome}` – Risolve un mercato
- Altri: gestione payout, reportistica, audit (vedi esempi nei file dedicati)

## Esempi di Utilizzo
```bash
php artisan activity:market:create "Elezioni 2024" "Prevedi il vincitore" "2024-11-30"
php artisan activity:market:place-bet market_xxx 12345 "Candidato A" 100
php artisan activity:market:resolve market_xxx "Candidato A"

# 🎯 Prediction Market Module

## 📚 Introduzione
Il modulo Prediction Market implementa un sistema completo di mercati predittivi utilizzando l'Event Sourcing in Laravel. Permette agli utenti di scommettere sull'esito di eventi futuri, con funzionalità avanzate di gestione dei mercati, calcolo delle quote e distribuzione dei pagamenti.

## 🎯 Funzionalità Principali

### 🏷️ Gestione Mercati
- Creazione e configurazione di mercati predittivi
- Definizione di esiti multipli per ogni mercato
- Scadenze temporali per la chiusura delle scommesse
- Risoluzione manuale o automatica dei mercati

### 💰 Sistema di Scommesse
- Piazzamento di scommesse con importi variabili
- Calcolo in tempo reale delle quote
- Gestione del saldo utente
- Storico delle scommesse con filtri avanzati

### 📊 Analisi e Report
- Dashboard con statistiche in tempo reale
- Report dettagliati su mercati e scommesse
- Esportazione dati in formati standard (CSV, Excel)
- Audit trail completo di tutte le operazioni

## 🏗️ Architettura

### Pattern Principali
- **Event Sourcing**: Tracciamento di ogni modifica di stato tramite eventi
- **CQRS**: Separazione tra comandi (write) e query (read)
- **Domain-Driven Design**: Modellazione del dominio con aggregati e value objects
- **Hexagonal Architecture**: Separazione tra dominio e infrastruttura

### Componenti Chiave

#### Aggregate Roots
- `Market`: Gestisce il ciclo di vita di un mercato
- `UserBettingProfile`: Gestisce il portafoglio e le scommesse di un utente
- `MarketResolution`: Gestisce la risoluzione e il payout dei mercati

#### Eventi di Dominio
- `MarketCreated`: Creazione di un nuovo mercato
- `BetPlaced`: Scommessa piazzata da un utente
- `MarketResolved`: Risoluzione di un mercato con esito
- `PayoutDistributed`: Distribuzione dei pagamenti ai vincitori

#### Proiezioni
- `MarketStatus`: Stato corrente dei mercati
- `UserBalance`: Saldo e storico transazioni utente
- `MarketOdds`: Quote aggiornate in tempo reale
- `BetHistory`: Storico delle scommesse con filtri

## 🚀 Primi Passi

### Requisiti
- PHP 8.2+
- Laravel 10.x
- MySQL 8.0+ o PostgreSQL 13+
- Redis (per le code e le notifiche in tempo reale)

### Installazione
1. Aggiungi il modulo al tuo progetto
2. Esegui le migrazioni
3. Configura i provider di servizio
4. Configura le code e i worker

### Comandi Console
```bash

# Gestione Mercati
php artisan market:create "Titolo Mercato" "Descrizione" "2023-12-31 23:59:59"
php artisan market:resolve {marketId} {outcomeId}

# Gestione Scommesse
php artisan bet:place {marketId} {userId} {outcomeId} {amount}
php artisan bet:cancel {betId}

# Report e Manutenzione
php artisan market:report --status=open
php artisan user:balance {userId}
```

## 📚 Documentazione Avanzata

- [Architettura](./architecture.md) - Panoramica dettagliata dell'architettura
- [Guida allo Sviluppo](./development.md) - Come estendere il modulo
- [API Reference](./api.md) - Documentazione delle API REST
- [Sicurezza](./security.md) - Linee guida sulla sicurezza
- [Performance](./performance.md) - Ottimizzazioni e best practice

## 🤝 Contributi

I contributi sono ben accetti! Si prega di leggere le nostre [linee guida per i contributi](./contributing.md) prima di inviare pull request.

## 📄 Licenza

Questo modulo è open-source con licenza [MIT](LICENSE).

## Panoramica

Un prediction market è un mercato finanziario in cui i partecipanti possono negoziare contratti il cui valore è legato al verificarsi di eventi futuri. Questi mercati sono utilizzati per raccogliere informazioni e fare previsioni su una vasta gamma di eventi, da quelli economici e politici a quelli sportivi e tecnologici.

## Casi d'Uso Principali

### 1. Previsioni di Mercato
- **Descrizione**: Permettere agli utenti di investire sul risultato di eventi futuri.
- **Esempio**: Scommettere sull'esito di elezioni politiche o sul prezzo futuro di una criptovaluta.
- **Vantaggi**:
  - Fornisce una visione aggregata delle aspettative del mercato.
  - Incentiva la ricerca e l'analisi approfondita.

### 2. Gestione del Rischio
- **Descrizione**: Consentire alle aziende di coprirsi da rischi specifici.
- **Esempio**: Un'azienda agricola potrebbe coprirsi dal rischio di siccità.
- **Vantaggi**:
  - Riduce l'incertezza finanziaria.
  - Permette una migliore pianificazione aziendale.

### 3. Ricerca di Mercato
- **Descrizione**: Utilizzare i prezzi di mercato come indicatori predittivi.
- **Esempio**: Valutare il potenziale successo di un nuovo prodotto.
- **Vantaggi**:
  - Dati in tempo reale sulle aspettative del mercato.
  - Maggiore accuratezza rispetto ai tradizionali sondaggi.

## Implementazione in Laravel

### 1. Modello dei Dati
```php
// Esempio di modello per un contratto di previsione
class PredictionContract extends Model
{
    protected $fillable = [
        'title',
        'description',
        'resolution_date',
        'resolved',
        'outcome',
    ];

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }
}
```

## Aggregate Root e Eventi
- **MarketAggregate**: gestisce creazione mercati, scommesse, risoluzioni
- **Eventi**: `MarketCreated`, `BetPlaced`, `MarketResolved`, `PayoutProcessed`, `UserBalanceUpdated`

## Proiezioni
- **MarketSummaryProjection**: stato attuale dei mercati
- **UserBetHistoryProjection**: storico scommesse per utente
- **MarketOutcomeProjection**: risultati mercati risolti

## Flusso Operativo
1. Comando CLI → 2. Aggregate → 3. Evento → 4. Proiettore → 5. Modello di lettura → 6. UI/API

## Best Practice
- Eventi immutabili e atomici
- Aggregate root come unico punto di logica di dominio
- Proiezioni solo per lettura, aggiornate da projectors
- Separazione tra comandi (write) e query (read)
- Reactors per effetti collaterali (notifiche, payout)
- DTO per passaggio dati tra livelli
- Test end-to-end tramite replay eventi

## Checklist di Implementazione
- [ ] Definire eventi e aggregate principali
- [ ] Implementare proiezioni e projectors
- [ ] Scrivere test per ogni comando/evento/proiezione
- [ ] Documentare i flussi principali e i comandi
- [ ] Prevedere rollback e replay

## FAQ
- Come aggiungere un nuovo comando?
- Come testare un aggregate?
- Come gestire rollback e replay eventi?
- Come integrare nuovi payout o oracoli?
- Come estendere le proiezioni?

## Collegamenti correlati
- [Console Commands Prediction Market](./console_commands.md)
- [Best Practice Prediction Market](./best_practices.md)
- [Architettura Prediction Market](./architecture.md)
- [Eventi Prediction Market](./events.md)
- [Implementazione Prediction Market](./implementation.md)
- [Test Prediction Market](./07_test.md)
- [Glossario Prediction Market](./08_glossario.md)
- [Confronto Approcci](../shop/07_confronto_approcci.md)
- [Build from Scratch](../shop/build_from_scratch.md)
- [README Shop](../shop/readme.md)
- [README Bank](../bank/readme.md)

---
**Questa documentazione è neutra e riutilizzabile, senza riferimenti a progetti specifici, e segue le regole di neutralità e modularità.**
