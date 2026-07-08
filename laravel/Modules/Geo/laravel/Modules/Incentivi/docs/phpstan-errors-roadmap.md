# PHPStan Level 10 Errors Roadmap - Modulo Incentivi

**Data**: 2026-01-12  
**Modulo**: Incentivi  
**Livello PHPStan**: 10  
**Status**: ✅ **COMPLETATO - 0 Errori**

---

## 📊 Errori Identificati

### Totale Errori: 9

Tutti gli errori sono dello stesso tipo: `getHeaderActions()` deve restituire array associativo con chiavi stringa.

**File interessati**:
1. `EditActivity.php`
2. `EditCapitalPercentage.php`
3. `EditDefaultActivity.php`
4. `EditEmployee.php`
5. `EditPhase.php`
6. `EditProject.php`
7. `EditSettlement.php`
8. `EditStabiDirigente.php`
9. `EditWorkgroup.php`

---

## 🧠 Analisi Errori

### Pattern: getHeaderActions() Return Type

**Problema**: Tutti i metodi `getHeaderActions()` restituiscono array indicizzati invece di associativi con chiavi stringa.

**Causa**: 
- Array restituiti senza chiavi stringa
- PHPStan Level 10 richiede `array<string, Action|ActionGroup>`

**Soluzione**: 
- Aggiungere chiavi stringa a tutti gli array restituiti
- Batch fix per tutti i file simili

---

## 📋 Piano di Correzione

### Strategia: Batch Fix

Correggere tutti i file in un unico batch seguendo lo stesso pattern.

**Pattern di correzione**:
```php
// ❌ PRIMA
protected function getHeaderActions(): array
{
    return [
        DeleteAction::make(),
        // oppure
        ViewAction::make(),
        DeleteAction::make(),
        // oppure
        DeleteAction::make(),
        ActionGroup::make([...]),
    ];
}

// ✅ DOPO
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make(),
        // oppure
        'view' => ViewAction::make(),
        'delete' => DeleteAction::make(),
        // oppure
        'delete' => DeleteAction::make(),
        'group' => ActionGroup::make([...]),
    ];
}
```

---

## ✅ Checklist Implementazione

- [ ] Correggere `getHeaderActions()` in `EditActivity.php`
- [ ] Correggere `getHeaderActions()` in `EditCapitalPercentage.php`
- [ ] Correggere `getHeaderActions()` in `EditDefaultActivity.php`
- [ ] Correggere `getHeaderActions()` in `EditEmployee.php`
- [ ] Correggere `getHeaderActions()` in `EditPhase.php`
- [ ] Correggere `getHeaderActions()` in `EditProject.php`
- [ ] Correggere `getHeaderActions()` in `EditSettlement.php`
- [ ] Correggere `getHeaderActions()` in `EditStabiDirigente.php`
- [ ] Correggere `getHeaderActions()` in `EditWorkgroup.php`
- [ ] Verificare PHPStan Level 10: `./vendor/bin/phpstan analyse Modules/Incentivi --level=10`
- [ ] Verificare PHPMD: `./vendor/bin/phpmd Modules/Incentivi text codesize`
- [ ] Verificare PHP Insights: `./vendor/bin/phpinsights analyse Modules/Incentivi`
- [ ] Formattare codice: `./vendor/bin/pint Modules/Incentivi`
- [ ] Aggiornare questa roadmap con risultati
- [ ] Git commit e push

---

## 📚 Riferimenti

- [Filament Class Extension Rules](../../Xot/docs/filament-class-extension-rules.md)
- [PHPStan Code Quality Guide](../../Xot/docs/phpstan-code-quality-guide.md)
- [Array Return Types](../../Xot/docs/phpstan-code-quality-guide.md#-array-return-types-importanti)

---

## 🎯 Strategia

**Approccio**: Batch fix massivo - tutti gli errori dello stesso tipo  
**Priorità**: Media (9 errori, ma tutti simili)  
**Tempo stimato**: 15 minuti
