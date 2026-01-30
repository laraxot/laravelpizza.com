# Risoluzione Conflitti ConvertVideoByMediaConvertAction.php

## Contesto del Conflitto
**File**: `/var/www/html/ptvx/laravel/Modules/Media/app/Actions/Video/ConvertVideoByMediaConvertAction.php`
**Linee**: 49-53
**Tipo**: Conflitto di annotazione PHPStan

## Descrizione del Conflitto
Il conflitto riguarda l'annotazione PHPStan per sopprimere un warning relativo al metodo FFMpeg:

### Versione HEAD
```php
// @phpstan-ignore method.notFound
FFMpeg::fromDisk($data->disk)
```

### Versione Branch
```php
// @phpstan-ignore-next-line
FFMpeg::fromDisk($data->disk)
```

## Analisi delle Differenze
- **HEAD**: Usa `@phpstan-ignore method.notFound` (annotazione specifica per il tipo di errore)
- **Branch**: Usa `@phpstan-ignore-next-line` (annotazione generica per tutta la linea)

## Strategia di Risoluzione: Mantenere Versione HEAD

### Motivazione
1. **Precisione dell'annotazione**: `method.notFound` è più specifico e preciso del generico `next-line`
2. **Best practice PHPStan**: Le annotazioni specifiche sono preferibili a quelle generiche
3. **Manutenibilità**: L'annotazione specifica rende più chiaro quale tipo di errore viene soppresso
4. **Coerenza con progetto**: Il progetto Laraxot PTVX preferisce annotazioni PHPStan specifiche
5. **Debugging**: In caso di problemi, è più facile capire cosa viene ignorato

### Vantaggi della Versione HEAD
- Annotazione più precisa e mirata
- Migliore documentazione del codice
- Facilita la manutenzione futura
- Coerente con le best practice PHPStan

### Implementazione
Rimuovere i marker di conflitto mantenendo la versione HEAD con l'annotazione specifica `@phpstan-ignore method.notFound`.

## Codice Finale
```php
// @phpstan-ignore method.notFound
FFMpeg::fromDisk($data->disk)
    ->open($data->file)
    ->export()
    ->onProgress(function (float $percentage, float $remaining, float $rate) use ($record): void {
        $record->update([
            'percentage' => $percentage,
            'remaining' => $remaining,
            'rate' => $rate,
        ]);
    })
    ->addFilter('-preset', 'ultrafast')
```

## Note Tecniche
- Il metodo `FFMpeg::fromDisk()` potrebbe non essere riconosciuto da PHPStan a causa di dynamic method calls
- L'annotazione specifica `method.notFound` è la soluzione più appropriata
- Nessun impatto sulla funzionalità, solo miglioramento della qualità del codice

## Pattern Identificato
**Pattern**: Preferire annotazioni PHPStan specifiche (`method.notFound`, `property.nonObject`, ecc.) invece di annotazioni generiche (`@phpstan-ignore-next-line`)

**Anti-pattern**: Uso di annotazioni generiche quando sono disponibili annotazioni specifiche

## Collegamenti
- [Media Module Documentation](module_media.md)
- [FFMpeg Integration Guide](ffmpeg_integration.md)
- [PHPStan Fixes Documentation](phpstan_fixes.md)
- [Root Conflict Resolution Guidelines](../../../docs/conflict-resolution-guidelines.md)

*Ultimo aggiornamento: giugno 2025*
