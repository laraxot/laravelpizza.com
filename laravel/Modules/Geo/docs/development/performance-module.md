# Modulo Performance

## Overview
Il modulo Performance gestisce le valutazioni delle performance del personale, inclusi i pesi per le diverse categorie di valutazione. Include funzionalità per la gestione dei pesi delle valutazioni individuali, la registrazione delle assenze e il calcolo dei punteggi finali.

## Struttura del Database

### Tabella: peso_performance_individuale

```sql
CREATE TABLE peso_performance_individuale (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    type varchar(255) NOT NULL,
    lista_propro varchar(255) NOT NULL,
    descr text NULL,
    peso_esperienza_acquisita decimal(5,2) NOT NULL,
    peso_risultati_ottenuti decimal(5,2) NOT NULL,
    peso_arricchimento_professionale decimal(5,2) NOT NULL,
    peso_impegno decimal(5,2) NOT NULL,
    peso_qualita_prestazione decimal(5,2) NOT NULL,
    anno year NOT NULL,
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,
    created_by varchar(255) NULL,
    updated_by varchar(255) NULL,
    PRIMARY KEY (id),
    UNIQUE KEY peso_performance_individuale_type_anno_unique (type, anno)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## Modelli

### IndividualePesi
Il modello `IndividualePesi` gestisce i pesi delle valutazioni individuali. Estende il modello base `BaseModel` e include le seguenti caratteristiche:

- Connessione al database: 'performance'
- Tabella: 'peso_performance_individuale'
- Campi fillable: tutti i campi della tabella
- Cast automatico del campo 'type' all'enum WorkerType

## Filament Resources

### IndividualePesiResource
Questa risorsa gestisce l'interfaccia amministrativa per i pesi delle valutazioni individuali.

#### Funzionalità
- Lista con colonne filtrabili e ordinabili
- Filtri per anno e tipo di lavoratore
- Azioni per creare, modificare ed eliminare i record
- Azione bulk per eliminazione multipla
- Funzionalità di copia da anno precedente

#### Form Schema
Il form include campi per:
- Tipo di lavoratore (select da enum WorkerType)
- Lista ProPro (input testuale)
- Descrizione (input testuale)
- Pesi numerici per varie categorie di valutazione
- Anno di riferimento

## Utilizzo

### Creazione di Nuovi Pesi
1. Accedere alla sezione "Pesi Individuali" nel pannello amministrativo
2. Cliccare su "Crea Nuovo"
3. Compilare il form con i dati richiesti
4. Salvare il record

### Copia da Anno Precedente
1. Nella lista dei pesi, utilizzare l'azione "Copia da Anno Precedente"
2. Selezionare l'anno di origine
3. Confermare l'operazione

### Modifica dei Pesi
1. Nella lista dei pesi, cliccare sull'azione "Modifica" per il record desiderato
2. Aggiornare i valori necessari
3. Salvare le modifiche

## Relazioni con Altri Modelli

Il modello `IndividualePesi` è collegato a:
- `Individuale` - Relazione one-to-many attraverso il campo 'individuale_id'
- `IndividualePo` - Relazione one-to-many per i pesi specifici delle Posizioni Organizzative
- `IndividualeRegionale` - Relazione one-to-many per i pesi specifici regionali
- `IndividualeAdm` - Relazione one-to-many per i pesi amministrativi

## Enums

### WorkerType

```php
declare(strict_types=1);

namespace Modules\Performance\Enums;

enum WorkerType: string
{
    case DIRIGENTE = 'DIRIGENTE';
    case FUNZIONARIO = 'FUNZIONARIO';
    case OPERATORE = 'OPERATORE';
}
```

## Best Practices

1. **Type Safety**
   - Utilizzare strict types
   - Definire getter e setter per i campi con casting
   - Utilizzare enums per i campi con valori predefiniti

2. **Validazione**
   - Validare i pesi per assicurare che la somma sia 100
   - Validare i campi numerici per range appropriati
   - Utilizzare regole di validazione personalizzate quando necessario

3. **Performance**
   - Utilizzare indici appropriati per le colonne di ricerca
   - Implementare caching per i dati frequentemente accessi
   - Ottimizzare le query per grandi dataset

4. **Sicurezza**
   - Validare tutti gli input utente
   - Implementare autorizzazioni appropriate
   - Proteggere i dati sensibili

## Note di Sviluppo

1. **Aggiornamenti**
   - Mantenere aggiornate le dipendenze
   - Seguire le best practices di Laravel
   - Testare le modifiche prima del deploy

2. **Testing**
   - Scrivere test unitari per i modelli
   - Testare le validazioni
   - Testare le relazioni

3. **Documentazione**
   - Mantenere aggiornata la documentazione
   - Documentare le modifiche al database
   - Documentare le API e i servizi 