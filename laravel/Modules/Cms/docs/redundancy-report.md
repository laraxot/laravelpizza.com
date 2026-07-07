- Inventario [ridondanze cross-modulo](../docs/redundancy-report.md)
- Concetti [ridondanze cross-cutting](../Xot/docs/wiki/concepts/ridondanze-cross-cutting-codebase.md)

# Redundancy Report — Modulo Cms

> Generato: 2026-05-21 | Analisi automatica deep-scan

## Problemi Trovati

### 1. 🟠 BaseTreeModel — Non estende Xot\BaseTreeModel

**File**: `app/Models/BaseTreeModel.php`

Implementa `HasRecursiveRelationships` e `HasRecursiveRelationshipsContract` direttamente, duplicando logica già presente in `Modules\Xot\Models\BaseTreeModel`.

**Azione suggerita**: Estendere `Xot\Models\BaseTreeModel` e aggiungere solo `MenuFactory` e `MediaCollection` specifici di Cms.

### 2. 🟠 BaseModelLang — Duplicato con Lang

| File | Modulo |
|------|--------|
| `app/Models/BaseModelLang.php` | Cms |
| `Modules/Lang/app/Models/BaseModelLang.php` | Lang |

Lang è il modulo canonico per i modelli di traduzione.

**Azione suggerita**: Cms dovrebbe estendere/importare la versione di Lang.

### 3. 🟡 Appearance Cluster — Duplicato con User

| File | Modulo |
|------|--------|
| `app/Filament/Clusters/Appearance.php` | Cms |
| `Modules/User/app/Filament/Clusters/Appearance.php` | User |

Verificare se entrambi i Cluster sono necessari.

### 4. 🟡 EventServiceProvider — Non usa XotBaseEventServiceProvider

**File**: `app/Providers/EventServiceProvider.php`

Estende `BaseEventServiceProvider` (Laravel) invece di `XotBaseEventServiceProvider`.

### 5. 🟠 ThemeComposer — copia storica fuori da PSR-4

Due file dichiarano `namespace Modules\Cms\View\Composers` e `class ThemeComposer`:

| Path | Effetto runtime |
|------|-----------------|
| [`app/View/Composers/ThemeComposer.php`](../app/View/Composers/ThemeComposer.php) | Caricato da autoload modulo (`"Modules\\Cms\\": "app/"` in [`composer.json`](../composer.json)). |
| `resources/views/Composers/ThemeComposer.php` | **Non incluso nell’autoload**: resta codice quasi gemello soggetto a deriva (“edito qui ma il sito usa l’altro”). |

Implementazioni divergono (es. **`getMenu`**: ciclo chiavi/`(string)` in `app/` vs assegnazione diretta nella copia sotto resources; branching `type/url` più difensivo in `app/`).

**Azione suggerita:** rimuovere o archiviare la copia sotto **`resources/views/Composers/`** dopo verifica grep che nessuno la importi tramite include manuale; finché coesiste tenerla nei triage refactor insieme a issue [#90](https://github.com/laraxot/base_fixcity_fila5/issues/90).

## Riepilogo

| Priorità | Problema | Stato |
|----------|----------|-------|
| 🟠 | BaseTreeModel non conforme | Da risolvere |
| 🟠 | BaseModelLang duplicato con Lang | Da unificare |
| 🟠 | ThemeComposer (copia in `resources/views/`) fuori autoload | Da bonificare / archiviare |
| 🟡 | Appearance Cluster duplicato con User | Da verificare |
| 🟡 | EventServiceProvider inconsistente | Da standardizzare |
