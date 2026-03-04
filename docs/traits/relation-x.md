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
- Auto-rileva la pivot table tramite `guessPivot()`
- Supporta relazioni cross-database
- Auto-configura `withPivot()` con i campi fillable
- Aggiunge automaticamente timestamps

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