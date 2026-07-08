# Informazioni sul Libro: Event Sourcing in Laravel

Questo documento contiene una documentazione dettagliata del libro **Event Sourcing in Laravel** scritto da Brent Roose, pubblicato nel 2021 da Spatie. Di seguito sono riportate tutte le informazioni estratte dal PDF convertito in Markdown tramite OCR, organizzate per sezioni e capitoli.

## Dettagli Generali
- **Titolo**: Event Sourcing in Laravel
- **Autore**: Brent Roose
- **Editore**: Spatie
- **Anno di Pubblicazione**: 2021
- **Versione**: 12a70f4-1
- **Recensori**: Freek Van der Herten, Matthias Noback, Stephen Moon, Wouter Brouwers
- **Design e Composizione**: Sebastian De Deyne, Willem Van Bockstal
- **Team Spatie**: Adriaan, Alex, Brent, Jef, Freek, Niels, Rias, Ruben, Sebastian, Willem, Wouter
- **Contatto per Errori**: info@spatie.be
- **Luogo di Creazione**: Belgio
- **Sito Web**: event-sourcing-laravel.com

## Prefazione

Nella prefazione, Brent Roose riflette sull'evoluzione della sua carriera come sviluppatore e sull'importanza di imparare dai progetti passati. Sottolinea come ogni nuovo progetto sia migliore e più raffinato grazie alle conoscenze acquisite precedentemente. Questo libro rappresenta il passo successivo nel suo viaggio come sviluppatore, con l'obiettivo di insegnare l'approccio del sourcing di eventi, una tecnica adatta a progetti con processi complessi, rendendoli flessibili e sostenibili.

### Note sulla Lettura
- **Linguaggio**: Gli esempi sono scritti in PHP 8, principalmente nel contesto di un'applicazione Laravel, ma i principi possono essere applicati a qualsiasi progetto o framework.
- **Target**: Il libro è adatto sia a chi ha esperienza teorica o pratica con il sourcing di eventi, sia a chi non ne ha mai sentito parlare. Si parte dalle basi per arrivare a argomenti più complessi.
- **Test**: Vengono forniti blocchi di test specifici per i componenti di design orientato agli eventi. Si utilizzano factory di test per oggetti non modello, come gli eventi.
- **App Demo**: Inclusa con il corso c'è un'app demo di un carrello della spesa, che può essere usata come base per progetti reali. Viene spesso citata nel libro.

## Introduzione

L'introduzione spiega il concetto di sourcing di eventi, un approccio in cui ogni cambiamento allo stato di un'applicazione viene catturato in un oggetto evento. Questi eventi sono memorizzati nella sequenza in cui sono stati applicati, garantendo che ogni modifica sia tracciata. Questo differisce dall'approccio CRUD tradizionale, dove solo lo stato finale viene salvato.

### Vantaggi del Sourcing di Eventi
- **Tracciabilità Completa**: Ogni azione è registrata come evento, fornendo una cronologia completa.
- **Ricostruzione dello Stato**: Gli eventi possono essere usati per ricostruire stati passati o adattarsi a cambiamenti retroattivi.
- **Flessibilità**: Nuove funzionalità possono essere aggiunte rigiocando eventi su nuovi proiettori senza modificare i dati esistenti.

### Sfide
- **Complessità**: La gestione degli eventi e delle proiezioni può essere più complessa rispetto a CRUD.
- **Performance**: Rigiocare molti eventi può essere lento, richiedendo strategie come snapshot.
- **Versionamento**: Gli eventi devono essere versionati per gestire cambiamenti nella struttura dei dati.

## Indice dei Contenuti

- **Prefazione**: Pag. 4
- **Introduzione**: Pag. 8
- **Parte 1: Le Basi**: Pag. 17
  - 1. Design Orientato agli Eventi: Pag. 18
  - 2. Il Bus degli Eventi: Pag. 28
  - 3. Eventi: Pag. 31
  - 4. Modellazione del Mondo: Pag. 37
  - 5. Memorizzazione e Proiezione degli Eventi: Pag. 44
  - 6. Proiettori in Profondità: Pag. 63
  - 7. Query sugli Eventi: Pag. 75
  - 8. Reattori: Pag. 83
  - 9. Radici Aggregate: Pag. 95
- **Parte 2: Pattern Avanzati**: Pag. 112
  - 10. Gestione dello Stato nelle Radici Aggregate: Pag. 113
  - 11. Parziali di Aggregati: Pag. 128
  - 12. Macchine a Stati con Parziali di Aggregati: Pag. 138
  - 13. Il Bus dei Comandi: Pag. 148
  - 14. CQRS: Pag. 162
  - 15. Saghe: Pag. 167
- **Parte 3: Sfide con il Sourcing di Eventi**: Pag. 173
  - 16. Versionamento degli Eventi: Pag. 174
  - 17. Snapshotting: Pag. 185
  - 18. Microservizi: Pag. 189
  - 19. Sourcing di Eventi Parziale: Pag. 196
  - 20. Strategie di Distribuzione: Pag. 202
  - 21. Note sull'Event Storming: Pag. 208
  - 22. Dettagli degni di Nota: Pag. 213

## Parte 1: Le Basi

### 1. Design Orientato agli Eventi

Questo capitolo introduce il concetto di design orientato agli eventi, che si concentra sulla modellazione di un sistema attorno agli eventi piuttosto che sullo stato finale. Ad esempio, invece di aggiornare direttamente un campo "saldo", si registrano eventi come `DepositMade` o `WithdrawalMade`.

### 2. Il Bus degli Eventi

Il bus degli eventi è un meccanismo centrale per distribuire eventi a vari ascoltatori o consumatori, come proiettori e reattori. In Laravel, può essere implementato usando il sistema di eventi integrato o pacchetti come `spatie/laravel-event-sourcing`.

### 3. Eventi

Gli eventi rappresentano qualcosa che è accaduto nel sistema. Devono essere chiari, specifici e contenere dati rilevanti. Esempi includono `CustomerRegistered`, `AppointmentBooked`, `TreatmentCompleted`. Alcuni eventi possono essere semplici notifiche senza dati aggiuntivi.

### 4. Modellazione del Mondo

La modellazione del mondo implica identificare eventi, aggregati e interazioni nel dominio. Sessioni di event storming aiutano a mappare i flussi di eventi per visualizzare i processi di business. Ad esempio, un carrello della spesa potrebbe avere eventi come `CartInitialized`, `CartItemAdded`, `CartItemRemoved`, `CartCheckedOut`.

### 5. Memorizzazione e Proiezione degli Eventi

Gli eventi sono memorizzati in un database di eventi, spesso in formato JSON con metadati come timestamp e UUID. La proiezione trasforma questi eventi in modelli di lettura per query rapide. Un proiettore potrebbe aggiornare una tabella `carts` con il conteggio degli articoli based on `CartItemAdded`.

### 6. Proiettori in Profondità

I proiettori creano viste di lettura basate sugli eventi e devono essere idempotenti. Ad esempio, un proiettore può calcolare il valore totale di un carrello sommando gli eventi di aggiunta e rimozione. Questo approccio consente di modellare flussi complessi mantenendo i componenti concisi.

### 7. Query sugli Eventi

Le query sugli eventi permettono di analizzare la storia degli eventi per insight o report. Ad esempio, si può determinare quante volte un articolo è stato aggiunto a un carrello in un periodo specifico.

### 8. Reattori

I reattori eseguono effetti collaterali come inviare email o notifiche invece di aggiornare modelli di lettura. Un reattore potrebbe notificare il magazzino quando un articolo viene aggiunto al carrello, riducendo l'inventario disponibile.

### 9. Radici Aggregate

Le radici aggregate incapsulano la logica di business e gestiscono gli eventi per un'entità specifica, garantendo coerenza nello stato. Ad esempio, un `CartAggregateRoot` potrebbe gestire eventi come `CartItemAdded` e `CartItemRemoved`.

## Parte 2: Pattern Avanzati

### 10. Gestione dello Stato nelle Radici Aggregate

La gestione dello stato può diventare complessa nelle radici aggregate. Si raccomanda di utilizzare metodi di applicazione per ogni tipo di evento per mantenere il codice leggibile e organizzato.

### 11. Parziali di Aggregati

I parziali di aggregati suddividono la logica di un aggregato in parti gestibili. Ad esempio, un carrello potrebbe avere un parziale per gli articoli e uno per i prezzi. Questo aiuta a gestire la complessità interna.

### 12. Macchine a Stati con Parziali di Aggregati

Le macchine a stati gestiscono transizioni di stato complesse usando parziali di aggregati. Un carrello potrebbe passare attraverso stati come "vuoto", "attivo", "in attesa di pagamento" e "completato", con regole specifiche per ogni transizione.

### 13. Il Bus dei Comandi

Il bus dei comandi instrada i comandi alle radici aggregate appropriate, separando la logica di comando dall'esecuzione. Questo rende il sistema più modulare. I comandi spostano la funzionalità di business lontano da punti di ingresso come controller o comandi CLI.

### 14. CQRS

Command Query Responsibility Segregation (CQRS) separa le operazioni di scrittura (comandi) da quelle di lettura (query). Nel sourcing di eventi, i comandi generano eventi, mentre le query leggono da modelli proiettati. Non dovrebbe esserci una mappatura uno-a-uno tra modello di scrittura e lettura.

### 15. Saghe

Le saghe gestiscono transazioni distribuite o flussi di lavoro complessi coinvolgendo più aggregati. Sono sequenze di comandi ed eventi con meccanismi di compensazione in caso di fallimento. Ad esempio, una saga di checkout potrebbe verificare l'inventario, creare un ordine e processare il pagamento.

## Parte 3: Sfide con il Sourcing di Eventi

### 16. Versionamento degli Eventi

Il versionamento degli eventi gestisce i cambiamenti nella struttura degli eventi nel tempo. Si usano convertitori per trasformare eventi vecchi in nuovi formati. Una strategia di migrazione prevede di eseguire script per trasformare eventi da un vecchio stream a uno nuovo.

### 17. Snapshotting

Rigiocare molti eventi può essere lento. Lo snapshotting salva periodicamente lo stato corrente di un aggregato, riducendo il numero di eventi da rigiocare. Questo è utile per aggregati con molti eventi, ma bisogna fare attenzione a non abusarne in aggregati complessi.

### 18. Microservizi

Nel contesto dei microservizi, il sourcing di eventi facilita la comunicazione tra servizi tramite serializzazione di messaggi su protocolli come HTTP. Gli eventi possono essere pubblicati su broker di messaggi come RabbitMQ o Kafka, permettendo reazioni tra servizi.

### 19. Sourcing di Eventi Parziale

Non tutte le parti di un'applicazione devono usare il sourcing di eventi. Può essere applicato solo a domini complessi che beneficiano di tracciabilità, usando CRUD per parti più semplici. Questo richiede una comunicazione chiara tra le parti event-sourced e CRUD.

### 20. Strategie di Distribuzione

Distribuire applicazioni con sourcing di eventi richiede attenzione alla sincronizzazione di eventi e proiezioni tra ambienti. Strategie come il blue-green deployment o database di eventi separati per ambiente possono aiutare. Script di migrazione personalizzati offrono flessibilità.

### 21. Note sull'Event Storming

L'event storming è una tecnica collaborativa per scoprire e modellare processi di business tramite eventi. È utile per identificare eventi chiave, comandi e aggregati prima dello sviluppo, chiarendo le regole di business con il cliente.

### 22. Dettagli degni di Nota

- **Idempotenza dei Proiettori**: I proiettori devono gestire eventi duplicati senza modifiche indesiderate.
- **Performance dell'Event Store**: Database ottimizzati come EventStoreDB sono consigliati per applicazioni ad alto volume.
- **Monitoraggio e Logging**: Monitorare la salute di proiezioni e reattori è cruciale per rilevare problemi.
- **Nomi delle Classi**: Usare nomi univoci per classi in namespace diversi per evitare confusione.

## Note Finali

Questo libro fornisce una guida completa al sourcing di eventi in Laravel, coprendo teoria, pratica e sfide. L'app demo del carrello della spesa inclusa serve come base pratica per applicare i concetti. Brent Roose sottolinea l'importanza dei test e della flessibilità del sourcing di eventi per applicazioni complesse.

Se hai bisogno di ulteriori dettagli su una sezione specifica o desideri che approfondisca un capitolo, fammi sapere!
