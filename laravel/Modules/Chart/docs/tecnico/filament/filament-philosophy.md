# Filosofia di Estensione Filament

## Classi Base

### XotBaseResource
La classe base per tutte le risorse Filament:

```php
abstract class XotBaseResource extends FilamentResource
{
    use NavigationLabelTrait;

    protected static ?string $model = null;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    // Metodi principali
    abstract public static function getFormSchema(): array;
    
    // Metodi utili
    public static function getModuleName(): string
    public static function getModel(): string
    public static function getNavigationBadge(): ?string
    public static function getPages(): array
    public static function getRelations(): array
}
```

### XotBasePage
La classe base per tutte le pagine Filament:

```php
abstract class XotBasePage extends Page
{
    use TransTrait;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    protected static string $view = 'job::filament.pages.job-monitor';
    protected static ?string $model = null;

    // Metodi utili
    public static function getModuleName(): string
    public static function trans(string $key): string
    public static function getPluralModelLabel(): string
    public static function getNavigationLabel(): string
    public static function getNavigationGroup(): string
    public function getModel(): string
}
```

## Pattern di Estensione

### 1. Resource
```php
class ArticleResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }
}
```

### 2. Pages
```php
class ListArticles extends XotBasePage
{
    protected static string $view = 'blog::filament.pages.list-articles';
}
```

### 3. Relation Managers
```php
class CommentsRelationManager extends XotBaseRelationManager
{
    // Implementazione
}
```

## Funzionalità Comuni

### 1. Traduzioni
- Uso del trait `TransTrait`
- Sistema di traduzione basato su namespace
- Supporto multilingua integrato

### 2. Navigazione
- Badge di navigazione automatici
- Gruppi di navigazione dinamici
- Etichette tradotte

### 3. Model Binding
- Rilevamento automatico del modello
- Namespace basato sulla struttura del modulo
- Validazione del modello esistente

### 4. Pagine Standard
- Lista record
- Creazione record
- Modifica record
- Visualizzazione record

### 5. Relation Managers
- Rilevamento automatico
- Validazione delle relazioni
- Integrazione con il modello

## Best Practices

### 1. Naming Conventions
- Resource: `ModelNameResource`
- Pages: `ActionModelName`
- Relation Managers: `RelatedModelRelationManager`

### 2. Views
- Path: `module::filament.pages.view-name`
- Organizzazione per modulo
- Supporto per override

### 3. Traduzioni
- Chiavi: `module::path.to.key`
- Organizzazione gerarchica
- Fallback automatico

### 4. Model Binding
- Rilevamento automatico
- Validazione esistenza
- Type hints

### 5. Form Schema
- Componenti riutilizzabili
- Validazione integrata
- Layout responsive

## Struttura Directory

```
Module/
└── app/
    └── Filament/
        ├── Resources/
        │   ├── ArticleResource.php
        │   └── RelationManagers/
        ├── Pages/
        │   ├── ListArticles.php
        │   ├── CreateArticle.php
        │   └── EditArticle.php
        └── Widgets/
            └── ArticleStats.php
```

## Workflow di Sviluppo

1. **Creazione Resource**
   - Estendere `XotBaseResource`
   - Implementare `getFormSchema()`
   - Configurare navigazione

2. **Creazione Pagine**
   - Estendere `XotBasePage`
   - Definire view
   - Configurare layout

3. **Relation Managers**
   - Estendere `XotBaseRelationManager`
   - Definire relazioni
   - Configurare form

4. **Traduzioni**
   - Aggiungere chiavi in `lang/`
   - Usare sistema di traduzione
   - Testare multilingua

5. **Testing**
   - Test resource
   - Test pagine
   - Test relazioni 