---
module: IndennitaCondizioniLavoro
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi IndennitaCondizioniLavoro

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **IndennitaCondizioniLavoro**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `getWidgets` (13 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Job, Ptv, Sigma, User, Xot

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Filament/Resources/CondizioniLavoroAdmResource.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Filament/Resources/CondizioniLavoroResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `authenticate` (8 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma, User

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Presente in 7 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `stabiDirigente` (7 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getCognomeAttribute` (7 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroRep.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `authorizeAccess` (7 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv, Xot

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Filament/Resources/CondizioniLavoroResource/Pages/CompilaCondizioniLavoro.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `redirectTo` (6 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `indennitaTipoDettaglio` (6 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroAdm.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroIndennitaTipoDettaglioPivot.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CrossCondizioniLavoroIndennitaTipoDettaglio.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsternoIndennitaTipoDettaglioPivot.php`

[Riflessione: Duplicato interno al modulo IndennitaCondizioniLavoro — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getTotAttribute` (6 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroIndennitaTipoDettaglioPivot.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CrossCondizioniLavoroIndennitaTipoDettaglio.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsternoIndennitaTipoDettaglioPivot.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getNomeAttribute` (6 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `back` (6 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Filament/Resources/CondizioniLavoroResource/Pages/CompilaCondizioniLavoro.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `populate` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Performance, Progressioni

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getNavigationBadge` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Performance, Xot

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Filament/Resources/CondizioniLavoroAdmResource.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Filament/Resources/CondizioniLavoroResource.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Filament/Resources/UploadResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getModule` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAssenzaAnnoAttribute` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Performance, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getContextName` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `reparts` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `mutateFormDataBeforeCreate` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, User

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Filament/Resources/UploadResource/Pages/CreateUpload.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getTotXPtimeAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroIndennitaTipoDettaglioPivot.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsternoIndennitaTipoDettaglioPivot.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getToFieldAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/Traits/MutatorTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getReparTxtAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgPresenzaAnnoAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Performance, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFromFieldAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/Traits/MutatorTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `indennitaTipo` (3 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/IndennitaTipoDettaglio.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/IndennitaTipoDettaglioAnno.php`

[Riflessione: Duplicato interno al modulo IndennitaCondizioniLavoro — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getValutatoreIdAttribute` (3 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTableFiltersLayout` (3 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Ptv

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Filament/Resources/CondizioniLavoroResource/Pages/ListCondizioniLavoros.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getDisci1Attribute` (3 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getCodquaAttribute` (3 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `condizioniLavoro` (3 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroIndennitaTipoDettaglioPivot.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CrossCondizioniLavoroIndennitaTipoDettaglio.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsternoIndennitaTipoDettaglioPivot.php`

[Riflessione: Duplicato interno al modulo IndennitaCondizioniLavoro — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `tipoDettaglio` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`

[Riflessione: Duplicato interno al modulo IndennitaCondizioniLavoro — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `shouldPersistTableFiltersInSession` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Filament/Resources/CondizioniLavoroResource/Pages/ListCondizioniLavoros.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `scopeOfQuarter` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroAdm.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `mutateFormDataBeforeFill` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Progressioni

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Filament/Resources/CondizioniLavoroResource/Pages/CompilaCondizioniLavoro.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `images` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/BaseModel.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getTotPresenzaPeriodoPlusNoTimbrAttribute` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTableActionsPosition` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Ptv

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Filament/Resources/CondizioniLavoroResource/Pages/ListCondizioniLavoros.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getHhAssenzaAnnoAttribute` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgPresenzaPeriodoAttribute` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/Traits/MutatorTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getDalAttribute` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/Traits/MutatorTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getAllIndennitaTipoAttribute` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getAlAttribute` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/Traits/MutatorTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `fillForm` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Progressioni

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Filament/Resources/CondizioniLavoroResource/Pages/CompilaCondizioniLavoro.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `calculateTot` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita

**File in IndennitaCondizioniLavoro:**

- `./laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroIndennitaTipoDettaglioPivot.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Riflessioni per IndennitaCondizioniLavoro

- **Totale metodi duplicati che coinvolgono IndennitaCondizioniLavoro:** 42
- **Di cui cross-modulo:** 34
- **Di cui interni al modulo:** 8

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 34 metodi
- **altro:** 8 metodi

### Moduli con maggiori duplicazioni incrociate

- **Sigma:** 31 metodi in comune
- **IndennitaResponsabilita:** 18 metodi in comune
- **Performance:** 12 metodi in comune
- **Progressioni:** 10 metodi in comune
- **Ptv:** 8 metodi in comune
- **User:** 8 metodi in comune
- **Xot:** 5 metodi in comune
- **Job:** 3 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
