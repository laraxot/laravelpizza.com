---
module: Lang
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi Lang

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Lang**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `before` (14 occorrenze)

**Moduli coinvolti:** Activity, Gdpr, Job, Lang, Media, Performance, Progressioni, Setting, Sigma, Tenant, UI, User, Xot

**File in Lang:**

- `./laravel/Modules/Lang/app/Models/Policies/LangBasePolicy.php`

[Riflessione: Presente in 13 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `get` (11 occorrenze)

**Moduli coinvolti:** Lang, Media, Notify, Seo, Xot

**File in Lang:**

- `./laravel/Modules/Lang/app/Casts/LangField.php`
- `./laravel/Modules/Lang/app/Services/TranslatorService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getRows` (11 occorrenze)

**Moduli coinvolti:** Lang, Setting, Sigma, Tenant, User, Xot

**File in Lang:**

- `./laravel/Modules/Lang/app/Models/TranslationFile.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `trans` (8 occorrenze)

**Moduli coinvolti:** Lang, Media, Tenant, Xot

**File in Lang:**

- `./laravel/Modules/Lang/app/Actions/TransArrayAction.php`
- `./laravel/Modules/Lang/app/Actions/TransCollectionAction.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getData` (8 occorrenze)

**Moduli coinvolti:** Lang, UI, User, Xot

**File in Lang:**

- `./laravel/Modules/Lang/app/Datas/TranslationData.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `canView` (7 occorrenze)

**Moduli coinvolti:** Gdpr, Lang, UI, User, Xot

**File in Lang:**

- `./laravel/Modules/Lang/app/Filament/Widgets/LanguageSwitcherWidget.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `collection` (6 occorrenze)

**Moduli coinvolti:** Lang, Progressioni, Ptv, Xot

**File in Lang:**

- `./laravel/Modules/Lang/app/Datas/LangData.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `afterSave` (6 occorrenze)

**Moduli coinvolti:** Incentivi, Lang, Setting, User, Xot

**File in Lang:**

- `./laravel/Modules/Lang/app/Filament/Resources/TranslationFileResource/Pages/EditTranslationFile.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `mutateFormDataBeforeSave` (5 occorrenze)

**Moduli coinvolti:** Lang, User, Xot

**File in Lang:**

- `./laravel/Modules/Lang/app/Filament/Resources/TranslationFileResource/Pages/EditTranslationFile.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getSlugOptions` (4 occorrenze)

**Moduli coinvolti:** Lang, Notify, Rating, User

**File in Lang:**

- `./laravel/Modules/Lang/app/Models/Post.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getModules` (4 occorrenze)

**Moduli coinvolti:** Lang, User, Xot

**File in Lang:**

- `./laravel/Modules/Lang/app/Actions/SyncTranslationsAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `set` (3 occorrenze)

**Moduli coinvolti:** Lang, Seo, Xot

**File in Lang:**

- `./laravel/Modules/Lang/app/Casts/LangField.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `saveTranslations` (3 occorrenze)

**Moduli coinvolti:** Lang

**File in Lang:**

- `./laravel/Modules/Lang/app/Actions/SyncTranslationsAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `mergeTranslations` (3 occorrenze)

**Moduli coinvolti:** Lang

**File in Lang:**

- `./laravel/Modules/Lang/app/Actions/SyncTranslationsAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `linkable` (3 occorrenze)

**Moduli coinvolti:** Incentivi, Lang, Notify

**File in Lang:**

- `./laravel/Modules/Lang/app/Models/Post.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getTranslatableLocales` (3 occorrenze)

**Moduli coinvolti:** Lang

**File in Lang:**

- `./laravel/Modules/Lang/app/Filament/Resources/LangBaseResource.php`
- `./laravel/Modules/Lang/app/Filament/Resources/TranslationFileResource.php`
- `./laravel/Modules/Lang/app/Filament/Resources/TranslationFileResource/Pages/EditTranslationFile.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getLanguageUrl` (3 occorrenze)

**Moduli coinvolti:** Lang

**File in Lang:**

- `./laravel/Modules/Lang/app/Filament/Widgets/LanguageSwitcherWidget.php`
- `./laravel/Modules/Lang/resources/views/components/language-switcher.blade.php`
- `./laravel/Modules/Lang/resources/views/filament/widgets/language-switcher.blade.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getLanguageFromPath` (3 occorrenze)

**Moduli coinvolti:** Lang

**File in Lang:**

- `./laravel/Modules/Lang/docs/italian-text-audit-script.php`
- `./laravel/Modules/Lang/docs/italian-text-validation-refined.php`
- `./laravel/Modules/Lang/docs/obbligatorio-audit-script.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `changeLanguage` (3 occorrenze)

**Moduli coinvolti:** Lang

**File in Lang:**

- `./laravel/Modules/Lang/app/Filament/Widgets/LanguageSwitcherWidget.php`
- `./laravel/Modules/Lang/resources/views/components/language-switcher.blade.php`
- `./laravel/Modules/Lang/resources/views/filament/widgets/language-switcher.blade.php`

[Riflessione: Duplicato interno al modulo Lang — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `arrayToPhp` (3 occorrenze)

**Moduli coinvolti:** Lang

**File in Lang:**

- `./laravel/Modules/Lang/app/Actions/ReadTranslationFileAction.php`
- `./laravel/Modules/Lang/app/Actions/SyncTranslationsAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `translatableComponents` (2 occorrenze)

**Moduli coinvolti:** Lang, Xot

**File in Lang:**

- `./laravel/Modules/Lang/app/Providers/LangServiceProvider.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `registerTranslator` (2 occorrenze)

**Moduli coinvolti:** Lang

**File in Lang:**

- `./laravel/Modules/Lang/app/Providers/LangServiceProvider.php`
- `./laravel/Modules/Lang/app/Providers/Traits/TranslatorTrait.php`

[Riflessione: Duplicato interno al modulo Lang — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `registerLang` (2 occorrenze)

**Moduli coinvolti:** Lang, Xot

**File in Lang:**

- `./laravel/Modules/Lang/app/Providers/RouteServiceProvider.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `loadTranslations` (2 occorrenze)

**Moduli coinvolti:** Lang

**File in Lang:**

- `./laravel/Modules/Lang/app/Actions/SyncTranslationsAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getTranslation` (2 occorrenze)

**Moduli coinvolti:** Lang

**File in Lang:**

- `./laravel/Modules/Lang/app/Models/Contracts/HasTranslationsContract.php`
- `./laravel/Modules/Lang/app/Models/Traits/HasStrictTranslations.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFilename` (2 occorrenze)

**Moduli coinvolti:** Lang, Xot

**File in Lang:**

- `./laravel/Modules/Lang/app/Datas/TranslationData.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getDefaultTranslatableLocale` (2 occorrenze)

**Moduli coinvolti:** Lang

**File in Lang:**

- `./laravel/Modules/Lang/app/Filament/Resources/LangBaseResource.php`
- `./laravel/Modules/Lang/app/Filament/Resources/TranslationFileResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getDefaultChildComponents` (2 occorrenze)

**Moduli coinvolti:** Lang, UI

**File in Lang:**

- `./laravel/Modules/Lang/app/Filament/Forms/Components/TranslationEditor.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `generateReport` (2 occorrenze)

**Moduli coinvolti:** Lang

**File in Lang:**

- `./laravel/Modules/Lang/docs/helper-text-audit-script.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Riflessioni per Lang

- **Totale metodi duplicati che coinvolgono Lang:** 29
- **Di cui cross-modulo:** 17
- **Di cui interni al modulo:** 12

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 22 metodi
- **altro:** 7 metodi

### Moduli con maggiori duplicazioni incrociate

- **Xot:** 27 metodi in comune
- **User:** 11 metodi in comune
- **Tenant:** 6 metodi in comune
- **UI:** 5 metodi in comune
- **Media:** 4 metodi in comune
- **Seo:** 4 metodi in comune
- **Gdpr:** 3 metodi in comune
- **Setting:** 3 metodi in comune
- **Notify:** 3 metodi in comune
- **Incentivi:** 3 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
