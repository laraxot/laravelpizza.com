# Regole per Risorse Filament

## Regola Fondamentale

Tutte le risorse Filament devono estendere `XotBaseResource` e seguire le convenzioni stabilite.

## Estensione Corretta

### ✅ FARE QUESTO

```php
namespace Modules\Notify\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class NotificationTemplateResource extends XotBaseResource
{
    protected static ?string $model = NotificationTemplate::class;

    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }
}
```

### ❌ NON FARE QUESTO

```php
use Filament\Resources\Resource;

class NotificationTemplateResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        // NON sovrascrivere form() perché è final
    }
}
```

## Metodi e Proprietà

### Metodi Final
- ❌ NON sovrascrivere `form()`
- ❌ NON sovrascrivere altri metodi marcati come `final`
- ✅ Implementare `getFormSchema()` invece di sovrascrivere `form()`

### Table Actions
- ❌ NON definire `getTableActions()` se restituisce solo azioni standard
- ✅ Se presente, includere `...parent::getTableActions()`
- ❌ NON definire `getTableBulkActions()` se restituisce solo DeleteBulkAction

### Proprietà
- ❌ NON definire `$navigationIcon`
- ❌ NON definire `$navigationGroup`
- ❌ NON definire `$navigationSort`
- ✅ SEMPRE definire `protected static ?string $model`

## Label e Traduzioni

### ❌ NON FARE QUESTO
```php
Forms\Components\TextInput::make('name')
    ->label('Nome')
```

### ✅ FARE QUESTO
```php
Forms\Components\TextInput::make('name')
// Le label sono gestite via file di traduzione
```

## Best Practices

1. **Estensione**
   - Estendere sempre `XotBaseResource`
   - Non sovrascrivere metodi `final`
   - Implementare i metodi astratti richiesti

2. **Form Schema**
   - Definire lo schema nel metodo `getFormSchema()`
   - Organizzare i campi in modo logico
   - Utilizzare i componenti appropriati

3. **Table Actions**
   - Rimuovere override non necessari
   - Includere le azioni del genitore
   - Aggiungere solo azioni personalizzate

4. **Traduzioni**
   - Utilizzare file di traduzione
   - Non usare `->label()` direttamente
   - Mantenere coerenza nelle traduzioni

## Collegamenti Bidirezionali

### Collegamenti nella Root
- [Architettura Filament](../architecture/filament.md)
- [Gestione Risorse](../architecture/resources.md)

### Collegamenti ai Moduli
- [XotBaseResource](../../laravel/Modules/Xot/docs/XotBaseResource.md)
- [Notify Resource](../../laravel/Modules/Notify/docs/filament-resources.md)

## Note Importanti

1. Non sovrascrivere mai metodi `final`
2. Utilizzare sempre i file di traduzione
3. Evitare override non necessari
4. Mantenere la documentazione aggiornata
5. Seguire le convenzioni di Filament

## Checklist di Validazione
- Verificare che tutte le risorse siano registrate nel service provider
- Controllare che i modelli referenziati esistano
- Assicurarsi che le pagine CRUD siano implementate
- Verificare i permessi e le policy

## Collegamenti tra versioni di filament-resources.md
- [filament-resources.md](docs/tecnico/filament/filament-resources.md)
- [filament-resources.md](docs/regole/filament-resources.md)
- [filament-resources.md](laravel/Modules/Gdpr/docs/filament-resources.md)
- [filament-resources.md](laravel/Modules/Xot/docs/filament-resources.md)
- [filament-resources.md](laravel/Modules/Cms/docs/filament-resources.md)
- [Gestione build assets Chart](../../laravel/Modules/Chart/docs/README.md)

### Nota architetturale
Ogni modulo deve documentare le proprie scelte di build asset e output nella rispettiva documentazione locale, con riferimento a questa regola centrale. La configurazione degli asset per i moduli (es. Chart) deve garantire autonomia, evitare conflitti con la root e facilitare la manutenzione.
