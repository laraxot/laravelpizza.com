# Filament Resources

## XotBaseResource

Quando si estende `XotBaseResource`, è necessario seguire alcune convenzioni specifiche:

### Cosa NON Includere
- ❌ NON includere `protected static ?string $navigationIcon`
- ❌ NON includere `protected static ?string $navigationGroup`
- ❌ NON includere `protected static ?string $navigationLabel`
- ❌ NON includere il metodo `getRelations()` se restituisce un array vuoto

### Form Schema
Il metodo `getFormSchema()` deve restituire un array associativo con le seguenti caratteristiche:

```php
public static function getFormSchema(): array
{
    return [
        'field_name' => Forms\Components\TextInput::make('field_name')
            ->required()
            ->maxLength(255),
        // altri campi...
    ];
}
```

Caratteristiche importanti:
- Le chiavi dell'array devono essere stringhe
- Le chiavi devono corrispondere ai nomi dei campi
- I valori devono essere componenti Filament
- NON usare array numerici o indici senza chiavi

### Esempio di Errore
```php
// ❌ NON FARE QUESTO
public static function getFormSchema(): array
{
    return [
        Forms\Components\TextInput::make('title'),  // Senza chiave stringa
        Forms\Components\TextInput::make('surname'), // Senza chiave stringa
    ];
}

// ✅ FARE QUESTO
public static function getFormSchema(): array
{
    return [
        'title' => Forms\Components\TextInput::make('title'),
        'surname' => Forms\Components\TextInput::make('surname'),
    ];
}
```

### Differenze con Resource Standard
- Non usare il metodo `form(Form $form): Form`
- Usare `getFormSchema(): array` invece
- Non utilizzare il builder di Filament (`$form->schema()`)
- Restituire direttamente l'array associativo

### Errori Comuni
1. **Errore: Cannot override final method**
   ```php
   // ❌ NON FARE QUESTO
   public static function form(Form $form): Form
   {
       return $form->schema(static::getFormSchema());
   }
   ```
   
   Il metodo `form()` è dichiarato come `final` nella classe base `XotBaseResource` e non può essere sovrascritto. Usare solo `getFormSchema()`.

2. **Errore: Undefined type**
   - Assicurarsi che i namespace delle classi delle pagine siano corretti
   - Verificare che le classi delle pagine esistano nella directory corretta
   - Importare correttamente le classi delle pagine

### Esempio Completo
```php
class PatientResource extends XotBaseResource
{
    protected static ?string $model = Patient::class;
    
    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            'surname' => Forms\Components\TextInput::make('surname')
                ->required()
                ->maxLength(255),
            // altri campi...
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
``` 
## Collegamenti tra versioni di filament-resources.md
* [filament-resources.md](docs/tecnico/filament/filament-resources.md)
* [filament-resources.md](docs/regole/filament-resources.md)
* [filament-resources.md](laravel/Modules/Gdpr/docs/filament-resources.md)
* [filament-resources.md](laravel/Modules/Xot/docs/filament-resources.md)
* [filament-resources.md](laravel/Modules/Cms/docs/filament-resources.md)

