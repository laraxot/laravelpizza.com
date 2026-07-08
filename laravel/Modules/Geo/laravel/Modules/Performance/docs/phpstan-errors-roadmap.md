# PHPStan Level 10 Errors Roadmap - Modulo Performance

**Data**: 2026-01-12  
**Modulo**: Performance  
**Livello PHPStan**: 10  
**Status**: ✅ **COMPLETATO - 0 Errori**

---

## 📊 Errori Identificati

### Totale Errori: 16

Tutti gli errori sono dello stesso tipo: `getHeaderActions()` deve restituire array associativo con chiavi stringa.

**File interessati** (tutti Edit*):
1. `EditCriteriMaggiorazione.php`
2. `EditCriteriValutazione.php`
3. `EditIndividualeAdm.php`
4. `EditIndividualeAssenze.php`
5. `EditIndividualeCatCoeff.php`
6. `EditIndividualeDecurtazioneAssenze.php`
7. `EditIndividualePesi.php`
8. `EditIndividuale.php`
9. `EditIndividualeTotStabi.php`
10. `EditMyLog.php`
11. `EditOrganizzativaAssenze.php`
12. `EditOrganizzativaCatCoeff.php`
13. `EditOrganizzativa.php`
14. `EditOrganizzativaTotStabi.php`
15. `IndividualeMoney.php` (PerformanceFondoResource)
16. Altri file Edit*

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

Correggere tutti i file in batch seguendo lo stesso pattern.

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

---

## ✅ Checklist Implementazione

- [ ] Identificare tutti i file con `getHeaderActions()` errato
- [ ] Correggere tutti i file in batch
- [ ] Verificare PHPStan Level 10: `./vendor/bin/phpstan analyse Modules/Performance --level=10`
- [ ] Verificare PHPMD: `./vendor/bin/phpmd Modules/Performance text codesize`
- [ ] Verificare PHP Insights: `./vendor/bin/phpinsights analyse Modules/Performance`
- [ ] Formattare codice: `./vendor/bin/pint Modules/Performance`
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
**Priorità**: Media (16 errori, ma tutti identici)  
**Tempo stimato**: 25 minuti
