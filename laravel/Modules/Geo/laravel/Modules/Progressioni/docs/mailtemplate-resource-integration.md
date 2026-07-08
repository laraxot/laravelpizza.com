# MailTemplateResource - Integrazione nel Modulo Progressioni

## Overview

Il modulo Progressioni include una `MailTemplateResource` per gestire template email specifici, riutilizzando l'infrastruttura del modulo Notify.

## Business Logic

### Perché una MailTemplateResource in Progressioni?

**Scopo**: Gestire template email specifici per il workflow delle progressioni (notifiche approvazione, rifiuto, stato avanzamento, ecc.) separatamente dai template globali di Notify.

**Vantaggi**:
1. ✅ **Separazione concerns**: Template progressioni isolati
2. ✅ **Filtro automatico**: Mostra solo template rilevanti per Progressioni
3. ✅ **UI personalizzata**: Può avere form/tabelle custom se necessario
4. ✅ **Riuso codice**: Estende Notify invece di duplicare logica

## Implementazione

### Resource Class

```php
// Modules/Progressioni/app/Filament/Resources/MailTemplateResource.php

namespace Modules\Progressioni\Filament\Resources;

use Modules\Notify\Filament\Resources\MailTemplateResource as NotifyBaseMailTemplateResource;

class MailTemplateResource extends NotifyBaseMailTemplateResource
{
    protected static ?string $model = MailTemplate::class;
    
    // ✅ Navigation properties (ereditate ma sovrascritte da traduzioni)
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';
    protected static \UnitEnum|string|null $navigationGroup = 'Configurazione';
    protected static ?int $navigationSort = 90;
    protected static bool $shouldRegisterNavigation = true;
    
    // ✅ Scope query per filtrare solo template Progressioni
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(function (Builder $query): void {
                $query->where('mailable', 'like', '%Progressioni%')
                    ->orWhere('slug', 'like', 'progressioni-%');
            });
    }
    
    // ✅ Riutilizzo Pages di Notify
    public static function getPages(): array
    {
        return [
            'index' => \Modules\Notify\Filament\Resources\MailTemplateResource\Pages\ListMailTemplates::route('/'),
            'create' => \Modules\Notify\Filament\Resources\MailTemplateResource\Pages\CreateMailTemplate::route('/create'),
            'edit' => \Modules\Notify\Filament\Resources\MailTemplateResource\Pages\EditMailTemplate::route('/{record}/edit'),
        ];
    }
}
```

### AdminPanelProvider

```php
// Modules/Progressioni/app/Providers/Filament/AdminPanelProvider.php

use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;

public function panel(Panel $panel): Panel
{
    // ✅ FONDAMENTALE: Plugin richiesto da LangBaseResource
    $panel->plugins([
        SpatieTranslatablePlugin::make()
            ->defaultLocales(['it', 'en']),
    ]);
    
    return parent::panel($panel);
}
```

### File Traduzione

```php
// Modules/Progressioni/lang/it/mail_template.php

return [
    'navigation' => [
        'name' => 'Template Email',
        'label' => 'Template Email',
        'group' => 'Configurazione',
        'icon' => 'heroicon-o-envelope',
        'sort' => 90,
    ],
    'fields' => [
        // ... definizioni campi
    ],
];
```

## Architettura NavigationLabelTrait

### Come Funziona

`XotBaseResource` usa il trait `NavigationLabelTrait` che **override** i metodi navigation per leggere dalle traduzioni:

```php
// NavigationLabelTrait

public static function getNavigationLabel(): string
{
    return static::transFunc(__FUNCTION__);
    // → Cerca: progressioni::mail_template.navigation.label
}

public static function getNavigationGroup(): string
{
    return static::transFunc(__FUNCTION__);
    // → Cerca: progressioni::mail_template.navigation.group
}

public static function getNavigationIcon(): string
{
    $icon = static::transFunc(__FUNCTION__);
    // → Cerca: progressioni::mail_template.navigation.icon
    
    if (svgExists($icon)) {
        return $icon;
    }
    
    return 'heroicon-o-question-mark-circle';  // Default
}
```

### Processo di Risoluzione

```
1. Filament chiama MailTemplateResource::getNavigationLabel()
   ↓
2. NavigationLabelTrait::getNavigationLabel()
   ↓
3. static::transFunc('getNavigationLabel')
   ↓
4. TransTrait::getKeyTransFunc('getNavigationLabel')
   ↓
5. Converte: getNavigationLabel → navigation.label
   ↓
6. GetTransKeyAction: progressioni::mail_template
   ↓
7. trans('progressioni::mail_template.navigation.label')
   ↓
8. Legge: Modules/Progressioni/lang/it/mail_template.php
   ↓
9. Ritorna: 'Template Email'
```

## Perché NON Appariva in Sidebar?

### Cause Identificate

1. ❌ **Plugin mancante**: `SpatieTranslatablePlugin` non registrato
   - **Fix**: Registrato in `AdminPanelProvider`

2. ❌ **File traduzione incompleto**: Mancavano chiavi navigation
   - **Fix**: Aggiunta struttura completa navigation

3. ❌ **Pages mancanti**: Auto-discovery cercava Pages in Progressioni
   - **Fix**: Override `getPages()` per usare Pages di Notify

4. ❌ **Cache obsoleta**: Traduzioni non aggiornate
   - **Fix**: `php artisan cache:clear`

## Checklist Risoluzione

- [x] Plugin `SpatieTranslatablePlugin` registrato in `AdminPanelProvider`
- [x] File traduzione `mail_template.php` con chiavi navigation complete
- [x] Navigation properties definite (Icon, Group, Sort)
- [x] `getPages()` override per usare Pages di Notify
- [x] Model definito correttamente
- [x] `shouldRegisterNavigation = true`
- [x] Cache cleared
- [x] Scope query per filtrare template Progressioni

## Risultato Finale

```
✅ Label: Template Email
✅ Group: Configurazione
✅ Icon: heroicon-o-envelope
✅ Sort: 90
✅ Should Register: YES
✅ Plugin: Registered
✅ Resource: Registered in Panel
```

## Template Email per Progressioni

### Esempi Use Case

1. **Notifica Approvazione Progressione**:
   - Slug: `progressioni-approvazione`
   - Mailable: `Modules\Progressioni\Mail\ApprovazioneProgressioneMail`

2. **Notifica Rifiuto Progressione**:
   - Slug: `progressioni-rifiuto`
   - Mailable: `Modules\Progressioni\Mail\RifiutoProgressioneMail`

3. **Reminder Scadenza Valutazione**:
   - Slug: `progressioni-reminder-valutazione`
   - Mailable: `Modules\Progressioni\Mail\ReminderValutazioneMail`

## Testing

### Test Funzionale

```php
use Livewire\Livewire;
use Modules\Progressioni\Filament\Resources\MailTemplateResource\Pages\ListMailTemplates;
use Modules\Notify\Models\MailTemplate;

test('MailTemplateResource appears in navigation', function () {
    $user = createUserWithRole('progressioni::admin');
    actingAs($user);
    
    // Accedi al panel
    $this->get('/progressioni/admin')
        ->assertSee('Template Email')  // Navigation label
        ->assertSee('Configurazione');  // Navigation group
});

test('MailTemplateResource filters only progressioni templates', function () {
    // Template per Progressioni
    $progressioniTemplate = MailTemplate::factory()->create([
        'slug' => 'progressioni-test',
        'mailable' => 'Modules\\Progressioni\\Mail\\TestMail',
    ]);
    
    // Template per altri moduli
    $notifyTemplate = MailTemplate::factory()->create([
        'slug' => 'notify-test',
        'mailable' => 'Modules\\Notify\\Mail\\GenericMail',
    ]);
    
    Livewire::test(ListMailTemplates::class)
        ->assertCanSeeTableRecords([$progressioniTemplate])
        ->assertCanNotSeeTableRecords([$notifyTemplate]);
});
```

## Best Practice Cross-Module Resource Extension

### Pattern Raccomandato

Quando si estende una Resource da altro modulo:

1. **Registra Plugin Dipendenze**:
   ```php
   // AdminPanelProvider
   $panel->plugins([/*...*/]);
   ```

2. **Override getPages()**:
   ```php
   // Riutilizza Pages del modulo base
   public static function getPages(): array
   {
       return [
           'index' => \Modules\BaseModule\...\ListRecords::route('/'),
       ];
   }
   ```

3. **File Traduzione Completo**:
   ```php
   // lang/it/resource-name.php
   return [
       'navigation' => [
           'name' => '...',
           'group' => '...',
           'icon' => '...',
           'sort' => 90,
       ],
   ];
   ```

4. **Scope Query per Filtrare**:
   ```php
   public static function getEloquentQuery(): Builder
   {
       return parent::getEloquentQuery()
           ->where('module', 'ThisModule');
   }
   ```

## Collegamenti

### Documentazione Correlata
- [Filament Resource Navigation](./filament-resource-navigation.md)
- [Spatie Translatable in Notify](../../Notify/docs/spatie-translatable-integration.md)
- [Navigation Label Trait](../../Xot/docs/filament/navigation-label-trait.md)
- [Lang Module README](../../Lang/docs/README.md)

### Troubleshooting
- [Plugin Not Registered Error](../../Notify/docs/errori/plugin-spatie-translatable-not-registered.md)

---

**Created**: 27 Ottobre 2025  
**Status**: ✅ FUNZIONANTE  
**Versione**: Filament 4.x, Laravel 12.x

