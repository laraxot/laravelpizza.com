# Regole Generali di Comportamento

## 1. Struttura del Codice

### 1.1 Migrazioni
- Utilizzare sempre classi anonime che estendono `XotBaseMigration`
- Dichiarare `strict_types=1` all'inizio del file
- Importare `Blueprint` da `Illuminate\Database\Schema\Blueprint`
- Dividere il metodo `up()` in due parti:
  ```php
  // -- CREATE --
  $this->tableCreate(...)
  
  // -- UPDATE --
  $this->tableUpdate(...)
  ```
- Utilizzare direttamente i metodi di Blueprint invece dei metodi helper
- Gestire i timestamp in una fase separata con `updateTimestamps()`
- Non implementare il metodo `down()`

### 1.2 Models
- Estendere sempre `BaseModel` invece di `Model`
- Utilizzare `SoftDeletes` quando necessario
- Definire sempre i tipi di ritorno per le relazioni
- Utilizzare `protected $casts` per i campi JSON e date
- Definire `$fillable` per i campi assegnabili in massa

### 1.3 Filament Resources
- Estendere sempre le classi base di Xot con prefisso `XotBase`
- Utilizzare `getFormSchema()` invece di `form()`
- Restituire array associativi con chiavi stringhe
- Non utilizzare il metodo `table()`
- Implementare la logica della tabella nella pagina "index"

### 1.4 Filament Pages
- Estendere sempre `XotBasePage`
- Implementare:
  - `getTableColumns()`
  - `getTableFilters()`
  - `getTableActions()`
- Tutti i metodi devono restituire array associativi con chiavi stringhe

## 2. Best Practices

### 2.1 Actions
- Utilizzare `QueableAction` per azioni asincrone
- Implementare il metodo `handle()` con tipi di parametri e ritorno definiti
- Separare la logica in metodi privati quando necessario
- Utilizzare `match` per logiche condizionali semplici

### 2.2 Data Transfer Objects
- Utilizzare Spatie Laravel Data
- Definire proprietà pubbliche con tipi
- Implementare `from()` per la creazione da array
- Utilizzare `toArray()` per la serializzazione

### 2.3 Validazione
- Creare classi `Request` dedicate
- Utilizzare regole di validazione specifiche
- Implementare `rules()` con array associativo
- Utilizzare `unique` con esclusione dell'ID corrente

## 3. Organizzazione del Codice

### 3.1 Directory Structure
```
app/
├── Actions/
├── Datas/
├── Filament/
│   ├── Resources/
│   ├── Pages/
│   └── Widgets/
├── Models/
└── Http/
    └── Requests/
```

### 3.2 Namespace
- Utilizzare namespace completi per le importazioni
- Seguire la struttura delle directory per i namespace
- Evitare importazioni con `*`

### 3.3 Naming Conventions
- Classi: PascalCase
- Metodi: camelCase
- Proprietà: camelCase
- Costanti: UPPER_SNAKE_CASE
- Variabili: camelCase

## 4. Testing

### 4.1 Unit Tests
- Testare ogni classe in modo isolato
- Utilizzare `TestCase` come base
- Implementare test per tutti i metodi pubblici
- Utilizzare `assertDatabaseHas` per verifiche DB

### 4.2 Feature Tests
- Testare flussi completi
- Verificare risposte HTTP
- Controllare stati del database
- Testare validazione e autorizzazione

## 5. Documentazione

### 5.1 Commenti
- Documentare metodi pubblici
- Spiegare logiche complesse
- Evitare commenti ovvi
- Utilizzare PHPDoc per tipi e descrizioni

### 5.2 README
- Mantenere aggiornato
- Includere istruzioni di setup
- Documentare dipendenze
- Fornire esempi di utilizzo

## 6. Performance

### 6.1 Database
- Utilizzare indici appropriati
- Evitare N+1 queries
- Utilizzare eager loading
- Ottimizzare query complesse

### 6.2 Cache
- Utilizzare cache per dati statici
- Implementare cache per query frequenti
- Gestire invalidazione cache
- Monitorare hit/miss ratio

## 7. Sicurezza

### 7.1 Input
- Validare sempre gli input
- Sanitizzare output HTML
- Utilizzare prepared statements
- Implementare CSRF protection

### 7.2 Autorizzazione
- Utilizzare policies
- Implementare gates
- Verificare permessi
- Loggare accessi critici

## 8. Manutenzione

### 8.1 Code Review
- Verificare standard di codice
- Controllare test coverage
- Valutare performance
- Seguire checklist

### 8.2 Refactoring
- Mantenere retrocompatibilità
- Aggiornare documentazione
- Verificare test
- Comunicare cambiamenti 