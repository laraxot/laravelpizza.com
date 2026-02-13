# Integrazione Spatie Translatable nel Modulo Notify

## Overview

Il modulo Notify usa il plugin **Lara Zeus Spatie Translatable** per supportare contenuti multilingua nelle risorse Filament.

## Versione

- **lara-zeus/spatie-translatable**: 1.0.4
- **Filament**: v4.x
- **Laravel**: v12.x

## Configurazione Panel

### Registrazione Plugin

Il plugin è registrato in `AdminPanelProvider`:

```php
// Modules/Notify/app/Providers/Filament/AdminPanelProvider.php

use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;

public function panel(Panel $panel): Panel
{
    $panel->plugins([
        SpatieTranslatablePlugin::make()
            ->defaultLocales(['it', 'en']),
    ]);
    
    return parent::panel($panel);
}
```

### Lingue Supportate

- **Italiano** (it) - predefinita
- **Inglese** (en)

## Risorse Traducibili

### MailTemplateResource

`MailTemplateResource` estende `LangBaseResource` che fornisce funzionalità multilingua.

#### Ereditarietà

```
MailTemplateResource
  └─> LangBaseResource (Modules/Lang)
       └─> trait Translatable
            └─> supporto multilingua
```

#### Page ListMailTemplates

```
ListMailTemplates
  └─> LangBaseListRecords (Modules/Lang)
       └─> trait Translatable
            └─> LocaleSwitcher in header actions
```

### Campi Traducibili

I seguenti campi di `MailTemplate` supportano traduzioni:

- `subject` - Oggetto dell'email
- `html_template` - Template HTML
- `text_template` - Template testo
- `sms_template` - Template SMS (opzionale)

## Modello MailTemplate

### Setup Traduzioni

```php
// Modules/Notify/app/Models/MailTemplate.php

use Spatie\Translatable\HasTranslations;

class MailTemplate extends BaseModel
{
    use HasTranslations;
    
    /**
     * Campi traducibili.
     *
     * @var list<string>
     */
    public array $translatable = [
        'subject',
        'html_template',
        'text_template',
        'sms_template',
    ];
}
```

### Struttura Dati Database

I campi traducibili sono salvati come JSON nel database:

```json
{
  "subject": {
    "it": "Benvenuto nel sistema",
    "en": "Welcome to the system"
  },
  "html_template": {
    "it": "<p>Ciao {{name}}</p>",
    "en": "<p>Hello {{name}}</p>"
  }
}
```

## Utilizzo nell'Interfaccia

### Locale Switcher

Nella pagina `ListMailTemplates`, l'utente può:
1. Vedere i template nella lingua corrente
2. Switchare lingua tramite `LocaleSwitcher` in header
3. Editare traduzioni per lingua selezionata

### Form Editing

Nel form di edit/create:
- I campi traducibili mostrano contenuto nella lingua attiva
- Il locale switcher permette di cambiare lingua al volo
- Le modifiche vengono salvate per la lingua selezionata

## Troubleshooting

### Errore: Plugin Not Registered

**Causa**: Plugin non registrato nel panel  
**Soluzione**: Vedere [plugin-spatie-translatable-not-registered.md](./errori/plugin-spatie-translatable-not-registered.md)

### Errore: Undefined Method `getTranslation()`

**Causa**: Modello non ha trait `HasTranslations`  
**Soluzione**: Aggiungere trait e proprietà `$translatable`

### Switcher Non Visibile

**Causa**: Page non usa trait `Translatable`  
**Soluzione**: Verificare che Page estenda `LangBaseListRecords`

## Pattern Architetturale

### LangBase* Classes (Modules/Lang)

Le classi `LangBase*` forniscono funzionalità multilingua riutilizzabili:

- `LangBaseResource` - Resource con trait Translatable
- `LangBaseListRecords` - ListRecords con LocaleSwitcher
- `LangBaseCreateRecord` - CreateRecord con supporto lingue
- `LangBaseEditRecord` - EditRecord con supporto lingue

### Quando Estendere LangBase

✅ **Estendere** se:
- Il modello ha campi traducibili
- Il panel ha il plugin registrato
- Serve gestire contenuti multilingua

❌ **NON estendere** se:
- Il modello non è traducibile
- Plugin non registrato nel panel
- Complessità non necessaria

## Best Practice

### 1. Registrazione Plugin

```php
// SEMPRE registrare in AdminPanelProvider
$panel->plugins([
    SpatieTranslatablePlugin::make()
        ->defaultLocales(config('app.available_locales', ['it', 'en']))
        ->persist(),  // Ricorda lingua selezionata
]);
```

### 2. Modello Traducibile

```php
use Spatie\Translatable\HasTranslations;

class MyModel extends BaseModel
{
    use HasTranslations;
    
    public array $translatable = ['field1', 'field2'];
}
```

### 3. Resource Configuration

```php
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;

class MyResource extends LangBaseResource
{
    use Translatable;  // Solo se il modello è traducibile!
    
    public static function getTranslatableLocales(): array
    {
        return ['it', 'en'];
    }
}
```

## Testing

### Test Funzionale

```php
// Modules/Notify/tests/Feature/Filament/Resources/MailTemplateResourceTest.php

use Livewire\Livewire;
use Modules\Notify\Filament\Resources\MailTemplateResource\Pages\ListMailTemplates;

test('locale switcher is visible', function () {
    Livewire::test(ListMailTemplates::class)
        ->assertActionExists('locale_switcher');
});

test('can switch locale', function () {
    Livewire::test(ListMailTemplates::class)
        ->callAction('locale_switcher', data: ['locale' => 'en'])
        ->assertSuccessful();
        
    expect(app()->getLocale())->toBe('en');
});
```

## Migration

Se il modello **NON** era precedentemente traducibile, serve migration:

```php
use Illuminate\Database\Schema\Blueprint;

Schema::table('mail_templates', function (Blueprint $table) {
    // Converti campi in JSON per supportare traduzioni
    $table->json('subject')->change();
    $table->json('html_template')->change();
    $table->json('text_template')->change();
});
```

## Collegamenti

### Documentazione Esterna
- [Lara Zeus Spatie Translatable](https://filamentphp.com/plugins/lara-zeus-spatie-translatable)
- [GitHub Repository](https://github.com/lara-zeus/spatie-translatable)
- [Spatie Laravel Translatable Docs](https://spatie.be/docs/laravel-translatable/v6/introduction)

### Documentazione Interna
- [Errore Plugin Not Registered](./errori/plugin-spatie-translatable-not-registered.md)
- [Lang Module README](../../Lang/docs/README.md)
- [Filament Panels Configuration](../../Xot/docs/filament/panel-configuration.md)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Status**: ✅ PLUGIN REGISTRATO  
**Compatibilità**: Filament 4.x


