# Convenzioni del Progetto <nome progetto>

## Convenzioni Generali

### 1. Estensione Classi
- **NON** estendere mai direttamente le classi di Filament
- Utilizzare sempre le classi base dal modulo Xot con prefisso `XotBase`
- Esempio:
  ```php
  // ❌ NON FARE
  class DoctorRegistrationResource extends Resource
  
  // ✅ FARE
  class DoctorRegistrationResource extends XotBaseResource
  ```

### 2. Struttura Moduli
- Ogni modulo deve essere autocontenuto
- Le classi base devono essere nel modulo Xot
- I moduli specifici estendono le classi base di Xot

### 3. Convenzioni Naming
- Classi base: `XotBase{ClassName}`
- Classi specifiche: `{ModuleName}{ClassName}`
- Namespace: `Modules\{ModuleName}\{Type}`

## Convenzioni Filament

### 1. Resources
- Estendere `XotBaseResource`
- Non implementare `form()` o `table()` direttamente
- Utilizzare i trait forniti da Xot

### 2. Pages
- Estendere `XotBasePage`
- Utilizzare i widget forniti da Xot
- Non duplicare la logica comune

### 3. Widgets
- Estendere `XotBaseWidget`
- Riutilizzare i componenti comuni
- Seguire il pattern di composizione

## Convenzioni Traduzioni

### 1. Struttura File
- Traduzioni comuni in `common.php`
- Traduzioni specifiche modulo in `{module}.php`
- Chiavi gerarchiche e descrittive

### 2. Utilizzo
- Usare `__()` per le traduzioni
- Non usare `->label()`
- Parametri dinamici con `:param`

## Convenzioni Notifiche

### 1. Sistema Notifiche
- Usare `recordNotification`
- Non creare classi di notifica specifiche
- Utilizzare i template comuni

### 2. Struttura Dati
- Tipo notifica
- Dati notifica
- URL azione
- Stato e metadati

## Convenzioni Enum

### 1. Stati e Tipi
- Enum generici per stati comuni
- Riutilizzo per casi simili
- Metodi helper standard

### 2. Implementazione
- Metodi `label()`, `color()`, `icon()`
- Traduzioni in file dedicati
- Validazione automatica

## Validazione Convenzioni

### 1. Comandi Artisan
```bash

# Verifica convenzioni
php artisan xot:check-conventions

# Fix automatico
php artisan xot:fix-conventions
```

### 2. CI/CD
- Check automatici su PR
- Validazione convenzioni
- Report violazioni

## Documentazione

### 1. Struttura
- Documentazione per modulo
- Esempi di utilizzo
- Best practices

### 2. Aggiornamento
- Mantenere aggiornata
- Includere nuovi casi
- Documentare eccezioni

## Note Importanti
- Queste convenzioni sono vincolanti
- Le violazioni verranno segnalate
- Mantenere la coerenza è fondamentale
- Consultare prima di deviare 
