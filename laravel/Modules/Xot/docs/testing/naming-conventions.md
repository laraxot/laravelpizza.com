# Convenzioni di Naming per i Test - Modulo Xot

## Riferimento Principale

Per la documentazione completa delle convenzioni di naming dei test, consultare:
- [../../../../docs/testing/naming-conventions.md](../../../../docs/testing/naming-conventions.md)

## Applicazione al Modulo Xot

### Duplicati Eliminati nel Modulo Xot

**Data:** Ottobre 2025  
**Duplicati trovati e eliminati:** 3 file

```
Modules/Xot/tests/Unit/metatagdatatest.php          → mantiene MetatagDataTest.php
Modules/Xot/tests/pest.php                           → mantiene Pest.php
Modules/Xot/tests/Feature/fixstructuretest.pest.php → mantiene FixStructureTest.pest.php
```

### Struttura Test Corretta del Modulo

```
Modules/Xot/tests/
├── Pest.php                           ✅ File configurazione (PascalCase)
├── Feature/
│   ├── FixStructureTest.php          ✅ PHPUnit standard
│   └── FixStructureTest.pest.php     ✅ Pest syntax
└── Unit/
    └── MetatagDataTest.php           ✅ PascalCase corretto
```

### Verifica Locale

```bash
# Da eseguire nella root del modulo
cd Modules/Xot
find tests -type f -name "*.php" | grep -E "(test\.php|test\.pest\.php|pest\.php)" | grep -v -E "(Test\.php|Test\.pest\.php|Pest\.php)"
# Output vuoto = tutto corretto ✅
```

### Regole Specifiche per Xot

1. **File di configurazione Pest:**
   - ✅ `tests/Pest.php` (PascalCase)
   - ❌ `tests/pest.php` (lowercase - duplicato)

2. **Test Feature:**
   - ✅ `tests/Feature/FixStructureTest.php`
   - ✅ `tests/Feature/FixStructureTest.pest.php`
   - ❌ `tests/Feature/fixstructuretest.pest.php`

3. **Test Unit:**
   - ✅ `tests/Unit/MetatagDataTest.php`
   - ❌ `tests/Unit/metatagdatatest.php`

### Impatto della Correzione

**Prima:**
- PHPStan riportava errori duplicati
- Test eseguiti più volte
- Confusione tra i file

**Dopo:**
- Nessun errore duplicato
- Test eseguiti una sola volta
- Codebase pulito

### Best Practice per Sviluppatori Xot

1. Creare sempre test con naming: `*Test.php` o `*Test.pest.php`
2. Verificare prima di commit che non esistano duplicati lowercase
3. Configurare editor per autocomplete con PascalCase
4. Code review: rifiutare PR con file lowercase

### Collegamenti Correlati

- [../../../../docs/testing/naming-conventions.md](../../../../docs/testing/naming-conventions.md) - Documentazione completa
- [../phpstan_fixes_xot.md](../phpstan_fixes_xot.md) - Correzioni PHPStan modulo Xot
- [./test-structure.md](./test-structure.md) - Struttura test module Xot

