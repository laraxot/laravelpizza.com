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
- [MetatagData](../../datas/MetatagData.md)

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
- [MetatagData](../../datas/MetatagData.md)
- [Filament Best Practices](../../filament-best-practices.md)
- [PHPStan Common Exceptions](../../PHPSTAN-COMMON-EXCEPTIONS.md) 
- [Filament Best Practices](../../FILAMENT-BEST-PRACTICES.md)
- [PHPStan Common Exceptions](../../PHPSTAN-COMMON-EXCEPTIONS.md) 
