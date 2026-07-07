---
module: Job
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi Job

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Job**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `via` (14 occorrenze)

**Moduli coinvolti:** Job, Notify, Progressioni, Ptv, User

**File in Job:**

- `./laravel/Modules/Job/app/Notifications/TaskCompleted.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `before` (14 occorrenze)

**Moduli coinvolti:** Activity, Gdpr, Job, Lang, Media, Performance, Progressioni, Setting, Sigma, Tenant, UI, User, Xot

**File in Job:**

- `./laravel/Modules/Job/app/Models/Policies/JobBasePolicy.php`

[Riflessione: Presente in 13 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getWidgets` (13 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Job, Ptv, Sigma, User, Xot

**File in Job:**

- `./laravel/Modules/Job/app/Filament/Resources/JobManagerResource.php`
- `./laravel/Modules/Job/app/Filament/Resources/JobResource.php`
- `./laravel/Modules/Job/app/Filament/Resources/JobsWaitingResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getHeaderWidgets` (13 occorrenze)

**Moduli coinvolti:** Job, Media, Notify, Ptv, UI, User, Xot

**File in Job:**

- `./laravel/Modules/Job/app/Filament/Pages/JobStatus.php`
- `./laravel/Modules/Job/app/Filament/Resources/JobsWaitingResource/Pages/ListJobsWaiting.php`
- `./laravel/Modules/Job/app/Filament/Resources/JobsWaitingResource/Pages/ListJobsWaitings.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `user` (10 occorrenze)

**Moduli coinvolti:** Activity, Job, Rating, User, Xot

**File in Job:**

- `./laravel/Modules/Job/app/Models/TaskComment.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `toMail` (10 occorrenze)

**Moduli coinvolti:** Job, Notify, Progressioni, Ptv, User

**File in Job:**

- `./laravel/Modules/Job/app/Notifications/TaskCompleted.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `validate` (9 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, Pdnd, Progressioni, UI, User

**File in Job:**

- `./laravel/Modules/Job/app/Rules/Corn.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getActions` (9 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, Progressioni, Rating

**File in Job:**

- `./laravel/Modules/Job/app/Filament/Columns/ActionGroup.php`
- `./laravel/Modules/Job/app/Filament/Tables/Columns/ActionGroup.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `failed` (8 occorrenze)

**Moduli coinvolti:** DbForge, Job, Notify, Xot

**File in Job:**

- `./laravel/Modules/Job/app/Models/JobBatch.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `status` (7 occorrenze)

**Moduli coinvolti:** Job, Xot

**File in Job:**

- `./laravel/Modules/Job/app/Models/Job.php`
- `./laravel/Modules/Job/app/Models/JobManager.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `rules` (6 occorrenze)

**Moduli coinvolti:** Job, Media, Performance, Progressioni, Sigma

**File in Job:**

- `./laravel/Modules/Job/app/Http/Requests/ScheduleRequest.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `removeTeamMember` (6 occorrenze)

**Moduli coinvolti:** Job, User

**File in Job:**

- `./laravel/Modules/Job/app/Models/Policies/FailedJobPolicy.php`
- `./laravel/Modules/Job/app/Models/Policies/JobBatchPolicy.php`
- `./laravel/Modules/Job/app/Models/Policies/JobPolicy.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `destroy` (6 occorrenze)

**Moduli coinvolti:** Job, Performance, Progressioni, Sigma, User

**File in Job:**

- `./laravel/Modules/Job/app/Contracts/TaskInterface.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `broadcastOn` (6 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, User, Xot

**File in Job:**

- `./laravel/Modules/Job/app/Events/BroadcastingEvent.php`
- `./laravel/Modules/Job/app/Events/PrivateEvent.php`
- `./laravel/Modules/Job/app/Events/PublicEvent.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `addTeamMember` (6 occorrenze)

**Moduli coinvolti:** Job, User

**File in Job:**

- `./laravel/Modules/Job/app/Models/Policies/FailedJobPolicy.php`
- `./laravel/Modules/Job/app/Models/Policies/JobBatchPolicy.php`
- `./laravel/Modules/Job/app/Models/Policies/JobPolicy.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `updateTeamMember` (5 occorrenze)

**Moduli coinvolti:** Job, User

**File in Job:**

- `./laravel/Modules/Job/app/Models/Policies/FailedJobPolicy.php`
- `./laravel/Modules/Job/app/Models/Policies/JobBatchPolicy.php`
- `./laravel/Modules/Job/app/Models/Policies/JobPolicy.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `messages` (5 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, Media, Progressioni

**File in Job:**

- `./laravel/Modules/Job/app/Http/Requests/ScheduleRequest.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getCards` (5 occorrenze)

**Moduli coinvolti:** Job, Ptv, UI

**File in Job:**

- `./laravel/Modules/Job/app/Filament/Resources/JobManagerResource/Widgets/JobStatsOverview.php`
- `./laravel/Modules/Job/app/Filament/Resources/JobResource/Widgets/JobStatsOverview.php`
- `./laravel/Modules/Job/app/Filament/Resources/JobsWaitingResource/Widgets/JobsWaitingOverview.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `withValue` (4 occorrenze)

**Moduli coinvolti:** Job

**File in Job:**

- `./laravel/Modules/Job/app/Filament/Columns/ScheduleArguments.php`
- `./laravel/Modules/Job/app/Filament/Columns/ScheduleOptions.php`
- `./laravel/Modules/Job/app/Filament/Tables/Columns/ScheduleArguments.php`
- `./laravel/Modules/Job/app/Filament/Tables/Columns/ScheduleOptions.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `updated` (4 occorrenze)

**Moduli coinvolti:** Activity, Job, Performance, Ptv

**File in Job:**

- `./laravel/Modules/Job/app/Observers/ScheduleObserver.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `task` (4 occorrenze)

**Moduli coinvolti:** Job

**File in Job:**

- `./laravel/Modules/Job/app/Models/Frequency.php`
- `./laravel/Modules/Job/app/Models/Parameter.php`
- `./laravel/Modules/Job/app/Models/Result.php`
- `./laravel/Modules/Job/app/Models/TaskComment.php`

[Riflessione: Duplicato interno al modulo Job — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `scopeActive` (4 occorrenze)

**Moduli coinvolti:** Job, Notify, Sigma, Xot

**File in Job:**

- `./laravel/Modules/Job/app/Models/Schedule.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getTags` (4 occorrenze)

**Moduli coinvolti:** Job

**File in Job:**

- `./laravel/Modules/Job/app/Filament/Columns/ScheduleArguments.php`
- `./laravel/Modules/Job/app/Filament/Columns/ScheduleOptions.php`
- `./laravel/Modules/Job/app/Filament/Tables/Columns/ScheduleArguments.php`
- `./laravel/Modules/Job/app/Filament/Tables/Columns/ScheduleOptions.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTable` (4 occorrenze)

**Moduli coinvolti:** Job, User, Xot

**File in Job:**

- `./laravel/Modules/Job/app/Models/Job.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `begin` (4 occorrenze)

**Moduli coinvolti:** Job, Media, Xot

**File in Job:**

- `./laravel/Modules/Job/app/Filament/Widgets/ClockWidget.php`
- `./laravel/Modules/Job/app/Filament/Widgets/QueueListenWidget.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `created` (3 occorrenze)

**Moduli coinvolti:** Activity, Job, User

**File in Job:**

- `./laravel/Modules/Job/app/Observers/ScheduleObserver.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `clearCache` (3 occorrenze)

**Moduli coinvolti:** Job, Xot

**File in Job:**

- `./laravel/Modules/Job/app/Observers/ScheduleObserver.php`
- `./laravel/Modules/Job/app/Services/ScheduleService.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `artisan` (3 occorrenze)

**Moduli coinvolti:** Job

**File in Job:**

- `./laravel/Modules/Job/app/Filament/Pages/JobStatus.php`
- `./laravel/Modules/Job/app/Http/Livewire/Job/Status.php`
- `./laravel/Modules/Job/app/Http/Livewire/Schedule/Status.php`

[Riflessione: Duplicato interno al modulo Job — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `try` (2 occorrenze)

**Moduli coinvolti:** Job, Notify

**File in Job:**

- `./laravel/Modules/Job/app/Http/Livewire/Broad.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `scopeInactive` (2 occorrenze)

**Moduli coinvolti:** Job, Xot

**File in Job:**

- `./laravel/Modules/Job/app/Models/Schedule.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `onValidationError` (2 occorrenze)

**Moduli coinvolti:** Job

**File in Job:**

- `./laravel/Modules/Job/app/Filament/Resources/ScheduleResource/Pages/CreateSchedule.php`
- `./laravel/Modules/Job/app/Filament/Resources/ScheduleResource/Pages/EditSchedule.php`

[Riflessione: Duplicato interno al modulo Job — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `formatArrayTags` (2 occorrenze)

**Moduli coinvolti:** Job

**File in Job:**

- `./laravel/Modules/Job/app/Filament/Columns/ScheduleArguments.php`
- `./laravel/Modules/Job/app/Filament/Tables/Columns/ScheduleArguments.php`

[Riflessione: Duplicato interno al modulo Job — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `filterEmptyTags` (2 occorrenze)

**Moduli coinvolti:** Job

**File in Job:**

- `./laravel/Modules/Job/app/Filament/Columns/ScheduleArguments.php`
- `./laravel/Modules/Job/app/Filament/Tables/Columns/ScheduleArguments.php`

[Riflessione: Duplicato interno al modulo Job — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `deleted` (2 occorrenze)

**Moduli coinvolti:** Activity, Job

**File in Job:**

- `./laravel/Modules/Job/app/Observers/ScheduleObserver.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `beginStream` (2 occorrenze)

**Moduli coinvolti:** Job

**File in Job:**

- `./laravel/Modules/Job/app/Filament/Widgets/ClockWidget.php`
- `./laravel/Modules/Job/app/Filament/Widgets/QueueListenWidget.php`

[Riflessione: Duplicato interno al modulo Job — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `beginProcess` (2 occorrenze)

**Moduli coinvolti:** Job

**File in Job:**

- `./laravel/Modules/Job/app/Filament/Widgets/ClockWidget.php`
- `./laravel/Modules/Job/app/Filament/Widgets/QueueListenWidget.php`

[Riflessione: Duplicato interno al modulo Job — valutare estrazione in trait di modulo o classe base]

---

## Riflessioni per Job

- **Totale metodi duplicati che coinvolgono Job:** 36
- **Di cui cross-modulo:** 27
- **Di cui interni al modulo:** 9

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 28 metodi
- **altro:** 8 metodi

### Moduli con maggiori duplicazioni incrociate

- **User:** 27 metodi in comune
- **Notify:** 21 metodi in comune
- **Xot:** 20 metodi in comune
- **Progressioni:** 8 metodi in comune
- **Ptv:** 7 metodi in comune
- **Performance:** 7 metodi in comune
- **IndennitaResponsabilita:** 7 metodi in comune
- **Media:** 6 metodi in comune
- **Activity:** 5 metodi in comune
- **Sigma:** 5 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
