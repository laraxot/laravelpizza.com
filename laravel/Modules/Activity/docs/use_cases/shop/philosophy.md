# Filosofia e Scelte di Design del Carrello della Spesa

## Introduzione

Questo documento esplora in profondità le scelte tecnologiche, la filosofia di design, le politiche di sviluppo e gli aspetti concettuali dietro i progetti di Spatie per un carrello della spesa basato su Event Sourcing. Analizziamo i due progetti principali: `laravel-shop-main` e `laravel-shop-command-bus`.

## Filosofia di Design

### Event Sourcing come Principio Fondante

Entrambi i progetti si basano sull'Event Sourcing, una filosofia di design che considera gli eventi come la fonte primaria di verità. Questo approccio si riflette in:
- **Tracciabilità**: Ogni azione (aggiunta di un articolo, checkout) genera un evento, consentendo di ricostruire lo stato del carrello in qualsiasi momento. Questo è cruciale per audit e debugging.
- **Immutabilità**: Gli eventi sono immutabili, garantendo che la storia non possa essere alterata, il che riflette una politica di integrità dei dati.
- **Reattività**: Gli eventi possono triggerare azioni secondarie (notifiche, aggiornamenti di inventario), incarnando un design reattivo.

La filosofia dietro l'Event Sourcing è di natura quasi 'zen': si accetta il flusso continuo di cambiamenti (eventi) come la realtà ultima, piuttosto che uno stato statico. Questo si contrappone a un approccio tradizionale dove lo stato corrente è l'unica verità.

### Separazione delle Responsabilità

- **Aggregate**: Incapsulano la logica di business, decidendo quali eventi generare in risposta a un comando. Questo riflette una politica di centralizzazione della logica di decisione.
- **Proiettori**: Gestiscono le viste per le query, separando la scrittura dalla lettura (CQRS - Command Query Responsibility Segregation). Questa separazione è una scelta architetturale che promuove scalabilità e manutenzione.

## Scelte Tecnologiche

### Laravel come Framework

- **Laravel Shop Main**: Usa una versione completa di Laravel (8.12 o superiore) come base, sfruttando l'ecosistema per autenticazione, routing e gestione del database. Questo riflette una scelta di familiarità e supporto della comunità.
- **Laravel Shop Command Bus**: Si integra come pacchetto in Laravel, utilizzando le stesse tecnologie ma con un focus sulla modularità. Dipende da `illuminate/contracts` per garantire compatibilità.

### Pacchetti Spatie

Entrambi i progetti utilizzano pacchetti Spatie come:
- `spatie/laravel-event-sourcing`: Fornisce le fondamenta per gestire eventi e aggregate.
- `spatie/laravel-model-states`: Per gestire stati in modo tipizzato.
- `spatie/browsershot` e `spatie/period`: Utilizzati per funzionalità accessorie come generazione di immagini o gestione di periodi di tempo.

Queste scelte tecnologiche riflettono una politica di riutilizzo interno e coerenza tra i progetti Spatie, riducendo la frammentazione.

### PHP 8.0+

L'uso di PHP 8.0 o superiore indica un impegno verso modernità e performance, sfruttando funzionalità come constructor property promotion e union types. Questo è in linea con una filosofia di progresso continuo.

## Politiche di Sviluppo

### Open Source e Supporto della Comunità

- **Licenza MIT**: Entrambi i progetti sono rilasciati sotto licenza MIT, riflettendo una politica di apertura e condivisione.
- **Supporto**: Spatie incoraggia il supporto attraverso l'acquisto di prodotti a pagamento o l'invio di cartoline, mostrando una filosofia di reciprocità con la comunità.
- **Contributi**: Le linee guida per contribuire sono chiare (`CONTRIBUTING.md`), indicando una politica di collaborazione strutturata.

### Testing e Qualità del Codice

- **PHPUnit**: Utilizzato per i test, con comandi come `composer test` o `vendor/bin/phpunit`, mostrando un impegno verso la qualità.
- **Psalm**: Per l'analisi statica del codice, riflettendo una politica di prevenzione degli errori.
- **Laravel IDE Helper**: Per migliorare l'esperienza di sviluppo, evidenziando una filosofia di produttività.

## Aspetti Concettuali e 'Religione'

### Religione del Codice Pulito

I progetti Spatie aderiscono a una 'religione' del codice pulito e leggibile:
- **Strutturazione**: La suddivisione in `Domain` o moduli (`Cart`, `Order`) riflette un culto dell'organizzazione.
- **Nomenclatura**: Nomi chiari come `CartItemAdded` o `CheckoutCart` mostrano una devozione alla chiarezza.

### Zen della Manutenzione

L'uso di Event Sourcing e CQRS è quasi uno 'zen' della manutenzione: si accetta che il sistema crescerà in complessità, ma si strutturano i componenti per rendere questa complessità gestibile. Gli eventi sono come 'koan' zen, piccoli frammenti di verità che, messi insieme, rivelano il quadro completo.

### Politica di Evoluzione

- **TODO List**: In `laravel-shop-command-bus`, Spatie elenca task futuri come gestione dell'inventario o supporto ai coupon, mostrando una politica di evoluzione iterativa.
- **Versionamento**: L'uso di versioni come `^5.0-dev` per `laravel-event-sourcing` indica una volontà di sperimentare pur mantenendo stabilità.

## Analisi Comparativa

### Laravel Shop Main

- **Filosofia**: È un progetto didattico, progettato per insegnare Event Sourcing. La sua 'religione' è l'educazione, con un diagramma temporale come 'scrittura sacra' per guidare gli sviluppatori.
- **Politica**: Meno modulare, più focalizzato sull'esempio pratico. Riflette una scelta di immediatezza.
- **Tecnologia**: Include frontend (con Yarn per la compilazione), mostrando un approccio olistico.

### Laravel Shop Command Bus

- **Filosofia**: È un pacchetto riutilizzabile, con una 'religione' di modularità e integrazione. La sua missione è essere parte di un sistema più grande.
- **Politica**: Più strutturato, con un command bus che riflette una scelta di disciplina architetturale.
- **Tecnologia**: Non include frontend, focalizzandosi sul backend e sull'integrazione con Laravel.

## Rilevanza per il Modulo Activity

- **Filosofia**: L'Event Sourcing si adatta al nostro bisogno di tracciabilità per ordini o acquisti nel settore sanitario, riflettendo una 'religione' di trasparenza.
- **Tecnologia**: Possiamo adottare `laravel-shop-command-bus` per la sua modularità, integrandolo con il nostro sistema esistente.
- **Politica**: Seguire l'approccio iterativo di Spatie, aggiungendo funzionalità come gestione di budget o notifiche personalizzate.
- **Zen**: Accettare il flusso di eventi come rappresentazione della realtà dinamica degli acquisti, piuttosto che uno stato statico.

## Conclusione

I progetti di Spatie non sono solo implementazioni tecniche, ma incarnano una filosofia di design, una politica di sviluppo e uno 'zen' di manutenzione. `Laravel Shop Main` è un maestro che insegna i principi, mentre `Laravel Shop Command Bus` è un compagno che si integra nei nostri sistemi. Per il modulo `Activity`, adottare questi principi significa costruire un sistema di ordini che non solo funziona, ma riflette una visione più profonda di tracciabilità, chiarezza e adattabilità.
