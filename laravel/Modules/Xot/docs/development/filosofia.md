# Filosofia di Sviluppo il progetto

## Principi Fondamentali

Lo sviluppo del progetto il progetto è guidato dai seguenti principi fondamentali:

### Leggibilità e Manutenibilità

- Privilegiare la chiarezza rispetto all'ottimizzazione prematura
- Scrivere codice pensando a chi lo leggerà in futuro
- Utilizzare nomi di variabili e funzioni descrittivi
- Documentare il "perché" delle decisioni, non solo il "cosa"

### Principi SOLID

- **S**ingle Responsibility: Ogni classe ha una sola responsabilità
- **O**pen/Closed: Aperto all'estensione, chiuso alla modifica
- **L**iskov Substitution: Le sottoclassi devono essere sostituibili alle classi base
- **I**nterface Segregation: Interfacce specifiche sono meglio di una generale
- **D**ependency Inversion: Dipendere da astrazioni, non da implementazioni concrete

### DRY (Don't Repeat Yourself)

- Evitare duplicazione di codice e logica
- Centralizzare funzionalità comuni
- Utilizzare trait e interfacce per condividere comportamenti

### Composizione vs Ereditarietà

- Preferire la composizione all'ereditarietà quando possibile
- Utilizzare l'iniezione delle dipendenze
- Favorire interfacce e implementazioni concrete

## Approccio Pragmatico

### Bilanciamento Perfezionismo/Pragmatismo

- Riconoscere quando una soluzione è "abbastanza buona"
- Evitare l'over-engineering
- Concentrarsi sulla consegna di valore

### Considerazione del Contesto

- Adattare le soluzioni al contesto specifico
- Valutare i trade-off in base alle esigenze del progetto
- Considerare vincoli di tempo, risorse e requisiti

### Iterazione Continua

- Preferire miglioramenti incrementali a rifacimenti completi
- Refactoring progressivo del codice
- Test continui durante lo sviluppo

## Pattern e Architettura

### Architettura Modulare

- Separazione chiara delle responsabilità
- Moduli indipendenti e riutilizzabili
- Interfacce ben definite tra i moduli

### Pattern Action

- Implementare logica di business in classi Action
- Utilizzare Spatie Queueable Actions invece di Service Classes
- Mantenere le Action focalizzate su un singolo compito

### Repository Pattern

- Astrarre l'accesso ai dati
- Separare la logica di business dalla persistenza
- Facilitare i test con mock e stub

### Data Transfer Objects

- Utilizzare DTO tipizzati invece di array associativi
- Validare i dati a livello di DTO
- Garantire l'integrità dei dati attraverso l'applicazione

## Qualità del Codice

### Analisi Statica

- Utilizzare PHPStan con livello progressivo
- Iniziare dal livello 1 per nuovi moduli
- Obiettivo finale: livello 9 per tutti i file

### Testing

- Scrivere test unitari per la logica critica
- Implementare test di integrazione per i flussi principali
- Utilizzare test browser per le interazioni UI

### Code Review

- Revisione del codice prima dell'integrazione
- Feedback costruttivo e focalizzato sul miglioramento
- Condivisione della conoscenza attraverso le revisioni

## Collaborazione e Comunicazione

### Documentazione Chiara

- Mantenere la documentazione aggiornata con il codice
- Documentare decisioni architetturali importanti
- Fornire esempi di utilizzo per componenti complessi

### Versionamento Semantico

- Seguire le convenzioni di versioning semantico
- Comunicare chiaramente le modifiche breaking
- Mantenere un changelog aggiornato

### Messaggi di Commit Significativi

- Scrivere messaggi di commit chiari e descrittivi
- Spiegare il "perché" delle modifiche
- Riferirsi a ticket o issue quando applicabile

## Collegamenti tra versioni di filosofia.md
* [filosofia.md](docs/filosofia.md)
* [filosofia.md](../../../Xot/docs/development/filosofia.md)

