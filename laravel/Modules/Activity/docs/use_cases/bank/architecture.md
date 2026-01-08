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
- **MoneyWithdrawn**: Registra un prelievo dal conto.
- **LimitHit**: Registra quando il saldo raggiunge il limite di -5000.
- **LoanProposalSent**: Registra l'invio di una proposta di prestito dopo tre tentativi consecutivi di superare il limite.

### 3. Proiettori

I proiettori costruiscono viste di lettura ottimizzate per le query, basate sugli eventi registrati.

- **AccountBalanceProjector**: Aggiorna il saldo corrente di ogni conto.
- **LimitHitProjector**: Conta quante volte un conto ha raggiunto il limite, triggerando una proposta di prestito se necessario.
- **TransactionHistoryProjector**: Registra la cronologia delle transazioni per report dettagliati.

### 4. Modelli di Lettura

I modelli di lettura sono tabelle o collezioni costruite dai proiettori per query efficienti.

- **AccountBalance**: Contiene il saldo attuale di ogni conto.
- **LimitHitCount**: Tiene traccia del numero di volte che il limite è stato raggiunto.
- **TransactionHistory**: Memorizza lo storico di tutte le transazioni.

## Flusso dei Dati

1. **Comando**: Un comando (es. `DepositMoney`, `WithdrawMoney`) viene inviato alla radice aggregate.
2. **Validazione**: La radice aggregate valida il comando in base allo stato corrente (es. verifica se un prelievo porterebbe il saldo sotto il limite).
3. **Evento**: Se valido, un evento viene generato e registrato nel flusso di eventi.
4. **Applicazione**: L'evento viene applicato alla radice aggregate per aggiornare lo stato.
5. **Proiezione**: I proiettori ascoltano l'evento e aggiornano i modelli di lettura.
6. **Query**: Le interfacce utente o API interrogano i modelli di lettura per mostrare dati aggiornati.

## Schema Architetturale

```
[Comando] --> [Radice Aggregate] --> [Eventi] --> [Flusso Eventi]
                                                  |
                                           [Proiettori]
                                                  |
                                        [Modelli di Lettura] --> [UI/API]
```

## Considerazioni Tecniche

- **Persistenza Eventi**: Gli eventi sono salvati in un database con metadati (UUID, tipo evento, dati, timestamp).
- **Rigiocata Eventi**: Gli eventi possono essere rigiocati per ricostruire lo stato o creare nuovi modelli di lettura.
- **Snapshot**: Per conti con molte transazioni, salvare snapshot periodici dello stato della radice aggregate per ridurre il numero di eventi da rigiocare.
- **Scalabilità**: Utilizzare code (es. Laravel Queue) per processare eventi e proiezioni in background.

## Adattamento al Modulo Activity

L'architettura di Larabank può essere adattata per gestire attività finanziarie nel contesto sanitario, come la gestione di budget per campagne o pagamenti per servizi. La radice aggregate potrebbe rappresentare un'entità finanziaria (es. un budget di progetto), mentre i proiettori creano report per amministratori o stakeholder.

## Conclusione

L'architettura di Larabank separa chiaramente le responsabilità tra logica di business (radice aggregate), registrazione storica (eventi) e query ottimizzate (proiettori e modelli di lettura). Questo approccio garantisce tracciabilità e flessibilità, rendendo il sistema bancario scalabile e adattabile a contesti come il nostro modulo `Activity`.
