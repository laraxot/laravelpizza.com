---
qmd: "graphify map"
issues: []
discussions: []
title: "Lang Module — Mappa Graphify"
module: lang
type: integration
tags: [integrations, modules, lang]
created: 2026-08-24
updated: 2026-08-24
---

# Lang Module — Mappa Graphify

**Versione:** 1.0.0 | **Modulo:** Lang | **Data:** 2026-08-02

---

## 📌 Cosa fa il modulo Lang

Il modulo **Lang** gestisce:
- **Gestione traduzioni** — CRUD traduzioni per molteplici lingue (IT, EN, DE)
- **Sincronizzazione file translation** — lettura/scrittura file `.php` per lingue supportate
- **Fallback chain e locale switching** — cambio lingua dinamico con fallback chain
- **Integrazione Filament** — UI admin per gestire traduzioni e file di traduzione
- **Database-backed translations** — persistenza traduzioni su DB con `translations` e `language_lines`
- **Multi-module translation aggregation** — raccolta traduzioni da tutti i moduli

---

## 🏗️ Architettura Essenziale

### Entry Points

| Tipo | Classe | Path |
|------|--------|------|
| **Model** | `Translation` | `app/Models/Translation.php` |
| **Model** | `TranslationFile` | `app/Models/TranslationFile.php` |
| **Model** | `LanguageLine` | `app/Models/LanguageLine.php` |
| **Action** | `SaveTransAction` | `app/Actions/SaveTransAction.php` |
| **Action** | `GetAllTranslationAction` | `app/Actions/GetAllTranslationAction.php` |
| **Action** | `ReadTranslationFileAction` | `app/Actions/ReadTranslationFileAction.php` |
| **Action** | `WriteTranslationFileAction` | `app/Actions/WriteTranslationFileAction.php` |
| **Action** | `SyncTranslationsAction` | `app/Actions/SyncTranslationsAction.php` |
| **Action** | `TransArrayAction` | `app/Actions/TransArrayAction.php` |
| **Action** | `TransCollectionAction` | `app/Actions/TransCollectionAction.php` |
| **Action** | `TranslatorAction` | `app/Actions/TranslatorAction.php` |
| **Service** | `TranslatorService` | `app/Services/TranslatorService.php` |
| **Filament** | `TranslationFileResource` | `app/Filament/Resources/TranslationFileResource.php` |
| **Filament** | `LangBaseResource` | `app/Filament/Resources/LangBaseResource.php` |
| **Widget** | `LanguageSwitcherWidget` | `app/Filament/Widgets/LanguageSwitcherWidget.php` |
| **Test** | `SaveTransActionTest` | `tests/Unit/Actions/SaveTransActionTest.php` |

### Dependencies (Incoming)

```
Performance → Lang (SaveTransAction per generare etichette traduzioni)
UI → Lang (SaveTransAction per calendar widgets)
Xot → Lang (SaveTransAction per AutoLabelAction, TransCollectionAction per export)
IndennitaResponsabilita → Lang (LangBasePanelProvider per admin panel)
```

### Dependencies (Outgoing)

```
Lang → Laravel i18n (app()->getLocale(), trans() facade)
Lang → Xot (XotBaseResource, XotBaseMigration, ProfileContract)
Lang → Illuminate (File, Arr, Facades)
Lang → Spatie Media (QueueableAction per azioni async)
```

---

## 📊 Grafo Locale (Query Rapide)

### Scoprire Entità Core

```bash
graphify query "Lang module models actions translations file management"
```

### Tracciare Flusso Principale

```bash
graphify path --from "SaveTransAction" --to "TranslationFile"
```

### Trovare Dipendenze

```bash
graphify query "modules using Lang SaveTransAction"
```

### Estendere Traduzioni

```bash
graphify path --from "GetAllTranslationAction" --to "TranslationFile"
```

---

## 🔗 Relazioni Dati (Schema Logico)

### Tabelle Principali

```
translations (DB-backed)
  ├── id (PK)
  ├── lang (nullable, indexed) — codice lingua: 'it', 'en', 'de'
  ├── namespace (nullable, indexed) — es. 'modules.performance'
  ├── group (nullable, indexed) — es. 'widgets', 'messages'
  ├── item (nullable) — specifica chiave dentro il gruppo
  ├── key (nullable, indexed) — chiave completa: 'lang.group.item'
  ├── value (text, nullable) — testo tradotto
  ├── locale (nullable, indexed) — locale IETF: 'it-IT', 'en-US'
  ├── user_id (nullable, indexed, FK → users)
  └── timestamps (created_at, updated_at)

language_lines (Spatie multi-language)
  ├── id (PK)
  ├── group (indexed) — es. 'messages', 'auth'
  ├── key (indexed) — es. 'welcome', 'login'
  ├── text (JSON) — { "it": "...", "en": "...", "de": "..." }
  ├── locale (indexed) — locale corrente
  └── unique(group, key, locale)

posts (test model, può estendersi)
  ├── id (PK)
  ├── title
  ├── content
  └── timestamps
```

### Relazioni tra Modelli

```
Translation ──*:1──> User (creator/updater via ProfileContract)
LanguageLine ──1:N──> Translation (stesso key/locale)
TranslationFile ──1:N──> Translation (stesso file, via Sushi model)
```

---

## 🎯 Task Comuni + Graphify

### Task 1: Aggiungere una nuova traduzione per modulo

**Domanda Graphify:**
```bash
graphify query "SaveTransAction workflow save translation to file"
```

**Workflow:**
1. Invocare `SaveTransAction->execute(key: 'modulo.group.item', data: 'Testo italiano')`
2. Action legge il file di traduzione via `GetTransPathAction`
3. Merge con dati esistenti via `Arr::set()` (Illuminate)
4. Scrivi file PHP via `SaveArrayAction` (da Xot)
5. Optional: Sincronizza DB via `SyncTranslationsAction`

**Esempio di implementazione:**
```php
// In Service o Controller
app(SaveTransAction::class)->execute(
    key: 'performance.widgets.total_revenue',
    data: 'Ricavi Totali'
);
```

---

### Task 2: Passare da una lingua all'altra con fallback

**Domanda Graphify:**
```bash
graphify query "Lang locale switching fallback chain translation loading"
```

**Workflow:**
1. Widget o Filament action chiama `LocaleSwitcherRefresh` action
2. Session locale viene aggiornato: `session()->put('locale', 'en')`
3. `GetAllTranslationAction` legge i file della nuova lingua con `app()->getLocale()`
4. Se traduzioni non trovate, fallback a locale di default
5. Translations aggiunte a `translations` table via `SyncTranslationsAction`

**Punti chiave:**
- Fallback chain: EN → IT (default)
- Session persiste tra richieste via middleware
- File translations hanno precedenza su DB

---

### Task 3: Aggregare traduzioni da tutti i moduli

**Domanda Graphify:**
```bash
graphify query "GetAllTranslationAction glob pattern module translation files"
```

**Workflow:**
1. `GetAllTranslationAction` usa glob: `Modules/*/lang/{locale}/*.php`
2. Estrae module name da path (tra `Modules/` e `/lang/`)
3. Costruisce chiave: `modulo_lowercase::nomefile`
4. Ritorna array di traduzioni aggregato
5. Scrive risultati su DB via `TranslationFile` (Sushi model, in-memory)

**Esempio:**
```php
$translations = app(GetAllTranslationAction::class)->execute();
// Risultato:
// [
//   ['key' => 'performance::widgets', 'path' => '/Modules/Performance/lang/it/widgets.php'],
//   ['key' => 'ui::messages', 'path' => '/Modules/UI/lang/it/messages.php'],
// ]
```

---

### Task 4: Tradurre array/collection per export

**Domanda Graphify:**
```bash
graphify query "TransArrayAction TransCollectionAction translate array keys values"
```

**Workflow:**
1. Moduli come Xot (export) passano array/collection a Lang
2. `TransArrayAction->execute()` traduce ogni valore tramite `trans()`
3. `TransCollectionAction->execute()` applica a collection Illuminate
4. Ritorna struttura tradotta, pronta per esport (Excel, CSV)

**Esempio di uso in Xot:**
```php
// In CollectionExport (Xot)
$translated = app(TransArrayAction::class)->execute(
    array: $data->toArray(),
    locale: app()->getLocale()
);
```

---

### Task 5: Gestire fallback e missing translations

**Domanda Graphify:**
```bash
graphify query "RecordMissingTranslationAction translation not found fallback"
```

**Workflow:**
1. Quando chiave non trovata: `trans('modulo.nonexistent')`
2. Laravel fallback a default locale
3. Optional: `RecordMissingTranslationAction` registra su DB per audit
4. Admin può aggiungere traduzione via Filament UI
5. File PHP viene aggiornato via `WriteTranslationFileAction`

**Fallback chain:**
- Locale richiesto (es. `en`) → File lang/en/*.php
- Locale fallback (es. `it`) → File lang/it/*.php
- Key fallback → Chiave stessa (es. `modulo.missing`)

---

## 📋 Test Coverage Map

```bash
graphify query "Lang module test coverage actions models"
```

### Checklist Copertura

- [x] `app/Models/Translation.php` → `SaveTransActionTest`
- [x] `app/Models/TranslationFile.php` → `ReadTranslationFileActionTest`
- [x] `app/Models/LanguageLine.php` → `LangActionsCoverageTest`
- [x] `app/Actions/SaveTransAction.php` → `SaveTransActionTest`
- [x] `app/Actions/GetAllTranslationAction.php` → `GetAllTranslationActionTest`
- [x] `app/Actions/ReadTranslationFileAction.php` → `ReadTranslationFileActionTest`
- [x] `app/Actions/TransArrayAction.php` → `TransArrayActionTest`
- [x] `app/Actions/TransCollectionAction.php` → `TransCollectionActionTest`
- [x] `app/Actions/GetTransPathAction.php` → `GetTransPathActionTest`
- [ ] `app/Filament/Resources/TranslationFileResource.php` → coverage needed
- [ ] `app/Services/TranslatorService.php` → coverage needed

---

## 🚀 Comandi Rapidi

### Esplora architettura completa

```bash
# Modelli e azioni principali
graphify query "Lang module architecture models actions services"

# Flusso di salvataggio
graphify path --from "SaveTransAction" --to "Translation"

# Flusso di lettura aggregata
graphify path --from "GetAllTranslationAction" --to "TranslationFile"
```

### Scopri dipendenze

```bash
# Chi dipende da Lang?
graphify query "modules importing from Modules.Lang"

# Quali azioni di Lang sono usate?
graphify query "Lang SaveTransAction TransArrayAction usage"
```

### Analiza coverage test

```bash
graphify query "Lang module test coverage gaps"

graphify query "LangActionsCoverageTest implementation"
```

### Query per feature specifiche

```bash
# Locale switching e fallback
graphify query "Lang LocaleSwitcherRefresh locale switching workflow"

# Multi-language handling
graphify query "Lang LanguageLine text JSON locale storage"

# Filament UI
graphify query "Lang TranslationFileResource Filament pages forms"
```

---

## 📚 Riferimenti

- **Graphify Central:** `docs/graphify-integration.md`
- **Module Discipline:** `docs/wiki/rules/module-naming-discipline.md`
- **Lang Config:** `config/lang.php`
- **Laravel i18n Docs:** https://laravel.com/docs/localization
- **Language Lines (Spatie):** https://github.com/spatie/laravel-translatable

---

## 🔄 Flow Diagrams (Concettuale)

### Flusso di Salvataggio Traduzione

```
User Filament UI
    ↓
SaveTransAction::execute(key, data)
    ↓
GetTransPathAction::execute(key) → path
    ↓
ReadTranslationFileAction → array
    ↓
Arr::set(array, piece, data) → merge
    ↓
SaveArrayAction → write to file
    ↓
SyncTranslationsAction → update DB
    ↓
Translation model updated
```

### Flusso di Lettura Aggregata

```
Session::get('locale') → app()->setLocale()
    ↓
GetAllTranslationAction::execute()
    ↓
glob('Modules/*/lang/{locale}/*.php')
    ↓
Parse each file → [key, path]
    ↓
TranslationFile (Sushi model) in-memory
    ↓
Filament TranslationFileResource displays
```

---

**Responsabile:** @marco76tv | **Last updated:** 2026-08-02
