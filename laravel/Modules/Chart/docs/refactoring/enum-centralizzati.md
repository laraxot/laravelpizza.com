# Centralizzazione degli Enum nel Sistema <nome progetto>

## Panoramica

Per migliorare la riusabilità del codice e mantenere una struttura coerente, abbiamo deciso di centralizzare gli enum comuni nel modulo `Xot`. Questo documento descrive il processo di centralizzazione e i vantaggi che ne derivano.

## Motivazione

Gli enum sono componenti ideali per la centralizzazione perché:

1. **Rappresentano concetti comuni**: Molti enum (come giorni della settimana, mesi, stati) sono utilizzati in diversi moduli
2. **Hanno una struttura stabile**: Raramente cambiano nel tempo
3. **Sono facilmente riutilizzabili**: Possono essere importati e utilizzati in qualsiasi modulo
4. **Riducono la duplicazione del codice**: Evitano implementazioni multiple dello stesso concetto

## Processo di Centralizzazione

### 1. Identificazione degli Enum Comuni

Abbiamo identificato i seguenti enum come candidati per la centralizzazione:

- `DayOfWeek`: Rappresenta i giorni della settimana
- `MonthOfYear`: Rappresenta i mesi dell'anno
- `TimeUnit`: Rappresenta le unità di tempo (secondi, minuti, ore, giorni, settimane, mesi, anni)
- `Status`: Rappresenta gli stati comuni (attivo, inattivo, in attesa, ecc.)

### 2. Implementazione nel Modulo Xot

Gli enum comuni sono stati implementati nel namespace `\Modules\Xot\Enums\`. Ogni enum include:

- Casi ben definiti
- Metodi di utilità (come `label()`, `toArray()`, ecc.)
- Documentazione completa

### 3. Aggiornamento dei Riferimenti

Tutti i riferimenti agli enum specifici dei moduli sono stati aggiornati per utilizzare gli enum centralizzati. Ad esempio:

```php
// Prima
use Modules\Patient\Enums\DayOfWeek;

// Dopo
use Modules\Xot\Enums\DayOfWeek;
```

### 4. Rimozione degli Enum Duplicati

Dopo aver aggiornato tutti i riferimenti, gli enum duplicati sono stati rimossi dai moduli specifici.

## Vantaggi della Centralizzazione

La centralizzazione degli enum offre numerosi vantaggi:

1. **Coerenza**: Garantisce che tutti i moduli utilizzino la stessa definizione per concetti comuni
2. **Manutenibilità**: Le modifiche devono essere apportate in un solo punto
3. **Riusabilità**: Gli enum possono essere facilmente utilizzati in qualsiasi modulo
4. **Riduzione della duplicazione**: Elimina il codice duplicato
5. **Documentazione centralizzata**: Semplifica la documentazione e l'apprendimento

## Enum Centralizzati

### DayOfWeek

L'enum `DayOfWeek` è stato spostato da `\Modules\Patient\Enums\DayOfWeek` a `\Modules\Xot\Enums\DayOfWeek`.

**Caratteristiche principali**:
- Rappresenta i giorni della settimana come valori interi (1-7)
- Fornisce metodi per la localizzazione (`label()`, `shortLabel()`)
- Include metodi per identificare giorni lavorativi e weekend
- Supporta la navigazione tra giorni (`next()`)

**Utilizzo**:
```php
use Modules\Xot\Enums\DayOfWeek;

// In un form Filament
Forms\Components\Select::make('day')
    ->options(DayOfWeek::toArray())
    ->enum(DayOfWeek::class)
    ->required();

// Verificare se un giorno è nel weekend
if ($dayOfWeek->isWeekend()) {
    // Logica per i giorni del weekend
}

// Ottenere tutti i giorni lavorativi
$workingDays = DayOfWeek::workingDays();
```

## Conclusione

La centralizzazione degli enum è un passo importante verso un'architettura più coerente e manutenibile. Continueremo a identificare e centralizzare altri componenti comuni per migliorare ulteriormente la qualità del codice nel sistema <nome progetto>.

## Riferimenti

- [Documentazione degli Enum Comuni](../enums/common-enums.md)
- [Best Practices per gli Enum in PHP](../best-practices/php-enums.md)
