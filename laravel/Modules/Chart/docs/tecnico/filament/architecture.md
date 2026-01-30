# Architettura Base Filament

## Panoramica
L'architettura base di Filament in il progetto è costruita su un sistema modulare che utilizza classi base astratte per fornire funzionalità comuni e standardizzare l'implementazione.

## Componenti Principali

### 1. XotBaseResource
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

### 2. XotBaseListRecords
La classe base per la visualizzazione degli elenchi:

```php
abstract class XotBaseListRecords extends ListRecords
{
    // Metodi pubblici obbligatori
    public function getTableHeaderActions(): array
    public function getTableActions(): array
    public function getTableBulkActions(): array
    public function getTableFilters(): array

    // Metodi protetti
    protected function getHeaderActions(): array
    protected function getPreviewModalView(): ?string
    protected function getPreviewModalDataRecordKey(): ?string
}
```

### 3. XotBasePanelProvider
La classe base per la configurazione dei pannelli:

```php
abstract class XotBasePanelProvider extends PanelProvider
{
    protected string $module;
    protected bool $topNavigation = false;
    protected bool $globalSearch = true;
    protected bool $navigation = true;

    // Metodi principali
    public function panel(Panel $panel): Panel
    protected function getModuleNamespace(): string
}
```

## Struttura Directory

```
Module/
├── app/
│   └── Filament/
│       ├── Resources/
│       │   ├── YourResource.php
│       │   └── RelationManagers/
│       ├── Pages/
│       │   └── ListYourRecords.php
│       └── Widgets/
│           └── YourWidget.php
└── providers/
    └── Filament/
        └── AdminPanelProvider.php
```

## Best Practices

### 1. Resources
- Estendere sempre `XotBaseResource`
- Implementare i metodi astratti richiesti
- Utilizzare i trait forniti per funzionalità aggiuntive
- Seguire le convenzioni di naming

### 2. List Records
- Mantenere i metodi pubblici come `public`
- Non modificare il livello di accesso dei metodi ereditati
- Implementare tutti i metodi astratti richiesti
- Utilizzare i trait per funzionalità aggiuntive

### 3. Panel Provider
- Dichiarare correttamente la proprietà `$module`
- Personalizzare le impostazioni del pannello se necessario
- Seguire le convenzioni di namespace
- Documentare le personalizzazioni

## Sicurezza

### 1. Middleware
- CSRF protection
- Autenticazione
- Gestione sessioni
- Autorizzazioni

### 2. Validazione
- Validazione dei form
- Sanitizzazione input
- Protezione XSS
- Validazione file upload

## Estensibilità

### 1. Resources
```php
class YourResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            // Schema personalizzato
        ];
    }
}
```

### 2. List Records
```php
class ListYourRecords extends XotBaseListRecords
{
    public function getTableColumns(): array
    {
        return [
            // Colonne personalizzate
        ];
    }
}
```

### 3. Panel Provider
```php
class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'YourModule';
    protected bool $topNavigation = true;
}
```

## Testing

### 1. Resource Test
```php
class YourResourceTest extends TestCase
{
    public function test_can_list_records()
    {
        // Implementazione test
    }
}
```

### 2. List Records Test
```php
class ListYourRecordsTest extends TestCase
{
    public function test_can_render_page()
    {
        // Implementazione test
    }
}
```

## Workflow di Sviluppo

1. **Setup Iniziale**
   - Creare struttura directory
   - Configurare namespace
   - Implementare classi base

2. **Implementazione**
   - Creare resources
   - Configurare list records
   - Personalizzare panel provider

3. **Testing**
   - Test unitari
   - Test funzionali
   - Test di integrazione

4. **Documentazione**
   - PHPDoc
   - README
   - CHANGELOG 
## Collegamenti tra versioni di architecture.md
* [architecture.md](docs/tecnico/filament/architecture.md)
* [architecture.md](docs/rules/architecture.md)
* [architecture.md](laravel/Modules/Gdpr/docs/architecture.md)
* [architecture.md](laravel/Modules/Cms/docs/frontoffice/architecture.md)
* [architecture.md](laravel/Modules/Cms/docs/architecture.md)
* [architecture.md](laravel/Themes/One/docs/roadmap/inspiration/architecture.md)

