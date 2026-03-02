# Bugfix: GroupColumn Architectural Violations

**Data Fix**: 11 Novembre 2025
**Status**: ✅ RISOLTO

## Problema

**Multiple Violazioni Regole Architetturali Laraxot** nel file `GroupColumn.php` e relativa view.

## 🔴 Violazioni Critiche

### 1. Reference Diretta a Classe Filament

```php
// ❌ PRIMA - Linea 28
return $item instanceof \Filament\Tables\Columns\Column;
```

**Violazione**: MAI referenziare classi Filament direttamente

**Problema**:
- Contraddice PHPDoc: `@var array<XotBaseColumn>`
- Accoppiamento diretto con Filament
- Viola pattern architetturale XotBase

```php
// ✅ DOPO
return $item instanceof XotBaseColumn;
```

### 2. Uso di `->getLabel()` nella View

```php
// ❌ PRIMA - group.blade.php linea 37
$label = $field->getLabel() ?? $name;
```

**Violazione Regola Laraxot Fondamentale**:
> **MAI utilizzare `->label()` o `->getLabel()` direttamente**
> Crea accoppiamento stretto e viola la separazione delle responsabilità.
> Utilizzare LangServiceProvider per tutte le traduzioni.

```php
// ✅ DOPO
$label = __('ui::table.columns.' . $name . '.label');
```
### 2. Gestione Label Localizzate (Aggiornamento 18 Nov 2025)

```php
// ✅ ATTUALE - group.blade.php
$rawLabel = $field->getLabel();
// ... fallback automatici e sanitizzazione
```

**Motivazione aggiornata**:
- LangServiceProvider assegna automaticamente le label ai componenti Filament
- GroupColumn ora utilizza `getLabel()` (che contiene già la traduzione) e applica fallback:
  1. `getLabel()` (inclusi Htmlable/Closure)
  2. `__('ui::table.columns.{name}.label')`
  3. `Str::headline($name)`

Questo garantisce:
- Compatibilità con l'automazione esistente
- Nessuna hardcoded namespace
- Traduzioni sempre presenti anche se mancano le chiavi `ui::table.*`

### 3. Proprietà Inutilizzata (Dead Code)

```php
// ❌ PRIMA - Linea 11
public array $form = [];
```

**Problema**:
- Dichiarata ma MAI usata
- Solo il parametro `$form` del metodo viene usato
- Codice morto aumenta complessità

```php
// ✅ DOPO
// Proprietà rimossa completamente
```

## 🟡 Violazioni Medie

### 4. Return Type Non Ottimale

```php
// ❌ PRIMA
public function schema(array $form): self

// ✅ DOPO - Supporta Late Static Binding
public function schema(array $form): static
```

### 5. Metodo Vuoto Inutile

```php
// ❌ PRIMA
protected function setUp(): void
{
    parent::setUp();
    // Component initialization logic
}

// ✅ DOPO
// Metodo rimosso completamente
```

### 6. Output Non Escapato (XSS Risk)

```php
// ❌ PRIMA - group.blade.php linea 41
{!! $displayText !!}<br/>

// ✅ DOPO - Sicuro contro XSS
{{ $displayText }}<br/>
```

## 🟢 Violazioni Minori

### 7. Spacing PSR-12

```php
// ❌ PRIMA
$fields=$getFields();
$record=$getRecord();

// ✅ DOPO
$fields = $getFields();
$record = $getRecord();
```

### 8. getAttribute() vs Direct Access

```php
// ❌ PRIMA
$value = $record->getAttribute($name);

// ✅ DOPO - Pattern Laraxot (attributi magici)
$value = $record->{$name} ?? null;
```

## Correzioni Applicate

### File PHP: `GroupColumn.php`

**Modifiche**:
1. ✅ Rimossa proprietà `$form` inutilizzata
2. ✅ Cambiato `instanceof \Filament\Tables\Columns\Column` → `instanceof XotBaseColumn`
3. ✅ Cambiato return type `self` → `static`
4. ✅ Rimosso metodo `setUp()` vuoto

**Prima**:
```php
final class GroupColumn extends XotBaseColumn
{
    public array $form = [];  // ❌ Dead code

    protected array $schema = [];

    public function schema(array $form): self  // ❌ self invece di static
    {
        $this->schema = array_filter($form, function ($item) {
            return $item instanceof \Filament\Tables\Columns\Column;  // ❌ Reference diretta
        });
        return $this;
    }

    protected function setUp(): void  // ❌ Metodo vuoto
    {
        parent::setUp();
    }
}
```

**Dopo**:
```php
final class GroupColumn extends XotBaseColumn
{
    protected array $schema = [];  // ✅ Clean

    public function schema(array $form): static  // ✅ static
    {
        $this->schema = array_filter($form, function ($item) {
            return $item instanceof XotBaseColumn;  // ✅ XotBase
        });
        return $this;
    }
    // ✅ setUp() rimosso
}
```

### File Blade: `group.blade.php`

**Modifiche**:
1. ✅ Spacing PSR-12 corretto
2. ✅ `->getLabel()` sostituito con `__()` translation
3. ✅ `{!! !!}` sostituito con `{{ }}` (escaped)
4. ✅ `->getAttribute()` sostituito con accesso diretto

**Prima**:
```blade
@php
    $fields=$getFields();  // ❌ No spacing
    $record=$getRecord();
@endphp

@foreach ($fields as $field)
    @php
        $name = $field->getName();
        $value = $record->getAttribute($name);  // ❌ getAttribute
        $label = $field->getLabel() ?? $name;  // ❌ getLabel()
        $displayText = $label . ': ' . $formattedValue;
    @endphp
    {!! $displayText !!}<br/>  // ❌ Unescaped
@endforeach
```

**Dopo**:
```blade
@php
    $fields = $getFields();  // ✅ PSR-12
**Dopo (18 Nov 2025)**:
```blade
@php
    $fields = $getFields();
    $record = $getRecord();
@endphp

@foreach ($fields as $field)
    @php
        $name = $field->getName();
        $value = $record->{$name} ?? null;  // ✅ Direct access
        $label = __('ui::table.columns.' . $name . '.label');  // ✅ Translation
        $displayText = $label . ': ' . $formattedValue;
    @endphp
    {{ $displayText }}<br/>  // ✅ Escaped
        $value = $record->{$name} ?? null;

        if (empty($value) && $value !== 0 && $value !== '0') {
            continue;
        }

        $rawLabel = $field->getLabel();

        if ($rawLabel instanceof \Closure) {
            $rawLabel = $rawLabel($record);
        }

        if ($rawLabel instanceof \Illuminate\Contracts\Support\Htmlable) {
            $labelText = trim(strip_tags($rawLabel->toHtml()));
        } elseif (is_string($rawLabel)) {
            $labelText = trim($rawLabel);
        } else {
            $labelText = '';
        }

        if ($labelText === '') {
            $translationKey = 'ui::table.columns.' . $name . '.label';
            $translated = __($translationKey);
            $labelText = $translated !== $translationKey
                ? $translated
                : \Illuminate\Support\Str::of((string) $name)->replace('_', ' ')->headline()->value();
        }
    @endphp

    {{ $labelText }}: {{ $value }}<br/>
@endforeach
```

## Verifica

- ✅ Nessuna reference diretta a classi Filament
- ✅ Tutte le label usano sistema traduzione
- ✅ Codice morto rimosso
- ✅ Return type ottimizzato
- ✅ Output escapato (sicuro XSS)
- ✅ PSR-12 compliant
- ✅ PHPDoc consistente con implementazione

## Pattern Architetturale Corretto

```
Column (Filament - DO NOT REFERENCE)
└── XotBaseColumn (Xot - abstract wrapper)
    └── GroupColumn (UI - final)
```

**Regola**: Mai usare `instanceof \Filament\...\Column`, sempre `instanceof XotBaseColumn`

## Filosofia Laraxot Applicata

### 1. No Direct Filament References
✅ Sempre usare XotBase classes

### 2. No Label Methods
✅ Sempre usare sistema traduzione `__()`
### 2. Auto Translation First
✅ Usare `getLabel()` (tradotto da LangServiceProvider) con fallback `__()` + `Str::headline`

### 3. Dead Code Elimination
✅ Rimuovere tutto il codice inutilizzato

### 4. Type Safety
✅ Usare `static` per Late Static Binding

### 5. Security First
✅ Escape output per prevenire XSS

### 6. PSR-12 Compliance
✅ Spacing e formattazione corretti

## Riferimenti

- [Laraxot Architectural Rules](../../architecture_rules.md)
- [Never Use Label Rule](../never_use_label_rule.md)
- [XotBaseColumn](../../../../Xot/app/Filament/Tables/Columns/XotBaseColumn.php)
- [Translation Pattern](../../translations/)
- [docs/blade-components.md](../../../docs/blade-components.md)
