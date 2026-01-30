# Convenzioni Filament

## Namespace

### 1. Struttura Base
```
Modules\{ModuleName}\{ComponentType}\{SubComponentType}
```

### 2. Componenti Principali
- Resources: `Modules\{ModuleName}\Filament\Resources`
- Pages: `Modules\{ModuleName}\Filament\Pages`
- Widgets: `Modules\{ModuleName}\Filament\Widgets`
- Forms: `Modules\{ModuleName}\Filament\Forms`
- Tables: `Modules\{ModuleName}\Filament\Tables`

### 3. Sub-Componenti
- Relation Managers: `Modules\{ModuleName}\Filament\Resources\{ResourceName}\RelationManagers`
- Actions: `Modules\{ModuleName}\Filament\Resources\{ResourceName}\Actions`
- Filters: `Modules\{ModuleName}\Filament\Resources\{ResourceName}\Filters`

## Naming

### 1. Classi
- Resources: `ModelNameResource`
- Pages: `ActionModelName`
- Widgets: `ModelNameWidget`
- Forms: `ModelNameForm`
- Tables: `ModelNameTable`
- Relation Managers: `RelatedModelRelationManager`
- Actions: `ActionNameAction`
- Filters: `FilterNameFilter`

### 2. Views
- Resources: `model-name/{action}.blade.php`
- Pages: `action-model-name.blade.php`
- Widgets: `model-name-widget.blade.php`

### 3. Routes
- Resources: `filament.resources.{model-name}.{action}`
- Pages: `filament.pages.{action-model-name}`
- Widgets: `filament.widgets.{model-name-widget}`

### 4. Traduzioni
- Resources: `{module}.resources.{model-name}`
- Pages: `{module}.pages.{action-model-name}`
- Widgets: `{module}.widgets.{model-name-widget}`

## File Structure

### 1. Resources
```
Module/
└── app/
    └── Filament/
        └── Resources/
            ├── ModelNameResource.php
            └── ModelNameResource/
                ├── RelationManagers/
                │   └── RelatedModelRelationManager.php
                ├── Actions/
                │   └── ActionNameAction.php
                └── Filters/
                    └── FilterNameFilter.php
```

### 2. Pages
```
Module/
└── app/
    └── Filament/
        └── Pages/
            ├── ListModelName.php
            ├── CreateModelName.php
            ├── EditModelName.php
            └── ViewModelName.php
```

### 3. Widgets
```
Module/
└── app/
    └── Filament/
        └── Widgets/
            └── ModelNameWidget.php
```

## Views Structure

### 1. Resources
```
Module/
└── resources/
    └── views/
        └── filament/
            └── resources/
                └── model-name/
                    ├── index.blade.php
                    ├── create.blade.php
                    ├── edit.blade.php
                    └── view.blade.php
```

### 2. Pages
```
Module/
└── resources/
    └── views/
        └── filament/
            └── pages/
                ├── list-model-name.blade.php
                ├── create-model-name.blade.php
                ├── edit-model-name.blade.php
                └── view-model-name.blade.php
```

### 3. Widgets
```
Module/
└── resources/
    └── views/
        └── filament/
            └── widgets/
                └── model-name-widget.blade.php
```

## Traduzioni Structure

### 1. File Organization
```
Module/
└── resources/
    └── lang/
        ├── it/
        │   └── module-name.php
        └── en/
            └── module-name.php
```

### 2. Chiavi di Traduzione
```php
return [
    'resources' => [
        'model-name' => [
            'title' => 'Model Title',
            'navigation' => [
                'group' => 'Group Name',
                'label' => 'Label Name',
            ],
        ],
    ],
    'pages' => [
        'action-model-name' => [
            'title' => 'Page Title',
        ],
    ],
    'widgets' => [
        'model-name-widget' => [
            'heading' => 'Widget Heading',
        ],
    ],
];
```

## Testing Structure

### 1. Directory Organization
```
Module/
└── tests/
    └── Filament/
        ├── Resources/
        │   └── ModelNameResourceTest.php
        ├── Pages/
        │   └── ActionModelNameTest.php
        └── Widgets/
            └── ModelNameWidgetTest.php
```

### 2. Class Naming
- Resource Tests: `ModelNameResourceTest`
- Page Tests: `ActionModelNameTest`
- Widget Tests: `ModelNameWidgetTest`

## Configurazione

### 1. Service Provider
```
Module/
└── providers/
    └── Filament/
        └── AdminPanelProvider.php
```

### 2. Config Files
```
Module/
└── config/
    └── filament.php
```

## Asset Structure

### 1. CSS
```
Module/
└── resources/
    └── css/
        └── filament/
            └── module-name.css
```

### 2. JavaScript
```
Module/
└── resources/
    └── js/
        └── filament/
            └── module-name.js
```

## Documentazione

### 1. PHPDoc
```php
/**
 * @property string $title
 * @property string $content
 * @property \Carbon\Carbon $published_at
 * @property-read \App\Models\User $author
 */
class ModelNameResource extends XotBaseResource
{
    // ...
}
```

### 2. README
```markdown

# Module Name

## Filament Resources
- `ModelNameResource`: Gestisce i record del modello
- `RelatedModelResource`: Gestisce i record correlati

## Filament Pages
- `ListModelName`: Lista i record
- `CreateModelName`: Crea nuovi record
- `EditModelName`: Modifica i record
- `ViewModelName`: Visualizza i dettagli

## Filament Widgets
- `ModelNameWidget`: Mostra statistiche
```

## Versionamento

### 1. CHANGELOG
```markdown

# Changelog

## [1.0.0] - 2024-03-26

### Added
- Resource `ModelNameResource`
- Page `ListModelName`
- Widget `ModelNameWidget`

### Changed
- Aggiornato layout delle views
- Migliorata performance delle query

### Fixed
- Bug nella validazione dei form
- Problemi di traduzione
```

### 2. Versioni
- Major: Cambiamenti non retrocompatibili
- Minor: Nuove funzionalità retrocompatibili
- Patch: Bugfix retrocompatibili 

## Collegamenti tra versioni di conventions.md
* [conventions.md](docs/tecnico/filament/conventions.md)
* [conventions.md](docs/conventions.md)

