# Filament in il progetto

## Panoramica

Filament è il framework di amministrazione utilizzato in il progetto per creare interfacce di gestione potenti e intuitive. Questa documentazione descrive l'implementazione e le best practices per l'utilizzo di Filament nel contesto del progetto.

## Regole Fondamentali

### Traduzioni e Localizzazione

- **MAI utilizzare** il metodo `->label()` nei componenti Filament
- Le etichette sono gestite automaticamente dal `LangServiceProvider`
- L'uso di `->label()` interferisce con il meccanismo di traduzione automatica
- Utilizzare i file di traduzione seguendo la struttura espansa (vedi sezione Traduzioni)

## XotBaseResource

Quando si estende `XotBaseResource`, seguire queste linee guida:

- **Non definire** `navigationIcon` se la classe estende `XotBaseResource`
- **Rimuovere** `getRelations()` se restituisce array vuoto
- **Rimuovere** `getPages()` se contiene solo route standard
- `getFormSchema()` deve restituire array associativo con chiavi stringhe

### Esempio Corretto

```php
// ✅ Implementazione corretta
class PatientResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            'first_name' => Forms\Components\TextInput::make('first_name')
                ->required()
                ->maxLength(255),
            'last_name' => Forms\Components\TextInput::make('last_name')
                ->required()
                ->maxLength(255),
            'birth_date' => Forms\Components\DatePicker::make('birth_date'),
        ];
    }
}
```

### Esempio da Evitare

```php
// ❌ Implementazione da evitare
class PatientResource extends XotBaseResource
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    
    public static function getRelations(): array
    {
        return [];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('first_name'),
            Forms\Components\TextInput::make('last_name'),
            Forms\Components\DatePicker::make('birth_date'),
        ];
    }
}
```

## XotBaseListRecords

Quando si estende `XotBaseListRecords`, seguire queste linee guida:

- **Rimuovere** `Actions()` se restituisce solo `createAction`
- `getListTableColumns()` deve restituire array associativo con chiavi stringhe

### Esempio Corretto

```php
// ✅ Implementazione corretta
class ListPatients extends XotBaseListRecords
{
    public function getListTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->sortable(),
            'first_name' => Tables\Columns\TextColumn::make('first_name')
                ->searchable(),
            'last_name' => Tables\Columns\TextColumn::make('last_name')
                ->searchable(),
        ];
    }
}
```

## Ottimizzazioni per Filament

### Caricamento Lazy delle Risorse

Per migliorare le prestazioni, implementare il caricamento lazy delle risorse:

```php
// config/filament.php
return [
    'resources' => [
        'register' => false,
    ],
];
```

### Riduzione del Payload JavaScript

Minimizzare il JavaScript caricato utilizzando solo i componenti necessari:

```php
// ✅ Caricamento selettivo dei componenti
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

// ❌ Evitare import generici
// use Filament\Forms\Components\*;
```

### Cache delle Viste

Abilitare la cache delle viste in produzione:

```bash
php artisan view:cache
```

## Integrazione con Moduli Laraxot

Per integrare Filament con i moduli Laraxot:

1. **Registrazione delle risorse** nei service provider dei moduli:

```php
// Modules/Patient/app/Providers/PatientServiceProvider.php
public function boot(): void
{
    Filament::registerResources([
        Resources\PatientResource::class,
    ]);
}
```

2. **Estensione dei componenti base** forniti dal modulo Xot:

```php
// Modules/Patient/app/Filament/Resources/PatientResource.php
namespace Modules\Patient\app\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class PatientResource extends XotBaseResource
{
    // ...
}
```

## Filosofia di Utilizzo

1. **Semplicità**: Preferire soluzioni semplici e dirette
2. **Consistenza**: Mantenere un'interfaccia coerente in tutta l'applicazione
3. **Accessibilità**: Garantire che l'interfaccia sia accessibile a tutti gli utenti
4. **Performance**: Ottimizzare per velocità e reattività
5. **Manutenibilità**: Scrivere codice chiaro e ben documentato

## Collegamenti tra versioni di filament.md
* [filament.md](docs/tecnico/filament/filament.md)
* [filament.md](../../../Chart/docs/filament.md)
* [filament.md](../../../Gdpr/docs/filament.md)
* [filament.md](../../../Xot/docs/technical/filament.md)
* [filament.md](../../../Xot/docs/roadmap/integration/filament.md)
* [filament.md](../../../Lang/docs/filament.md)
* [filament.md](../../../Job/docs/filament.md)
* [filament.md](../../../Activity/docs/filament.md)
* [filament.md](../../../Cms/docs/filament.md)

