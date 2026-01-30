# Linee Guida per le Risorse Filament in <nome progetto>

## Panoramica

Questo documento fornisce una panoramica delle linee guida per l'implementazione delle risorse Filament nel progetto <nome progetto>. Per una documentazione più dettagliata, consultare il [documento completo nel modulo Xot](/laravel/Modules/Xot/docs/FILAMENT_RESOURCE_RULES.md).

## Principi Fondamentali

1. **Estensione di XotBaseResource**: Tutte le risorse Filament **DEVONO** estendere `Modules\Xot\Filament\Resources\XotBaseResource` invece di `Filament\Resources\Resource`.

2. **Proprietà e Metodi Vietati**: Le classi che estendono `XotBaseResource` **NON DEVONO** dichiarare:
   - `$navigationIcon`
   - `$navigationGroup`
   - `$navigationSort`
   - `$translationPrefix`
   - `getNavigationLabel()`
   - `getPluralModelLabel()`
   - `getModelLabel()`
   - `table(Table $table)`
   - `getListTableColumns()`

3. **Traduzioni**: **MAI** utilizzare il metodo `->label()` nei componenti Filament. Le etichette sono gestite automaticamente dal `LangServiceProvider`.

4. **Namespace di Traduzione**: **NON** utilizzare la proprietà `$translationPrefix`. Utilizzare invece direttamente il namespace di traduzione (es. `__('module::resource.field_name')`).

5. **Relazioni e Pagine**: Non dichiarare `getRelations()` se restituisce un array vuoto, né `getPages()` se contiene solo le route standard.

## Esempio Corretto

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

## Motivazioni

1. **Centralizzazione**: Le configurazioni comuni sono centralizzate nella classe base
2. **Manutenibilità**: Riduce la duplicazione del codice e semplifica gli aggiornamenti
3. **Coerenza**: Garantisce un'esperienza utente coerente in tutta l'applicazione
4. **Localizzazione**: Facilita la gestione delle traduzioni
5. **Prestazioni**: Riduce il carico di memoria evitando la duplicazione di codice

## Errori Comuni

1. **Dichiarazione di Proprietà di Navigazione**: Errore comune che può causare inconsistenze nell'interfaccia utente
2. **Uso di `->label()`**: Viola il sistema di traduzione centralizzato
3. **Uso di `$translationPrefix`**: Crea dipendenze non necessarie
4. **Dichiarazione di Metodi Standard**: Aumenta la complessità del codice senza aggiungere valore

## Documentazione Correlata

- [Regole Dettagliate per le Risorse Filament](/laravel/Modules/Xot/docs/FILAMENT_RESOURCE_RULES.md)
- [Filament Form Builder](/docs/filament-form-builder.md)
- [Gestione delle Traduzioni](/docs/translation-management.md)
- [Estensione delle Classi Filament](/docs/filament-extension-pattern.md)
