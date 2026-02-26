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

## Pagine

Se il metodo `getPages()` contiene solo le route standard (index, create, edit), **NON** dichiararlo:

```php
// ❌ ERRATO
public static function getPages(): array
{
    return [
        'index' => Pages\ListRecords::route('/'),
        'create' => Pages\CreateRecord::route('/create'),
        'edit' => Pages\EditRecord::route('/{record}/edit'),
    ];
}

// ✅ CORRETTO
// Non dichiarare il metodo se contiene solo le route standard
```

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

- [Filament Form Builder](/project_docs/filament-form-builder.md)
- [Gestione delle Traduzioni](/project_docs/translation-management.md)
- [Estensione delle Classi Filament](/project_docs/filament-extension-pattern.md)
