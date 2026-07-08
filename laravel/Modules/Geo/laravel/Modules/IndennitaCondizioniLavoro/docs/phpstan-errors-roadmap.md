# PHPStan Level 10 Errors Roadmap - Modulo IndennitaCondizioniLavoro

**Data**: 2026-01-12  
**Modulo**: IndennitaCondizioniLavoro  
**Livello PHPStan**: 10  
**Status**: ✅ **COMPLETATO - 0 Errori**

---

## 📊 Errori Identificati

### Totale Errori: 3

Tutti gli errori sono dello stesso tipo: `getHeaderActions()` deve restituire array associativo con chiavi stringa.

1. **`app/Filament/Resources/CondizioniLavoroAdmResource/Pages/EditCondizioniLavoroAdm.php`** (Linea 17)
   - **Errore**: `Method getHeaderActions() should return array<string, ...> but returns array{DeleteAction}`
   - **Tipo**: `return.type`

2. **`app/Filament/Resources/IndennitaTipoResource/Pages/EditIndennitaTipo.php`** (Linea 17)
   - **Errore**: `Method getHeaderActions() should return array<string, ...> but returns array{DeleteAction}`
   - **Tipo**: `return.type`

3. **`app/Filament/Resources/UploadResource/Pages/EditUpload.php`** (Linea 18)
   - **Errore**: `Method getHeaderActions() should return array<string, ...> but returns array{ViewAction, DeleteAction}`
   - **Tipo**: `return.type`

---

## 🧠 Analisi Errori

### Pattern: getHeaderActions() Return Type

**Problema**: Tutti i metodi `getHeaderActions()` restituiscono array indicizzati invece di associativi con chiavi stringa.

**Causa**: 
- Array restituiti senza chiavi stringa
- PHPStan Level 10 richiede `array<string, Action|ActionGroup>`

**Soluzione**: 
- Aggiungere chiavi stringa a tutti gli array restituiti
- Se contiene solo azioni standard, valutare se rimuovere il metodo

---

## 📋 Piano di Correzione

### Fase 1: Correzione getHeaderActions() - EditCondizioniLavoroAdm

**File**: `app/Filament/Resources/CondizioniLavoroAdmResource/Pages/EditCondizioniLavoroAdm.php`

```php
// ❌ PRIMA
protected function getHeaderActions(): array
{
    return [
        DeleteAction::make(),
    ];
}

// ✅ DOPO
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make(),
    ];
}
```

### Fase 2: Correzione getHeaderActions() - EditIndennitaTipo

**File**: `app/Filament/Resources/IndennitaTipoResource/Pages/EditIndennitaTipo.php`

```php
// ❌ PRIMA
protected function getHeaderActions(): array
{
    return [
        DeleteAction::make(),
    ];
}

// ✅ DOPO
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make(),
    ];
}
```

### Fase 3: Correzione getHeaderActions() - EditUpload

**File**: `app/Filament/Resources/UploadResource/Pages/EditUpload.php`

```php
// ❌ PRIMA
protected function getHeaderActions(): array
{
    return [
        ViewAction::make(),
        DeleteAction::make(),
    ];
}

// ✅ DOPO
protected function getHeaderActions(): array
{
    return [
        'view' => ViewAction::make(),
        'delete' => DeleteAction::make(),
    ];
}
```

---

## ✅ Checklist Implementazione

- [ ] Correggere `getHeaderActions()` in `EditCondizioniLavoroAdm.php`
- [ ] Correggere `getHeaderActions()` in `EditIndennitaTipo.php`
- [ ] Correggere `getHeaderActions()` in `EditUpload.php`
- [ ] Verificare PHPStan Level 10: `./vendor/bin/phpstan analyse Modules/IndennitaCondizioniLavoro --level=10`
- [ ] Verificare PHPMD: `./vendor/bin/phpmd Modules/IndennitaCondizioniLavoro text codesize`
- [ ] Verificare PHP Insights: `./vendor/bin/phpinsights analyse Modules/IndennitaCondizioniLavoro`
- [ ] Formattare codice: `./vendor/bin/pint Modules/IndennitaCondizioniLavoro`
- [ ] Aggiornare questa roadmap con risultati
- [ ] Git commit e push

---

## 📚 Riferimenti

- [Filament Class Extension Rules](../../Xot/docs/filament-class-extension-rules.md)
- [PHPStan Code Quality Guide](../../Xot/docs/phpstan-code-quality-guide.md)
- [Array Return Types](../../Xot/docs/phpstan-code-quality-guide.md#-array-return-types-importanti)

---

## 🎯 Strategia

**Approccio**: Batch fix - tutti gli errori dello stesso tipo  
**Priorità**: Alta (modulo con pochi errori)  
**Tempo stimato**: 10 minuti
