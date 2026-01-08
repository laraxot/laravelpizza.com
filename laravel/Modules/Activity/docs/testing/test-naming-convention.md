# Convenzione Naming File Test - Activity Module

**Modulo:** Activity  
**Data:** 10 Ottobre 2025  
**Categoria:** Testing Standards

## 🎯 Regola

**File test DEVONO seguire PascalCase**

## ✅ Esempi Corretti (Activity Module)

```bash
ActivityBusinessLogicTest.php
ActivityIntegrationTest.php
StoredEventBusinessLogicTest.php
EventSourcingBusinessLogicTest.php
LoginListenerTest.php
LogoutListenerTest.php
BaseModelBusinessLogicPestTest.php
```

## 📋 Pattern Activity

```
[Model][Aspect]Test.php
Activity BusinessLogic Test.php
StoredEvent BusinessLogic Test.php

[Feature][Tipo]Test.php
EventSourcing BusinessLogic Test.php
Login Listener Test.php
```

## 🔍 Verifica

```bash
# Verifica naming test Activity
find Modules/Activity/tests -name "*.php" | while read f; do
    bn=$(basename "$f")
    if [[ "${bn:0:1}" =~ [a-z] ]]; then
        echo "❌ $f"
    fi
done
```

## 📚 Riferimenti

- [Regola Critica Progetto](../../../../docs/regole-critiche/test-naming-pascalcase.md)
- [PHPStan Best Practices](../phpstan/best-practices.md)

---

**Activity Module - Test Naming Standards** ✅

