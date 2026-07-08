# Larabank: Caso d'Uso Bancario con Event Sourcing

## Introduzione

Larabank è un'applicazione di esempio sviluppata da Spatie per dimostrare l'uso dell'Event Sourcing in Laravel, utilizzando aggregate e proiettori. Questo caso d'uso è stato analizzato e documentato per il modulo `Activity` per mostrare come i concetti di Event Sourcing possono essere applicati a un sistema bancario, con regole specifiche come limiti di saldo e notifiche automatiche.

Il repository di riferimento è [larabank-aggregates](https://github.com/spatie/larabank-aggregates), parte della documentazione di [laravel-event-sourcing](https://spatie.be/docs/laravel-event-sourcing).

## Obiettivi

- Mostrare come l'Event Sourcing può gestire transazioni bancarie complesse.
- Implementare regole di business come limiti di saldo e notifiche automatiche.
- Fornire un esempio pratico di aggregate e proiettori in un contesto finanziario.

## Regole Implementate in Larabank

- **Limite di Saldo**: Un utente non può scendere sotto -5000 su un conto.
- **Notifica di Prestito**: Quando il limite viene raggiunto tre volte consecutivamente, deve essere inviata un'email con una proposta di prestito.

## Rilevanza per il Modulo Activity

Questo caso d'uso bancario può essere adattato per monitorare attività finanziarie o transazioni correlate a pazienti, fornitori o progetti nel contesto sanitario. Ad esempio, si potrebbe tracciare il budget di una campagna sanitaria o gestire pagamenti per servizi, applicando regole simili per limiti di spesa o notifiche automatiche.

## Confronto tra Approcci di Implementazione

Spatie ha sviluppato diverse varianti di Larabank per dimostrare approcci differenti alla gestione di un'applicazione bancaria:

- **Larabank Aggregates** ([GitHub](https://github.com/spatie/larabank-aggregates)): Utilizza aggregate per gestire lo stato tramite Event Sourcing.
- **Larabank Projectors** ([GitHub](https://github.com/spatie/larabank-projectors)): Si concentra sull'uso di proiettori per creare viste di lettura ottimizzate.
- **Larabank EventSauce** ([GitHub](https://github.com/spatie/larabank-eventsauce)): Implementa Event Sourcing utilizzando la libreria EventSauce.
- **Larabank Traditional** ([GitHub](https://github.com/spatie/larabank-traditional)): Segue un approccio tradizionale senza Event Sourcing, per confronto.

Ogni variante evidenzia un aspetto diverso dell'architettura e permette di confrontare i vantaggi di Event Sourcing rispetto a metodi tradizionali. La documentazione seguente esplorerà queste differenze e il loro impatto sull'implementazione.

## Struttura della Documentazione

- **Architettura**: Spiega come sono strutturati gli aggregate e i proiettori in Larabank.
- **Eventi**: Dettaglia gli eventi principali utilizzati per gestire le transazioni.
- **Aggregate Root**: Descrive la logica di business incapsulata nell'aggregate root.
- **Proiettori**: Mostra come i proiettori creano viste di lettura per report finanziari.
- **Implementazione**: Guida pratica per adattare questo caso d'uso al modulo `Activity`.

Se hai bisogno di approfondire un aspetto specifico di Larabank o della sua applicazione al nostro contesto, fammi sapere!
