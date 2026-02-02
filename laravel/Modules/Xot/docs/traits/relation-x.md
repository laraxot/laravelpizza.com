# RelationX Trait

## Scopo Business
Fornisce metodi estesi per gestire relazioni Eloquent complesse, supportando:
- Relazioni many-to-many cross-database
- Relazioni polimorfiche avanzate
- Auto-detection di pivot tables e campi
- Gestione automatica di timestamps e fillable fields

## Metodi Principali

### belongsToManyX()
Versione estesa di `belongsToMany` che:
- Auto-rileva la pivot table tramite `guessPivot($related)` (nome da basename dei due modelli, es. Event+User → EventUser) oppure, se passi il secondo argomento (nome tabella), tramite `guessPivotFromTable($table)` (classe pivot = Studly del nome tabella nello stesso namespace del modello, es. `event_performer` → `EventPerformer`).
- Supporta relazioni cross-database
- Auto-configura `withPivot()` con i campi fillable della pivot
- Aggiunge automaticamente timestamps e `using(Pivot::class)`

**Regola critica**: nei modelli Laraxot usare **sempre** `belongsToManyX()` e **mai** `belongsToMany()` per relazioni many-to-many. Vedi `.cursor/rules/belongstomanyx-critical.md`.

**Business Logic:**
- Rileva automaticamente il modello pivot appropriato
- Gestisce connessioni database diverse tra entità correlate
- Configura automaticamente tutti i campi pivot necessari

### morphToManyX()
Versione estesa di `morphToMany` con le stesse funzionalità di `belongsToManyX` per relazioni polimorfiche.

## Vantaggi per la Business Logic
1. **Auto-configurazione**: Riduce errori di configurazione manuale
2. **Cross-database support**: Supporta architetture multi-database
3. **Type safety**: Utilizza strict types e validazione con Assert
4. **Flessibilità**: Supporta sia relazioni standard che polimorfiche

## Utilizzo nei Moduli
Questo trait è utilizzato nei modelli base di tutti i moduli per standardizzare le relazioni complesse e garantire coerenza nell'accesso ai dati.