# Filament Resources

## ⚠️ IMPORTANTE: Metodi da NON Implementare
I seguenti metodi sono gestiti da XotBaseResource e **NON DEVONO** essere sovrascritti:
- `form()`
- `table()`
- `getPages()` (se standard)
- `getTableColumns()`
- `getTableFilters()`
- `getTableActions()`
- `getTableBulkActions()`
- `getNavigationGroup()`

## Metodi da Implementare
```php
class MyResource extends XotBaseResource
{
    protected static ?string $model = MyModel::class;

    // OBBLIGATORIO
    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }
}
```

## Struttura Base
```php
namespace Modules\ModuleName\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class MyResource extends XotBaseResource
{
    protected static ?string $model = MyModel::class;

    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }
}
```

## Gerarchia delle Classi
1. **XotBaseResource** (Modulo Xot)
   - Gestisce traduzioni (TransTrait)
   - Gestisce form base (final)
   - Gestisce table base (final)
   - Gestisce pagine base (final)
   - Gestisce colonne tabella
   - Gestisce filtri tabella
   - Gestisce azioni tabella
   - Gestisce navigazione

2. **ModuleResource** (Modulo Specifico)
   - Estende XotBaseResource
   - Implementa SOLO getFormSchema
   - NON sovrascrive metodi della tabella
   - NON sovrascrive metodi di navigazione

## Traduzioni
- Gestite automaticamente da LangServiceProvider
- File traduzioni in `resources/lang/it/`
- Struttura standard per fields e actions
- NON usare metodi di traduzione diretti

## Struttura File Traduzioni
```php
// resources/lang/it/module_name.php
return [
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta',
            'placeholder' => 'Placeholder',
            'helper_text' => 'Testo di aiuto',
        ],
    ],
    'actions' => [
        'action_name' => [
            'label' => 'Etichetta Azione',
            'icon' => 'heroicon-o-icon-name',
            'color' => 'primary|warning|danger|success|info',
        ],
    ],
];
```

## Best Practices
1. **Struttura**:
   - Un Resource per Model
   - Namespace corretto
   - Estendere XotBaseResource
   - NON sovrascrivere metodi non necessari

2. **Traduzioni**:
   - File traduzioni per modulo
   - Struttura standard
   - No hardcoding
   - Gestione automatica

3. **Form Schema**:
   - Campi validati
   - Relazioni gestite
   - Layout responsive
   - UI/UX ottimizzata

4. **Ereditarietà**:
   - Estendere SEMPRE `XotBaseResource`
   - NON estendere direttamente classi Filament
   - Verificare la gerarchia delle classi
   - Rispettare il pattern di ereditarietà

5. **Implementazione**:
   - Implementare SOLO `getFormSchema()`
   - NON sovrascrivere metodi già gestiti
   - Mantenere codice minimo
   - Seguire il pattern standard

6. **Traduzioni**:
   - Usare file di traduzioni
   - Struttura standard:
     ```php
     'fields' => [
         'name' => ['label' => 'Nome'],
         'email' => ['label' => 'Email'],
     ]
     ```
   - NO hardcoding di traduzioni
   - NO uso di `->label()`, `->placeholder()`, `->helperText()`

7. **Metodi Deprecati**:
   - `getListTableColumns()` - DEPRECATO
   - `getGridTableColumns()` - DEPRECATO
   - Usare `getTableColumns()` con layout appropriato
   - Verificare la documentazione per aggiornamenti

8. **Anti-pattern**:
   - ❌ Estendere direttamente classi Filament
   - ❌ Implementare metodi non necessari
   - ❌ Hardcoding traduzioni
   - ❌ Duplicazione codice
   - ❌ Uso di metodi deprecati

## Esempio Corretto
```php
namespace Modules\Xot\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class ExampleResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            // Schema form
        ];
    }
}
```

## Note Importanti
1. **Responsabilità**:
   - XotBaseResource gestisce la logica comune
   - Resources specifici gestiscono SOLO lo schema form
   - Traduzioni gestite tramite file di lingua
   - Layout gestito tramite configurazione

2. **Manutenzione**:
   - Verificare aggiornamenti Filament
   - Controllare metodi deprecati
   - Aggiornare documentazione
   - Mantenere codice pulito

3. **Performance**:
   - Minimizzare codice
   - Evitare duplicazioni
   - Usare cache quando possibile
   - Ottimizzare query

4. **Sicurezza**:
   - Validare input
   - Gestire permessi
   - Proteggere dati sensibili
   - Logging appropriato

## Checklist Implementazione
1. [ ] Estendere XotBaseResource
2. [ ] Definire model
3. [ ] Implementare getFormSchema
4. [ ] NON implementare metodi non necessari
5. [ ] Creare file traduzioni
6. [ ] Verificare namespace
7. [ ] Testare funzionalità
8. [ ] Documentare codice

## Note Importanti
- XotBaseResource include già TransTrait
- Le traduzioni sono gestite automaticamente
- NON sovrascrivere metodi non necessari
- Seguire la struttura standard
- Mantenere coerenza tra moduli

## XotBaseResource

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

## Implementazione

### 1. Creazione Resource
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

### 2. Struttura Directory
```
Module/
└── app/
    └── Filament/
        └── Resources/
            ├── ArticleResource.php
            └── RelationManagers/
                └── CommentsRelationManager.php
```

### 3. Funzionalità Base
- Rilevamento automatico del modello
- Badge di navigazione
- Pagine standard (List, Create, Edit, View)
- Relation managers automatici
- Traduzioni integrate

### 4. Best Practices
- Naming: `ModelNameResource`
- Namespace: `Modules\ModuleName\Filament\Resources`
- Implementare sempre `getFormSchema()`
- Utilizzare type hints
- Documentare PHPDoc

### 5. Esempio Completo
```php
declare(strict_types=1);

namespace Modules\Blog\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class ArticleResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }

    public static function getNavigationGroup(): string
    {
        return 'Blog';
    }
}
```

## Relation Managers

### 1. Creazione
```php
class CommentsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'comments';
    protected static ?string $recordTitleAttribute = 'title';
}
```

### 2. Struttura Directory
```
Module/
└── app/
    └── Filament/
        └── Resources/
            └── ArticleResource/
                └── RelationManagers/
                    └── CommentsRelationManager.php
```

### 3. Best Practices
- Naming: `RelatedModelRelationManager`
- Definire sempre `$relationship`
- Definire `$recordTitleAttribute`
- Utilizzare type hints
- Documentare PHPDoc

## Testing

### 1. Resource Test
```php
class ArticleResourceTest extends TestCase
{
    public function test_can_list_articles()
    {
        // Test implementation
    }
}
```

### 2. Relation Manager Test
```php
class CommentsRelationManagerTest extends TestCase
{
    public function test_can_list_comments()
    {
        // Test implementation
    }
}
```

## Workflow di Sviluppo

1. **Setup Iniziale**
   - Creare directory Resources
   - Creare classe base
   - Configurare namespace

2. **Implementazione**
   - Definire schema form
   - Configurare navigazione
   - Aggiungere relation managers

3. **Testing**
   - Test resource
   - Test relation managers
   - Test navigazione

4. **Documentazione**
   - PHPDoc
   - README
   - CHANGELOG 
## Collegamenti tra versioni di resources.md
* [resources.md](docs/tecnico/filament/resources.md)
* [resources.md](laravel/Modules/UI/docs/filament/resources.md)

