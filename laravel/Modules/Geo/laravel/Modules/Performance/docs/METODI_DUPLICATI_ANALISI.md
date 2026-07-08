---
module: Performance
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi Performance

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Performance**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `before` (14 occorrenze)

**Moduli coinvolti:** Activity, Gdpr, Job, Lang, Media, Performance, Progressioni, Setting, Sigma, Tenant, UI, User, Xot

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Policies/IndividualeDipPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/StabiDirigentePolicy.php`

[Riflessione: Presente in 13 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getType` (10 occorrenze)

**Moduli coinvolti:** Performance, Seo, UI, User, Xot

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Traits/FunctionTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `envelope` (8 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Notify, Performance, Progressioni, Ptv

**File in Performance:**

- `./laravel/Modules/Performance/app/Mail/SchedaMail.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `authenticate` (8 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma, User

**File in Performance:**

- `./laravel/Modules/Performance/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Presente in 7 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `attachments` (8 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Notify, Performance, Progressioni, Ptv

**File in Performance:**

- `./laravel/Modules/Performance/app/Mail/SchedaMail.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `stabiDirigente` (7 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv, Sigma

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `options` (7 occorrenze)

**Moduli coinvolti:** Notify, Performance, UI, Xot

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Organizzativa.php`
- `./laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `mailInviate` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`
- `./laravel/Modules/Performance/app/Models/Organizzativa.php`
- `./laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `index` (7 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Sigma

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Policies/BaseIndividualePolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeDipPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualePoPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/StabiDirigentePolicy.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getXlsFields` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Filament/Resources/IndividualeAdmResource.php`
- `./laravel/Modules/Performance/app/Filament/Resources/IndividualeDipResource.php`
- `./laravel/Modules/Performance/app/Filament/Resources/IndividualePoResource.php`
- `./laravel/Modules/Performance/app/Filament/Resources/IndividualeResource.php`
- `./laravel/Modules/Performance/app/Filament/Resources/OrganizzativaResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `edit` (7 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Sigma

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Policies/BaseIndividualePolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeDipPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualePoPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeRegionalePolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/StabiDirigentePolicy.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `criteriOptions` (7 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`
- `./laravel/Modules/Performance/app/Models/Organizzativa.php`
- `./laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `content` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Notify, Performance, Progressioni, Ptv

**File in Performance:**

- `./laravel/Modules/Performance/app/Mail/SchedaMail.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `authorizeAccess` (7 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv, Xot

**File in Performance:**

- `./laravel/Modules/Performance/app/Filament/Resources/IndividualeResource/Pages/FillOutTheForm.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `xlsIndividualeStabiRepar` (6 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Policies/BaseIndividualePolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeAdmPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeDipPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualePoPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeRegionalePolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/StabiDirigentePolicy.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `rules` (6 occorrenze)

**Moduli coinvolti:** Job, Media, Performance, Progressioni, Sigma

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/IndividualePoPesi.php`
- `./laravel/Modules/Performance/app/Models/IndividualeTotStabi.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `redirectTo` (6 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma

**File in Performance:**

- `./laravel/Modules/Performance/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `pdfIndividualeStabiRepar` (6 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Policies/BaseIndividualePolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeAdmPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeDipPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualePoPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeRegionalePolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/StabiDirigentePolicy.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `massMail` (6 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Policies/BaseIndividualePolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeAdmPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeDipPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualePoPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeRegionalePolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/StabiDirigentePolicy.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `mails` (6 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/IndividualeDip.php`
- `./laravel/Modules/Performance/app/Models/IndividualeDirigente.php`
- `./laravel/Modules/Performance/app/Models/IndividualePo.php`
- `./laravel/Modules/Performance/app/Models/IndividualeRegionale.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getResource` (6 occorrenze)

**Moduli coinvolti:** Performance, Ptv, Xot

**File in Performance:**

- `./laravel/Modules/Performance/app/Filament/Resources/IndividualeResource/Pages/FillOutTheForm.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `destroy` (6 occorrenze)

**Moduli coinvolti:** Job, Performance, Progressioni, Sigma, User

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Policies/BaseIndividualePolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualePoPolicy.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `back` (6 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv

**File in Performance:**

- `./laravel/Modules/Performance/app/Filament/Resources/IndividualeResource/Pages/FillOutTheForm.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `valutatore` (5 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv, Sigma

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`
- `./laravel/Modules/Performance/app/Models/IndividualeTotValutatoreId.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `show` (5 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Policies/BaseIndividualePolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeDipPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualePoPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeRegionalePolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/StabiDirigentePolicy.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `populate` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/IndividualeAssenze.php`
- `./laravel/Modules/Performance/app/Models/IndividualeDecurtazioneAssenze.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `individualePdf` (5 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Policies/BaseIndividualePolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeDipPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualePoPolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/IndividualeRegionalePolicy.php`
- `./laravel/Modules/Performance/app/Models/Policies/StabiDirigentePolicy.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getNavigationBadge` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Performance, Xot

**File in Performance:**

- `./laravel/Modules/Performance/app/Filament/Resources/IndividualeResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getModule` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma

**File in Performance:**

- `./laravel/Modules/Performance/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgAssenzaAnnoAttribute` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Performance, Sigma

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Traits/MutatorTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getContextName` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma

**File in Performance:**

- `./laravel/Modules/Performance/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `filter` (5 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`
- `./laravel/Modules/Performance/app/Models/IndividualeAssenze.php`
- `./laravel/Modules/Performance/app/Models/IndividualeDecurtazioneAssenze.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `build` (5 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni, Xot

**File in Performance:**

- `./laravel/Modules/Performance/app/Mail/PerformanceMail.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `updated` (4 occorrenze)

**Moduli coinvolti:** Activity, Job, Performance, Ptv

**File in Performance:**

- `./laravel/Modules/Performance/app/Filament/Resources/IndividualeResource/Pages/FillOutTheForm.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `setMotivoAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `setHaDirittoAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `message` (4 occorrenze)

**Moduli coinvolti:** Media, Performance, User, Xot

**File in Performance:**

- `./laravel/Modules/Performance/app/Rules/ExcellenceRule.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getGgPresenzaAnnoAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Performance, Sigma

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Traits/MutatorTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFieldsYear` (4 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv

**File in Performance:**

- `./laravel/Modules/Performance/app/Services/CriteriValutazioneService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `criteriOptionsArr` (4 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Sigma

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Traits/FunctionTrait.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `criteriEsclusione` (4 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`
- `./laravel/Modules/Performance/app/Models/Organizzativa.php`
- `./laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `check` (4 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, User

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/TrovaEsclusiAction.php`
- `./laravel/Modules/Performance/app/Models/Traits/FunctionTrait.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `cards` (4 occorrenze)

**Moduli coinvolti:** Performance, UI

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`
- `./laravel/Modules/Performance/app/Models/Organizzativa.php`
- `./laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `updatedData` (3 occorrenze)

**Moduli coinvolti:** Performance, Ptv

**File in Performance:**

- `./laravel/Modules/Performance/app/Filament/Resources/IndividualeResource/Pages/FillOutTheForm.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `stampaRiepilogoDiagnostico` (3 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/Individuale/UpdateBudgetAssegnatoAction.php`
- `./laravel/Modules/Performance/app/Actions/Individuale/UpdateQuotaEffettivaAction.php`
- `./laravel/Modules/Performance/app/Actions/Individuale/UpdateRestiAction.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `recalculate` (3 occorrenze)

**Moduli coinvolti:** Performance, Ptv

**File in Performance:**

- `./laravel/Modules/Performance/app/Filament/Resources/IndividualeResource/Pages/FillOutTheForm.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `passes` (3 occorrenze)

**Moduli coinvolti:** Media, Performance, Xot

**File in Performance:**

- `./laravel/Modules/Performance/app/Rules/ExcellenceRule.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `isRegionale` (3 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Traits/FunctionTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `isPo` (3 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Traits/FunctionTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTypeAttribute` (3 occorrenze)

**Moduli coinvolti:** Performance, Ptv, Sigma

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Individuale.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPesoEsperienzaAcquisitaAttribute` (3 occorrenze)

**Moduli coinvolti:** Performance, Sigma

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/IndividualePesi.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getListaTipoCodiceAspettative` (3 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Traits/FunctionTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `criteriMaggiorazione` (3 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`
- `./laravel/Modules/Performance/app/Models/Organizzativa.php`
- `./laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `checkMinGgAnno` (3 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/GetHaDirittoMotivoAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `verifyTotalResti` (2 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/Individuale/UpdateRestiPondByValutatoreIdAction.php`
- `./laravel/Modules/Performance/app/Actions/Organizzativa/UpdateRestiPondByValutatoreIdAction.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `updating` (2 occorrenze)

**Moduli coinvolti:** Performance, Ptv

**File in Performance:**

- `./laravel/Modules/Performance/app/Filament/Resources/IndividualeResource/Pages/FillOutTheForm.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `updateTotals` (2 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/Individuale/UpdateTotValutatoreIdAction.php`
- `./laravel/Modules/Performance/app/Actions/Organizzativa/UpdateTotValutatoreIdAction.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `updateRestiPond` (2 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/Individuale/UpdateRestiPondByValutatoreIdAction.php`
- `./laravel/Modules/Performance/app/Actions/Organizzativa/UpdateRestiPondByValutatoreIdAction.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `totStabi` (2 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`
- `./laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `setTypeAttribute` (2 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/IndividualePesi.php`
- `./laravel/Modules/Performance/app/Models/Traits/MutatorTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `resetRestiPond` (2 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/Individuale/UpdateRestiPondByValutatoreIdAction.php`
- `./laravel/Modules/Performance/app/Actions/Organizzativa/UpdateRestiPondByValutatoreIdAction.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `peso` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `listaCodiciAspettative` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Organizzativa.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `isVisible` (2 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Filament/Actions/Header/CopyFromIndividualeAction.php`
- `./laravel/Modules/Performance/app/Filament/Actions/Header/CopyFromOrganizzativaAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `individuale` (2 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/IndividualePesi.php`
- `./laravel/Modules/Performance/app/Models/IndividualePoPesi.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `individualeRegionale` (2 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/IndividualePesi.php`
- `./laravel/Modules/Performance/app/Models/IndividualePoPesi.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `individualePo` (2 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/IndividualePesi.php`
- `./laravel/Modules/Performance/app/Models/IndividualePoPesi.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `individualeAdm` (2 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/IndividualePesi.php`
- `./laravel/Modules/Performance/app/Models/IndividualePoPesi.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getDateMax` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Organizzativa.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `createRecordsForValutatori` (2 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/Individuale/UpdateTotValutatoreIdAction.php`
- `./laravel/Modules/Performance/app/Actions/Organizzativa/UpdateTotValutatoreIdAction.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `clearExistingRecords` (2 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/Individuale/UpdateTotValutatoreIdAction.php`
- `./laravel/Modules/Performance/app/Actions/Organizzativa/UpdateTotValutatoreIdAction.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `checkNoproproList` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/GetHaDirittoMotivoAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `checkNoposizList` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/GetHaDirittoMotivoAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `checkNoposfunList` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/GetHaDirittoMotivoAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `checkNodisci1List` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/GetHaDirittoMotivoAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `checkMinGgRuolo` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/GetHaDirittoMotivoAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `checkMaxGgAssenzeAnno` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/GetHaDirittoMotivoAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `checkDateMinAssunz` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/GetHaDirittoMotivoAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `canSendEmail` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Traits/FunctionTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `calculateDeltas` (2 occorrenze)

**Moduli coinvolti:** Performance

**File in Performance:**

- `./laravel/Modules/Performance/app/Actions/Individuale/UpdateTotValutatoreIdAction.php`
- `./laravel/Modules/Performance/app/Actions/Organizzativa/UpdateTotValutatoreIdAction.php`

[Riflessione: Duplicato interno al modulo Performance — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `asz` (2 occorrenze)

**Moduli coinvolti:** Performance, Ptv

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Organizzativa.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `aszEff` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Organizzativa.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `assenze` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/Organizzativa.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `_data` (2 occorrenze)

**Moduli coinvolti:** Performance, Ptv

**File in Performance:**

- `./laravel/Modules/Performance/app/Models/MyLog.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Riflessioni per Performance

- **Totale metodi duplicati che coinvolgono Performance:** 84
- **Di cui cross-modulo:** 63
- **Di cui interni al modulo:** 21

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 63 metodi
- **altro:** 21 metodi

### Moduli con maggiori duplicazioni incrociate

- **Progressioni:** 52 metodi in comune
- **Ptv:** 25 metodi in comune
- **Sigma:** 20 metodi in comune
- **IndennitaResponsabilita:** 20 metodi in comune
- **Xot:** 15 metodi in comune
- **IndennitaCondizioniLavoro:** 15 metodi in comune
- **Notify:** 14 metodi in comune
- **User:** 8 metodi in comune
- **Job:** 4 metodi in comune
- **Media:** 4 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
