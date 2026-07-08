# Resource Filament Non Visibile in Navigation - Analisi e Soluzione

## Problema

La `MailTemplateResource` aggiunta in `Modules/Progressioni/app/Filament/Resources/` non appare nella sidebar del panel `progressioni::admin`.

## Business Logic

### Perché una Resource Appare nella Sidebar?

Filament usa diverse proprietà statiche per controllare la visibilità navigation:

```php
class MyResource extends XotBaseResource
{
    // 1. ✅ Model DEVE essere definito
    protected static ?string $model = MyModel::class;
    
    // 2. ⚠️  Se false, la resource NON appare
    protected static bool $shouldRegisterNavigation = true;  // Default
    
    // 3. 🎨 Icona nel menu (opzionale ma raccomandato)
    protected static ?string $navigationIcon = 'heroicon-o-document';
    
    // 4. 📁 Gruppo navigation (opzionale)
    protected static ?string $navigationGroup = 'Contenuti';
    
    // 5. 🔢 Ordinamento (opzionale)
    protected static ?int $navigationSort = null;
    
    // 6. 🏷️  Label navigation (default: auto-generata)
    protected static ?string $navigationLabel = null;
}
```

## Analisi MailTemplateResource di Progressioni

### Codice Attuale

```php
// Modules/Progressioni/app/Filament/Resources/MailTemplateResource.php

namespace Modules\Progressioni\Filament\Resources;

use Modules\Notify\Filament\Resources\MailTemplateResource as NotifyBaseMailTemplateResource;

class MailTemplateResource extends NotifyBaseMailTemplateResource
{
    // ❌ VUOTA - Eredita tutto da NotifyBaseMailTemplateResource
    // ❌ Nessuna proprietà navigation definita
}
```

### Problemi Identificati

1. **Ereditarietà da Altro Modulo**:
   - Estende `Notify\...\MailTemplateResource`
   - Eredita modello, form, pages da Notify
   - **MA** potrebbe ereditare anche `$shouldRegisterNavigation = false`

2. **Nessuna Personalizzazione**:
   - Nessuna proprietà navigation override
   - Nessun gruppo specificato
   - Nessuna icona specificata

3. **Model Commentato**:
   ```php
   //protected static ?string $model = Integparam::class;  // ← Commentato!
   ```
   - Usa modello da parent (Notify\Models\MailTemplate)
   - Potrebbe causare conflitti cross-modulo

## Scopo: Perché Duplicare MailTemplateResource?

### Scenario 1: Template Email Specifici per Progressioni

**Business Case**:
- Modulo Progressioni ha template email dedicati
- Vuole gestirli separatamente da Notify
- Stesso modello ma panel diverso

**Soluzione**:
```php
class MailTemplateResource extends NotifyBaseMailTemplateResource
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Notifiche';
    protected static ?int $navigationSort = 50;
    
    // Filtro scope per mostrare solo template Progressioni
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('module', 'Progressioni');
    }
}
```

### Scenario 2: Personalizzazione UI

**Business Case**:
- Stessi template ma form/tabelle diverse
- UI personalizzata per Progressioni

**Soluzione**:
```php
class MailTemplateResource extends NotifyBaseMailTemplateResource
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    
    #[Override]
    public static function getFormSchema(): array
    {
        // Form personalizzato per Progressioni
        return [
            // ...custom fields
        ];
    }
}
```

### Scenario 3: Errore/Test

**Business Case**:
- File creato per errore
- O per test/sperimentazione

**Soluzione**: Eliminare il file se non serve

## Soluzione Raccomandata

### Analisi Requisiti

**Domande Chiave**:
1. Progressioni ha template email propri?
2. Serve UI diversa da Notify?
3. O è solo duplicazione?

### Implementazione

#### Se Serve MailTemplateResource in Progressioni

```php
<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Modules\Notify\Filament\Resources\MailTemplateResource as NotifyMailTemplateResource;
use Modules\Notify\Models\MailTemplate;
use Override;

/**
 * Resource per la gestione template email specifici del modulo Progressioni.
 * 
 * Estende la resource base di Notify mantenendo stessa struttura ma
 * con filtro scope per mostrare solo template rilevanti per Progressioni.
 */
class MailTemplateResource extends NotifyMailTemplateResource
{
    protected static ?string $model = MailTemplate::class;
    
    // ✅ Navigation Properties
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Configurazione';
    protected static ?int $navigationSort = 90;
    protected static bool $shouldRegisterNavigation = true;
    
    /**
     * Filtra solo template email per modulo Progressioni.
     */
    #[Override]
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where(function ($query) {
                $query->where('mailable', 'like', '%Progressioni%')
                    ->orWhere('slug', 'like', 'progressioni%');
            });
    }
}
```

#### Se NON Serve

Eliminare il file:
```bash
rm Modules/Progressioni/app/Filament/Resources/MailTemplateResource.php
```

## Pattern Cross-Module Resource Extension

### Best Practice

Quando si estende una Resource da altro modulo:

1. **Definire SEMPRE navigation properties**:
   ```php
   protected static ?string $navigationIcon = 'icon-name';
   protected static ?string $navigationGroup = 'Group';
   protected static bool $shouldRegisterNavigation = true;
   ```

2. **Scope Query per Filtrare**:
   ```php
   public static function getEloquentQuery(): Builder
   {
       return parent::getEloquentQuery()->where('module', 'ThisModule');
   }
   ```

3. **Override Model se necessario**:
   ```php
   protected static ?string $model = LocalModel::class;
   ```

4. **Registrare Plugin Richiesti**:
   - Se parent usa `LangBaseResource` → serve `SpatieTranslatablePlugin`
   - Verificare `AdminPanelProvider` abbia plugin registrati

## Checklist Debug Resource Navigation

Quando una Resource non appare in sidebar:

- [ ] File esiste in `app/Filament/Resources/`?
- [ ] Namespace corretto: `Modules\{Module}\Filament\Resources`?
- [ ] Estende `XotBaseResource` o sottoclasse?
- [ ] Property `$model` definita?
- [ ] Property `$shouldRegisterNavigation = true`?
- [ ] Property `$navigationIcon` definita? (raccomandato)
- [ ] Pages esistono (`ListRecords`, `CreateRecord`, `EditRecord`)?
- [ ] Panel ha plugin richiesti registrati?
- [ ] Cache cleared: `php artisan optimize:clear`?

## Testing

### Verifica Resource Registrata

```bash
cd laravel
php artisan filament:list | grep -A5 "progressioni::admin"
```

**Output Atteso**:
```
progressioni::admin
  ├─ Resources:
  │   ├─ MailTemplateResource  ← Dovrebbe apparire!
  │   ├─ SchedeResource
```

### Test Pest

```php
use Filament\Facades\Filament;
use Modules\Progressioni\Filament\Resources\MailTemplateResource;

test('MailTemplateResource is discovered in progressioni panel', function () {
    $panel = Filament::getPanel('progressioni::admin');
    
    $resources = $panel->getResources();
    
    expect($resources)
        ->toContain(MailTemplateResource::class);
});

test('MailTemplateResource appears in navigation', function () {
    expect(MailTemplateResource::shouldRegisterNavigation())
        ->toBeTrue();
});
```

## Collegamenti

### Documentazione Correlata
- [XotBase Architecture](../../Xot/docs/xotbase-architecture-complete.md)
- [Filament Resource Creation](../../Xot/docs/filament-resource-creation-fix.md)
- [Navigation Label Trait](../../Xot/docs/filament/navigation-label-trait.md)

### Issue Tracker
- [GitHub Issue: Resource Navigation Visibility](link)

---

**Created**: 27 Ottobre 2025  
**Status**: 📋 ANALISI COMPLETATA  
**Next Step**: Decidere se mantenere o eliminare MailTemplateResource in Progressioni

