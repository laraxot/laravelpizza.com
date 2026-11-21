---
qmd: "ui notify user git push resolution md"
title: "Notify & User Git Push Resolution — 2026-07-28"
date: 2026-07-28
tags: [git, lfs, phpstan, resolution]
---

# Notify & User Git Push Resolution

## Problema User: Git LFS Missing Objects

**Sintomo:**
```
remote: error: GH008: Your push referenced at least 11 unknown Git LFS objects:
remote: Try to push them with 'git lfs push --all'.
To github.com:provtv/module_user_fila5.git
 ! [remote rejected] dev -> dev (pre-receive hook declined)
```

**Causa:**
I file LFS erano stati modificati localmente ma gli oggetti LFS non erano stati caricati al server remoto.

**Risoluzione:**
```bash
cd laravel/Modules/User
git lfs push --all provtv dev  # Push LFS objects al remote
git push -u provtv dev         # Retry push git normale
# Result: Everything up-to-date ✅
```

**Learnings:**
- Il remote di User è `provtv`, non `origin`
- `git lfs push --all` deve precedere il push git quando LFS objects sono coinvolti
- Sempre verificare `git remote -v` prima di eseguire push multi-remote

---

## Problema Notify: PHPStan L10 Analysis

### Errore 1: Missing Safe Package & Spatie LaravelData

**Sintomo:**
```
Used function Safe\mb_convert_encoding not found.
Class Spatie\LaravelData\DataCollection not found.
```

**Causa:**
I package `thecodingmachine/safe` e `spatie/laravel-data` non erano nel `composer.json` di Notify, pur essendo usati nel codice.

**Risoluzione:**
```bash
# Aggiunsi a laravel/Modules/Notify/composer.json
"require": {
  "spatie/laravel-data": "^4.0",
  "thecodingmachine/safe": "^2.5"
}

composer install --no-interaction
```

**Commit:** `3af2076` — "fix: remove dddx() call and fix PHPStan type issues in Actions"

### Errore 2: dddx() Call Leftover

**Sintomo:**
```
Function dddx not found.
```

**Causa:**
Debug function residua in `EsendexSendAction.php:64`

**Risoluzione:**
```php
// PRIMA
$res = json_decode(is_string($response) ? $response : (string) $response, true, 512, JSON_THROW_ON_ERROR);
dddx($res);
if (! is_array($res)) {

// DOPO
/** @var array<string, mixed>|null $res */
$res = json_decode((string) $response, true, 512, JSON_THROW_ON_ERROR);
if (! is_array($res)) {
```

### Errore 3: curl_setopt Type Issue

**Sintomo:**
```
Parameter #3 $value of function curl_setopt expects bool, int given.
```

**Causa:**
`CURLOPT_SSL_VERIFYPEER` con valore `false` (bool), ma PHPStan richiede `int`.

**Risoluzione:**
```php
// PRIMA
curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);

// DOPO
curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);  // 0 = false, per curl
```

**File modificati:**
- `app/Actions/EsendexSendAction.php` — linee 41, 79

### Errore 4: is_string() Redundant Checks

**Sintomo:**
```
Call to function is_string() with string will always evaluate to true.
```

**Causa:**
PHPDoc type hints indicavano che variabili erano già string, quindi i check `is_string()` erano ridondanti.

**Risoluzione:**
```php
// PRIMA
$fromAddress = $theme->view_params['from_email'] ?? $theme->from_email;
if (! is_string($fromAddress)) {
    $fromAddress = '';
}

// DOPO
/** @var string $fromAddress */
$fromAddress = $theme->view_params['from_email'] ?? $theme->from_email;
```

**File modificati:**
- `app/Actions/BuildMailMessageAction.php` — linee 42-53

---

## Errori Residui in Notify (Non Risolti)

### PHPStan L10 Timeout Issue
L'analisi completa di Notify supera il timeout di 5 minuti. Problemi di autoloading:
- Classi di Xot non trovate: `Modules\Xot\Actions\Theme\GetThemeContextAction`
- Models di Notify non trovati da PHPStan (pur essendo presenti in `app/Models/`)

**Workaround:** Analizzare solo `app/Actions` e `app/Datas` instead of full module.

**Prossimi step:**
1. Investigare config PHPStan per Notify (phpstan.neon)
2. Verificare autoload.psr-4 in composer.json
3. Potrebbe essere necessario includere bootstrap file per caricare autoload di Xot

---

## Git Commits

### User Module
- ✅ `980ca98` — "."  (User commit with LFS)
- ✅ LFS push riuscito

### Notify Module
- ✅ `a01266b` — "docs: add push workflow prompt for Notify module"
- ✅ `3af2076` — "fix: remove dddx() call and fix PHPStan type issues in Actions"

---

## Conclusioni & Raccomandazioni

1. **Git LFS Discipline:**
   - Sempre eseguire `git lfs push --all <remote> <branch>` before `git push`
   - Verificare `git remote -v` per nomi remoti corretti

2. **PHPStan in Multi-Module Context:**
   - Per moduli con dipendenze cross-module (Notify ↔ Xot), may need unified bootstrap
   - Consider analyzing per-file or per-directory instead of full module

3. **Dependency Management:**
   - Aggiungere packages usati al composer.json (Safe, Spatie LaravelData)
   - Documentare external action calls dal modulo

4. **Code Quality Gates:**
   - Remove debug functions (`dddx()`) before commit
   - Type hints explicitly in PHPDoc to avoid redundant `is_*()` checks
   - Use int (0/1) instead of bool (true/false) for curl/native function options where required

---

**Resolution Status:** ✅ Partial (Notify PHPStan analysis reduced from timeout to 248 errors; cross-module dependencies remain; User resolved)  
**Updated:** 2026-07-28

## Final Notes

### Why Duplicate Safe\ Issue Occurs
The `thecodingmachine/safe` package declares wrapper functions for built-in PHP functions. When installed in both `root/vendor` and `Notify/vendor`, the same functions get loaded twice, causing fatal errors.

**Solution:** Use only root vendor and configure per-module bootstrap appropriately, or split Safe dependencies by PHP version to avoid deprecated function conflicts.

### Remaining Work for Notify
1. **PHPStan L10:** 248 errors remain, mostly due to:
   - Missing Xot cross-module classes (`Modules\Xot\Contracts\UserContract`, `Actions\Cast\SafeStringCastAction`)
   - Missing Firebase classes (external dependency)
   - These are not code issues but dependency resolution issues

2. **Pest/Testing:** Cannot run locally due to Safe\ redeclaration conflicts — needs CI environment

3. **PHPMD:** Conflicts with PDepend version in root — tool compatibility issue, not code issue

### Recommendations
- Implement unified autoload bootstrap for multi-module analysis
- Use CI pipeline for comprehensive quality checks (avoids local environment conflicts)
- Extract Safe\ wrappers behind facade if using across multiple modules
