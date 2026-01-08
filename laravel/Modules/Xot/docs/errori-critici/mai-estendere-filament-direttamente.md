# ERRORE CRITICO: Mai Estendere Classi Filament Direttamente

## ⚠️ REGOLA FONDAMENTALE LARAXOT

**NON ESTENDERE MAI CLASSI FILAMENT DIRETTAMENTE**

Estendere SEMPRE una classe XotBase* che a sua volta estende Filament.

## Motivazione Business Logic

### Perché Questa Regola?

1. **Controllo Centralizzato**: Modifiche globali in un solo punto
2. **Compatibilità Futura**: Aggiornamenti Filament gestiti in XotBase*
3. **Override Locale**: Funzionalità custom senza toccare vendor
4. **Coerenza Sistema**: Comportamento uniforme tra moduli
5. **Manutenibilità**: Debug e fix centralizzati

### Cosa Succede Senza XotBase?

❌ **Scenario Problematico**:
```
Filament aggiorna da v3 → v4
↓
Cambiano 50 metodi in Action
↓
TUTTI i moduli rotti (100+ files da modificare)
↓
Giorni di lavoro per fix
```

✅ **Con XotBase**:
```
Filament aggiorna da v3 → v4
↓
Modifichi SOLO XotBaseAction (1 file)
↓
TUTTI i moduli funzionano
↓
30 minuti di lavoro
```

## Mappatura Completa Classi

### Pages

| ❌ NON Usare | ✅ Usare Invece |
|-------------|----------------|
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\Page` | `Modules\Xot\Filament\Resources\Pages\XotBasePage` |
| `Filament\Pages\Page` | `Modules\Xot\Filament\Pages\XotBasePage` |

### Resources

| ❌ NON Usare | ✅ Usare Invece |
|-------------|----------------|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |

### Actions

| ❌ NON Usare | ✅ Usare Invece |
|-------------|----------------|
| `Filament\Actions\Action` | `Modules\Xot\Filament\Actions\XotBaseAction` |
| `Filament\Tables\Actions\Action` | `Modules\Xot\Filament\Tables\Actions\XotBaseTableAction` |

### Widgets

| ❌ NON Usare | ✅ Usare Invece |
|-------------|----------------|
| `Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |
| `Filament\Widgets\StatsOverviewWidget` | `Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget` |

### Form Components

| ❌ NON Usare | ✅ Usare Invece |
|-------------|----------------|
| `Filament\Forms\Components\Field` | `Modules\Xot\Filament\Forms\Components\XotBaseField` |
| `Filament\Forms\Components\Component` | `Modules\Xot\Filament\Forms\Components\XotBaseFormComponent` |

### RelationManagers

| ❌ NON Usare | ✅ Usare Invece |
|-------------|----------------|
| `Filament\Resources\RelationManagers\RelationManager` | `Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager` |

## Esempi di Errori e Correzioni

### ❌ ERRORE: Action Estende Filament Direttamente

```php
<?php

namespace Modules\Activity\Filament\Actions;

use Filament\Actions\Action;  // ❌ ERRORE CRITICO!

class ListLogActivitiesAction extends Action  // ❌ ESTENSIONE DIRETTA!
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->tooltip('Visualizza cronologia');  // ❌ ALTRO ERRORE! (tooltip hardcoded)
    }
}
```

**Problemi**:
1. Estende Filament direttamente (viola regola fondamentale)
2. Usa `->tooltip()` invece di traduzioni automatiche
3. Nessun controllo centralizzato

### ✅ CORRETTO: Action Estende XotBaseAction

```php
<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Actions;

use Modules\Xot\Filament\Actions\XotBaseAction;  // ✅ CORRETTO!

/**
 * ⚠️ IMPORTANTE: Estende XotBaseAction, MAI Filament\Actions\Action!
 */
class ListLogActivitiesAction extends XotBaseAction  // ✅ ESTENSIONE CORRETTA!
{
    public static function getDefaultName(): ?string
    {
        return 'list_log_activities';
    }

    protected function setUp(): void
    {
        parent::setUp();
        
        // ✅ NESSUN ->tooltip() o ->label()
        // Le traduzioni avvengono automaticamente tramite LangServiceProvider
        // usando il nome 'list_log_activities'
        
        $this->icon('heroicon-o-clock')
            ->color('gray')
            ->url(function ($livewire, $record): string {
                return $livewire->getResource()::getUrl('log-activity', ['record' => $record]);
            });
    }
}
```

## Regole Correlate

### VIETATO: Usare ->label(), ->placeholder(), ->tooltip()

**Perché?** Il `LangServiceProvider` gestisce automaticamente le traduzioni basandosi sul nome del componente.

```php
// ❌ VIETATO
TextInput::make('name')
    ->label('Nome')              // NO!
    ->placeholder('Inserisci')   // NO!
    ->helperText('Aiuto');       // NO!

// ✅ CORRETTO
TextInput::make('name');  // Tradotto automaticamente!
```

**Come Funziona**:
```php
// LangServiceProvider risolve automaticamente:
TextInput::make('name')
↓
$transKey = "{modulename}::resource.fields.name.label"
↓
Applica traduzione automatica senza ->label()
```

### VIETATO: Usare BadgeColumn

```php
// ❌ DEPRECATED
use Filament\Tables\Columns\BadgeColumn;

BadgeColumn::make('status');

// ✅ CORRETTO
use Filament\Tables\Columns\TextColumn;

TextColumn::make('status')
    ->badge();
```

### VIETATO: Usare Services

```php
// ❌ NON USARE Services tradizionali
namespace Modules\MyModule\Services;

class MyService
{
    public function process($data) { }
}

// ✅ USARE Spatie QueueableAction
namespace Modules\MyModule\Actions;

use Spatie\QueueableAction\QueueableAction;

class ProcessDataAction
{
    use QueueableAction;
    
    public function execute($data) { }
}
```

## Sistema di Validazione

### Pre-Commit Hook

Creare uno script per verificare violazioni:

```bash
#!/bin/bash
# .git/hooks/pre-commit

echo "🔍 Verifica violazioni regole Laraxot..."

# Cerca estensioni dirette di classi Filament
VIOLATIONS=$(grep -r "extends.*Filament\\" --include="*.php" Modules/ \
    | grep -v "XotBase" \
    | grep -v "vendor" \
    | wc -l)

if [ $VIOLATIONS -gt 0 ]; then
    echo "❌ ERRORE: Trovate $VIOLATIONS estensioni dirette di classi Filament!"
    echo "   Usa sempre classi XotBase*"
    grep -r "extends.*Filament\\" --include="*.php" Modules/ | grep -v "XotBase"
    exit 1
fi

# Cerca uso di ->label(), ->tooltip(), ->placeholder()
LABEL_VIOLATIONS=$(grep -r "->label\|->tooltip\|->placeholder\|->helperText" --include="*.php" Modules/*/app/Filament \
    | grep -v "getLabel\|setLabel" \
    | wc -l)

if [ $LABEL_VIOLATIONS -gt 0 ]; then
    echo "⚠️  WARNING: Trovati $LABEL_VIOLATIONS usi di ->label()/->tooltip()/->placeholder()"
    echo "   Le traduzioni devono avvenire automaticamente!"
fi

echo "✅ Validazione completata"
```

### PHPStan Custom Rule

```php
// phpstan-laraxot-rules.php
<?php

namespace App\PHPStan\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

class NoDirectFilamentExtensionRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Stmt\Class_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node->extends) {
            return [];
        }

        $extends = $node->extends->toString();
        
        if (str_starts_with($extends, 'Filament\\') && !str_contains($extends, 'XotBase')) {
            return [
                "MAI estendere classi Filament direttamente! Usa una classe XotBase*"
            ];
        }

        return [];
    }
}
```

## Checklist Pre-Implementazione

Prima di creare QUALSIASI classe Filament:

- [ ] Verificare se esiste classe XotBase* corrispondente
- [ ] NON estendere MAI classi Filament direttamente
- [ ] NON usare ->label(), ->tooltip(), ->placeholder()
- [ ] Verificare file di traduzione creati correttamente
- [ ] Documentare l'implementazione nelle docs del modulo
- [ ] Aggiungere test per la classe
- [ ] Eseguire PHPStan per validazione

## Workflow Corretto

### 1. Prima di Scrivere Codice

```bash
# Cercare se esiste XotBase* per il tipo di classe necessario
find Modules/Xot/app/Filament -name "XotBase*.php"

# Output mostra tutte le classi base disponibili:
# XotBaseAction.php
# XotBaseResource.php
# XotBasePage.php
# XotBaseWidget.php
# ... etc
```

### 2. Template Classe

```php
<?php

declare(strict_types=1);

namespace Modules\[Module]\Filament\Actions;

use Modules\Xot\Filament\Actions\XotBaseAction;  // ✅ SEMPRE XotBase!

/**
 * ⚠️ IMPORTANTE: Estende XotBaseAction, MAI Filament\Actions\Action!
 */
class MyCustomAction extends XotBaseAction
{
    public static function getDefaultName(): ?string
    {
        return 'my_custom_action';
    }

    protected function setUp(): void
    {
        parent::setUp();
        
        // ✅ NESSUN ->label() o ->tooltip()!
        // Traduzioni automatiche tramite: {module}::actions.my_custom_action.*
        
        $this->icon('heroicon-o-star')
            ->color('primary')
            ->action(fn () => $this->doSomething());
    }
}
```

### 3. File Traduzione

```php
// Modules/[Module]/lang/it/actions.php
return [
    'my_custom_action' => [
        'label' => 'Azione Personalizzata',
        'tooltip' => 'Descrizione azione',
        'modal' => [
            'heading' => 'Conferma Azione',
        ],
    ],
];
```

## Documentazione Errore

### Caso Reale: ListLogActivitiesAction

**Data**: 27 Ottobre 2025  
**File**: `Modules/Activity/app/Filament/Actions/ListLogActivitiesAction.php`  
**Errore**: Estensione diretta di `Filament\Actions\Action`

**Cosa è Successo**:
1. Implementato Action estendendo Filament direttamente
2. Usato `->tooltip()` hardcoded
3. Non verificato esistenza `XotBaseAction`

**Impatto**:
- ⚠️ Violazione architettura Laraxot
- ⚠️ Manutenibilità compromessa
- ⚠️ Pattern anti-DRY

**Correzione Applicata**:
1. ✅ Cambiato estensione a `XotBaseAction`
2. ✅ Rimosso `->tooltip()` (traduzione automatica)
3. ✅ Aggiunto warning PHPDoc
4. ✅ Documentato errore

**Prevenzione**:
- Memoria permanente creata
- Regole aggiornate in .cursor e .windsurf
- Checklist pre-implementazione documentata
- Pre-commit hook suggerito

## Collegamenti

### Regole Fondamentali
- [Filament Class Rules](./../../.cursor/rules/filament-custom-actions.mdc)
- [XotBase Architecture](./xotbase-architecture.md)
- [Translation System](./translation-system.md)

### Classi Base Disponibili
- [XotBaseAction](../app/Filament/Actions/XotBaseAction.php)
- [XotBaseResource](../app/Filament/Resources/XotBaseResource.php)
- [XotBasePage](../app/Filament/Pages/XotBasePage.php)
- [XotBaseWidget](../app/Filament/Widgets/XotBaseWidget.php)

### Errori Simili Documentati
- [No Hint Path Defined](../../Activity/docs/errori/no-hint-path-defined.md)
- [Service Provider Issues](./service-provider-issues.md)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Severità**: CRITICA  
**Categoria**: Violazione Architettura Fondamentale  
**Status**: ✅ CORRETTO e DOCUMENTATO


