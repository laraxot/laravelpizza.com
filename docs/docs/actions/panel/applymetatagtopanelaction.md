# ApplyMetatagToPanelAction

## Descrizione
Action responsabile dell'applicazione delle configurazioni metatag al pannello Filament.

## Metodi
### execute(Panel &$panel): Panel
Applica le configurazioni metatag al pannello Filament.

#### Parametri
- `$panel`: Panel - Riferimento al pannello Filament da configurare

#### Return
- `Panel` - Il pannello configurato

## Dipendenze
- [MetatagData](../../datas/metatagdata.md)

## Errori PHPStan Comuni
1. Chiamata al metodo inesistente `getColors()`
   - **Problema**: Il metodo viene chiamato su `MetatagData` ma non esiste
   - **Soluzione**: Sostituire con `getFilamentColors()`
   ```php
   // Errato
   ->colors($metatag->getColors())

   // Corretto
   ->colors($metatag->getFilamentColors())
   ```

## Note sulla Correzione
La correzione dell'errore PHPStan richiede la modifica del metodo chiamato da `getColors()` a `getFilamentColors()`. Questo metodo è specificamente progettato per restituire i colori nel formato richiesto da Filament.

## Collegamenti
- [MetatagData](../../datas/metatagdata.md)
- [Filament Best Practices](../../filament-best-practices.md)
- [PHPStan Common Exceptions](../../phpstan-common-exceptions.md)
- [Filament Best Practices](../../filament-best-practices.md)
- [PHPStan Common Exceptions](../../phpstan-common-exceptions.md)
