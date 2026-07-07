# Regole per le Risorse Filament in

## Panoramica

Questo documento definisce le regole fondamentali per l'implementazione delle risorse Filament nel progetto . Seguire queste linee guida è essenziale per garantire coerenza, manutenibilità e prestazioni ottimali dell'applicazione.

## Estensione di XotBaseResource

Tutte le risorse Filament in  **DEVONO** estendere `Modules\Xot\Filament\Resources\XotBaseResource` invece di `Filament\Resources\Resource`. Questa classe base personalizzata fornisce funzionalità specifiche per il progetto e garantisce coerenza in tutta l'applicazione.
# Regole per le Risorse Filament in <nome progetto>

## Panoramica

Questo documento definisce le regole fondamentali per l'implementazione delle risorse Filament nel progetto <nome progetto>. Seguire queste linee guida è essenziale per garantire coerenza, manutenibilità e prestazioni ottimali dell'applicazione.

## Estensione di XotBaseResource

Tutte le risorse Filament in <nome progetto> **DEVONO** estendere `Modules\Xot\Filament\Resources\XotBaseResource` invece di `Filament\Resources\Resource`. Questa classe base personalizzata fornisce funzionalità specifiche per il progetto e garantisce coerenza in tutta l'applicazione.

```php
// ✅ CORRETTO
use Modules\Xot\Filament\Resources\XotBaseResource;

class DoctorResource extends XotBaseResource
{
    // ...
}

// ❌ ERRATO
use Filament\Resources\Resource;

class DoctorResource extends Resource
{
    // ...
}
```

## Proprietà e Metodi da NON Dichiarare

Le classi che estendono `XotBaseResource` **NON DEVONO** dichiarare le seguenti proprietà e metodi, poiché sono già gestiti dalla classe base o non sono consentiti per garantire coerenza architetturale:

### Proprietà di Navigazione

```php
// ❌ NON DICHIARARE QUESTE PROPRIETÀ
protected static ?string $navigationIcon = 'heroicon-o-users';
protected static ?string $navigationGroup = 'Utenti';
protected static ?string $navigationSort = 1;
protected static ?string $translationPrefix = 'module::resource';
```

### Metodi di Navigazione

```php
// ❌ NON DICHIARARE QUESTI METODI
public static function getNavigationLabel(): string
public static function getPluralModelLabel(): string
public static function getModelLabel(): string
```

### Metodi di Tabella

```php
// ❌ NON DICHIARARE QUESTI METODI
public static function table(Table $table): Table
public static function getListTableColumns(): array
```

## Cosa Dichiarare

Le classi che estendono `XotBaseResource` **DEVONO** dichiarare solo:

```php
// ✅ DICHIARARE SOLO QUESTE PROPRIETÀ/METODI
protected static ?string $model = YourModel::class;

public static function getFormSchema(): array
{
    return [
        'field_name' => Forms\Components\TextInput::make('field_name'),
        // Altri campi...
    ];
}
```

## Traduzioni e Etichette

**NON** utilizzare mai il metodo `->label()` nei componenti Filament. Le etichette sono gestite automaticamente dal `LangServiceProvider` utilizzando i file di traduzione.

```php
// ❌ ERRATO
Forms\Components\TextInput::make('first_name')
    ->label('Nome')

// ✅ CORRETTO
Forms\Components\TextInput::make('first_name')
    // L'etichetta sarà recuperata automaticamente dal file di traduzione
```

## Namespace di Traduzione

**NON** utilizzare la proprietà `$translationPrefix` nelle classi che estendono `XotBaseResource`. Utilizzare invece direttamente il namespace di traduzione:

```php
// ❌ ERRATO
$prefix = static::$translationPrefix;
__("{$prefix}.field_name")

// ✅ CORRETTO
__('module::resource.field_name')
```

## Relazioni

Se il metodo `getRelations()` restituisce un array vuoto, **NON** dichiararlo:

```php
// ❌ ERRATO
public static function getRelations(): array
{
    return [];
}

// ✅ CORRETTO
// Non dichiarare il metodo se restituisce un array vuoto
```

## Pagine (`getPages()`)

**Non dichiarare** `getPages()` quando:

1. Servono solo le route CRUD `index`, `create`, `edit` (nessuna `view` né pagina custom).
2. Le classi Page seguono la convenzione auto-discovery di `XotBaseResource`:
   - `List{plural}` dove `plural = Str::plural(nomeResourceSenzaSuffissoResource)`
   - `Create{nome}`, `Edit{nome}`

```php
// ❌ ERRATO — ridondante se le Page sono ListCoeffs, CreateCoeff, EditCoeff
public static function getPages(): array
{
    return [
        'index' => Pages\ListCoeffs::route('/'),
        'create' => Pages\CreateCoeff::route('/create'),
        'edit' => Pages\EditCoeff::route('/{record}/edit'),
    ];
}

// ✅ CORRETTO — delega alla base
// (nessun metodo getPages() nella Resource)
```

**Mantenere** `getPages()` se le Page hanno nomi diversi (es. `ListAssenza` per `AssenzeResource`), se c'è `view` esplicita, o pagine custom.

Documentazione: [filament/getpages-redundancy-rule.md](./filament/getpages-redundancy-rule.md) · Script: `bashscripts/filament/analyze-redundant-getpages.php`

## Motivazioni

1. **Centralizzazione della Configurazione**: Le configurazioni comuni sono centralizzate nella classe base
2. **Manutenibilità**: Riduce la duplicazione del codice e semplifica gli aggiornamenti
3. **Coerenza**: Garantisce un'esperienza utente coerente in tutta l'applicazione
4. **Localizzazione**: Facilita la gestione delle traduzioni
5. **Prestazioni**: Riduce il carico di memoria evitando la duplicazione di codice

## Esempio Completo

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Filament\Resources;

use Filament\Forms;
use Modules\Patient\Models\Doctor;
use Modules\Xot\Filament\Resources\XotBaseResource;

class DoctorResource extends XotBaseResource
{
    protected static ?string $model = Doctor::class;

    public static function getFormSchema(): array
    {
        return [
            'first_name' => Forms\Components\TextInput::make('first_name')
                ->required()
                ->maxLength(255),

            'last_name' => Forms\Components\TextInput::make('last_name')
                ->required()
                ->maxLength(255),

            'email' => Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
        ];
    }
}
```

## Documentazione Correlata

- [getpages-redundancy-rule.md](./filament/getpages-redundancy-rule.md)
- [xotbaseresource.md](./filament/xotbaseresource.md)
- [forbidden-methods.md](./filament/resources/architecture/forbidden-methods.md)
- [consolidated/filament/resources/xot-base-resource.md](./consolidated/filament/resources/xot-base-resource.md)
