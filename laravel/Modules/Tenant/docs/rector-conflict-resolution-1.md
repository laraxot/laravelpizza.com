# Risoluzione conflitto git su rector.php

## Problema
Sono presenti marker di conflitto git nel file `rector.php` del modulo Tenant. Le differenze riguardano principalmente:
- L'importazione di classi Rector e SetList
- La configurazione dei set di regole e funzioni di configurazione

## Analisi
- La versione più aggiornata e compatibile con Rector >= 0.13 prevede l'uso di `SetList` e `LaravelSetList`.
- Alcune versioni legacy fanno riferimento a `Rector\Core\Configuration\Option` e set obsoleti.
- La configurazione deve essere coerente con la struttura dei path e delle regole realmente supportate dal modulo e dalle dipendenze.

## Scelta
- Verrà mantenuta la versione che utilizza `SetList` e `LaravelSetList`, eliminando riferimenti legacy e duplicazioni.
- Verrà verificata la sintassi e la coerenza dopo la correzione.

## Collegamenti
- [Documentazione root risoluzione conflitti](../../../docs/risoluzione_conflitti_git.md#tenant-rectorphp)
