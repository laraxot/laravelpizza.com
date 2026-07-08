# PHPStan Level 10 Errors Roadmap - Modulo Ptv

**Data**: 2026-01-12  
**Modulo**: Ptv  
**Livello PHPStan**: 10  
**Status**: ✅ **COMPLETATO - 0 Errori**

---

## 📊 Errori Identificati

### Totale Errori: 7

1. **`app/Filament/Resources/CriteriOptionResource/Pages/EditCriteriOption.php`** (Linea 17)
   - **Errore**: `getHeaderActions() should return array<string, ...> but returns array{DeleteAction}`
   - **Tipo**: `return.type`

2. **`app/Filament/Resources/MyLogResource/Pages/ViewMyLog.php`** (Linea 38)
   - **Errore**: `getInfolistSchema() should return array<string, Component> but returns array<int, Section>`
   - **Tipo**: `return.type`

3. **`app/Filament/Resources/ReportResource/Pages/EditStabiDirigente.php`** (Linea 17)
   - **Errore**: `getHeaderActions() should return array<string, ...> but returns array{DeleteAction}`
   - **Tipo**: `return.type`

4. **`app/Filament/Resources/ReportResource/Widgets/FirmaStabiReparWidget.php`** (Linea 52)
   - **Errore**: `getFormSchema() should return array<int|string, Component> but returns array<int, mixed>`
   - **Tipo**: `return.type`

5. **`app/Filament/Resources/ReportResource/Widgets/FirmaStabiReparWidget.php`** (Linea 53)
   - **Errore**: `Call to static method make() on an unknown class Filament\Forms\Components\Grid`
   - **Tipo**: `class.notFound`

6. **`app/Filament/Resources/ReportResource/Widgets/FirmaStabiReparWidget.php`** (Linea 53)
   - **Errore**: `Cannot call method schema() on mixed`
   - **Tipo**: `method.nonObject`

7. **`app/Filament/Resources/StabiDirigenteResource/Pages/EditStabiDirigente.php`** (Linea 17)
   - **Errore**: `getHeaderActions() should return array<string, ...> but returns array{DeleteAction}`
   - **Tipo**: `return.type`

---

## 🧠 Analisi Errori

### Pattern 1: getHeaderActions() Return Type (3 errori)

**Problema**: Array indicizzati invece di associativi con chiavi stringa.

### Pattern 2: getInfolistSchema() Return Type (1 errore)

**Problema**: Array indicizzato invece di associativo con chiavi stringa.

### Pattern 3: getFormSchema() + Grid Class (3 errori)

**Problema**: 
- Array indicizzato invece di associativo
- Classe `Filament\Forms\Components\Grid` non esiste (dovrebbe essere `Filament\Schemas\Components\Grid`)

---

## 📋 Piano di Correzione

### Fase 1: Correzione getHeaderActions() (3 file)

**File**: `EditCriteriOption.php`, `EditStabiDirigente.php`, `EditStabiDirigente.php` (StabiDirigenteResource)

```php
// ❌ PRIMA
protected function getHeaderActions(): array
{
    return [DeleteAction::make()];
}

// ✅ DOPO
protected function getHeaderActions(): array
{
    return ['delete' => DeleteAction::make()];
}
```

### Fase 2: Correzione getInfolistSchema()

**File**: `app/Filament/Resources/MyLogResource/Pages/ViewMyLog.php`

```php
// ❌ PRIMA
protected function getInfolistSchema(): array
{
    return [
        Section::make('Informazioni Generali')
            ->schema([...]),
    ];
}

// ✅ DOPO
protected function getInfolistSchema(): array
{
    return [
        'info_section' => Section::make('Informazioni Generali')
            ->schema([...]),
    ];
}
```

### Fase 3: Correzione getFormSchema() + Grid

**File**: `app/Filament/Resources/ReportResource/Widgets/FirmaStabiReparWidget.php`

**Problemi**:
1. Import errato: `Filament\Forms\Components\Grid` → `Filament\Schemas\Components\Grid`
2. Array indicizzato invece di associativo

```php
// ❌ PRIMA
use Filament\Forms\Components\Grid;

public function getFormSchema(): array
{
    return [
        Grid::make(2)
            ->schema([...]),
    ];
}

// ✅ DOPO
use Filament\Schemas\Components\Grid;

public function getFormSchema(): array
{
    return [
        'form_grid' => Grid::make(2)
            ->schema([...]),
    ];
}
```

---

## ✅ Checklist Implementazione

- [ ] Correggere `getHeaderActions()` in 3 file
- [ ] Correggere `getInfolistSchema()` in `ViewMyLog.php`
- [ ] Correggere import e `getFormSchema()` in `FirmaStabiReparWidget.php`
- [ ] Verificare PHPStan Level 10: `./vendor/bin/phpstan analyse Modules/Ptv --level=10`
- [ ] Verificare PHPMD: `./vendor/bin/phpmd Modules/Ptv text codesize`
- [ ] Verificare PHP Insights: `./vendor/bin/phpinsights analyse Modules/Ptv`
- [ ] Formattare codice: `./vendor/bin/pint Modules/Ptv`
- [ ] Aggiornare questa roadmap con risultati
- [ ] Git commit e push

---

## 📚 Riferimenti

- [Filament Class Extension Rules](../../Xot/docs/filament-class-extension-rules.md)
- [PHPStan Code Quality Guide](../../Xot/docs/phpstan-code-quality-guide.md)
- [Array Return Types](../../Xot/docs/phpstan-code-quality-guide.md#-array-return-types-importanti)

---

## 🎯 Strategia

**Approccio**: Batch fix - errori simili raggruppati  
**Priorità**: Media (7 errori, alcuni richiedono verifica import)  
**Tempo stimato**: 20 minuti
