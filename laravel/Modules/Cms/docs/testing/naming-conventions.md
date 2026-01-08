# Convenzioni di Naming per i Test - Modulo Cms

## Riferimento Principale

Per la documentazione completa delle convenzioni di naming dei test, consultare:
- [../../../../docs/testing/naming-conventions.md](../../../../docs/testing/naming-conventions.md)

## Applicazione al Modulo Cms

### Duplicati Eliminati nel Modulo Cms

**Data:** Ottobre 2025  
**Duplicati trovati e eliminati:** 12 file (il modulo più interessato!)

**Path:** `Modules/Cms/tests/Feature/Auth/`

```
authenticationtest.php              → mantiene AuthenticationTest.php
emailverificationtest.pest.php      → mantiene EmailVerificationTest.pest.php
logintest.php                       → mantiene LoginTest.php
loginvolttest.php                   → mantiene LoginVoltTest.php
loginwidgettest.php                 → mantiene LoginWidgetTest.php
passwordconfirmationtest.php        → mantiene PasswordConfirmationTest.php
passwordresettest.php               → mantiene PasswordResetTest.php
passwordupdatetest.php              → mantiene PasswordUpdateTest.php
profileupdatetest.php               → mantiene ProfileUpdateTest.php
registertest.php                    → mantiene RegisterTest.php
registertypetest.php                → mantiene RegisterTypeTest.php
registertypewidgettest.php          → mantiene RegisterTypeWidgetTest.php
```

### Struttura Test Corretta del Modulo

```
Modules/Cms/tests/
├── Pest.php
├── Feature/
│   └── Auth/
│       ├── AuthenticationTest.php              ✅
│       ├── EmailVerificationTest.pest.php      ✅
│       ├── LoginTest.php                       ✅
│       ├── LoginVoltTest.php                   ✅
│       ├── LoginWidgetTest.php                 ✅
│       ├── PasswordConfirmationTest.php        ✅
│       ├── PasswordResetTest.php               ✅
│       ├── PasswordUpdateTest.php              ✅
│       ├── ProfileUpdateTest.php               ✅
│       ├── RegisterTest.php                    ✅
│       ├── RegisterTypeTest.php                ✅
│       └── RegisterTypeWidgetTest.php          ✅
└── Unit/
    └── ...
```

### Pattern Test di Autenticazione Cms

Il modulo Cms ha una struttura particolare per i test di autenticazione:

1. **Test separati per architettura:**
   - `LoginTest.php` - Testa la pagina `/it/auth/login`
   - `LoginVoltTest.php` - Testa il componente Volt `auth.login`
   - `LoginWidgetTest.php` - Testa il widget Filament

2. **Test separati per registrazione:**
   - `RegisterTest.php` - Registrazione base
   - `RegisterTypeTest.php` - Registrazione con tipologia
   - `RegisterTypeWidgetTest.php` - Widget registrazione

Questa separazione richiede **naming ancora più preciso** per evitare confusione!

### Verifica Locale

```bash
# Da eseguire nella root del modulo
cd Modules/Cms
find tests -type f -name "*.php" | grep -E "(test\.php|test\.pest\.php)" | grep -v -E "(Test\.php|Test\.pest\.php)"
# Output vuoto = tutto corretto ✅
```

### Lezione Appresa: Modulo con Molti Test Auth

**Problema:**
- 12 duplicati su un solo modulo
- Tutti nella stessa cartella `tests/Feature/Auth/`
- Creati probabilmente durante refactoring o merge

**Soluzione:**
- Eliminazione sistematica dei duplicati lowercase
- Verifica manuale che la versione PascalCase esista
- Documentazione del pattern

### Best Practice per Test Auth in Cms

1. **Naming esplicito per evitare confusione:**
   - `LoginTest` vs `LoginVoltTest` vs `LoginWidgetTest`
   - Ogni test ha responsabilità separata

2. **Verifica doppia prima di commit:**
   ```bash
   # Verifica naming prima di commit
   git status | grep -i "test" | grep -v "Test"
   ```

3. **Code review rigoroso:**
   - Verificare che non ci siano duplicati
   - Controllare che i test abbiano nomi univoci

### Impatto della Correzione

**Prima:**
- 12 file duplicati eseguiti 2 volte
- Confusione su quale file modificare
- Errori PHPStan duplicati

**Dopo:**
- Ogni test eseguito una sola volta
- Chiarezza sui file da modificare
- Riduzione errori PHPStan

### Collegamenti Correlati

- [../../../../docs/testing/naming-conventions.md](../../../../docs/testing/naming-conventions.md) - Documentazione completa
- [../auth/testing-patterns.md](../auth/testing-patterns.md) - Pattern test autenticazione
- [../phpstan_fixes_cms.md](../phpstan_fixes_cms.md) - Correzioni PHPStan modulo Cms

