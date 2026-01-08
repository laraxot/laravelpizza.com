# Confronto tra Approcci: Traditional, Projectors, Aggregates, Eventsauce

## 1. Larabank-Traditional
- **Architettura**: CRUD classico, stato salvato direttamente nel database, ogni update sovrascrive il valore precedente.
- **Vantaggi**: Semplicità, immediatezza, adatto a casi d'uso semplici.
- **Svantaggi**: Nessuna tracciabilità storica, difficile audit, nessuna possibilità di ricostruire lo stato passato.
- **Pattern**: Eloquent Model, Controller, DB.
- **Quando usarlo**: Applicazioni semplici senza requisiti di audit o reporting avanzato.

## 2. Larabank-Projectors
- **Architettura**: Event sourcing parziale. Gli eventi vengono registrati e proiettati su tabelle di lettura tramite projectors.
- **Vantaggi**: Tracciabilità degli eventi, possibilità di creare nuove proiezioni anche a posteriori, reporting avanzato.
- **Svantaggi**: La logica di business resta fuori dagli aggregate, rischio di duplicazione logica.
- **Pattern**: Eventi, Projectors, Proiezioni.
- **Quando usarlo**: Quando serve audit, reporting, o si vogliono aggiungere nuove viste senza cambiare la logica di scrittura.

## 3. Larabank-Aggregates
- **Architettura**: Event sourcing completo. Tutta la logica di business è negli aggregate, che decidono se un evento può essere registrato.
- **Vantaggi**: Coerenza, regole di business centralizzate, audit completo, possibilità di replay eventi.
- **Svantaggi**: Maggiore complessità, curva di apprendimento.
- **Pattern**: Aggregate Root, Eventi, Projectors, Reactors.
- **Quando usarlo**: Sistemi critici, banking, workflow complessi, necessità di audit e rollback.

## 4. Larabank-Eventsauce
- **Architettura**: Event sourcing con la libreria Eventsauce, simile a aggregates ma con API e pattern diversi.
- **Vantaggi**: Separazione netta tra comando, evento, proiezione. Standardizzazione, testabilità.
- **Svantaggi**: Complessità, learning curve, meno integrato con Laravel rispetto a spatie/laravel-event-sourcing.
- **Pattern**: Command, Event, Aggregate, Projector.
- **Quando usarlo**: Progetti che richiedono standardizzazione, compatibilità con altri ecosistemi Event Sourcing.

## Tabella di Sintesi
| Approccio         | Tracciabilità | Audit | Complessità | Estendibilità | Performance | Use case ideale |
|-------------------|---------------|-------|-------------|---------------|-------------|-----------------|
| Traditional       | ❌            | ❌    | Bassa       | Bassa         | Alta        | CRUD semplice   |
| Projectors        | ✅            | Parziale| Media      | Alta          | Media       | Reporting, audit|
| Aggregates        | ✅            | ✅    | Alta        | Alta          | Media       | Banking, workflow|
| Eventsauce        | ✅            | ✅    | Alta        | Alta          | Media       | Standard ES     |

## Conclusioni
- **Traditional**: per casi semplici e prototipi.
- **Projectors**: per aggiungere audit/reporting senza cambiare la logica di business.
- **Aggregates**: per sistemi mission critical, banking, compliance.
- **Eventsauce**: per chi vuole uno standard ES puro e interoperabilità. 
