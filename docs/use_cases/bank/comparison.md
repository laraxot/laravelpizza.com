# Confronto tra le Implementazioni di Larabank

## Introduzione

Spatie ha creato diverse varianti di Larabank per dimostrare approcci differenti alla costruzione di un'applicazione bancaria. Questo documento confronta queste varianti per evidenziarne i punti di forza, le debolezze e la loro rilevanza per il modulo `Activity`.

## Varianti di Larabank

### 1. Larabank Traditional ([GitHub](https://github.com/spatie/larabank-traditional))

- **Approccio**: Implementazione tradizionale senza Event Sourcing.
- **Caratteristiche**:
  - Utilizza modelli Eloquent standard e transazioni di database.
  - La logica di business è incorporata nei controller o nei modelli.
  - Non c'è separazione tra logica di comando e query.
- **Vantaggi**:
  - Semplicità per sviluppatori abituati al flusso di lavoro Laravel standard.
  - Minore complessità iniziale e curva di apprendimento.
- **Svantaggi**:
  - Difficoltà nel tracciare la storia delle modifiche allo stato.
  - La logica di business può diventare disordinata e difficile da mantenere.
- **Rilevanza per Activity**: Utile come baseline per confrontare i benefici dell'Event Sourcing, ma non ideale per applicazioni che richiedono tracciabilità completa.

### 2. Larabank Aggregates ([GitHub](https://github.com/spatie/larabank-aggregates))

- **Approccio**: Event Sourcing con aggregate.
- **Caratteristiche**:
  - La radice aggregate incapsula la logica di business e gestisce lo stato tramite eventi.
  - Regole come il limite di saldo (-5000) sono applicate nell'aggregate.
- **Vantaggi**:
  - Tracciabilità completa di ogni cambiamento di stato.
  - Separazione chiara della logica di business.
- **Svantaggi**:
  - Complessità maggiore rispetto all'approccio tradizionale.
  - Necessità di rigiocare eventi per ricostruire lo stato, che può influire sulle performance.
- **Rilevanza per Activity**: Ideale per tracciare attività finanziarie o budget con regole di business complesse.

### 3. Larabank Projectors ([GitHub](https://github.com/spatie/larabank-projectors))

- **Approccio**: Event Sourcing con focus sui proiettori.
- **Caratteristiche**:
  - I proiettori creano viste di lettura ottimizzate per query (es. saldo corrente).
  - Separazione tra logica di comando (aggregate) e query (proiettori).
- **Vantaggi**:
  - Performance migliorate per operazioni di lettura.
  - Flessibilità nel creare viste multiple dello stesso dato.
- **Svantaggi**:
  - Complessità aggiuntiva nel gestire la coerenza tra aggregate e proiettori.
  - Possibili discrepanze se i proiettori non sono idempotenti.
- **Rilevanza per Activity**: Utile per creare report e dashboard finanziari nel modulo.

### 4. Larabank EventSauce ([GitHub](https://github.com/spatie/larabank-eventsauce))

- **Approccio**: Event Sourcing utilizzando la libreria EventSauce.
- **Caratteristiche**:
  - Implementa Event Sourcing con un framework alternativo a quello di Spatie.
  - Simile a Larabank Aggregates ma con strumenti diversi.
- **Vantaggi**:
  - Mostra la flessibilità di Event Sourcing con librerie diverse.
  - Potenzialmente più adatto a progetti che preferiscono EventSauce.
- **Svantaggi**:
  - Dipendenza da una libreria esterna con una comunità diversa.
  - Curva di apprendimento per chi è abituato al pacchetto di Spatie.
- **Rilevanza per Activity**: Interessante per valutare alternative, ma probabilmente non necessario se già usiamo il pacchetto di Spatie.

## Confronto Diretto

| Variante            | Event Sourcing | Separazione Comando/Query | Tracciabilità | Complessità | Performance Lettura |
|---------------------|----------------|---------------------------|---------------|-------------|---------------------|
| Traditional         | No             | No                        | Bassa         | Bassa       | Media              |
| Aggregates          | Sì            | Parziale                  | Alta          | Media       | Bassa/Media        |
| Projectors          | Sì            | Sì                        | Alta          | Alta        | Alta               |
| EventSauce          | Sì            | Parziale                  | Alta          | Media/Alta  | Bassa/Media        |

## Considerazioni per il Modulo Activity

- **Tracciabilità**: Event Sourcing (Aggregates, Projectors, EventSauce) è preferibile per garantire un audit trail completo, utile per dati finanziari o budget nel settore sanitario.
- **Performance**: Larabank Projectors offre il miglior compromesso per applicazioni che richiedono report frequenti e dashboard.
- **Semplicità**: Larabank Traditional potrebbe essere considerato per prototipi rapidi, ma perde i vantaggi di tracciabilità.
- **Flessibilità**: EventSauce dimostra che possiamo scegliere tra diverse librerie di Event Sourcing, ma Aggregates e Projectors sono più integrati con l'ecosistema Laravel di Spatie.

## Conclusione

Per il modulo `Activity`, l'approccio basato su **Larabank Aggregates** e **Larabank Projectors** è il più adatto. Offre tracciabilità, separazione delle responsabilità e performance ottimizzate per query, che sono cruciali per gestire budget, spese o transazioni finanziarie. Larabank Traditional può essere utile come riferimento per comprendere i limiti degli approcci non-Event Sourcing, mentre EventSauce è un'opzione alternativa per progetti che preferiscono quella libreria.
