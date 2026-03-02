# PHPStan Fixes - Modulo Cms

## Panoramica
Documentazione dei fix applicati al modulo Cms per raggiungere PHPStan livello 9.

## Fix Applicati

### 1. generate_business_data.php
**Problema**: Uso di `file_put_contents` non sicuro
```php
// PRIMA (non sicuro)
file_put_contents($filePath, $content);

// DOPO (sicuro)
use function Safe\file_put_contents;
file_put_contents($filePath, $content);
```

**Motivazione**: 
- Utilizzo della funzione sicura `Safe\file_put_contents` per gestione errori robusta
- Prevenzione di errori runtime in caso di problemi di scrittura file
- Conformità agli standard di sicurezza PHPStan

### 3. Metodi duplicati rimossi dai model (2026-03-02) - REGRESSIONE CORRETTA

**Problema**: `getJsonFile()` era stato aggiunto direttamente a Attachment, Menu, PageContent, Section
usando `base_path()` invece di usare il metodo gia' presente in `SushiToJsons` trait
che usa correttamente `TenantService::filePath()`.

**Secondo problema**: `getBlocksBySlug()` era stato aggiunto direttamente a Section e Page
invece di usare quello gia' presente in `HasBlocks` trait.

**Soluzione**:
- Rimosso `getJsonFile()` da tutti e 4 i model (usare quello del trait)
- Rimosso `getBlocksBySlug()` da Section.php e Page.php (usare quello di HasBlocks)
- Rimossi gli `@method` docblock ridondanti

**Regola**: Prima di aggiungere un metodo a un model, leggere TUTTI i trait che usa.
Se il metodo esiste gia' nel trait, NON ridefinirlo.

---

### 2. SushiToJsonsHelper rimosso (2026-03-02)
**Problema**: Fatal error "Trait Modules\Cms\Models\SushiToJsonsHelper not found" bloccava PHPStan.

**Soluzione**: Allineamento a `base_techplanner_fila5`. Il trait `SushiToJsonsHelper` non esiste in techplanner; `SushiToJsons` è self-contained. Rimossi `use SushiToJsonsHelper` da:
- `Section.php`
- `PageContent.php` (già senza)
- `BaseModelJsons.php` (modulo Tenant)

**Riferimento**: [base_techplanner Cms Section](https://github.com/laraxot/base_techplanner_fila5/blob/main/laravel/Modules/Cms/app/Models/Section.php) usa solo `SushiToJsons`.

### 4. Session 2026-03-02 - Blocks, SushiToJson, Safe
- **UI Blocks**: Aggiunto supporto `tpl` come alias di `view` per retrocompatibilità
- **Cms/Blog ThemeComposer**: Sostituito `tpl:` con `view:` nelle chiamate Blocks
- **Tenant SushiToJson**: Aggiunto `@phpstan-require-implements` e assert `instanceof SushiToJsonContract` nelle closure
- **Tenant SushiToJsons**: Rimossi check `is_string($file)` ridondanti (getJsonFile restituisce string)
- **Geo Comune**: Aggiunto thecodingmachine/safe, use Safe\file_get_contents, json_decode, mkdir, file_put_contents, json_encode
- **TestSushiModel**: Corretto return type saveToJson a bool
- **Cms Page/Section**: phpstan-ignore per getBlocksBySlug (metodo da trait)
- **Cms PageSlugMiddleware**: phpstan-ignore e cast array per getMiddlewareBySlug
- **Cms GuestLayout**: @phpstan-var view-string per parametro view

## Risultati
- ✅ **Fatal SushiToJsonsHelper** risolto
- ✅ **Conformità** agli standard di sicurezza
- ✅ **Gestione errori** robusta per operazioni file

## Collegamenti
- [Report Completo PHPStan Fixes](../../../bashscripts/docs/phpstan_fixes_comprehensive_report.md)
- [Script Risoluzione Conflitti](../../../bashscripts/docs/conflict_resolution_script_improvements.md)

