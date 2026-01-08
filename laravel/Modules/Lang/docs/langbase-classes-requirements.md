# LangBase Classes - Requisiti e Pattern

## Overview

Le classi `LangBase*` forniscono funzionalità multilingua riutilizzabili tramite integrazione con **Lara Zeus Spatie Translatable**.

## Classi Disponibili

### LangBaseResource

**Path**: `Modules/Lang/app/Filament/Resources/LangBaseResource.php`

**Estende**: `XotBaseResource`

**Trait**: `Translatable` (commentato per compatibilità)

**Metodi**:
- `getDefaultTranslatableLocale()` - Ritorna lingua predefinita
- `getTranslatableLocales()` - Ritorna array lingue supportate

### LangBaseListRecords

**Path**: `Modules/Lang/app/Filament/Resources/Pages/LangBaseListRecords.php`

**Estende**: `XotBaseListRecords`

**Trait**: `Translatable` (attivo)

**Caratteristiche**:
- ✅ Aggiunge `LocaleSwitcher` in header actions
- ✅ Supporta switch lingua nell'interfaccia
- ⚠️  **RICHIEDE** plugin registrato nel panel!

### LangBaseCreateRecord

**Path**: `Modules/Lang/app/Filament/Resources/Pages/LangBaseCreateRecord.php`

**Estende**: `XotBaseCreateRecord`

**Trait**: `Translatable`

**Caratteristiche**:
- Supporto creazione record multilingua
- Form con campi traducibili

### LangBaseEditRecord

**Path**: `Modules/Lang/app/Filament/Resources/Pages/LangBaseEditRecord.php`

**Estende**: `XotBaseEditRecord`

**Trait**: `Translatable`

**Caratteristiche**:
- Supporto editing record multilingua
- LocaleSwitcher in header
- Form con campi traducibili

## Requisiti per Estendere LangBase Classes

### Requisito 1: Plugin Registrato nel Panel ⚠️

**FONDAMENTALE**: Il panel **DEVE** avere il plugin `spatie-translatable` registrato:

```php
// Modules/{ModuleName}/app/Providers/Filament/AdminPanelProvider.php

use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;

public function panel(Panel $panel): Panel
{
    // ✅ OBBLIGATORIO
    $panel->plugins([
        SpatieTranslatablePlugin::make()
            ->defaultLocales(['it', 'en']),
    ]);
    
    return parent::panel($panel);
}
```

**Se manca** → `LogicException: Plugin [spatie-translatable] is not registered`

### Requisito 2: Modello con HasTranslations

Il modello **DEVE** avere il trait `HasTranslations`:

```php
use Spatie\Translatable\HasTranslations;

class MyModel extends BaseModel
{
    use HasTranslations;
    
    /**
     * Campi traducibili.
     *
     * @var list<string>
     */
    public array $translatable = ['name', 'description'];
}
```

### Requisito 3: Campi JSON nel Database

I campi traducibili devono essere JSON nel database:

```php
// Migration
Schema::create('my_table', function (Blueprint $table) {
    $table->id();
    $table->json('name');
    $table->json('description');
    $table->timestamps();
});
```

## Quando Estendere LangBase Classes

### ✅ Estendere SE:

1. Il modello ha campi traducibili
2. Il panel ha il plugin registrato
3. Serve gestire contenuti in più lingue
4. Gli admin devono switchare tra lingue

### ❌ NON Estendere SE:

1. Il modello NON è traducibile
2. Plugin non registrato nel panel
3. Complessità non necessaria
4. Solo una lingua supportata

## Pattern Corretto

### Scenario: Resource Traducibile

```php
// 1. Registra plugin nel panel
// Modules/MyModule/app/Providers/Filament/AdminPanelProvider.php
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;

$panel->plugins([
    SpatieTranslatablePlugin::make()->defaultLocales(['it', 'en']),
]);

// 2. Modello con trait
// Modules/MyModule/app/Models/MyModel.php
use Spatie\Translatable\HasTranslations;

class MyModel extends BaseModel
{
    use HasTranslations;
    public array $translatable = ['field1', 'field2'];
}

// 3. Resource estende LangBase
// Modules/MyModule/app/Filament/Resources/MyModelResource.php
use Modules\Lang\Filament\Resources\LangBaseResource;

class MyModelResource extends LangBaseResource
{
    protected static ?string $model = MyModel::class;
}

// 4. Pages estendono LangBase
// Modules/MyModule/.../Pages/ListMyModels.php
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;

class ListMyModels extends LangBaseListRecords
{
    // LocaleSwitcher automatico in header!
}
```

## Errori Comuni

### Errore: Plugin Not Registered

**Sintomo**:
```
LogicException: Plugin [spatie-translatable] is not registered for panel [xxx::admin]
```

**Causa**: Page estende `LangBaseListRecords` ma plugin NON registrato

**Fix**: Registrare plugin nel panel provider

**Documentazione**: [Notify - Plugin Not Registered](../../Notify/docs/errori/plugin-spatie-translatable-not-registered.md)

### Errore: Undefined Method getTranslation()

**Sintomo**:
```
Call to undefined method MyModel::getTranslation()
```

**Causa**: Modello non ha trait `HasTranslations`

**Fix**: Aggiungere trait al modello

### Errore: Column Type JSON Expected

**Sintomo**:
```
SQLSTATE[22001]: String data, right truncated
```

**Causa**: Campo traducibile non è JSON nel database

**Fix**: Migration per convertire campo in JSON

```php
Schema::table('my_table', function (Blueprint $table) {
    $table->json('field_name')->change();
});
```

## Checklist Estensione LangBase

Prima di estendere `LangBase*` classes:

- [ ] Plugin `spatie-translatable` registrato nel panel?
- [ ] Modello ha trait `HasTranslations`?
- [ ] Campi traducibili sono JSON nel database?
- [ ] Array `$translatable` definito nel modello?
- [ ] Migration per conversione campi esistenti (se necessario)?
- [ ] Test per verifica multilingua?

## Moduli che Usano LangBase

### ✅ Notify
- **Resource**: `MailTemplateResource`
- **Plugin**: Registrato
- **Status**: ✅ Funzionante

### ✅ Lang  
- **Resource**: Varie (Post, Translation, etc.)
- **Plugin**: Registrato
- **Status**: ✅ Funzionante

### ⚠️  Altri Moduli

Verificare se altri moduli estendono `LangBase*` e assicurarsi che abbiano il plugin registrato.

## Best Practice

### 1. Sempre Registrare Plugin

Se estendi `LangBase*`, **DEVI** registrare il plugin:

```php
$panel->plugins([
    SpatieTranslatablePlugin::make()
        ->defaultLocales(config('app.available_locales', ['it', 'en']))
        ->persist(),  // Ricorda lingua selezionata
]);
```

### 2. Migrare Modelli Esistenti

Se aggiungi multilingua a modello esistente:

```php
// Migration
Schema::table('existing_table', function (Blueprint $table) {
    $table->json('field_to_translate')->change();
});

// Seeder per convertire dati esistenti
MyModel::all()->each(function ($record) {
    $record->setTranslation('field_name', 'it', $record->getAttributeValue('field_name'));
    $record->save();
});
```

### 3. Testing Multilingua

```php
test('can create translated record', function () {
    $data = [
        'name' => [
            'it' => 'Nome italiano',
            'en' => 'English name',
        ],
    ];
    
    $record = MyModel::create($data);
    
    expect($record->getTranslation('name', 'it'))->toBe('Nome italiano')
        ->and($record->getTranslation('name', 'en'))->toBe('English name');
});
```

## Documentazione Spatie Translatable

### Metodi Disponibili

```php
// Set traduzione
$model->setTranslation('field', 'it', 'valore');

// Get traduzione
$value = $model->getTranslation('field', 'it');

// Get traduzioni tutte
$translations = $model->getTranslations('field');
// ['it' => 'valore', 'en' => 'value']

// Fallback lingua
app()->setLocale('en');
$value = $model->field;  // Ritorna traduzione 'en' se esiste, altrimenti fallback
```

## Collegamenti

### Documentazione Esterna
- [Lara Zeus Spatie Translatable Plugin](https://filamentphp.com/plugins/lara-zeus-spatie-translatable)
- [GitHub lara-zeus/spatie-translatable](https://github.com/lara-zeus/spatie-translatable)
- [Spatie Laravel Translatable Docs](https://spatie.be/docs/laravel-translatable/v6/introduction)

### Documentazione Interna
- [Notify Integration](../../Notify/docs/spatie-translatable-integration.md)
- [Xot Filament Best Practices](../../Xot/docs/filament-best-practices.md)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Versione Plugin**: lara-zeus/spatie-translatable 1.0.4  
**Compatibilità**: Filament 4.x, Laravel 12.x


