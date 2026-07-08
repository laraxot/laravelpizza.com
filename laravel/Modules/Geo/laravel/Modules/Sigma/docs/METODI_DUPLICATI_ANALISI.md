---
module: Sigma
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi Sigma

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Sigma**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `getFormActions` (14 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Media, Pdnd, Ptv, Sigma, User, Xot

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Filament/Pages/SqlUpload.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `before` (14 occorrenze)

**Moduli coinvolti:** Activity, Gdpr, Job, Lang, Media, Performance, Progressioni, Setting, Sigma, Tenant, UI, User, Xot

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Policies/RepartPolicy.php`

[Riflessione: Presente in 13 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getWidgets` (13 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Job, Ptv, Sigma, User, Xot

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Filament/Pages/Dashboard.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `form` (13 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Ptv, Sigma, User, Xot

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Filament/Pages/SqlUpload.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getRows` (11 occorrenze)

**Moduli coinvolti:** Lang, Setting, Sigma, Tenant, User, Xot

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/WebService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `authenticate` (8 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma, User

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Presente in 7 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `stabiDirigente` (7 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Relationships/SchedaRelationship.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `index` (7 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Policies/RepartPolicy.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getCognomeAttribute` (7 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Ana10f.php`
- `./laravel/Modules/Sigma/app/Models/Dipt00f.php`
- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/EnteMatrMutator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `edit` (7 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Policies/RepartPolicy.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `anag` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni, Ptv, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteMatrRelationship.php`
- `./laravel/Modules/Sigma/app/Models/Wstr01lx.php`
- `./laravel/Modules/Sigma/app/Models/Wstr02f.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `rules` (6 occorrenze)

**Moduli coinvolti:** Job, Media, Performance, Progressioni, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/WebService.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `redirectTo` (6 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `matrField` (6 occorrenze)

**Moduli coinvolti:** Ptv, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/BaseModel.php`
- `./laravel/Modules/Sigma/app/Models/Contracts/EnteMatrFieldsContract.php`
- `./laravel/Modules/Sigma/app/Models/Dipt00f.php`
- `./laravel/Modules/Sigma/app/Models/Wstr01lx.php`
- `./laravel/Modules/Sigma/app/Models/Wstr02f.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getNomeAttribute` (6 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Ana10f.php`
- `./laravel/Modules/Sigma/app/Models/Dipt00f.php`
- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/EnteMatrMutator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `destroy` (6 occorrenze)

**Moduli coinvolti:** Job, Performance, Progressioni, Sigma, User

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Policies/RepartPolicy.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `booted` (6 occorrenze)

**Moduli coinvolti:** Gdpr, Incentivi, Sigma, User

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Asz00f.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `valutatore` (5 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Relationships/SchedaRelationship.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `scopeWithDays` (5 occorrenze)

**Moduli coinvolti:** Ptv, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Asz00f.php`
- `./laravel/Modules/Sigma/app/Models/Asz00k1.php`
- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Rep00f.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `isActive` (5 occorrenze)

**Moduli coinvolti:** Sigma, Tenant, Xot

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Integparam.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getModule` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAssenzaAnnoAttribute` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Performance, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getContextName` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `enteField` (5 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/BaseModel.php`
- `./laravel/Modules/Sigma/app/Models/Contracts/EnteMatrFieldsContract.php`
- `./laravel/Modules/Sigma/app/Models/Dipt00f.php`
- `./laravel/Modules/Sigma/app/Models/Wstr01lx.php`
- `./laravel/Modules/Sigma/app/Models/Wstr02f.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getNomeDiriAttribute` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Ptv, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Rep00f.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `scopeActive` (4 occorrenze)

**Moduli coinvolti:** Job, Notify, Sigma, Xot

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/WebService.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `repart` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Ptv, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Rep00f.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `reparts` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Rep00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteStabiRelationship.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `qua00f` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Asz00k1.php`
- `./laravel/Modules/Sigma/app/Models/Rep00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteMatrRelationship.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `giorni` (4 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Qua00k1.php`
- `./laravel/Modules/Sigma/app/Models/Qua03f.php`
- `./laravel/Modules/Sigma/app/Models/Sto00f.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `gg` (4 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Asz00k1.php`
- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Qua03f.php`
- `./laravel/Modules/Sigma/app/Models/Sto00f.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `ggInSedeTot` (4 occorrenze)

**Moduli coinvolti:** Progressioni, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getToFieldAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Asz00k1.php`
- `./laravel/Modules/Sigma/app/Models/Qua00f.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getSubheading` (4 occorrenze)

**Moduli coinvolti:** Notify, Ptv, Sigma, User

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Filament/Pages/Dashboard.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getReparTxtAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Rep00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/EnteStabiMutator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgPresenzaAnnoAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Performance, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFullNameAttribute` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Sigma, User

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Integparam.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFromFieldAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Asz00k1.php`
- `./laravel/Modules/Sigma/app/Models/Qua00f.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getEnteAttribute` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Ptv, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Dipt00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/EnteMatrMutator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getEmailAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/EnteMatrMutator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getCategoriaEcoAttribute` (4 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Qua03f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/EnteMatrDateRangeMutator.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/EnteMatrProproPosfunMutator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `criteriOptionsArr` (4 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `codici` (4 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Asz00f.php`
- `./laravel/Modules/Sigma/app/Models/Asz00k1.php`
- `./laravel/Modules/Sigma/app/Models/Mov01k2.php`
- `./laravel/Modules/Sigma/app/Models/Wgiu03f.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `wstr01lx` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteMatrRelationship.php`
- `./laravel/Modules/Sigma/app/Models/Wmen00f.php`
- `./laravel/Modules/Sigma/app/Models/Wstr02f.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `scopeOfYear` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Rep00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Scopes/CommonScope.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `scopeOfEnteYear` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Rep00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Scopes/CommonScope.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `rangeIntersect` (3 occorrenze)

**Moduli coinvolti:** Sigma, Xot

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `hhAssenzaInSedeTot` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `hhAssenzaFuoriSedeTot` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `ggFuoriSedeTot` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `ggAssenzaInSedeTot` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `ggAssenzaFuoriSedeTot` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getValutatoreId` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getValutatoreIdAttribute` (3 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTypeAttribute` (3 occorrenze)

**Moduli coinvolti:** Performance, Ptv, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/SchedaMutator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTotalePondAttribute` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Accessors/PerfAccessor.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getStabiAttribute` (3 occorrenze)

**Moduli coinvolti:** Incentivi, Ptv, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/EnteStabiMutator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getReparAttribute` (3 occorrenze)

**Moduli coinvolti:** Incentivi, Ptv, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/EnteStabiMutator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPuntProgressioneFinaleAttribute` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Accessors/PerfAccessor.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPropro` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getProproAttribute` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Asz00k1.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPosizioneEcoAttribute` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Asz00k1.php`
- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/SchedaMutator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPosfunval` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPesoEsperienzaAcquisitaAttribute` (3 occorrenze)

**Moduli coinvolti:** Performance, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfIndMedia` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGg` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgIntegParams` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCateco` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoPosfun` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoPosfunInSede` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoPosfunFuoriSede` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoInSede` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoFuoriSede` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAttribute` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Accessors/GgAccessor.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszInSede` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszFuoriSede` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszCateco` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszCatecoPosfunInSede` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszCatecoPosfunFuoriSede` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszCatecoInSede` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getExcellencesCountLast3yearsAttribute` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Accessors/PerfAccessor.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getDisci1Attribute` (3 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/SchedaMutator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getCriteriOptions` (3 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Helpers/SchedaHelper.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getCodquaAttribute` (3 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/SchedaMutator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getAventiDirittoEffAttribute` (3 occorrenze)

**Moduli coinvolti:** Progressioni, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getAventiDirittoAttribute` (3 occorrenze)

**Moduli coinvolti:** Progressioni, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `categoriaPropro` (3 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Relationships/SchedaRelationship.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `tqu00f` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Relationships/TquRelationship.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `setPuntProgressioneFinaleAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `scopeOfQuarter` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Scopes/CommonScope.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `scopeOfDate` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Rep00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Scopes/CommonScope.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `scopeOfCodici` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Asz00f.php`
- `./laravel/Modules/Sigma/app/Models/Asz00k1.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `rep00f` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteMatrRelationship.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `qua00fYear` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteMatrAnnoRelationship.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteMatrYearRelationship.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `puntProgressioneFinale` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `perfIndMedia` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `last_qua00f` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Qua00k1.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `giorni_propro` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Qua00k1.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `giorni_propro_posfun` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Qua00k1.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `ggInSedeTotByArray` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Extras/FunctionExtra.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getValutatoreTxtAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getValoreDifferenzialeRapportatoPtAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getStdataAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Wgiu03f.php`
- `./laravel/Modules/Sigma/app/Models/Wstr02f.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getStabi` (2 occorrenze)

**Moduli coinvolti:** Incentivi, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/EnteStabiMutator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getStabiTxtAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Rep00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/EnteStabiMutator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPtimeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPostTypeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPosizioneAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPosizTxtAttribute` (2 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Mutators/SchedaMutator.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPosfunvalAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfIndMediaAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfIndCountLast3YearsAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2030Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2029Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2028Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2027Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2026Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2025Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2024Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2023Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2022Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2021Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2020Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2019Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2018Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2017Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2016Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2015Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPerfInd2014Attribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPauseAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Wmen00f.php`
- `./laravel/Modules/Sigma/app/Models/Wstr02f.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getListaProproSupAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getListaProproAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getImportoStipendioAnnuoAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getHhAszInSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getHhAszFuoriSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getHhAszAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgPosiz1InSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgNoAszAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgIntegParamsAszAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgInSedeNoAszAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgInSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgFuoriSedeNoAszAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgFuoriSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgEsperienzaNoAszAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoSupInSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoSupFuoriSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoSupAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoPosfunNoAszAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoPosfunInSedeNoAszAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoPosfunInSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoPosfunFuoriSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoPosfunAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoNoPosfunNoAszAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoNoAszAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoInSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoFuoriSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgCatecoAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszTipCodEsclusoSubito` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszTipCodEsclusoSubitoAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszInSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszFuoriSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszCatecoPosfunInSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszCatecoPosfunFuoriSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszCatecoPosfunAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszCatecoInSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszCatecoFuoriSedeAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszCatecoAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAszAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAnnoAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getDurataPomeriggioAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Wmen00f.php`
- `./laravel/Modules/Sigma/app/Models/Wstr02f.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getDurataAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Wmen00f.php`
- `./laravel/Modules/Sigma/app/Models/Wstr02f.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getAszdescrAttribute` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Asz00f.php`
- `./laravel/Modules/Sigma/app/Models/Asz00k1.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `funcYear` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `excellencesCountLast3years` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/SchedaExtraFieldTrait.php`
- `./laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `createTable` (2 occorrenze)

**Moduli coinvolti:** DbForge, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Services/TxtdService.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `asz00k1` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteMatrRelationship.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `ana10f` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteMatrRelationship.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `ana02f` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Qua00f.php`
- `./laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteMatrRelationship.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `Tqu00f` (2 occorrenze)

**Moduli coinvolti:** Sigma

**File in Sigma:**

- `./laravel/Modules/Sigma/app/Models/Qua00k1.php`
- `./laravel/Modules/Sigma/app/Models/Qua03f.php`

[Riflessione: Duplicato interno al modulo Sigma — valutare estrazione in trait di modulo o classe base]

---

## Riflessioni per Sigma

- **Totale metodi duplicati che coinvolgono Sigma:** 179
- **Di cui cross-modulo:** 55
- **Di cui interni al modulo:** 124

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 169 metodi
- **altro:** 10 metodi

### Moduli con maggiori duplicazioni incrociate

- **Performance:** 27 metodi in comune
- **IndennitaCondizioniLavoro:** 27 metodi in comune
- **Xot:** 22 metodi in comune
- **User:** 20 metodi in comune
- **Ptv:** 19 metodi in comune
- **Progressioni:** 19 metodi in comune
- **IndennitaResponsabilita:** 16 metodi in comune
- **Incentivi:** 9 metodi in comune
- **Job:** 7 metodi in comune
- **Tenant:** 6 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
