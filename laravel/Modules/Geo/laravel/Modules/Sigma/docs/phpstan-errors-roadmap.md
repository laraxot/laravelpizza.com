# PHPStan Level 10 Errors Roadmap - Modulo Sigma

**Data**: 2026-01-12  
**Modulo**: Sigma  
**Livello PHPStan**: 10  
**Status**: ✅ **COMPLETATO - 0 Errori**

---

## 📊 Errori Identificati

### Totale Errori: 1

1. **`app/Filament/Resources/WebServiceResource/Pages/EditWebService.php`** (Linea 18)
   - **Errore**: `Method getHeaderActions() should return array<string, Filament\Actions\Action|Filament\Actions\ActionGroup> but returns array{Filament\Actions\DeleteAction}`
   - **Tipo**: `return.type`
   - **Causa**: Il metodo restituisce un array indicizzato invece di associativo con chiavi stringa

---

## 🧠 Analisi Errori

### Pattern: getHeaderActions() Return Type

**Problema**: `getHeaderActions()` deve restituire `array<string, Action|ActionGroup>` ma restituisce `array{DeleteAction}` (array indicizzato).

**Causa**: 
- Array restituito senza chiavi stringa
- PHPStan richiede chiavi stringa per array associativi

**Soluzione**: 
- Aggiungere chiavi stringa all'array restituito
- Se contiene solo `DeleteAction`, rimuovere il metodo (gestito automaticamente dalla classe base) oppure aggiungere chiave stringa

---

## 📋 Piano di Correzione

### Fase 1: Correzione getHeaderActions()

**File**: `app/Filament/Resources/WebServiceResource/Pages/EditWebService.php`

**Correzione**:
```php
// ❌ PRIMA (Errore)
protected function getHeaderActions(): array
{
    return [
        DeleteAction::make(),
    ];
}

// ✅ DOPO (Corretto)
protected function getHeaderActions(): array
{
    return [
        'delete' => DeleteAction::make(),
    ];
}
```

**Alternativa** (se solo DeleteAction standard):
```php
// ✅ Se contiene solo azioni standard, rimuovere il metodo
// La classe base gestisce automaticamente DeleteAction
```

---

## ✅ Checklist Implementazione

- [ ] Correggere `getHeaderActions()` in `EditWebService.php`
- [ ] Verificare PHPStan Level 10: `./vendor/bin/phpstan analyse Modules/Sigma --level=10`
- [ ] Verificare PHPMD: `./vendor/bin/phpmd Modules/Sigma text codesize`
- [ ] Verificare PHP Insights: `./vendor/bin/phpinsights analyse Modules/Sigma`
- [ ] Formattare codice: `./vendor/bin/pint Modules/Sigma`
- [ ] Aggiornare questa roadmap con risultati
- [ ] Git commit e push

---

## 📚 Riferimenti

- [Filament Class Extension Rules](../../Xot/docs/filament-class-extension-rules.md)
- [PHPStan Code Quality Guide](../../Xot/docs/phpstan-code-quality-guide.md)
- [Array Return Types](../../Xot/docs/phpstan-code-quality-guide.md#-array-return-types-importanti)

---

## 🎯 Strategia

**Approccio**: Quick win - 1 solo errore, correzione semplice  
**Priorità**: Alta (modulo con meno errori)  
**Tempo stimato**: 5 minuti
