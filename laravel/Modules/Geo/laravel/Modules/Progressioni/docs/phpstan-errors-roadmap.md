# PHPStan Level 10 Errors Roadmap - Modulo Progressioni

**Data**: 2026-01-12  
**Modulo**: Progressioni  
**Livello PHPStan**: 10  
**Status**: ✅ **COMPLETATO - 0 Errori**

---

## 📊 Errori Identificati

### Totale Errori: 15

Tutti gli errori sono dello stesso tipo: `getHeaderActions()` deve restituire array associativo con chiavi stringa.

**File interessati** (tutti Edit*):
1. `EditAssenza.php`
2. `EditCategoriaPropro.php`
3. `EditCedDiff.php`
4. `EditCoeff.php`
5. `EditCriteriEsclusione.php`
6. `EditCriteriOption.php`
7. `EditCriteriPrecedenza.php`
8. `EditCriteriValutazione.php`
9. `EditEsclusiExtra.php`
10. `EditMyLog.php`
11. `EditPesi.php`
12. `EditSchede.php`
13. `EditStipendioTabellare.php`
14. `EditValutatore.php`
15. `ViewIntegparam.php` (ha EditAction + DeleteAction)

---

## 🧠 Analisi Errori

### Pattern: getHeaderActions() Return Type

**Problema**: Tutti i metodi `getHeaderActions()` restituiscono array indicizzati invece di associativi con chiavi stringa.

**Causa**: 
- Array restituiti senza chiavi stringa
- PHPStan Level 10 richiede `array<string, Action|ActionGroup>`

**Soluzione**: 
- Batch fix per tutti i file
- Aggiungere chiavi stringa a tutti gli array restituiti

---

## 📋 Piano di Correzione

### Strategia: Batch Fix Massivo

Correggere tutti i 15 file in batch seguendo lo stesso pattern.

**Pattern standard**:
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

**Pattern per ViewIntegparam** (ha 2 azioni):
```php
// ❌ PRIMA
protected function getHeaderActions(): array
{
    return [
        EditAction::make(),
        DeleteAction::make(),
    ];
}

// ✅ DOPO
protected function getHeaderActions(): array
{
    return [
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
    ];
}
```

---

## ✅ Checklist Implementazione

- [ ] Correggere tutti i 15 file `getHeaderActions()`
- [ ] Verificare PHPStan Level 10: `./vendor/bin/phpstan analyse Modules/Progressioni --level=10`
- [ ] Verificare PHPMD: `./vendor/bin/phpmd Modules/Progressioni text codesize`
- [ ] Verificare PHP Insights: `./vendor/bin/phpinsights analyse Modules/Progressioni`
- [ ] Formattare codice: `./vendor/bin/pint Modules/Progressioni`
- [ ] Aggiornare questa roadmap con risultati
- [ ] Git commit e push

---

## 📚 Riferimenti

- [Filament Class Extension Rules](../../Xot/docs/filament-class-extension-rules.md)
- [PHPStan Code Quality Guide](../../Xot/docs/phpstan-code-quality-guide.md)
- [Array Return Types](../../Xot/docs/phpstan-code-quality-guide.md#-array-return-types-importanti)

---

## 🎯 Strategia

**Approccio**: Batch fix massivo - tutti gli errori identici  
**Priorità**: Media (15 errori, ma tutti identici)  
**Tempo stimato**: 20 minuti
