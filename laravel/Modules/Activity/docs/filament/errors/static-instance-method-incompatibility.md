# Incompatibilità tra metodi statici e di istanza in Filament

> **NOTA IMPORTANTE**: Questo documento è un riferimento specifico per il modulo Activity. 
> La documentazione principale e completa si trova nel [modulo UI](../../../UI/docs/filament/errors/static-instance-method-incompatibility.md).

## Errore incontrato

Nel file `Modules/Activity/app/Filament/Resources/ActivityResource/Pages/ListActivities.php` è stato rilevato il seguente errore:

```
Cannot make non static method Filament\Resources\Pages\ListRecords::getTableColumns() static in class Modules\Activity\Filament\Resources\ActivityResource\Pages\ListActivities
```

## Analisi dell'errore

L'errore si verifica perché il metodo `getTableColumns()` è dichiarato come statico nella classe `ListActivities`, mentre nella classe base `Filament\Resources\Pages\ListRecords` è un metodo di istanza.

```php
// File: Modules/Activity/app/Filament/Resources/ActivityResource/Pages/ListActivities.php
public static function getTableColumns(): array
{
    // ...
}
```

## Soluzione corretta

Per risolvere l'errore, il metodo deve essere modificato per corrispondere alla dichiarazione nella classe base:

```php
// Correzione
public function getTableColumns(): array
{
    // ...
}
```

Oppure utilizzare il metodo corretto che Filament si aspetta per questa personalizzazione:

```php 
// Approccio consigliato
protected function getTableColumns(): array
{
    // ...
}
```

## Altri errori simili da verificare nel modulo

Verificare se i seguenti metodi sono stati dichiarati correttamente:
- `getTableFilters()`
- `getTableBulkActions()`
- `getTableRecordsPerPageSelectOptions()`

Questi devono tutti essere metodi di istanza, non statici.

## Riferimenti

- [Principio di sostituzione di Liskov](../../../UI/docs/filament/errors/static-instance-method-incompatibility.md)
- [Documentazione ufficiale Filament](https://filamentphp.com/docs/3.x/tables/columns)
