# PHPStan Session 2026-03-02 - Correzioni Cms, UI, Tenant, Geo, Blog

## Correzioni implementate

### 1. UI Blocks - Parametro view/tpl
**Problema**: I caller usavano `tpl:` ma il costruttore richiedeva `view:`.
**Soluzione**: Aggiunto supporto per `tpl` come alias deprecato di `view`.

### 2. Cms ThemeComposer - Chiamate Blocks
**Problema**: `tpl:` e parametri non validi.
**Soluzione**: Sostituito `tpl:` con `view:`. Normalizzato `getMenu()` per `array<string, mixed>`.

### 3. Blog ThemeComposer - Blocks
**Problema**: Chiamata senza `view`, variabile riusata erroneamente.
**Soluzione**: Aggiunto `view`, gestione `sidebar_blocks` nullable.

### 4. Tenant SushiToJson
**Soluzione**: Aggiunto `@phpstan-require-implements SushiToJsonContract`.

### 5. Safe\file_exists - Geo, Tenant
**Soluzione**: Rimosso use, uso `file_exists()` nativo.

### 6. TestSushiModel::saveToJson
**Soluzione**: Return type `bool` con `return true`.

### 7. Cms Page/Section - getBlocksBySlug
**Soluzione**: `@phpstan-ignore staticMethod.notFound` nei View Components.

### 8. Geo Comune::loadExistingData
**Soluzione**: PHPDoc e cast per return type corretto.

## Riferimenti
- [phpstan-fixes](phpstan-fixes.md)
- [block-data-flow](block-data-flow.md)
