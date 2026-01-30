# Regole per l'Estensione di XotBaseResource

## Panoramica

In <nome progetto>, tutte le classi Resource di Filament devono estendere `Modules\Xot\Filament\Resources\XotBaseResource` e non direttamente `Filament\Resources\Resource`. Questo documento definisce le regole da seguire quando si estende `XotBaseResource`.

> **IMPORTANTE**: Questo documento è collegato alla documentazione ufficiale nel modulo Xot. Per informazioni più dettagliate, consultare:
> - [XotBaseResource.md](/var/www/html/<nome progetto>/laravel/Modules/Xot/docs/XotBaseResource.md)
> - [FILAMENT-BEST-PRACTICES.md](/var/www/html/<nome progetto>/laravel/Modules/Xot/docs/FILAMENT-BEST-PRACTICES.md)

## Regole Fondamentali

### Proprietà e Metodi da NON Definire

Quando si estende `XotBaseResource`, **NON** definire le seguenti proprietà e metodi:

1. **NON definire** `protected static ?string $navigationIcon`
   - Questa proprietà è gestita automaticamente da `XotBaseResource`

2. **NON definire** `protected static ?string $navigationGroup`
   - Questa proprietà è gestita automaticamente da `XotBaseResource`

3. **NON definire** `protected static ?int $navigationSort`
   - Questa proprietà è gestita automaticamente da `XotBaseResource`

4. **NON definire** `public static function getTableColumns()`
   - Utilizzare invece `getListTableColumns()` definito in `XotBaseResource`

5. **NON definire** `public static function getRelations()`
   - Se restituisce un array vuoto, non definirlo affatto

6. **NON definire** `public static function getPages()`
   - Se restituisce solo le route standard (index, create, edit), non definirlo affatto

### Esempio Errato

```php
// ❌ NON FARE
use Modules\Xot\Filament\Resources\XotBaseResource;

class DoctorResource extends XotBaseResource
{
    protected static ?string $navigationIcon = 'heroicon-o-user'; // ERRORE: non definire

    protected static ?string $navigationGroup = 'Pazienti'; // ERRORE: non definire

    protected static ?int $navigationSort = 3; // ERRORE: non definire

    public static function getRelations(): array
    {
        return []; // ERRORE: se vuoto, non definire
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ]; // ERRORE: se standard, non definire
    }

    public static function getTableColumns(): array
    {
        // ERRORE: utilizzare getListTableColumns() invece
    }
}
```

### Esempio Corretto

```php
// ✅ CORRETTO
use Modules\Xot\Filament\Resources\XotBaseResource;

class DoctorResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required(),
            'email' => Forms\Components\TextInput::make('email')
                ->email()
                ->required(),
        ];
    }

    public static function getListTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id'),
            'name' => Tables\Columns\TextColumn::make('name'),
            'email' => Tables\Columns\TextColumn::make('email'),
        ];
    }
}
```

## Metodi da Utilizzare

Quando si estende `XotBaseResource`, utilizzare i seguenti metodi:

1. **Utilizzare** `getFormSchema()` per definire lo schema del form
   - Restituire un array associativo con chiavi stringhe

2. **Utilizzare** `getListTableColumns()` per definire le colonne della tabella
   - Restituire un array associativo con chiavi stringhe

3. **Utilizzare** `getRelations()` solo se ci sono relazioni da definire
   - Non definire se restituisce un array vuoto

4. **Utilizzare** `getPages()` solo se si vogliono definire pagine personalizzate
   - Non definire se si utilizzano solo le route standard

## Conclusione

Seguire queste regole è fondamentale per mantenere la coerenza e la manutenibilità del codice in <nome progetto>. La classe `XotBaseResource` fornisce funzionalità personalizzate e comportamenti specifici per il progetto che sono essenziali per il corretto funzionamento dell'applicazione.
