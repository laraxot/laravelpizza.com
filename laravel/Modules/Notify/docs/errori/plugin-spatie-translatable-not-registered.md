# Errore: Plugin spatie-translatable Not Registered

## Errore

```
LogicException - Internal Server Error

Plugin [spatie-translatable] is not registered for panel [notify::admin].
```

## Stack Trace Chiave

```
vendor/lara-zeus/spatie-translatable/src/Resources/Concerns/HasActiveLocaleSwitcher.php:76
vendor/lara-zeus/spatie-translatable/src/Resources/Pages/ListRecords/Concerns/Translatable.php:27
```

## Contesto

**URL**: `/notify/admin/mail-templates`  
**Resource**: `Modules\Notify\Filament\Resources\MailTemplateResource`  
**Page**: `Modules\Notify\Filament\Resources\MailTemplateResource\Pages\ListMailTemplates`

## Business Logic

### Struttura Ereditarietà

```
ListMailTemplates 
  └─> LangBaseListRecords (Modules/Lang)
       └─> trait Translatable (lara-zeus/spatie-translatable)
            └─> LocaleSwitcher::make()
                 └─> filament()->getPlugin('spatie-translatable')
                      └─> ❌ Plugin NON registrato nel panel notify::admin
```

### Perché l'Errore?

1. **`ListMailTemplates` estende `LangBaseListRecords`**:
   ```php
   // Modules/Notify/.../Pages/ListMailTemplates.php
   class ListMailTemplates extends LangBaseListRecords
   ```

2. **`LangBaseListRecords` usa il trait `Translatable`**:
   ```php
   // Modules/Lang/.../Pages/LangBaseListRecords.php
   use LaraZeus\SpatieTranslatable\Resources\Pages\ListRecords\Concerns\Translatable;
   
   abstract class LangBaseListRecords extends XotBaseListRecords
   {
       use Translatable;  // ← Richiede il plugin!
   ```

3. **Il trait `Translatable` chiama `LocaleSwitcher::make()`**:
   ```php
   // lara-zeus/spatie-translatable/src/Resources/Pages/ListRecords/Concerns/Translatable.php
   protected function getHeaderActions(): array
   {
       return [
           LocaleSwitcher::make(), // ← Richiede plugin registrato!
       ];
   }
   ```

4. **`LocaleSwitcher` richiede il plugin**:
   ```php
   // lara-zeus/spatie-translatable/src/Resources/Concerns/HasActiveLocaleSwitcher.php:76
   filament()->getPlugin('spatie-translatable');
   // ❌ Plugin NON registrato nel panel notify::admin!
   ```

## Causa Radice

Il plugin `SpatieTranslatablePlugin` è **commentato** in `Notify\Providers\Filament\AdminPanelProvider`:

```php
// Modules/Notify/app/Providers/Filament/AdminPanelProvider.php

public function panel(Panel $panel): Panel
{
    // ❌ PLUGIN COMMENTATO
    // Temporaneamente commentato per compatibilità Filament 4.x
    // $panel->plugins([
    //     SpatieTranslatablePlugin::make(),
    // ]);
    
    // ...
    return parent::panel($panel);
}
```

**MA** le risorse nel modulo Notify estendono `LangBaseListRecords` che **richiede il plugin attivo**.

## Soluzione

### Opzione 1: Registrare il Plugin (RACCOMANDATO)

```php
// Modules/Notify/app/Providers/Filament/AdminPanelProvider.php

use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;

public function panel(Panel $panel): Panel
{
    // ✅ Registra il plugin
    $panel->plugins([
        SpatieTranslatablePlugin::make()
            ->defaultLocales(['it', 'en']),
    ]);
    
    // Database notifications...
    if (! XotData::make()->disable_database_notifications) {
        DatabaseNotifications::trigger('notify::livewire.database-notifications-trigger');
        DatabaseNotifications::pollingInterval('60s');
        FilamentView::registerRenderHook('panels::user-menu.before', static fn (): string => Blade::render(
            '@livewire(\'database-notifications\')',
        ));
    }

    return parent::panel($panel);
}
```

### Opzione 2: Rimuovere Ereditarietà da LangBase

Se il modulo Notify **NON** ha bisogno di funzionalità multilingua:

```php
// Modules/Notify/app/Filament/Resources/MailTemplateResource/Pages/ListMailTemplates.php

// ❌ PRIMA
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;

class ListMailTemplates extends LangBaseListRecords  // Richiede plugin!

// ✅ DOPO
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListMailTemplates extends XotBaseListRecords  // No plugin richiesto
```

## Scopo del Plugin Spatie Translatable

### Cosa Fa

- Gestione contenuti multilingua in Filament
- Switcher lingua nell'interfaccia admin
- Supporto modelli con trait `Spatie\Translatable\HasTranslations`
- Editing simultaneo di traduzioni multiple

### Quando Usarlo

✅ **SÌ** se:
- Il modello ha campi traducibili (es. `name`, `description`)
- Serve gestire contenuti in più lingue
- Gli admin devono switchare tra lingue

❌ **NO** se:
- Il modello NON ha campi traducibili
- Non serve multilingua per quella risorsa
- Aggiunge complessità non necessaria

## Analisi Caso MailTemplate

### Modello MailTemplate

```php
// Modules/Notify/app/Models/MailTemplate.php
// Ha campi traducibili?
- mailable (no, è un FQCN)
- subject (sì, potrebbe essere traducibile)
- html_template (sì, potrebbe essere traducibile)
- text_template (sì, potrebbe essere traducibile)
```

### Domanda Chiave

**I template email devono essere multilingua?**

- **SÌ** → Registra il plugin + aggiungi trait al modello
- **NO** → Usa `XotBaseListRecords` invece di `LangBaseListRecords`

## Implementazione Raccomandata

### Se MailTemplate DEVE essere traducibile

#### 1. Registra Plugin in Panel

```php
// Modules/Notify/app/Providers/Filament/AdminPanelProvider.php
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;

$panel->plugins([
    SpatieTranslatablePlugin::make()
        ->defaultLocales(['it', 'en', 'de']),
]);
```

#### 2. Aggiungi Trait al Modello

```php
// Modules/Notify/app/Models/MailTemplate.php
use Spatie\Translatable\HasTranslations;

class MailTemplate extends BaseModel
{
    use HasTranslations;
    
    /** @var list<string> */
    public array $translatable = ['subject', 'html_template', 'text_template'];
}
```

#### 3. Aggiungi Trait alla Resource

```php
// Modules/Notify/app/Filament/Resources/MailTemplateResource.php
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;

class MailTemplateResource extends LangBaseResource
{
    use Translatable;  // Abilita multilingua
}
```

### Se MailTemplate NON deve essere traducibile

#### 1. Cambia Estensione Page

```php
// Modules/Notify/app/Filament/Resources/MailTemplateResource/Pages/ListMailTemplates.php

// ❌ PRIMA
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;
class ListMailTemplates extends LangBaseListRecords

// ✅ DOPO
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
class ListMailTemplates extends XotBaseListRecords
```

#### 2. Rimuovi Dipendenze Lang

```php
// Modules/Notify/app/Filament/Resources/MailTemplateResource.php

// ❌ PRIMA
use Modules\Lang\Filament\Resources\LangBaseResource;
class MailTemplateResource extends LangBaseResource

// ✅ DOPO
use Modules\Xot\Filament\Resources\XotBaseResource;
class MailTemplateResource extends XotBaseResource
```

## Decisione da Prendere

### Domande per l'Utente/Team

1. **I template email devono supportare più lingue?**
   - Se SÌ → Registrare plugin
   - Se NO → Rimuovere ereditarietà da LangBase

2. **Quali altri moduli usano LangBase?**
   - Verificare che tutti i panel abbiano il plugin registrato
   - O rimuovere LangBase dove non serve

3. **Strategia multilingua globale?**
   - Plugin registrato in tutti i panel?
   - Solo in panel specifici?

## Raccomandazione

### Scenario 1: MailTemplate È Traducibile (PROBABILE)

I template email **DOVREBBERO** essere multilingua per supportare notifiche in più lingue.

**Azione**: Registrare il plugin nel panel `notify::admin`.

### Scenario 2: MailTemplate NON È Traducibile

Se i template sono solo in italiano/una lingua.

**Azione**: Rimuovere ereditarietà da `LangBase*`.

## Implementazione

### Fix Immediato (Opzione 1)

```php
// Modules/Notify/app/Providers/Filament/AdminPanelProvider.php

use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;

public function panel(Panel $panel): Panel
{
    // ✅ Decommentare e registrare plugin
    $panel->plugins([
        SpatieTranslatablePlugin::make()
            ->defaultLocales(['it', 'en']),
    ]);
    
    if (! XotData::make()->disable_database_notifications) {
        // ...
    }

    return parent::panel($panel);
}
```

### Validazione

```bash
# Dopo il fix
cd /var/www/html/ptvx/laravel
php artisan optimize:clear
php artisan cache:clear

# Test URL
curl -I http://personale2022.prov.tv.local/notify/admin/mail-templates
# ✅ Dovrebbe ritornare 200 OK
```

## Best Practice

### Plugin Registration Pattern

```php
// Modules/{Module}/app/Providers/Filament/AdminPanelProvider.php

use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;

public function panel(Panel $panel): Panel
{
    // ✅ Sempre registrare i plugin PRIMA di parent::panel()
    $panel->plugins([
        SpatieTranslatablePlugin::make()
            ->defaultLocales(config('app.available_locales', ['it', 'en']))
            ->persist(),  // Ricorda lingua selezionata
    ]);
    
    // ... altre configurazioni ...
    
    return parent::panel($panel);
}
```

### Resource Inheritance Check

Prima di usare `LangBase*`:

1. ✅ Verifica che il panel abbia il plugin registrato
2. ✅ Verifica che il modello sia traducibile
3. ✅ Verifica che la resource usi il trait `Translatable`

## Collegamenti

### Documentazione Ufficiale
- [Lara Zeus Spatie Translatable](https://filamentphp.com/plugins/lara-zeus-spatie-translatable)
- [GitHub lara-zeus/spatie-translatable](https://github.com/lara-zeus/spatie-translatable)
- [Spatie Laravel Translatable](https://spatie.be/docs/laravel-translatable/v6/introduction)

### Documentazione Interna
- [Lang Module README](../../../Lang/docs/README.md)
- [Filament Panel Configuration](../../../Xot/docs/filament/panel-configuration.md)

---

**Created**: 27 Ottobre 2025  
**Status**: ⏳ ATTENDE DECISIONE  
**Priority**: P1 (blocca funzionalità)  
**Next Step**: Decidere se MailTemplate deve essere traducibile


