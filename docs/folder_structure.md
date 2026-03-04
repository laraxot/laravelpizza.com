# Struttura delle Cartelle Coinvolte nel CmsServiceProvider

**Obiettivo**: Documentare le directory e i file chiave utilizzati da `CmsServiceProvider` per la gestione della localizzazione e del tema pubblicazione, applicando principi di Clean Code (Single Responsibility, nomi chiari, Feature Folder Pattern).

## 1. Root Configuration
- **.env**: definisce `APP_LOCALE`, `APP_FALLBACK_LOCALE`, `APP_FAKER_LOCALE`.
- **config/app.php**: imposta `'locale'`, `'fallback_locale'`, `'faker_locale'` in base a `.env`.
- **config/laravellocalization.php**: elenca `supportedLocales`, `useAcceptLanguageHeader`, `hideDefaultLocaleInURL`, `localesOrder`, ecc.

## 2. Modulo Cms
- **Modules/Cms/app/Providers/CmsServiceProvider.php**:
  - Verifica e sincronizza la lingua predefinita con `supportedLocales`.
  - Carica configurazioni di localizzazione del modulo con `mergeConfigFrom()`.
  - Registra percorsi di view e Livewire tramite `registerFolio()` e `registerThemeLivewireComponents()`.
  - Principi Clean Code:
    - Ogni metodo ha una **singola responsabilità**.
    - Nomi chiari e coerenti (`registerFolio`, `registerNamespaces`).

- **Modules/Cms/config/laravellocalization.php** (opzionale): estende le impostazioni di localizzazione del modulo.
- **Modules/Cms/lang/**: traduzioni specifiche del modulo caricate da `registerNamespaces()`.
- **Modules/Cms/resources/views/pages/**: template Blade delle pagine CMS utilizzate da Folio.
- **Modules/Cms/project_docs/**: documentazione del modulo (incluso questo file).

## 3. Temi Pubblici (Themes)
- **Themes/{pub_theme}/resources/lang/**: traduzioni del tema.
- **Themes/{pub_theme}/resources/views/pages/**: view Blade per le pagine del tema.
- **Themes/{pub_theme}/app/Http/Livewire/**: componenti Livewire del tema registrati in `registerThemeLivewireComponents()`.

## Principi di Clean Code Applicati
- **Feature Folder Pattern**: raggruppamento per feature (Configuration, Provider, Lang, Views, Docs).
- **Single Responsibility**: ogni cartella/class è responsabile di un solo compito.
- **Naming** descrittivi e coerenti.
- Evitare **eccessiva profondità** di directory (>3 livelli).
- Isolare la logica di localizzazione e tema all'interno del modulo Cms.

---
*Documento generato per allineare la struttura del progetto ai principi di Clean Code.*
