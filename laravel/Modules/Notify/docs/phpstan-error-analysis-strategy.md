# Strategia Correzione Errori PHPStan - SendEmailPage.php

**Data**: 2025-12-23
**File**: `app/Filament/Clusters/Test/Pages/SendEmailPage.php`
**Errori**: 4

## 🔍 Analisi Approfondita Errori

### Errore #1: Unknown Class (Line 49)

**Messaggio PHPStan**:
```
PHPDoc tag @var for variable $formSchema contains unknown class
Filament\Facades\Filament\Schemas\Components\Component.
```

**Codice Attuale** (Line 48):
```php
/** @var array<string, Component> $formSchema */
$formSchema = $this->getEmailFormSchema();
```

**Problema**:
- Import errato: `use Filament\Facades\Filament\Schemas\Components\Component;` (Line 7)
- Namespace corretto: `Filament\Schemas\Components\Component`

**Soluzione**: Correggere l'import

### Errore #2: Argument Type Mismatch (Line 51)

**Messaggio PHPStan**:
```
Parameter #1 $components of method Filament\Schemas\Schema::components() expects
array<Illuminate\Contracts\Support\Htmlable|string>|Closure|Illuminate\Contracts\Support\Htmlable|string,
array<string, Filament\Facades\Filament\Schemas\Components\Component> given.
```

**Codice Attuale**:
```php
return $schema->components($formSchema)->model($this->getUser())->statePath('emailData');
```

**Problema**:
- `$formSchema` ha tipo `array<string, Filament\Facades\Filament\Schemas\Components\Component>` (namespace errato)
- Il metodo si aspetta un tipo diverso

**Soluzione**: Dopo correzione import, questo errore dovrebbe risolversi

### Errore #3: Invalid Return Type (Line 57)

**Messaggio PHPStan**:
```
Method getEmailFormSchema() has invalid return type
Filament\Facades\Filament\Schemas\Components\Component.
```

**Codice Attuale** (Line 54-57):
```php
/**
 * @return array<string, Component>
 */
public function getEmailFormSchema(): array
```

**Problema**: `Component` nel PHPDoc si riferisce a namespace errato

**Soluzione**: Dopo correzione import, aggiornare PHPDoc

### Errore #4: Return Type Mismatch (Line 59)

**Messaggio PHPStan**:
```
Method getEmailFormSchema() should return array<string, Filament\Facades\Filament\Schemas\Components\Component>
but returns array<string, Filament\Schemas\Components\Section>.
```

**Codice Attuale** (Line 59-70):
```php
return [
    'section' => Section::make()
        ->schema([
            'recipient' => TextInput::make('recipient'),
            // ...
        ]),
];
```

**Problema**:
- Il metodo ritorna `array<string, Section>`
- Il PHPDoc dice `array<string, Component>`
- `Section` estende `Component`, quindi il tipo è corretto ma il PHPDoc è troppo specifico

**Soluzione**: Il PHPDoc `array<string, Component>` è corretto perché `Section extends Component`. Dopo correzione import, questo errore dovrebbe risolversi.

## 🎯 Strategia di Correzione

### Passo 1: Correggere Import

**Prima**:
```php
use Filament\Facades\Filament\Schemas\Components\Component;
```

**Dopo**:
```php
use Filament\Schemas\Components\Component;
```

### Passo 2: Verificare Altri Import

Controllare che anche `Section` e `Schema` abbiano import corretti:
```php
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
```

### Passo 3: Validare PHPDoc

Il PHPDoc `@return array<string, Component>` è corretto perché `Section extends Component`.

## 📝 Note

Tutti gli errori derivano da un namespace errato nell'import. La correzione è semplice: usare `Filament\Schemas\Components\Component` invece di `Filament\Facades\Filament\Schemas\Components\Component`.
