---
module: Incentivi
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi Incentivi

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Incentivi**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `schede` (9 occorrenze)

**Moduli coinvolti:** Incentivi, Progressioni, Ptv

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/StabiDirigente.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `booted` (6 occorrenze)

**Moduli coinvolti:** Gdpr, Incentivi, Sigma, User

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/Project.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `afterSave` (6 occorrenze)

**Moduli coinvolti:** Incentivi, Lang, Setting, User, Xot

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Filament/Resources/ActivityResource/Pages/EditActivity.php`
- `./laravel/Modules/Incentivi/app/Filament/Resources/ProjectResource/Pages/EditProject.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getRedirectUrl` (5 occorrenze)

**Moduli coinvolti:** Incentivi, Setting, User

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Filament/Resources/EmployeeResource/Pages/CreateEmployee.php`
- `./laravel/Modules/Incentivi/app/Filament/Resources/WorkgroupResource/Pages/CreateWorkgroup.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getModelLabel` (5 occorrenze)

**Moduli coinvolti:** Incentivi, User, Xot

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Filament/Resources/ActivityResource/RelationManagers/EmployeesRelationManager.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `download` (5 occorrenze)

**Moduli coinvolti:** Incentivi, Setting, Xot

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Http/Controllers/PdfDownloadController.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `benificiariProgressione` (5 occorrenze)

**Moduli coinvolti:** Incentivi, Progressioni, Ptv

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/StabiDirigente.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getNomeStabiAttribute` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Progressioni, Ptv

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/StabiDirigente.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getNomeDiriAttribute` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Ptv, Sigma

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/StabiDirigente.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `repart` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Ptv, Sigma

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/StabiDirigente.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `qua00f` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Sigma

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/Employee.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `project` (4 occorrenze)

**Moduli coinvolti:** Incentivi

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/Activity.php`
- `./laravel/Modules/Incentivi/app/Models/EmployeeProject.php`
- `./laravel/Modules/Incentivi/app/Models/Phase.php`
- `./laravel/Modules/Incentivi/app/Models/Settlement.php`

[Riflessione: Duplicato interno al modulo Incentivi — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getFullNameAttribute` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Sigma, User

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/Employee.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getEnteAttribute` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Ptv, Sigma

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/StabiDirigente.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `linkable` (3 occorrenze)

**Moduli coinvolti:** Incentivi, Lang, Notify

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/Settlement.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getStabiAttribute` (3 occorrenze)

**Moduli coinvolti:** Incentivi, Ptv, Sigma

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/StabiDirigente.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getReparAttribute` (3 occorrenze)

**Moduli coinvolti:** Incentivi, Ptv, Sigma

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/StabiDirigente.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `employee` (3 occorrenze)

**Moduli coinvolti:** Incentivi

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/ActivityEmployee.php`
- `./laravel/Modules/Incentivi/app/Models/EmployeeProject.php`
- `./laravel/Modules/Incentivi/app/Models/EmployeeWorkgroup.php`

[Riflessione: Duplicato interno al modulo Incentivi — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `employees` (3 occorrenze)

**Moduli coinvolti:** Incentivi

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/Activity.php`
- `./laravel/Modules/Incentivi/app/Models/Project.php`
- `./laravel/Modules/Incentivi/app/Models/Workgroup.php`

[Riflessione: Duplicato interno al modulo Incentivi — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `budgetAssegnato` (3 occorrenze)

**Moduli coinvolti:** Incentivi, Progressioni

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/StabiDirigente.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `sumPerColumn` (2 occorrenze)

**Moduli coinvolti:** Incentivi

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Filament/Resources/ProjectResource/Pages/ManageProjectEmployees.php`
- `./laravel/Modules/Incentivi/app/Http/Controllers/PdfDownloadController.php`

[Riflessione: Duplicato interno al modulo Incentivi — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `shouldRegisterNavigation` (2 occorrenze)

**Moduli coinvolti:** Incentivi

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Filament/Resources/ActivityResource.php`
- `./laravel/Modules/Incentivi/app/Filament/Resources/EmployeeResource.php`

[Riflessione: Duplicato interno al modulo Incentivi — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `replicate` (2 occorrenze)

**Moduli coinvolti:** Incentivi

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/Policies/ActivityPolicy.php`
- `./laravel/Modules/Incentivi/app/Models/Policies/ProjectPolicy.php`

[Riflessione: Duplicato interno al modulo Incentivi — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getTabs` (2 occorrenze)

**Moduli coinvolti:** Incentivi

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Filament/Resources/CapitalPercentageResource/Pages/ListCapitalPercentages.php`
- `./laravel/Modules/Incentivi/app/Filament/Resources/DefaultActivityResource/Pages/ListDefaultActivities.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTableRecordTitleAttribute` (2 occorrenze)

**Moduli coinvolti:** Incentivi, Xot

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Filament/Resources/ProjectResource/Pages/ManageProjectEmployees.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTablePaginated` (2 occorrenze)

**Moduli coinvolti:** Incentivi, Xot

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Filament/Resources/ProjectResource/Pages/ManageProjectActivities.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getStabi` (2 occorrenze)

**Moduli coinvolti:** Incentivi, Sigma

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/StabiDirigente.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getBreadcrumbs` (2 occorrenze)

**Moduli coinvolti:** Incentivi

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Filament/Resources/ActivityResource/Pages/EditActivity.php`
- `./laravel/Modules/Incentivi/app/Filament/Resources/PhaseResource/Pages/EditPhase.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `export` (2 occorrenze)

**Moduli coinvolti:** Incentivi

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/Policies/EmployeePolicy.php`
- `./laravel/Modules/Incentivi/app/Models/Policies/ProjectPolicy.php`

[Riflessione: Duplicato interno al modulo Incentivi — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `canCreate` (2 occorrenze)

**Moduli coinvolti:** Incentivi

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Filament/Resources/ProjectResource/Pages/ManageProjectActivities.php`
- `./laravel/Modules/Incentivi/app/Filament/Resources/SettlementResource.php`

[Riflessione: Duplicato interno al modulo Incentivi — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `attachRUPAndDEC` (2 occorrenze)

**Moduli coinvolti:** Incentivi

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Filament/Resources/ProjectResource/Pages/CreateProject.php`
- `./laravel/Modules/Incentivi/app/Filament/Resources/ProjectResource/Pages/EditProject.php`

[Riflessione: Duplicato interno al modulo Incentivi — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `approve` (2 occorrenze)

**Moduli coinvolti:** Incentivi

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/Policies/ProjectPolicy.php`
- `./laravel/Modules/Incentivi/app/Models/Policies/SettlementPolicy.php`

[Riflessione: Duplicato interno al modulo Incentivi — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `afterCreate` (2 occorrenze)

**Moduli coinvolti:** Incentivi, Setting

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Filament/Resources/ProjectResource/Pages/CreateProject.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `activities` (2 occorrenze)

**Moduli coinvolti:** Incentivi

**File in Incentivi:**

- `./laravel/Modules/Incentivi/app/Models/Employee.php`
- `./laravel/Modules/Incentivi/app/Models/Project.php`

[Riflessione: Duplicato interno al modulo Incentivi — valutare estrazione in trait di modulo o classe base]

---

## Riflessioni per Incentivi

- **Totale metodi duplicati che coinvolgono Incentivi:** 34
- **Di cui cross-modulo:** 21
- **Di cui interni al modulo:** 13

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 31 metodi
- **altro:** 3 metodi

### Moduli con maggiori duplicazioni incrociate

- **Ptv:** 15 metodi in comune
- **Sigma:** 12 metodi in comune
- **Progressioni:** 9 metodi in comune
- **Xot:** 8 metodi in comune
- **User:** 7 metodi in comune
- **Setting:** 5 metodi in comune
- **Gdpr:** 3 metodi in comune
- **Lang:** 2 metodi in comune
- **Notify:** 1 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
