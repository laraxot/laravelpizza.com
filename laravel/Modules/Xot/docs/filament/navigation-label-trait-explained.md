# NavigationLabelTrait - Sistema di Traduzione Automatica Navigation

## Overview

Il `NavigationLabelTrait` è un componente fondamentale dell'architettura Laraxot che implementa **traduzione automatica** per tutte le proprietà di navigation delle Filament Resources.

## Business Logic

### Problema che Risolve

**Senza il trait**:
```php
class MyResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationLabel = 'I Miei Documenti';  // ❌ Hardcoded
    protected static ?string $navigationGroup = 'Contenuti';  // ❌ Hardcoded
}
```

**Problemi**:
- ❌ Stringhe hardcoded
- ❌ Non traducibili
- ❌ Difficile manutenzione
- ❌ Duplicazione traduzioni

**Con il trait**:
```php
class MyResource extends XotBaseResource  // usa NavigationLabelTrait
{
    // ✅ Tutto automatico dai file di traduzione!
}
```

## Funzionamento

### Metodi Override

Il trait override questi metodi statici di `Filament\Resources\Resource`:

```php
trait NavigationLabelTrait
{
    // 1. Label navigation (nome risorsa)
    public static function getNavigationLabel(): string
    {
        return static::transFunc(__FUNCTION__);
        // → trans('modulename::model-name.navigation.label')
    }
    
    // 2. Gruppo navigation
    public static function getNavigationGroup(): string
    {
        return static::transFunc(__FUNCTION__);
        // → trans('modulename::model-name.navigation.group')
    }
    
    // 3. Icona navigation
    public static function getNavigationIcon(): string
    {
        $icon = static::transFunc(__FUNCTION__);
        // → trans('modulename::model-name.navigation.icon')
        
        if (svgExists($icon)) {
            return $icon;
        }
        
        return 'heroicon-o-question-mark-circle';  // Fallback
    }
    
    // 4. Sort navigation
    public static function getNavigationSort(): ?int
    {
        $res = static::transFunc(__FUNCTION__);
        $value = intval($res);
        
        if ($value === 0) {
            // Auto-genera sort random se manca
            $value = rand(1, 100);
            saveTrans($key, $value);  // Salva per prossima volta
        }
        
        return $value;
    }
}
```

### TransFunc Pipeline

```
getNavigationLabel()
  ↓
static::transFunc('getNavigationLabel')
  ↓
TransTrait::getKeyTransFunc('getNavigationLabel')
  ↓
Converte metodo → chiave: getNavigationLabel → navigation.label
  ↓
GetTransKeyAction::execute(static::class)
  ↓
Calcola namespace: progressioni::mail_template
  ↓
trans('progressioni::mail_template.navigation.label')
  ↓
Legge: Modules/Progressioni/lang/it/mail_template.php
  ↓
return $array['navigation']['label'];  // 'Template Email'
```

## File Traduzione Richiesto

### Struttura Completa

```php
// Modules/{ModuleName}/lang/it/{model-name}.php

return [
    'navigation' => [
        'name' => 'Nome Singolare',
        'plural' => 'Nome Plurale',
        'label' => 'Label Navigation',  // ← getNavigationLabel()
        'group' => 'Gruppo Navigation',  // ← getNavigationGroup()
        'icon' => 'heroicon-o-icon-name',  // ← getNavigationIcon()
        'sort' => 50,  // ← getNavigationSort()
    ],
    'label' => 'Label Risorsa',
    'plural_label' => 'Label Plurale',
    // ... altri campi
];
```

### Chiavi Navigation Obbligatorie

Per apparire correttamente in sidebar:

| Chiave | Metodo | Default se Manca | Obbligatorio |
|--------|--------|------------------|--------------|
| `navigation.label` | `getNavigationLabel()` | Chiave traduzione | ✅ SÌ |
| `navigation.group` | `getNavigationGroup()` | Chiave traduzione | ✅ SÌ |
| `navigation.icon` | `getNavigationIcon()` | `heroicon-o-question-mark-circle` | ⚠️  Raccomandato |
| `navigation.sort` | `getNavigationSort()` | Random 1-100 | ⚠️  Opzionale |

## Convenzione Naming File Traduzione

### Regola

Nome file traduzione = **kebab-case del nome modello**

```
Model: MailTemplate
File:  mail_template.php  (snake_case)

Model: UserProfile
File:  user_profile.php

Model: StabiDirigente
File:  stabi_dirigente.php
```

### Come Viene Calcolato

```php
// GetTransKeyAction

$moduleName = 'Progressioni';  // Da namespace
$modelClass = MailTemplate::class;
$modelName = class_basename($modelClass);  // 'MailTemplate'
$modelKebab = Str::kebab($modelName);  // 'mail-template'
$modelSnake = Str::snake($modelName);  // 'mail_template'

return strtolower($moduleName) . '::' . $modelSnake;
// → 'progressioni::mail_template'
```

## Esempi Pratici

### Esempio 1: Resource Semplice

```php
// Modules/Blog/app/Filament/Resources/PostResource.php
class PostResource extends XotBaseResource
{
    protected static ?string $model = Post::class;
}
```

```php
// Modules/Blog/lang/it/post.php
return [
    'navigation' => [
        'label' => 'Articoli',
        'group' => 'Blog',
        'icon' => 'heroicon-o-document-text',
        'sort' => 10,
    ],
];
```

**Risultato**: Appare in sidebar come "Articoli" nel gruppo "Blog"

### Esempio 2: Resource Cross-Module

```php
// Modules/Progressioni/app/Filament/Resources/MailTemplateResource.php
class MailTemplateResource extends NotifyMailTemplateResource
{
    // Estende Notify ma navigation da Progressioni
}
```

```php
// Modules/Progressioni/lang/it/mail_template.php
return [
    'navigation' => [
        'label' => 'Template Email',
        'group' => 'Configurazione',
        'icon' => 'heroicon-o-envelope',
        'sort' => 90,
    ],
];
```

**Risultato**: Appare in sidebar "Progressioni" con label/icon da file traduzione Progressioni

## Troubleshooting

### Problema: Label è "model-name.navigation.label"

**Causa**: File traduzione manca o chiave errata

**Fix**:
1. Verifica nome file: `{model-name}.php` in snake_case
2. Verifica chiave esista: `['navigation']['label']`
3. Clear cache: `php artisan cache:clear`

### Problema: Icon è "heroicon-o-question-mark-circle"

**Causa**: Icona nei file traduzione non valida

**Fix**:
1. Usa icona Heroicons valida: `heroicon-o-*` o `heroicon-s-*`
2. Verifica SVG esistente se icona custom
3. Aggiorna chiave: `['navigation']['icon']`

### Problema: Group è "model-name.navigation.group"

**Causa**: Chiave `navigation.group` manca

**Fix**:
```php
return [
    'navigation' => [
        'group' => 'Nome Gruppo',  // ← Aggiungi questa chiave!
    ],
];
```

### Problema: Sort è Random

**Causa**: Chiave `navigation.sort` manca

**Comportamento**: Auto-genera random 1-100 e salva per prossime volte

**Fix**: Definisci sort esplicito:
```php
'navigation' => [
    'sort' => 50,  // ← Definisci ordinamento
],
```

## Best Practice

### 1. File Traduzione Completo

Sempre includere TUTTE le chiavi navigation:

```php
return [
    'navigation' => [
        'name' => '...',
        'label' => '...',
        'plural' => '...',
        'group' => '...',
        'icon' => '...',
        'sort' => 50,
    ],
    'label' => '...',
    'plural_label' => '...',
];
```

### 2. Icone Consistenti

Usare icone Heroicons per consistenza UI:
- `heroicon-o-*` per outline
- `heroicon-s-*` per solid

### 3. Gruppi Logici

Raggruppare risorse correlate:
- "Configurazione" - Settings, Config, Templates
- "Contenuti" - Posts, Pages, Media
- "Utenti" - Users, Roles, Permissions
- "Sistema" - Logs, Cache, Queue

### 4. Sort Strategico

Ordinare risorse per frequenza uso:
- 1-20: Risorse più usate
- 21-50: Risorse medie
- 51-100: Configurazioni, Settings

## Collegamenti

### Documentazione Interna
- [Progressioni MailTemplate Integration](../../Progressioni/docs/mailtemplate-resource-integration.md)
- [TransTrait](./trans-trait.md)
- [GetTransKeyAction](../actions/get-trans-key-action.md)

### Esempi
- [Notify MailTemplateResource](../../Notify/app/Filament/Resources/MailTemplateResource.php)
- [Progressioni MailTemplateResource](../../Progressioni/app/Filament/Resources/MailTemplateResource.php)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Maintainer**: Team PTVX

