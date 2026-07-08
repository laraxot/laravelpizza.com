# Convenzioni di Naming per i Test

## Problema: Duplicati Lowercase in Filesystem Case-Insensitive

### Contesto
In sistemi operativi case-insensitive (Windows, macOS di default), Git può creare duplicati di file con nomi che differiscono solo per il case (maiuscole/minuscole). Quando il repository viene clonato su sistemi case-sensitive (Linux), questi duplicati diventano file separati, causando:
- Test eseguiti due volte
- Errori PHPStan duplicati
- Confusione nella manutenzione del codice
- Problemi di merge in Git

### Regola Fondamentale

**TUTTI i file di test devono seguire il PascalCase con suffisso `Test`:**
- ✅ `UserTest.php`
- ✅ `LoginTest.php`
- ✅ `FixStructureTest.pest.php`
- ✅ `Pest.php` (file di configurazione Pest)
- ❌ `usertest.php` (DUPLICATO DA ELIMINARE)
- ❌ `logintest.php` (DUPLICATO DA ELIMINARE)
- ❌ `fixstructuretest.pest.php` (DUPLICATO DA ELIMINARE)
- ❌ `pest.php` (DUPLICATO DA ELIMINARE)

### Pattern di Riconoscimento Duplicati

I duplicati lowercase seguono questi pattern:
```bash
# Pattern errati (da eliminare)
*test.php         # es: logintest.php
*test.pest.php    # es: fixstructuretest.pest.php
pest.php          # (solo se esiste anche Pest.php)

# Pattern corretti (da mantenere)
*Test.php         # es: LoginTest.php
*Test.pest.php    # es: FixStructureTest.pest.php
Pest.php          # (file di configurazione)
```

### Comando per Trovare Duplicati

```bash
# Trova tutti i duplicati lowercase nei test
find Modules/*/tests Themes/*/tests -type f \
  \( -name "*test.php" -o -name "*test.pest.php" -o -name "pest.php" \) \
  ! -name "*Test.php" ! -name "*Test.pest.php" ! -name "Pest.php" \
  2>/dev/null
```

### Procedura di Pulizia

1. **Identificare i duplicati:**
   ```bash
   cd /var/www/_bases/base_fixcity_fila5_mono/laravel
   find Modules/*/tests Themes/*/tests -type f \
     \( -name "*test.php" -o -name "*test.pest.php" -o -name "pest.php" \) \
     ! -name "*Test.php" ! -name "*Test.pest.php" ! -name "Pest.php" \
     2>/dev/null | tee /tmp/duplicates_to_delete.txt
   ```

2. **Verificare che siano effettivamente duplicati:**
   ```bash
   # Per ogni file lowercase, deve esistere la versione PascalCase
   while read file; do
     basename=$(basename "$file")
     dirname=$(dirname "$file")
     pascalcase=$(echo "$basename" | sed 's/^\(.\)/\U\1/')
     correct="$dirname/$pascalcase"
     if [ -f "$correct" ]; then
       echo "✓ $file è duplicato di $correct"
     else
       echo "⚠ $file NON ha corrispondente PascalCase!"
     fi
   done < /tmp/duplicates_to_delete.txt
   ```

3. **Eliminare i duplicati:**
   ```bash
   # Solo dopo verifica manuale!
   cat /tmp/duplicates_to_delete.txt | while read file; do
     rm -v "$file"
   done
   ```

### Prevenzione

**Durante lo sviluppo:**
- Creare sempre i file di test con PascalCase: `*Test.php` o `*Test.pest.php`
- Configurare Git per essere case-sensitive anche su filesystem case-insensitive:
  ```bash
  git config core.ignorecase false
  ```
- Utilizzare pre-commit hook per verificare il naming

**Durante il code review:**
- Verificare che tutti i nuovi test seguano il PascalCase
- Rifiutare PR con file lowercase

### Correzione Effettuata - Ottobre 2025

**Duplicati eliminati: 21 file**

**Moduli interessati:**
- `Cms`: 12 duplicati in `tests/Feature/Auth/`
- `Gdpr`: 1 duplicato in `tests/Feature/`
- `Geo`: 1 duplicato in `tests/Unit/Models/`
- `Media`: 1 duplicato in `tests/Filament/Resources/`
- `Notify`: 2 duplicati in `tests/Feature/`
- `Tenant`: 1 duplicato in `tests/Unit/`
- `Xot`: 3 duplicati (`tests/Unit/`, `tests/Feature/`, `tests/`)

**File eliminati:**
```
Modules/Cms/tests/Feature/Auth/registertest.php
Modules/Cms/tests/Feature/Auth/logintest.php
Modules/Cms/tests/Feature/Auth/loginwidgettest.php
Modules/Cms/tests/Feature/Auth/loginvolttest.php
Modules/Cms/tests/Feature/Auth/emailverificationtest.pest.php
Modules/Cms/tests/Feature/Auth/authenticationtest.php
Modules/Cms/tests/Feature/Auth/registertypetest.php
Modules/Cms/tests/Feature/Auth/registertypewidgettest.php
Modules/Cms/tests/Feature/Auth/passwordconfirmationtest.php
Modules/Cms/tests/Feature/Auth/profileupdatetest.php
Modules/Cms/tests/Feature/Auth/passwordresettest.php
Modules/Cms/tests/Feature/Auth/passwordupdatetest.php
Modules/Gdpr/tests/Feature/conflictresolutiontest.php
Modules/Geo/tests/Unit/Models/comunetest.php
Modules/Media/tests/Filament/Resources/mediaconvertresourcetest.php
Modules/Notify/tests/Feature/jsoncomponentstest.php
Modules/Notify/tests/Feature/emailtemplatestest.php
Modules/Tenant/tests/Unit/domaintest.php
Modules/Xot/tests/Unit/metatagdatatest.php
Modules/Xot/tests/pest.php
Modules/Xot/tests/Feature/fixstructuretest.pest.php
```

### Impatto

**Prima della pulizia:**
- Test eseguiti più volte (ridondanti)
- Errori PHPStan duplicati
- Confusione nel codebase

**Dopo la pulizia:**
- Ogni test eseguito una sola volta
- Riduzione errori PHPStan
- Codebase più pulito e manutenibile

### Best Practice

1. **Naming Consistente:** Sempre PascalCase per i test
2. **Verifica Git:** Configurare `core.ignorecase false`
3. **CI/CD:** Aggiungere check automatico per rilevare duplicati
4. **Documentazione:** Mantenere questa regola aggiornata
5. **Training:** Educare il team sulle convenzioni di naming

### Collegamenti

- [PSR-12: Coding Style](https://www.php-fig.org/psr/psr-12/)
- [Laravel Testing Best Practices](https://laravel.com/docs/testing)
- [Pest PHP Documentation](https://pestphp.com/)
- [Git Case Sensitivity](https://git-scm.com/docs/git-config#Documentation/git-config.txt-coreignoreCase)

### Riferimenti Interni

- [../quality/phpstan-fixes.md](../quality/phpstan-fixes.md)
- [../../Modules/Activity/docs/testing-guidelines.md](../../laravel/Modules/Activity/docs/testing-guidelines.md)
- [./test-structure.md](./test-structure.md)

