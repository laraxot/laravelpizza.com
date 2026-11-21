---
title: "ide helper sushi pattern"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "ide helper sushi pattern"
issues: []
discussions: []
name: ide-helper-sushi-pattern
description: Pattern per gestire modelli Sushi (in-memory) durante l'analisi ide-helper
metadata:
  module: Lang
  type: architecture
  severity: medium
  status: implemented
  last_run: 2026-07-15
---

# IDE Helper + Sushi: Pattern di Caricamento Lazy

## Problema

`TranslationFile` usa `Sushi` (in-memory model senza DB). Durante `php artisan ide-helper:models`:

1. IDE Helper istanzia `TranslationFile`
2. Sushi chiama `bootSushi()` durante `__construct()`
3. `bootSushi()` chiama `getRows()` per caricare i dati
4. `getRows()` esegue `File::getRequire()` sui file di traduzione
5. Se il file contiene funzioni locali (es. `merge_translation_files()`), fallisce:
   ```
   Exception: Call to undefined function merge_translation_files()
   ```

## Root Cause

Sushi non sa che è in fase di analisi statica e carica i dati come se fosse runtime.

Catena osservata il 2026-07-15:

1. ide-helper istanzia `TranslationFile`
2. trait `Sushi` → `bootSushi()` → `getRows()`
3. `GetAllTranslationAction` elenca path `Modules/*/lang/{locale}/*.php`
4. `File::getRequire($path)` esegue file loader (es. `job_core.php`, `set_default_tenant_for_urls_fields.php`)
5. Loader chiama `merge_translation_files()` — funzione **non presente** in `Helper.php` runtime (solo stub PHPStan in Xot)
6. Exception → `Could not analyze class`

### Scopo business (perché esiste TranslationFile)

- **Business:** dare a Filament/admin una tabella virtuale di tutti i file traduzione modulo, con chiave `modulo::file`, path e contenuto JSON per editing.
- **Tecnico:** Sushi evita una tabella DB dedicata; i dati vivono nel filesystem lang.
- **Conflitto:** l'analisi statica non deve eseguire loader i18n pensati per LangServiceProvider con bootstrap completo.

Vedi anche [merge-translation-files-helper](../../Xot/docs/merge-translation-files-helper.md).

## Soluzione: Guard per IDE Helper

### Implementazione

Aggiungi questo metodo a `TranslationFile`:

```php
class TranslationFile extends BaseModel {
    use Sushi;

    public function getRows(): array {
        // Skip data loading durante ide-helper per evitare side-effects
        if ($this->shouldSkipDataLoad()) {
            return [];
        }

        // Caricamento normale
        $files = app(GetAllTranslationAction::class)->execute();
        // ... resto della logica
    }

    /**
     * Ritorna true se siamo in fase di analisi statica.
     * Usato per evitare side-effects (caricamento file, accesso DB, ecc.)
     */
    private function shouldSkipDataLoad(): bool {
        // Check 1: Ambiente CLI durante ide-helper
        if (in_array('ide-helper:models', $_SERVER['argv'] ?? [], true)) {
            return true;
        }

        // Check 2: PHPStan in esecuzione
        if (defined('PHPSTAN_RUNNING')) {
            return true;
        }

        // Check 3: Environment variable esplicita
        if (getenv('IDE_HELPER_RUNNING') === '1') {
            return true;
        }

        return false;
    }
}
```

### Come Funziona

1. **Sushi riceve uno schema vuoto** → sa che il modello ha le colonne definite in `$form`
2. **getRows() non carica file** → nessun `File::getRequire()` durante analisi
3. **IDE Helper genera PHPDoc** → normale, senza errori
4. **Runtime normale** → `getRows()` carica i dati, tutto funziona

## Test

```bash
# Prima (falliva):
php artisan ide-helper:models
# Exception: Call to undefined function merge_translation_files()

# Dopo (dovrebbe passare):
php artisan ide-helper:models
# Model information was written to _ide_helper_models.php
```

## Filosofia

- **Sushi è lazy loading in-memory** — dati reali solo a runtime utente/admin
- **IDE Helper è analisi statica** — schema sì, `require` lang no
- **Lo schema `$form` basta** — colonne note senza righe
- **Religione Lang:** traduzioni = SSoT filesystem; il model è una **vista**, non il loader
- **Politica:** helper merge è di competenza Xot; Lang consuma path
- **Zen:** `return []` durante ide-helper ≠ perdita funzionalità runtime

## Run 2026-07-15

```bash
cd laravel && php artisan ide-helper:models --no-interaction
```

```text
Exception: Call to undefined function merge_translation_files()
Could not analyze class Modules\Lang\Models\TranslationFile.
```

Implementazione guard in `TranslationFile::getRows()`: **applicata** (2026-07-15).

## Pattern Applicabile Ad Altri Moduli

Se altri moduli usano `Sushi` o caricano risorse durante `__construct()`:

1. Identifica dove avviene il caricamento (getRows, boot trait, ecc.)
2. Aggiungi il guard `shouldSkipDataLoad()` 
3. Restituisci dati minimi (array vuoto, schema stub, ecc.)

---

**Vedi anche:**

- [ide-helper-philosophy](../../Xot/docs/ide-helper-philosophy.md) — Filosofia generale
- [merge-translation-files-helper](../../Xot/docs/merge-translation-files-helper.md) — Helper loader modulare
- [ide-helper-models-wave](../../Xot/docs/ide-helper-models-wave.md) — Registro wave
