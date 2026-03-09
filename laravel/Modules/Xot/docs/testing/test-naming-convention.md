# Convenzione Naming File Test - Xot Module

**Modulo:** Xot (Core Framework)
**Data:** 10 Ottobre 2025
**Categoria:** Testing Standards

## 🎯 Regola Fondamentale

**File test DEVONO seguire PascalCase - MAI minuscolo**

## ✅ Esempi Corretti

```bash
# Test Pest
FixStructureTest.pest.php
XotBaseModelTest.pest.php
ModuleServiceTest.pest.php
HasXotTableTest.pest.php

# Test PHPUnit
XotBaseModelBusinessLogicTest.php
ModuleServiceIntegrationTest.php
```

## ❌ Esempi Errati

```bash
# ❌ ELIMINATI dal modulo Xot
fixstructuretest.pest.php  # Duplicato - eliminato il 10/10/2025
```

## 📊 Caso Reale

**Problema Riscontrato:**
- File duplicati: `fixstructuretest.pest.php` + `FixStructureTest.pest.php`
- PHPStan analizzava entrambi → errori doppi
- **Impatto:** 128 → 109 errori (-19 errori, 15%) solo eliminando duplicato!

## 🔧 Verifica Modulo

```bash
# Verifica file test con naming errato
find Modules/Xot/tests -name "*.pest.php" -o -name "*Test.php" | \
while read f; do
    bn=$(basename "$f")
    if [[ "${bn:0:1}" =~ [a-z] ]]; then
        echo "❌ ERRATO: $f"
    fi
done

# Risultato atteso: VUOTO (nessun file errato)
```

## 📋 Checklist Creazione Test

Quando crei un nuovo test nel modulo Xot:

- [ ] Nome file in PascalCase
- [ ] Suffisso `Test.pest.php` o `Test.php`
- [ ] Verifica no duplicati case-insensitive
- [ ] Run PHPStan sul file
- [ ] Commit solo se naming corretto

## 🎓 Pattern Standard Xot

```
[Cosa][Aspect]Test.pest.php

Esempi:
- XotBaseModelBusinessLogicTest.php
- ModuleServiceIntegrationTest.php
- HasXotTableTest.php
- FixStructureTest.pest.php
```

## 📚 Documentazione Correlata

- [Regola Critica Progetto](../../../../../docs/regole-critiche/test-naming-pascalcase.md)
- [Testing Best Practices](./testing-best-practices.md)
- [PHPStan Compliance](../phpstan-compliance.md)

---

**Xot Module - Test Naming PascalCase** ✅
