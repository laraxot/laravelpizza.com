# 🔴 XotBaseTableWidget - NO table() Method Rule

**Path**: `.agents/docs/rules/xotbase-table-method.md`  
**Last Updated**: 2026-03-26  
**Status**: ✅ CRITICAL RULE  
**Priority**: BLOCKER

---

## 🎯 The Rule

> **MAI** definire il metodo `table()` in classi che estendono `XotBaseTableWidget`.
> Il metodo `table()` è **GIÀ DEFINITO** in `XotBaseTableWidget`.

**Example**:
```php
// ✅ CORRETTO
class OutcomesTableWidget extends XotBaseTableWidget
{
    // NO table() method
    // Configuration ereditata da XotBaseTableWidget
}

// ❌ SBAGLIATO
class OutcomesTableWidget extends XotBaseTableWidget
{
    public function table(Table $table): Table  // ❌ DUPLICATO!
    {
        return $table->columns([...]);
    }
}
```

---

## 🧠 The WHY

### Level 1: DRY Principle

**XotBaseTableWidget** (base class):
```php
abstract class XotBaseTableWidget extends FilamentTableWidget
{
    public function table(Table $table): Table
    {
        // ✅ GIÀ IMPLEMENTATO
        return $table
            ->columns($this->getColumns())
            ->filters($this->getFilters())
            ->actions($this->getActions());
    }
    
    protected function getColumns(): array
    {
        // Override questo, NON table()
        return [];
    }
}
```

**Se duplichi table()**:
```php
// ❌ SBAGLIATO: Duplicazione
class OutcomesTableWidget extends XotBaseTableWidget
{
    public function table(Table $table): Table  // ❌ DUPLICATO!
    {
        return $table->columns([...]);  // Riscrivi ciò che è già fatto
    }
}
```

**Problems**:
- ❌ Duplica logica già esistente
- ❌ Ignora configuration di XotBaseTableWidget
- ❌ Rompe l'ereditarietà
- ❌ Incoerente con altri widget

---

### Level 2: Template Method Pattern

**XotBaseTableWidget** usa il **Template Method Pattern**:

```php
abstract class XotBaseTableWidget extends FilamentTableWidget
{
    // TEMPLATE METHOD (final - non override)
    final public function table(Table $table): Table
    {
        return $table
            ->columns($this->getColumns())    // ← Hook method
            ->filters($this->getFilters())    // ← Hook method
            ->actions($this->getActions())    // ← Hook method
            ->defaultSort($this->getDefaultSort());
    }
    
    // HOOK METHODS (override questi)
    protected function getColumns(): array { return []; }
    protected function getFilters(): array { return []; }
    protected function getActions(): array { return []; }
    protected function getDefaultSort(): ?string { return null; }
}
```

**Correct Usage**:
```php
// ✅ CORRETTO: Override hook methods
class OutcomesTableWidget extends XotBaseTableWidget
{
    protected function getColumns(): array
    {
        return [
            TextColumn::make('title'),
            TextColumn::make('probability'),
        ];
    }
    
    protected function getFilters(): array
    {
        return [
            SelectFilter::make('status'),
        ];
    }
}
```

---

### Level 3: Zen Architecture

> "XotBaseTableWidget è il **TEMPLATE**.
> La tua classe è il **CONTENUTO**.
> Non duplicare il template, **RIEMPIL0**."

**Philosophy**:
```
XotBaseTableWidget (TEMPLATE)
    ↓
    table() method (GIÀ FATTO)
    ↓
    getColumns() hook (DA FARE)
    getFilters() hook (DA FARE)
    getActions() hook (DA FARE)
    
OutcomesTableWidget (CONTENUTO)
    ↓
    getColumns() → [colonne specifiche]
    getFilters() → [filtri specifici]
    getActions() → [azioni specifiche]
```

---

## 📊 Impact Analysis

### Before (Wrong) ❌

```php
class OutcomesTableWidget extends XotBaseTableWidget
{
    // ❌ Duplica table()
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('probability'),
            ])
            ->filters([
                SelectFilter::make('status'),
            ]);
    }
}
```

**Problems**:
- ❌ Ignora `getColumns()`, `getFilters()`, `getActions()`
- ❌ Duplica logica base
- ❌ Non usa configuration di XotBaseTableWidget
- ❌ Incompatibile con future modifiche a XotBaseTableWidget

### After (Correct) ✅

```php
class OutcomesTableWidget extends XotBaseTableWidget
{
    // ✅ Override hook methods
    protected function getColumns(): array
    {
        return [
            TextColumn::make('title')->sortable()->searchable(),
            TextColumn::make('probability')->sortable(),
        ];
    }
    
    protected function getFilters(): array
    {
        return [
            SelectFilter::make('status')
                ->options([
                    'active' => 'Active',
                    'closed' => 'Closed',
                ]),
        ];
    }
    
    protected function getActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
```

**Benefits**:
- ✅ Usa template di XotBaseTableWidget
- ✅ Configuration coerente
- ✅ Compatibile con future modifiche
- ✅ DRY: Scrivi solo ciò che è specifico

---

## 🔍 How to Spot the Violation

### Red Flag 🚩

```php
class MyWidget extends XotBaseTableWidget
{
    public function table(Table $table): Table  // 🚩 RED FLAG!
    {
        // ...
    }
}
```

**Immediate Fix**:
```php
class MyWidget extends XotBaseTableWidget
{
    // ✅ Rimuovi table()
    // ✅ Aggiungi getColumns(), getFilters(), getActions()
    
    protected function getColumns(): array { ... }
    protected function getFilters(): array { ... }
    protected function getActions(): array { ... }
}
```

---

## 📋 Checklist

**BEFORE** committing a XotBaseTableWidget extension:

- [ ] **NO** `table()` method defined
- [ ] **YES** `getColumns()` method defined (if needed)
- [ ] **YES** `getFilters()` method defined (if needed)
- [ ] **YES** `getActions()` method defined (if needed)
- [ ] **YES** Extends `XotBaseTableWidget` (not `FilamentTableWidget`)

---

## 🔗 Related Documentation

### AI Agents Docs
- **[Rules Index](00-INDEX.md)** - All rules
- **[XotBase Extension Rule](xotbase-extension-rule.md)** - Why extend XotBase
- **[Bash Commands Auto-Allow](bash-commands-auto-allow.md)** - Bash permissions

### Module Docs
- **[XotBaseTableWidget](../../laravel/Modules/Xot/app/Filament/Widgets/XotBaseTableWidget.php)** - Base class source
- **[OutcomesTableWidget](../../laravel/Modules/Predict/Filament/Widgets/OutcomesTableWidget.php)** - Example implementation

---

## 📝 Changelog

### 2026-03-26 - CRITICAL RULE ADDED
- ✅ Added "NO table() method" rule
- ✅ Documented Template Method Pattern
- ✅ Added examples (CORRECT vs WRONG)
- ✅ Added checklist

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Per-release  
**Next Review**: 2026-04-02  
**Enforcement**: 🔴 CRITICAL (violation = code review failure)
