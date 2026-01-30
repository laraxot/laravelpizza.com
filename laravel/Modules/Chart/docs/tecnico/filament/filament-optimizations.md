# Ottimizzazioni Filament

## Regole per XotBaseResource

### Proprietà da Rimuovere
- `protected static ?string $navigationIcon` non deve essere definita se la classe estende `XotBaseResource`

### Metodi da Rimuovere
1. `getRelations()` se restituisce un array vuoto
2. `getPages()` se contiene solo le route standard:
   ```php
   return [
       'index' => Pages\ListRecords::route('/'),
       'create' => Pages\CreateRecord::route('/create'),
       'edit' => Pages\EditRecord::route('/{record}/edit'),
   ];
   ```

### Metodi da Ottimizzare
- `getFormSchema()` deve restituire un array associativo con chiavi di tipo stringa

## Regole per XotBaseListRecords

### Metodi da Rimuovere
- `Actions()` se restituisce solo `createAction`

### Metodi da Ottimizzare
- `getTableColumns()` deve restituire un array associativo con chiavi di tipo stringa

## Esempi di Ottimizzazione

### Prima
```php
class MyResource extends XotBaseResource
{
    protected static ?string $navigationIcon = 'heroicon-o-document';
    
    public static function getRelations(): array
    {
        return [];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecords::route('/'),
            'create' => Pages\CreateRecord::route('/create'),
            'edit' => Pages\EditRecord::route('/{record}/edit'),
        ];
    }

    public static function getFormSchema(): array
    {
        return [
            'title' => Forms\Components\TextInput::make('title'),
            'content' => Forms\Components\RichEditor::make('content'),
        ];
    }
}
```

### Dopo
```php
class MyResource extends XotBaseResource
{
    // Rimossi navigationIcon, getRelations e getPages
    
    public static function getFormSchema(): array
    {
        return [
            'title' => Forms\Components\TextInput::make('title'),
            'content' => Forms\Components\RichEditor::make('content'),
        ];
    }
}
```

### Prima
```php
class MyListRecords extends XotBaseListRecords
{
    public static function Actions(): array
    {
        return [
            createAction::make(),
        ];
    }
    
    public static function getTableColumns(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Nome',
        ];
    }
}
```

### Dopo
```php
class MyListRecords extends XotBaseListRecords
{
    // Rimosso Actions
    
    public static function getTableColumns(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Nome',
        ];
    }
} 