# Errore di incompatibilità tra metodi statici e di istanza in Filament

## Problema

Quando si estendono le classi di Filament, è fondamentale mantenere la stessa modalità di dichiarazione dei metodi (statico o di istanza) della classe base. Un errore comune è dichiarare un metodo come `static` in una classe derivata, mentre nella classe base è un metodo di istanza.

Esempio di errore:
```
Cannot make non static method Filament\Resources\Pages\ListRecords::getTableColumns() static in class ModulesActivity\Filament\Resources\ActivityResource\Pages\ListActivities
```

## Causa

Il problema è una violazione del principio di sostituzione di Liskov (LSP). In PHP, quando si sovrascrive un metodo, la firma del metodo deve essere compatibile con quella del metodo nella classe base.

In particolare:
1. Un metodo statico nella classe base deve rimanere statico nella classe derivata
2. Un metodo di istanza nella classe base deve rimanere un metodo di istanza nella classe derivata

## Soluzione

### 1. Correggere la dichiarazione del metodo

Per risolvere l'errore, modifica la dichiarazione del metodo nella classe derivata per corrispondere alla modalità della classe base:

```php
// ERRATO ❌
public static function getTableColumns(): array
{
    // ...
}

// CORRETTO ✅
public function getTableColumns(): array
{
    // ...
}
```

### 2. Verificare la documentazione ufficiale

Prima di implementare metodi personalizzati, verifica sempre la documentazione ufficiale di Filament per capire se un metodo dovrebbe essere statico o di istanza:
- [Filament Tables Documentation](https://filamentphp.com/docs/3.x/tables/columns/getting-started)
- [Filament Resources Documentation](https://filamentphp.com/docs/3.x/panels/resources/getting-started)

### 3. Se hai bisogno di funzionalità statiche

Se hai bisogno di funzionalità accessibili staticamente, crea un nuovo metodo con un nome diverso invece di sovrascrivere un metodo esistente:

```php
// Metodo statico personalizzato con nome diverso
public static function getCustomColumns(): array
{
    // ...
}

// Metodo di istanza che sovrascrive il metodo della classe base
public function getTableColumns(): array
{
    return static::getCustomColumns();
}
```

## Casi comuni di errore

### ListRecords

I seguenti metodi sono metodi di istanza in `Filament\Resources\Pages\ListRecords`:
- `getTableColumns()`
- `getTableFilters()`
- `getTableRecordsPerPageSelectOptions()`
- `getTableBulkActions()`

### RelationManagers

I seguenti metodi sono metodi di istanza in `Filament\Resources\RelationManagers\RelationManager`:
- `getTableColumns()`
- `getTableFilters()`
- `getTableHeaderActions()`
- `getTableBulkActions()`

### Problema con overriding in XotBaseListRecords

Se stai estendendo `XotBaseListRecords` o altre classi personalizzate, verifica sempre che i metodi nella classe base non siano stati dichiarati in modo incompatibile con quelli di Filament.

### EditRecord / CreateRecord

I seguenti metodi sono metodi di istanza in `Filament\Resources\Pages\EditRecord` e `CreateRecord`:
- `getFormSchema()`
- `getFormStatePath()`
- `getForms()`

## Risorse correlate

- [Filament GitHub Repository](https://github.com/filamentphp/filament)
- [PHP: Visibilità dei metodi](https://www.php.net/manual/en/language.oop5.visibility.php)
- [Principio di sostituzione di Liskov](https://en.wikipedia.org/wiki/Liskov_substitution_principle)
