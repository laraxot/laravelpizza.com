# PHPStan Fix Roadmap - XotBaseWidget View-String Error

**Status**: ✅ Completato
**Errore**: 1 (risolto)
**Modulo**: Xot
**File**: `app/Filament/Widgets/XotBaseWidget.php`

---

## 📋 Errore Identificato

### Errore PHPStan
```
Line 234: Property Modules\Xot\Filament\Widgets\XotBaseWidget::$view (view-string) does not accept string.
```

### File Coinvolto
- `Modules/Xot/app/Filament/Widgets/XotBaseWidget.php` (riga 234)

---

## 🔍 Analisi del Problema

### Causa Root
1. La proprietà `$view` è dichiarata come `protected string $view` (riga 63)
2. Filament Widget base class usa `view-string` nel PHPDoc
3. Il metodo `resolveView()` assegna una string normale a `$this->view` (riga 234)
4. PHPStan non riconosce la string come `view-string` valido

### Pattern Esistente
Nel file stesso (righe 178-179) c'è già un esempio di come gestire questo:
```php
/** @var view-string $submit_view */
$submit_view = 'pub_theme::filament.wizard.submit-button';
```

---

## ✅ Soluzione Proposta

### Strategia
Usare PHPDoc `@var view-string` per indicare a PHPStan che la stringa è un percorso view valido.

### Implementazione
Modificare il metodo `resolveView()` per usare un cast PHPDoc:

```php
private function resolveView(): void
{
    $view = app(GetViewByClassAction::class)->execute(static::class);

    /** @var view-string $view */
    $this->view = $view;
}
```

---

## 📝 Piano di Implementazione

### Fase 1: Correzione
- [x] Analisi errore
- [x] Applicare fix con PHPDoc `@var view-string`
- [x] Verificare che `GetViewByClassAction` restituisca sempre un view-string valido

### Fase 2: Verifica Qualità
- [x] PHPStan Level 10: `./vendor/bin/phpstan analyse Modules/Xot --level=10` ✅
- [x] PHPMD: `php phpmd.phar Modules/Xot/app/Filament/Widgets/XotBaseWidget.php text codesize,design` ✅
- [x] PHPInsights: `./vendor/bin/phpinsights analyse Modules/Xot/app/Filament/Widgets/XotBaseWidget.php` ✅ (warning pre-esistenti)

### Fase 3: Documentazione
- [x] Creare roadmap
- [ ] Aggiornare documentazione se necessario

---

## 🔗 Riferimenti

- [Property Type Fixes](./consolidated/archive/property-type-fixes.md) - Documentazione esistente
- [View-String Type Fixes (User Module)](../User/docs/type-safety-improvements.md) - Pattern simile risolto
- [Path Resolution Fixes](./consolidated/archive/path-resolution-fixes.md) - Soluzione simile

---

## 📊 Progresso

| Fase | Status | Note |
|------|--------|------|
| Analisi | ✅ | Errore identificato e analizzato |
| Fix | ✅ | PHPDoc `@var view-string` applicato |
| Verifica PHPStan | ✅ | Nessun errore |
| Verifica PHPMD | ✅ | Nessun errore |
| Verifica PHPInsights | ✅ | Warning pre-esistenti (public properties) |
| Commit | ⏳ | Pronto per commit |

---

**Ultimo aggiornamento**: 2025-01-22
**Versione**: 1.0.0
