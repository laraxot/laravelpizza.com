# Regola Critica: Naming File Test - PascalCase Obbligatorio

**Data:** 10 Ottobre 2025  
**Categoria:** Testing, Naming Conventions  
**Severità:** 🔴 CRITICA

## 🚨 Regola

**TUTTI i file di test (Pest o PHPUnit) DEVONO seguire PascalCase, MAI minuscolo.**

## ✅ Naming Corretto

```bash
# ✅ CORRETTO - PascalCase
FixStructureTest.pest.php
EmailVerificationTest.pest.php
UserAuthenticationTest.php
ArticleBusinessLogicTest.php
```

## ❌ Naming Errato

```bash
# ❌ SBAGLIATO - minuscolo
fixstructuretest.pest.php
emailverificationtest.pest.php
userauthenticationtest.php
articlebusinesslogictest.php
```

## 🔍 Problema Riscontrato

Durante la correzione PHPStan del modulo Xot, sono stati trovati **file test duplicati** con naming diverso:

### Modulo Xot
- ❌ `fixstructuretest.pest.php` (eliminato)
- ✅ `FixStructureTest.pest.php` (corretto)

### Modulo Cms
- ❌ `emailverificationtest.pest.php` (eliminato)
- ✅ `EmailVerificationTest.pest.php` (corretto)

**Impatto PHPStan:**
- File duplicati causano errori multipli
- Aumentano complessità analisi
- **19 errori eliminati** solo rimuovendo duplicato Xot!

## 📋 Convenzioni Standard

### PHP Test Naming

**PSR-4 Autoloading Standard:**
```
Class Name: UserAuthenticationTest
File Name: UserAuthenticationTest.php
```

**Pest Naming:**
```
Test Name: User Authentication
File Name: UserAuthenticationTest.pest.php  (NON userauthenticationtest.pest.php)
```

### Pattern Corretti

| Tipo | Naming | Esempio |
|------|--------|---------|
| Pest Test | PascalCase.pest.php | `CreateUserTest.pest.php` |
| PHPUnit Test | PascalCase.php | `CreateUserTest.php` |
| Unit Test | PascalCaseTest.php | `UserServiceTest.php` |
| Feature Test | PascalCaseTest.php | `LoginFeatureTest.php` |

## 🔧 Come Identificare File Errati

```bash
# Cerca file test con naming minuscolo
find laravel/Modules -type f \( -name "*.pest.php" -o -name "*Test.php" \) | \
while read f; do 
    bn=$(basename "$f")
    first_char="${bn:0:1}"
    if [[ "$first_char" =~ [a-z] ]]; then 
        echo "❌ ERRATO: $f"
    fi
done

# Cerca duplicati (stesso nome, case diverso)
find laravel/Modules -type f -name "*Test.pest.php" -o -name "*test.pest.php" | \
sort -f | uniq -i -d
```

## 🛠️ Correzione

```bash
# 1. Identifica duplicati
ls -la tests/Feature/ | grep -i fixstructuretest

# 2. Confronta contenuti
diff fixstructuretest.pest.php FixStructureTest.pest.php

# 3. Se identici, elimina minuscolo
rm fixstructuretest.pest.php

# 4. Se diversi, unifica nel PascalCase
# Copia contenuto unico da minuscolo a PascalCase
# Poi elimina minuscolo
```

## 📚 Motivazione

### Perché PascalCase?

1. **PSR-4 Standard:** Class names = file names
2. **Autoloading:** Composer autoload richiede corrispondenza esatta
3. **Convenzioni PHP:** Classi in PascalCase = file in PascalCase
4. **Cross-Platform:** Evita problemi case-sensitivity file system
5. **Leggibilità:** Distinzione chiara tra file test e altri file

### Perché È Critico?

```php
// File: userauthenticationtest.php
class UserAuthenticationTest extends TestCase { }
//      ^^^^^^^^^^^^^^^^^^^^^ PascalCase
//    vs
// File: userauthenticationtest.php
//       ^^^^^^^^^^^^^^^^^^^^^ minuscolo
// ❌ MISMATCH! Può causare problemi autoloading
```

## 🎯 Best Practice

### Creazione Nuovi Test

```bash
# ✅ SEMPRE usa artisan make:test
php artisan make:test UserAuthenticationTest --pest
# Crea: tests/Feature/UserAuthenticationTest.php

# ✅ Per test Pest manuale
# Nome file: CreateArticleTest.pest.php
```

### Pattern da Seguire

```
[Cosa Testa][Tipo Test].pest.php
CreateUser  Test      .pest.php  ✅
createuser  test      .pest.php  ❌

[Model][Aspect]Test.pest.php
Article BusinessLogic Test.pest.php  ✅
article businesslogic test.pest.php  ❌
```

## 🔍 Checklist Pre-Commit

```bash
# 1. Verifica naming test
find tests/ -name "*test.php" -o -name "*test.pest.php"
# Risultato atteso: VUOTO

# 2. Verifica duplicati case-insensitive
find tests/ -name "*Test*" | sort -f | uniq -i -d
# Risultato atteso: VUOTO

# 3. Verifica PHPStan
./vendor/bin/phpstan analyse
# Risultato atteso: [OK] No errors
```

## 📊 Impatto Duplicati

**Caso Reale Xot Module:**
- Errori prima: 128
- Duplicato eliminato: fixstructuretest.pest.php
- Errori dopo: 109
- **Risparmio: 19 errori (15%!)**

**Cause Errori Duplicati:**
1. PHPStan analizza entrambi i file
2. Stesse property/metodi riportati 2x
3. Confusione su quale correggere
4. Rischio correzioni divergenti

## 🎓 Regola Generale

**File Test Naming = Class Naming**

| Elemento | Convention | Esempio |
|----------|------------|---------|
| Class Name | PascalCase | `UserAuthenticationTest` |
| File Name | PascalCase.php | `UserAuthenticationTest.php` |
| File Pest | PascalCase.pest.php | `UserAuthenticationTest.pest.php` |
| Namespace | PascalCase | `Tests\Feature\UserAuthenticationTest` |

**Mai:**
- ❌ minuscolo totale: `usertest.php`
- ❌ snake_case: `user_test.php`
- ❌ camelCase: `userTest.php`
- ❌ UPPERCASE: `USERTEST.PHP`

**Sempre:**
- ✅ PascalCase: `UserTest.php`
- ✅ PascalCase Pest: `UserTest.pest.php`

## 📖 Documentazione Correlata

- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)
- [Pest Documentation](https://pestphp.com/)
- [Laravel Testing](https://laravel.com/docs/testing)

## 🏆 Benefici

✅ Nessun duplicato  
✅ Autoloading corretto  
✅ PHPStan pulito  
✅ Cross-platform sicuro  
✅ Convenzioni standard

---

**Regola Critica: Test File Naming**  
**SEMPRE PascalCase - MAI minuscolo** 🎯

