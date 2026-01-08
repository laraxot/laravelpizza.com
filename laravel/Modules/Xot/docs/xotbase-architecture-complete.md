# Architettura XotBase - Sistema Completo Wrapper Filament

## Filosofia Fondamentale

> **"Mai estendere Filament direttamente - Sempre tramite XotBase"**

Questa non è una preferenza, è una **REGOLA ARCHITETTONICA FONDAMENTALE** del framework Laraxot.

## Business Logic: Perché XotBase?

### Scenario Senza XotBase ❌

```
Applicazione con 100 componenti Filament
↓
Filament rilascia breaking change
↓
TUTTI i 100 componenti devono essere modificati
↓
3-5 giorni di lavoro
↓
Rischio alto di regressioni
```

### Scenario Con XotBase ✅

```
Applicazione con 100 componenti che estendono XotBase
↓
Filament rilascia breaking change
↓
Modifichi SOLO le 10 classi XotBase
↓
2-3 ore di lavoro
↓
Rischio minimo (modifiche centralizzate)
```

**ROI**: Tempo risparmiato = 95%+ su ogni major update Filament

## Principio DRY Applicato

### Senza XotBase (Ripetizione)

```php
// File 1
class ActionA extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        // Setup comune
        $this->configurazione1();
        $this->configurazione2();
    }
}

// File 2
class ActionB extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        // Setup comune DUPLICATO
        $this->configurazione1();
        $this->configurazione2();
    }
}

// File 3, 4, 5... 100 → TUTTO DUPLICATO!
```

### Con XotBase (DRY)

```php
// UNA SOLA VOLTA in XotBaseAction
abstract class XotBaseAction extends FilamentAction
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->configurazione1();
        $this->configurazione2();
    }
}

// Tutti gli altri: ZERO duplicazione
class ActionA extends XotBaseAction { }
class ActionB extends XotBaseAction { }
class ActionC extends XotBaseAction { }
```

## Mappatura Completa Sistema

### Gerarchia Estensioni

```
Filament\Actions\Action
    ↓ NO! VIETATO!
    ↓
Modules\Xot\Filament\Actions\XotBaseAction
    ↓ SI! CORRETTO!
    ↓
Modules\[Module]\Filament\Actions\MyCustomAction
```

### Tutte le Classi XotBase Disponibili

#### 1. Actions

```php
// Filament 4 Actions
Filament\Actions\Action
    → Modules\Xot\Filament\Actions\XotBaseAction

// Table Actions
Filament\Tables\Actions\Action
    → Modules\Xot\Filament\Tables\Actions\XotBaseTableAction
```

**Percorsi**:
- `Modules/Xot/app/Filament/Actions/XotBaseAction.php`
- `Modules/Xot/app/Filament/Tables/Actions/XotBaseTableAction.php`

#### 2. Pages

```php
// Resource Pages
Filament\Resources\Pages\CreateRecord
    → Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord

Filament\Resources\Pages\EditRecord
    → Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord

Filament\Resources\Pages\ListRecords
    → Modules\Xot\Filament\Resources\Pages\XotBaseListRecords

Filament\Resources\Pages\Page
    → Modules\Xot\Filament\Resources\Pages\XotBasePage

// Standalone Pages
Filament\Pages\Page
    → Modules\Xot\Filament\Pages\XotBasePage
```

**Percorsi**:
- `Modules/Xot/app/Filament/Resources/Pages/XotBase*.php`
- `Modules/Xot/app/Filament/Pages/XotBasePage.php`

#### 3. Resources

```php
Filament\Resources\Resource
    → Modules\Xot\Filament\Resources\XotBaseResource
```

**Percorso**: `Modules/Xot/app/Filament/Resources/XotBaseResource.php`

#### 4. Widgets

```php
Filament\Widgets\Widget
    → Modules\Xot\Filament\Widgets\XotBaseWidget

Filament\Widgets\StatsOverviewWidget
    → Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget
```

**Percorsi**:
- `Modules/Xot/app/Filament/Widgets/XotBaseWidget.php`
- `Modules/Xot/app/Filament/Widgets/XotBaseStatsOverviewWidget.php`

#### 5. Form Components

```php
Filament\Forms\Components\Field
    → Modules\Xot\Filament\Forms\Components\XotBaseField

Filament\Forms\Components\Component
    → Modules\Xot\Filament\Forms\Components\XotBaseFormComponent
```

**Percorsi**:
- `Modules/Xot/app/Filament/Forms/Components/XotBaseField.php`
- `Modules/Xot/app/Filament/Forms/Components/XotBaseFormComponent.php`

#### 6. RelationManagers

```php
Filament\Resources\RelationManagers\RelationManager
    → Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager
```

**Percorso**: `Modules/Xot/app/Filament/Resources/RelationManagers/XotBaseRelationManager.php`

## Funzionalità Fornite da XotBase

### XotBaseAction

**Cosa Aggiunge**:
- Gestione traduzioni automatiche
- Metodi helper comuni
- Gestione autorizzazioni centralizzata
- Logging integrato
- Error handling standardizzato

### XotBaseResource

**Cosa Aggiunge**:
- Metodo `getFormSchema()` invece di `form()`
- Metodi `getTableColumns()` invece di definizione diretta
- NavigationLabelTrait per traduzioni automatiche
- Gestione relazioni standardizzata

### XotBasePage

**Cosa Aggiunge**:
- TransTrait per traduzioni automatiche
- Rilevamento intelligente modello
- Gestione form integrata
- Metodi helper per schema

### XotBaseWidget

**Cosa Aggiunge**:
- InteractsWithActions
- InteractsWithForms  
- TransTrait
- Gestione filtri pagina

## Regole Correlate VIETATE

### 1. VIETATO: ->label(), ->placeholder(), ->tooltip()

```php
// ❌ VIETATO
TextInput::make('name')->label('Nome');
Select::make('type')->placeholder('Seleziona');
Textarea::make('note')->helperText('Aiuto');

// ✅ CORRETTO
TextInput::make('name');    // Label automatica!
Select::make('type');       // Placeholder automatico!
Textarea::make('note');     // Helper automatico!
```

**Perché?** LangServiceProvider risolve automaticamente:
```
TextInput::make('field_name')
→ Cerca: {module}::resource.fields.field_name.label
→ Applica traduzione automatica
```

### 2. VIETATO: BadgeColumn

```php
// ❌ DEPRECATED
use Filament\Tables\Columns\BadgeColumn;

BadgeColumn::make('status');

// ✅ CORRETTO
use Filament\Tables\Columns\TextColumn;

TextColumn::make('status')->badge();
```

### 3. VIETATO: Services Tradizionali

```php
// ❌ NON USARE
namespace Modules\MyModule\Services;

class UserService
{
    public function createUser(array $data) { }
}

// ✅ USARE QueueableAction
namespace Modules\MyModule\Actions;

use Spatie\QueueableAction\QueueableAction;

class CreateUserAction
{
    use QueueableAction;
    
    public function execute(array $data): User { }
}
```

### 4. VIETATO: Proprietà in XotBasePage

```php
// ❌ NON DEFINIRE in classi che estendono XotBasePage
protected static ?string $navigationIcon = 'heroicon-o-home';
protected static ?string $title = 'Titolo';
protected static ?string $navigationLabel = 'Label';

// ✅ CORRETTO
// Nessuna proprietà! Gestite automaticamente da XotBasePage
```

## Workflow Pre-Implementazione OBBLIGATORIO

### Checklist (ESEGUIRE SEMPRE)

```bash
# 1. Identificare tipo componente necessario
echo "Devo creare: Action/Page/Resource/Widget?"

# 2. Cercare classe XotBase corrispondente
find Modules/Xot/app/Filament -name "XotBase*.php" | grep -i "action\|page\|resource\|widget"

# 3. Leggere XotBase per capire funzionalità
cat Modules/Xot/app/Filament/Actions/XotBaseAction.php

# 4. Creare classe estendendo XotBase
# Template:
# <?php
# namespace Modules\[Module]\Filament\Actions;
# use Modules\Xot\Filament\Actions\XotBaseAction;
# class MyAction extends XotBaseAction { }

# 5. VERIFICARE: nessuna estensione diretta Filament
grep -r "extends.*Filament\\" Modules/[Module]/app/Filament/ | grep -v "XotBase"
# Output deve essere VUOTO!

# 6. VERIFICARE: nessun ->label() o ->tooltip()
grep -r "->label\|->tooltip\|->placeholder\|->helperText" Modules/[Module]/app/Filament/
# Se trova risultati → ERRORE!

# 7. Creare file traduzione PRIMA del codice
touch Modules/[Module]/lang/it/actions.php

# 8. Documentare in docs/ PRIMA di implementare
touch Modules/[Module]/docs/actions/my-action.md
```

## Sistema di Prevenzione

### Git Pre-Commit Hook

```bash
#!/bin/bash
# .git/hooks/pre-commit

echo "🔍 Validazione Regole Laraxot..."

# Check 1: Estensioni dirette Filament
FILAMENT_DIRECT=$(grep -r "extends.*Filament\\" --include="*.php" Modules/*/app/Filament \
    | grep -v "XotBase" \
    | grep -v "/vendor/" \
    | wc -l)

if [ $FILAMENT_DIRECT -gt 0 ]; then
    echo "❌ ERRORE CRITICO: Estensioni dirette di classi Filament trovate!"
    echo ""
    grep -r "extends.*Filament\\" --include="*.php" Modules/*/app/Filament \
        | grep -v "XotBase" \
        | grep -v "/vendor/"
    echo ""
    echo "➡️  USA: XotBaseAction, XotBaseResource, XotBasePage, etc."
    echo "➡️  VEDI: Modules/Xot/docs/errori-critici/mai-estendere-filament-direttamente.md"
    exit 1
fi

# Check 2: Uso di ->label(), ->tooltip(), etc
TRANSLATION_METHODS=$(grep -rn "->label(\|->tooltip(\|->placeholder(\|->helperText(" \
    --include="*.php" \
    Modules/*/app/Filament \
    | grep -v "getLabel\|setLabel" \
    | wc -l)

if [ $TRANSLATION_METHODS -gt 0 ]; then
    echo "⚠️  WARNING: Uso di metodi traduzione vietati!"
    echo "   Trovate $TRANSLATION_METHODS occorrenze di ->label()/->tooltip()/etc"
    echo ""
    echo "➡️  RIMUOVERE: Traduzioni automatiche tramite LangServiceProvider"
    echo "➡️  VEDI: Modules/Xot/docs/translation-system.md"
    # Non blocca commit ma avvisa
fi

# Check 3: BadgeColumn deprecated
BADGE_COLUMN=$(grep -rn "BadgeColumn" --include="*.php" Modules/*/app/Filament \
    | wc -l)

if [ $BADGE_COLUMN -gt 0 ]; then
    echo "⚠️  WARNING: BadgeColumn è deprecated!"
    echo "   Usare TextColumn con ->badge() invece"
fi

echo "✅ Validazione completata"
```

### PHPStan Rule Custom

```php
<?php
// phpstan/Rules/NoDirectFilamentExtensionRule.php

declare(strict_types=1);

namespace App\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Regola PHPStan per impedire estensione diretta di classi Filament.
 * 
 * @implements Rule<Class_>
 */
class NoDirectFilamentExtensionRule implements Rule
{
    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @param Class_ $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->extends === null) {
            return [];
        }

        $extendsName = $node->extends->toString();

        // Controlla se estende direttamente una classe Filament
        if (str_starts_with($extendsName, 'Filament\\')) {
            // Verifica se NON è una classe XotBase (che è permessa)
            $className = $node->namespacedName?->toString() ?? 'Unknown';
            
            if (!str_contains($className, 'XotBase')) {
                return [
                    RuleErrorBuilder::message(sprintf(
                        "Classe '%s' estende direttamente '%s'. " .
                        "VIETATO! Usa una classe XotBase* invece. " .
                        "Vedi: Modules/Xot/docs/errori-critici/mai-estendere-filament-direttamente.md",
                        $className,
                        $extendsName
                    ))->build(),
                ];
            }
        }

        return [];
    }
}
```

### Configurazione PHPStan

```neon
# phpstan.neon
rules:
    - App\PHPStan\Rules\NoDirectFilamentExtensionRule

parameters:
    customRulesetUsed: true
```

## Elenco Completo Classi XotBase

### Actions & Commands
- `XotBaseAction` - Base per Actions Filament
- `XotBaseTableAction` - Base per Table Actions
- `XotBaseCommand` - Base per Artisan Commands

### Pages
- `XotBasePage` - Base per standalone Pages
- `XotBaseCreateRecord` - Base per Create pages
- `XotBaseEditRecord` - Base per Edit pages  
- `XotBaseListRecords` - Base per List pages
- `XotBaseViewRecord` - Base per View pages
- `XotBaseManageRelatedRecords` - Base per Manage pages

### Resources
- `XotBaseResource` - Base per Resources

### Widgets
- `XotBaseWidget` - Base per Widget generici
- `XotBaseStatsOverviewWidget` - Base per Stats widgets
- `XotBaseChartWidget` - Base per Chart widgets

### Form Components
- `XotBaseField` - Base per campi form
- `XotBaseFormComponent` - Base per componenti form

### Table Components
- `XotBaseColumn` - Base per colonne tabella

### RelationManagers
- `XotBaseRelationManager` - Base per Relation Managers

## Come Trovare la Classe XotBase Giusta

### Metodo 1: Ricerca per Nome

```bash
# Cercare per tipo
find Modules/Xot/app/Filament -name "XotBase*Action*.php"
find Modules/Xot/app/Filament -name "XotBase*Page*.php"
find Modules/Xot/app/Filament -name "XotBase*Resource*.php"
```

### Metodo 2: Grepping

```bash
# Cercare per estensione Filament
grep -r "extends Filament" Modules/Xot/app/Filament/ --include="*.php"

# Output mostra tutte le classi XotBase e cosa estendono
```

### Metodo 3: Documentazione

Consultare: `Modules/Xot/docs/filament/xotbase-classes-reference.md`

## Cosa Fare Se XotBase Non Esiste

### Scenario: Serve Action ma XotBaseAction non esiste ancora

1. **NON creare** la classe estendendo Filament direttamente
2. **CREARE** prima XotBaseAction in `Modules/Xot`
3. **POI** creare la classe custom estendendo XotBaseAction

**Template XotBase**:
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Actions;

use Filament\Actions\Action as FilamentAction;

/**
 * Classe base per tutte le Actions Filament del sistema.
 * 
 * Fornisce funzionalità comuni e permette override centralizzato
 * per gestire breaking changes futuri di Filament.
 */
abstract class XotBaseAction extends FilamentAction
{
    // Funzionalità comuni a tutte le actions
    // Override centralizzati
    // Helper methods
}
```

## Errori Comuni e Correzioni

### Errore 1: Estensione Diretta

```php
// ❌ ERRORE
use Filament\Actions\Action;

class MyAction extends Action { }
```

**Correzione**:
```php
// ✅ CORRETTO
use Modules\Xot\Filament\Actions\XotBaseAction;

class MyAction extends XotBaseAction { }
```

### Errore 2: Metodi Traduzione

```php
// ❌ ERRORE
protected function setUp(): void
{
    parent::setUp();
    $this->label('Etichetta')
        ->tooltip('Descrizione');
}
```

**Correzione**:
```php
// ✅ CORRETTO
protected function setUp(): void
{
    parent::setUp();
    // NESSUN ->label() o ->tooltip()
    // LangServiceProvider li gestisce automaticamente!
}
```

### Errore 3: Import Sbagliato

```php
// ❌ ERRORE
use Filament\Resources\Pages\ListRecords;

class ListMyModels extends ListRecords { }
```

**Correzione**:
```php
// ✅ CORRETTO
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListMyModels extends XotBaseListRecords { }
```

## Testing della Conformità

### Test Automatico

```php
<?php

use Illuminate\Support\Facades\File;

test('no direct filament extensions in modules', function () {
    $files = File::allFiles(base_path('Modules'));
    
    foreach ($files as $file) {
        if (!str_ends_with($file->getFilename(), '.php')) {
            continue;
        }
        
        if (str_contains($file->getPath(), '/vendor/')) {
            continue;
        }
        
        if (str_contains($file->getPath(), '/Xot/app/Filament/')) {
            // Le classi XotBase possono estendere Filament
            continue;
        }
        
        $content = $file->getContents();
        
        // Verifica estensioni dirette Filament
        if (preg_match('/extends\s+Filament\\\\/', $content)) {
            $this->fail(
                "File {$file->getRelativePathname()} estende direttamente una classe Filament! " .
                "Usa XotBase* invece."
            );
        }
    }
    
    expect(true)->toBeTrue();
});
```

## Collegamenti

### Documentazione Fondamentale
- [Errore Critico Documentato](./errori-critici/mai-estendere-filament-direttamente.md)
- [Service Provider Architecture](./service-provider-architecture.md)
- [Translation System](./translation-system.md)

### Regole Progetto
- [Filament Class Rules](../../../.cursor/rules/filament-class-rules.mdc)
- [Laraxot Conventions](../../../docs/laraxot-conventions.md)

### Esempi Corretti
- [Activity - ListLogActivitiesAction](../../Activity/app/Filament/Actions/ListLogActivitiesAction.php) - ✅ Corretto dopo fix
- [Performance - Actions](../../Performance/app/Filament/Actions/) - ✅ Esempi corretti

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Importanza**: ⚠️⚠️⚠️ CRITICA  
**Non Derogabile**: Questa regola NON ha eccezioni  
**Filosofia**: "XotBase è il nostro contratto con il futuro"


