---
module: Ptv
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi Ptv

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Ptv**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `via` (14 occorrenze)

**Moduli coinvolti:** Job, Notify, Progressioni, Ptv, User

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Notifications/SendSchedaNotification.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getFormActions` (14 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Media, Pdnd, Ptv, Sigma, User, Xot

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaStabiReparWidget.php`
- `./laravel/Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaValutatoreWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getWidgets` (13 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Job, Ptv, Sigma, User, Xot

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Pages/Dashboard.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getModel` (13 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Media, Notify, Ptv, User, Xot

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/BaseSchedaResource.php`
- `./laravel/Modules/Ptv/app/Filament/Resources/UserResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getHeaderWidgets` (13 occorrenze)

**Moduli coinvolti:** Job, Media, Notify, Ptv, UI, User, Xot

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/ListScheda.php`
- `./laravel/Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/ListSchedas.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `form` (13 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Ptv, Sigma, User, Xot

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/AnagResource/RelationManagers/AszEffRelationManager.php`
- `./laravel/Modules/Ptv/app/Filament/Resources/ReportResource/Pages/CreateStabiDirigente.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `toMail` (10 occorrenze)

**Moduli coinvolti:** Job, Notify, Progressioni, Ptv, User

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Notifications/SendSchedaNotification.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `schede` (9 occorrenze)

**Moduli coinvolti:** Incentivi, Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/Contracts/CriteriEsclusioneContract.php`
- `./laravel/Modules/Ptv/app/Models/Contracts/StabiDirigenteContract.php`
- `./laravel/Modules/Ptv/app/Models/CriteriEsclusione.php`
- `./laravel/Modules/Ptv/app/Models/Valutatore.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getSchema` (9 occorrenze)

**Moduli coinvolti:** Ptv, Xot

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Columns/LavoratoreColumn.php`
- `./laravel/Modules/Ptv/app/Filament/Columns/PeriodoColumn.php`
- `./laravel/Modules/Ptv/app/Filament/Columns/QuaColumn.php`
- `./laravel/Modules/Ptv/app/Filament/Columns/QualificaColumn.php`
- `./laravel/Modules/Ptv/app/Filament/Columns/RepColumn.php`
- `./laravel/Modules/Ptv/app/Filament/Columns/RepartoColumn.php`
- `./laravel/Modules/Ptv/app/Filament/Columns/WorkerColumn.php`
- `./laravel/Modules/Ptv/app/Filament/Forms/Components/PeriodoSection.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `envelope` (8 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Notify, Performance, Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Mail/SchedaMail.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `attachments` (8 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Notify, Performance, Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Mail/SchedaMail.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `stabiDirigente` (7 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv, Sigma

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/Traits/HasStabiDirigente.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `criteriOptions` (7 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseScheda.php`
- `./laravel/Modules/Ptv/app/Models/CriteriEsclusione.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `content` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Notify, Performance, Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Mail/SchedaMail.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `cast` (7 occorrenze)

**Moduli coinvolti:** Ptv, Xot

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Casts/DateStringToIntCast.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `authorizeAccess` (7 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv, Xot

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseCompilaScheda.php`
- `./laravel/Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseFillOutTheForm.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `appendColumns` (7 occorrenze)

**Moduli coinvolti:** Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Columns/LavoratoreColumn.php`
- `./laravel/Modules/Ptv/app/Filament/Columns/PeriodoColumn.php`
- `./laravel/Modules/Ptv/app/Filament/Columns/QuaColumn.php`
- `./laravel/Modules/Ptv/app/Filament/Columns/QualificaColumn.php`
- `./laravel/Modules/Ptv/app/Filament/Columns/RepColumn.php`
- `./laravel/Modules/Ptv/app/Filament/Columns/RepartoColumn.php`
- `./laravel/Modules/Ptv/app/Filament/Columns/WorkerColumn.php`

[Riflessione: Duplicato interno al modulo Ptv — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `anag` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni, Ptv, Sigma

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseScheda.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `matrField` (6 occorrenze)

**Moduli coinvolti:** Ptv, Sigma

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Forms/Components/WorkerFields.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getResource` (6 occorrenze)

**Moduli coinvolti:** Performance, Ptv, Xot

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/ReportResource/Pages/FillOutTheForm.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `collection` (6 occorrenze)

**Moduli coinvolti:** Lang, Progressioni, Ptv, Xot

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Datas/RepQuaYearData.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `back` (6 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseCompilaScheda.php`
- `./laravel/Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseFillOutTheForm.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `valutatore` (5 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv, Sigma

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/Traits/HasValutatore.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `scopeWithDays` (5 occorrenze)

**Moduli coinvolti:** Ptv, Sigma

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseScheda.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getCards` (5 occorrenze)

**Moduli coinvolti:** Job, Ptv, UI

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Widgets/AdminWidgets.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `benificiariProgressione` (5 occorrenze)

**Moduli coinvolti:** Incentivi, Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseStabiDirigente.php`
- `./laravel/Modules/Ptv/app/Models/Valutatore.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getNomeStabiAttribute` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseStabiDirigente.php`
- `./laravel/Modules/Ptv/app/Models/Valutatore.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getNomeDiriAttribute` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Ptv, Sigma

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseStabiDirigente.php`
- `./laravel/Modules/Ptv/app/Models/Valutatore.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `updated` (4 occorrenze)

**Moduli coinvolti:** Activity, Job, Performance, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseFillOutTheForm.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `repart` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Ptv, Sigma

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseStabiDirigente.php`
- `./laravel/Modules/Ptv/app/Models/Valutatore.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getSubheading` (4 occorrenze)

**Moduli coinvolti:** Notify, Ptv, Sigma, User

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Pages/Dashboard.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFieldsYear` (4 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Services/CriteriPrecedenzaService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getEnteAttribute` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Ptv, Sigma

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseStabiDirigente.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `updatedData` (3 occorrenze)

**Moduli coinvolti:** Performance, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseCompilaScheda.php`
- `./laravel/Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseFillOutTheForm.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `updateFilters` (3 occorrenze)

**Moduli coinvolti:** Ptv, UI, Xot

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaValutatoreWidget.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `recalculate` (3 occorrenze)

**Moduli coinvolti:** Performance, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseCompilaScheda.php`
- `./laravel/Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseFillOutTheForm.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `isRegionale` (3 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseScheda.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `isPo` (3 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseScheda.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTypeAttribute` (3 occorrenze)

**Moduli coinvolti:** Performance, Ptv, Sigma

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/Message.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTableFiltersLayout` (3 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/ReportResource/Pages/ListStabiDirigentes.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getStabiAttribute` (3 occorrenze)

**Moduli coinvolti:** Incentivi, Ptv, Sigma

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseStabiDirigente.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getSchedaCollection` (3 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/Contracts/CriteriEsclusioneContract.php`
- `./laravel/Modules/Ptv/app/Models/CriteriEsclusione.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getReparAttribute` (3 occorrenze)

**Moduli coinvolti:** Incentivi, Ptv, Sigma

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseStabiDirigente.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getListaTipoCodiceAspettative` (3 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseScheda.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `criteriOptionsCollection` (3 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/Contracts/CriteriEsclusioneContract.php`
- `./laravel/Modules/Ptv/app/Models/CriteriEsclusione.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `myLogs` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/Traits/HasMyLogs.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `where` (2 occorrenze)

**Moduli coinvolti:** Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Contracts/StabiDirigenteContract.php`
- `./laravel/Modules/Ptv/app/Filament/Forms/Components/SelectValutatore.php`

[Riflessione: Duplicato interno al modulo Ptv — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `updating` (2 occorrenze)

**Moduli coinvolti:** Performance, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseFillOutTheForm.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `stipendioTabellare` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseScheda.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `schedas` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseStabiDirigente.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `performanceIndividuale` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseScheda.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `perfInd` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseScheda.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getTableActionsPosition` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/ReportResource/Pages/ListStabiDirigentes.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFormActionsAlignment` (2 occorrenze)

**Moduli coinvolti:** Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaStabiReparWidget.php`
- `./laravel/Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaValutatoreWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFieldsNamesYear` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Services/CriteriPrecedenzaService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `filtersUpdated` (2 occorrenze)

**Moduli coinvolti:** Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaStabiReparWidget.php`
- `./laravel/Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaValutatoreWidget.php`

[Riflessione: Duplicato interno al modulo Ptv — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `disabled` (2 occorrenze)

**Moduli coinvolti:** Notify, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Forms/Components/WorkerFields.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `criteriValutazione` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/Traits/HasCriteriValutazione.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `avversariCategoriaEco` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseScheda.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `asz` (2 occorrenze)

**Moduli coinvolti:** Performance, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/BaseScheda.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `areFormActionsSticky` (2 occorrenze)

**Moduli coinvolti:** Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaStabiReparWidget.php`
- `./laravel/Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaValutatoreWidget.php`

[Riflessione: Duplicato interno al modulo Ptv — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `add` (2 occorrenze)

**Moduli coinvolti:** Ptv, User

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Filament/Forms/Components/PeriodoSection.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `_data` (2 occorrenze)

**Moduli coinvolti:** Performance, Ptv

**File in Ptv:**

- `./laravel/Modules/Ptv/app/Models/MyLog.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Riflessioni per Ptv

- **Totale metodi duplicati che coinvolgono Ptv:** 63
- **Di cui cross-modulo:** 58
- **Di cui interni al modulo:** 5

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 45 metodi
- **altro:** 18 metodi

### Moduli con maggiori duplicazioni incrociate

- **Progressioni:** 35 metodi in comune
- **Xot:** 33 metodi in comune
- **Notify:** 31 metodi in comune
- **Sigma:** 25 metodi in comune
- **Performance:** 23 metodi in comune
- **User:** 22 metodi in comune
- **IndennitaResponsabilita:** 13 metodi in comune
- **Job:** 12 metodi in comune
- **Incentivi:** 8 metodi in comune
- **IndennitaCondizioniLavoro:** 7 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
