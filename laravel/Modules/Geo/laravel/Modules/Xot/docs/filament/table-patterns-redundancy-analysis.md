# Table Resources: Pattern Redundancy Analysis

**Data:** 2026-05-26  
**Moduli Analizzati:** Lang, User (Passport, Socialite), Rating, Gdpr, etc.

## Ridondanze Trovate

### 1. Column Definitions (34-72 righe per file)

**Pattern:** Ogni `*Table.php` ripete lo stesso set di colonne.

```php
// In TranslationFilesTable
->columns([
    Tables\Columns\TextColumn::make('key'),
    Tables\Columns\TextColumn::make('group'),
    // ... 30+ righe uguali in ogni table
])

// In UsersTable
->columns([
    Tables\Columns\TextColumn::make('name'),
    Tables\Columns\TextColumn::make('email'),
    // ... stesso pattern
])
```

**Problema:** Zero reuse. Ogni resource redefine tutte le colonne.

**Soluzione Possibile:**
```php
// Trait: HasCommonColumns
trait HasCommonTableColumns {
    protected function textColumn(string $name): TextColumn {
        return Tables\Columns\TextColumn::make($name)
            ->sortable()
            ->searchable();
    }
    
    protected function getCommonColumns(): array {
        return [/* ... */];
    }
}

// In concrete Table class
class UsersTable extends XotBaseResourceTable {
    use HasCommonTableColumns;
    
    public function getTableColumns(): array {
        return array_merge(
            $this->getCommonColumns(),
            $this->userSpecificColumns()
        );
    }
}
```

### 2. Search & Sort Boilerplate

**Pattern:** Ogni colonna ripete `->sortable()` e `->searchable()`.

```php
// ❌ Ripetuto 300+ volte
TextColumn::make('name')
    ->sortable()
    ->searchable()
    ->label('Nome'),
```

**Soluzione:**
```php
// ✅ Factory method
protected function searchableColumn(string $name, ?string $label = null): TextColumn {
    return TextColumn::make($name)
        ->sortable()
        ->searchable()
        ->label($label ?? Str::title($name));
}
```

### 3. Action Patterns

**Pattern:** Ogni resource table ha View, Edit, Delete actions quasi identiche.

```php
// In 50+ files — lo stesso
->actions([
    Actions\ViewAction::make(),
    Actions\EditAction::make(),
    Actions\DeleteAction::make(),
])
```

**Soluzione:** Centralize in `XotBaseResourceTable`:
```php
abstract class XotBaseResourceTable {
    protected function getDefaultActions(): array {
        return [
            Actions\ViewAction::make(),
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
```

## Impatto Potenziale

| Ridondanza | Occorrenze | LOC Duplcati | Risk | Priorità |
|-----------|-----------|----------|------|----------|
| Column definitions | 50+ | 2000+ | Medium | Alta |
| Search/Sort | 300+ | 1500+ | Low | Media |
| Actions | 50+ | 500+ | Low | Bassa |

## Raccomandazione Filosofica

> **"DRY non è ossessione; è riduzione del carico cognitivo."**

Quando vedi lo stesso pattern 50 volte, non è copia-incolla intelligente — è **fractal complexity**. Ogni ridondanza è un punto di rot futuro.

## Fase 2: Trait Library

Proposta per refactor controllato:

```
Modules/Xot/app/Filament/Traits/Table/
├── HasSearchableColumns.php
├── HasDefaultActions.php
├── HasBulkActions.php
└── HasTableFilters.php
```

Ogni trait = un aspetto isolato, testabile, documentato.

## Next Steps

- [ ] Implementare `HasCommonTableColumns` trait
- [ ] Migrare 3 modules pilota (Lang, User, Rating)
- [ ] Testare performance (Filament discovery)
- [ ] Documentare breaking changes (se necessarie)
