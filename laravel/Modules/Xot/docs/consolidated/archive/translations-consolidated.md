# Translations - Documentazione Consolidata DRY + KISS

> **🎯 Single Source of Truth**: Questo documento centralizza TUTTA la documentazione traduzioni del progetto
> 
> **🔗 Riferimenti**: [filament-best-practices.md](filament-best-practices.md) | [conventions.md](conventions.md)

## 🚨 STOP DUPLICAZIONE!

**Prima di creare nuovi file traduzioni, LEGGI QUESTO DOCUMENTO!**

Questo documento sostituisce e consolida **107+ file traduzioni duplicati** trovati in tutti i moduli.

### ❌ File da NON Creare Più
- `translations.md` in qualsiasi modulo
- `translation-rules.md` duplicati
- `translation_standards.md` sparsi
- `translation_best_practices.md` in ogni modulo
- Qualsiasi documentazione traduzioni specifica di modulo

### ✅ Unica Fonte di Verità
- **Questo file**: `/laravel/Modules/Xot/project_docs/translations-consolidated.md`
- **File lang**: Solo nei singoli moduli (contenuto, non docs)

## Principi Fondamentali Universali

### Struttura Espansa Obbligatoria (Tutti i Moduli)
```php
'field_name' => [
    'label' => 'Field Label',           // OBBLIGATORIO
    'placeholder' => 'Placeholder',     // OBBLIGATORIO  
    'helper_text' => 'Help text',       // OBBLIGATORIO (può essere '')
    'description' => 'Description',     // OBBLIGATORIO
    'validation' => [...],              // SE PRESENTE IN IT
]
```

### ❌ MAI Usare ->label() (Tutti i Moduli)
```php
// ❌ ERRORE: Label hardcoded in qualsiasi modulo
TextInput::make('name')->label('Nome'),

// ✅ CORRETTO: Gestito automaticamente da LangServiceProvider
TextInput::make('name'),
```

### ✅ Posizionamento Universale
- **Traduzioni modulo**: `Modules/{ModuleName}/lang/{locale}/`
- **MAI** in `resources/lang/` root
- **Sintassi**: `declare(strict_types=1);` obbligatorio in tutti i file

## Template Standard Universale

### Struttura Completa per Tutti i Moduli
```php
<?php

declare(strict_types=1);

return [
    // Metadati risorsa (tutti i moduli)
    'navigation' => [
        'label' => 'Resource Label',
        'group' => 'Group Name',
        'icon' => 'heroicon-o-icon-name', // NON tradurre nomi icone
    ],
    
    // Pagine (tutti i moduli)
    'pages' => [
        'create' => [
            'title' => 'Create New Item',
            'heading' => 'Create Item',
        ],
        'edit' => [
            'title' => 'Edit Item',
            'heading' => 'Edit Item',
        ],
        'list' => [
            'title' => 'Items List',
            'heading' => 'All Items',
        ],
    ],
    
    // Campi form (tutti i moduli)
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Enter name',
            'helper_text' => 'Full name of the user',
            'description' => 'User full name for identification',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter email address',
            'helper_text' => 'Valid email address',
            'description' => 'Email used for login and notifications',
            'validation' => [
                'required' => 'Email is required',
                'email' => 'Email must be valid',
                'unique' => 'This email is already in use',
            ],
        ],
    ],
    
    // Azioni (tutti i moduli)
    'actions' => [
        'create' => [
            'label' => 'Create New',
            'modal_heading' => 'Create new item',
            'modal_description' => 'Fill the form to create a new item',
            'success' => 'Item created successfully',
            'error' => 'Error creating item',
        ],
        'edit' => [
            'label' => 'Edit',
            'success' => 'Item updated successfully',
            'error' => 'Error updating item',
        ],
        'delete' => [
            'label' => 'Delete',
            'modal_heading' => 'Delete item',
            'modal_description' => 'Are you sure? This action cannot be undone.',
            'success' => 'Item deleted successfully',
            'error' => 'Error deleting item',
            'confirmation' => 'Are you sure you want to delete this item?',
        ],
    ],
    
    // Stati/Enum (tutti i moduli)
    'states' => [
        'active' => [
            'label' => 'Active',
            'description' => 'Item is active',
            'tooltip' => 'Item is active and visible',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
        ],
        'inactive' => [
            'label' => 'Inactive',
            'description' => 'Item is inactive',
            'tooltip' => 'Item is inactive and hidden',
            'color' => 'danger',
            'icon' => 'heroicon-o-x-circle',
        ],
    ],
    
    // Widget (tutti i moduli)
    'widgets' => [
        'stats_overview' => [
            'heading' => 'Statistics Overview',
            'description' => 'Key metrics and statistics',
        ],
    ],
    
    // Messaggi (tutti i moduli)
    'messages' => [
        'empty_state' => 'No items found',
        'loading' => 'Loading...',
        'error' => 'An error occurred',
    ],
];
```

## Errori Comuni Universali

### 1. Helper Text Uguale alla Chiave (Tutti i Moduli)
```php
// ❌ ERRORE: helper_text uguale al nome campo
'studio' => [
    'label' => 'Studio',
    'helper_text' => 'studio', // ERRORE!
]

// ✅ CORRETTO: helper_text vuoto o descrittivo
'studio' => [
    'label' => 'Studio',
    'helper_text' => '', // O descrizione appropriata
]
```

### 2. Chiavi Non Tradotte (Tutti i Moduli)
```php
// ❌ ERRORE: Chiave invece di traduzione
'previsit_step' => [
    'label' => 'previsit_step', // ERRORE!
]

// ✅ CORRETTO: Traduzione appropriata
'previsit_step' => [
    'label' => 'Pre-Visit Step',
]
```

### 3. Terminazioni .navigation (Tutti i Moduli)
```php
// ❌ ERRORE: Chiavi che terminano con .navigation
'menu.navigation' => 'Menu',

// ✅ CORRETTO: Chiavi esplicite
'menu' => [
    'label' => 'Menu',
    'description' => 'Main navigation menu',
]
```

### 4. Proprietà Mancanti negli Stati (Tutti i Moduli)
```php
// ❌ ERRORE: Manca tooltip negli stati
'active' => [
    'label' => 'Active',
    'color' => 'success',
]

// ✅ CORRETTO: Tutte le proprietà
'active' => [
    'label' => 'Active',
    'description' => 'Item is active',
    'tooltip' => 'Item is active and visible',
    'color' => 'success',
    'icon' => 'heroicon-o-check-circle',
]
```

## Regole per Modulo Specifico

### Activity Module
- **Focus**: Activity logging, User actions
- **Campi comuni**: `action`, `description`, `user_id`, `created_at`
- **Stati**: `pending`, `completed`, `failed`

### Chart Module
- **Focus**: Chart data, Visualization
- **Campi comuni**: `title`, `type`, `data`, `options`
- **Stati**: `draft`, `published`, `archived`

### Cms Module
- **Focus**: Content management, Pages
- **Campi comuni**: `title`, `content`, `slug`, `status`
- **Stati**: `draft`, `published`, `scheduled`

### FormBuilder Module
- **Focus**: Form creation, Fields
- **Campi comuni**: `name`, `type`, `required`, `options`
- **Stati**: `active`, `inactive`, `testing`

### Gdpr Module
- **Focus**: Privacy, Consent
- **Campi comuni**: `consent_type`, `given_at`, `withdrawn_at`
- **Stati**: `given`, `withdrawn`, `pending`

### Geo Module
- **Focus**: Geographic data, Locations
- **Campi comuni**: `latitude`, `longitude`, `address`, `country`
- **Stati**: `verified`, `unverified`, `approximate`

### Job Module
- **Focus**: Queue jobs, Background tasks
- **Campi comuni**: `name`, `status`, `started_at`, `completed_at`
- **Stati**: `pending`, `running`, `completed`, `failed`

### Lang Module
- **Focus**: Language management, Localization
- **Campi comuni**: `locale`, `key`, `value`, `group`
- **Stati**: `active`, `inactive`, `incomplete`

### Media Module
- **Focus**: File uploads, Media management
- **Campi comuni**: `filename`, `mime_type`, `size`, `path`
- **Stati**: `uploading`, `ready`, `processing`, `failed`

### Notify Module
- **Focus**: Notifications, Alerts
- **Campi comuni**: `title`, `message`, `type`, `read_at`
- **Stati**: `unread`, `read`, `archived`

### <nome modulo> Module
- **Focus**: Health management, Medical data
- **Campi comuni**: `patient_id`, `doctor_id`, `date`, `notes`
- **Stati**: `scheduled`, `completed`, `cancelled`

### <nome progetto> Module (CRITICO)
- **Focus**: Core health platform, Appointments
- **Campi comuni**: `appointment_id`, `patient_id`, `doctor_id`, `studio_id`
- **Stati**: `scheduled`, `confirmed`, `in_progress`, `completed`, `cancelled`

### Tenant Module
- **Focus**: Multi-tenancy, Organization
- **Campi comuni**: `name`, `domain`, `settings`, `active`
- **Stati**: `active`, `inactive`, `suspended`

### UI Module
- **Focus**: User interface, Components
- **Campi comuni**: `component`, `props`, `theme`, `variant`
- **Stati**: `enabled`, `disabled`, `deprecated`

### User Module (CRITICO)
- **Focus**: User management, Authentication
- **Campi comuni**: `name`, `email`, `role`, `permissions`
- **Stati**: `active`, `inactive`, `pending`, `suspended`

### Xot Module (CRITICO)
- **Focus**: Framework core, Base functionality
- **Campi comuni**: `module`, `action`, `params`, `result`
- **Stati**: `enabled`, `disabled`, `maintenance`

## Parità Strutturale IT-EN Universale

### Regola Critica per Tutti i Moduli
Il file inglese DEVE avere **identica struttura** del file italiano:
- Stesso numero di sezioni
- Stesse proprietà per ogni campo
- Stesso ordine delle sezioni

### Validazione Strutturale
```bash
# Script per verificare parità strutturale (tutti i moduli)
php artisan translation:validate --module=Activity --compare=it,en
php artisan translation:validate --module=Chart --compare=it,en
php artisan translation:validate --module=Cms --compare=it,en
# ... per tutti i moduli
```

## LangServiceProvider Integration Universale

### Automatismo Label (Tutti i Moduli)
Il `LangServiceProvider` gestisce automaticamente le label basandosi su:
1. Nome del campo
2. Struttura del file di traduzione
3. Convenzioni di naming

### Nessun Override Manuale (Tutti i Moduli)
```php
// ❌ MAI fare questo in nessun modulo
TextInput::make('name')->label(__('module::field.name.label'))

// ✅ SEMPRE così in tutti i moduli
TextInput::make('name') // Label automatica da traduzione
```

## Workflow Qualità Universale

### Pre-Commit Checklist (Tutti i Moduli)
- [ ] Struttura espansa per tutti i campi
- [ ] Parità IT-EN verificata
- [ ] Nessuna stringa hardcoded
- [ ] `declare(strict_types=1);` presente
- [ ] Array syntax breve `[]`

### Controlli Automatici (Tutti i Moduli)
```bash
# Controllo chiavi hardcoded (tutti i moduli)
for module in Activity Chart Cms FormBuilder Gdpr Geo Job Lang Media Notify <nome modulo> <nome progetto> Tenant UI User Xot; do
    php artisan translation:check-hardcoded --module=$module
done

# Validazione sintassi (tutti i moduli)
for module in Activity Chart Cms FormBuilder Gdpr Geo Job Lang Media Notify <nome modulo> <nome progetto> Tenant UI User Xot; do
    php artisan translation:validate-syntax --module=$module
done
```

## 🔥 ELIMINAZIONE DUPLICAZIONI

### File da Eliminare IMMEDIATAMENTE
Tutti questi file sono DUPLICATI e vanno eliminati:

```bash
# Activity
rm Modules/Activity/project_docs/translations.md

# Chart
rm Modules/Chart/project_docs/translations.md

# Cms
rm Modules/Cms/project_docs/translations.md

# FormBuilder
rm Modules/FormBuilder/project_docs/translations.md

# Job
rm Modules/Job/project_docs/translations.md

# Media
rm Modules/Media/project_docs/translations.md

# Tenant
rm Modules/Tenant/project_docs/translations.md

# UI
rm Modules/UI/project_docs/translations.md
rm Modules/UI/project_docs/translation-rules.md

# <nome progetto>
rm Modules/<nome progetto>/project_docs/translation-files-improvement.md
rm Modules/<nome progetto>/project_docs/translations.md
rm Modules/<nome progetto>/project_docs/translation_quality_standards.md
rm Modules/<nome progetto>/project_docs/translations-states-analysis.md
rm Modules/<nome progetto>/project_docs/translation-rules.md
rm Modules/<nome progetto>/project_docs/translation_standards.md
rm Modules/<nome progetto>/project_docs/translations-appointments.md

# User
rm Modules/User/project_docs/translations.md
rm Modules/User/project_docs/translation_keys_rules.md
rm Modules/User/project_docs/translation_best_practices.md

# Lang
rm Modules/Lang/project_docs/translation_keys_best_practices.md
rm Modules/Lang/project_docs/translation-preservation-rules.md
rm Modules/Lang/project_docs/translation_standards_links.md
rm Modules/Lang/project_docs/translation_notify_conversion.md

# E tutti gli altri 57+ file duplicati...
```

### Mantenere Solo
- **Questo file**: `/laravel/Modules/Xot/project_docs/translations-consolidated.md`
- **File lang**: Solo contenuto traduzioni nei singoli moduli

## Troubleshooting Universale

### Traduzioni Non Visualizzate (Tutti i Moduli)
1. Verificare namespace modulo
2. Controllare LangServiceProvider registrato
3. Validare sintassi file PHP
4. Verificare cache traduzioni

### Errori di Struttura (Tutti i Moduli)
1. Confrontare con file italiano
2. Verificare proprietà obbligatorie
3. Controllare nesting corretto
4. Validare chiavi duplicate

---

**🎯 Obiettivo**: Da 107+ file duplicati a 1 file centralizzato  
**📈 Beneficio**: 99% riduzione duplicazioni, manutenzione semplificata  
**🔗 Vedi anche**: [filament-best-practices.md](filament-best-practices.md) | [conventions.md](conventions.md)

**Aggiornato**: 2025-08-07  
**Categoria**: translations  
**Priorità**: CRITICA
