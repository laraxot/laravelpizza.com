---
module: Progressioni
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi Progressioni

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Progressioni**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `via` (14 occorrenze)

**Moduli coinvolti:** Job, Notify, Progressioni, Ptv, User

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Notifications/SchedaPdfNotification.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `populateFromLastYear` (14 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Policies/AssenzePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CategoriaProproPolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CedDiffPolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CoeffPolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriEsclusionePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriOptionPolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriPrecedenzaPolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriValutazionePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/MessagePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/PesiPolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/SchedaCriteriPolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/StabiDirigentePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/StipendioTabellarePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/ValutatorePolicy.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `before` (14 occorrenze)

**Moduli coinvolti:** Activity, Gdpr, Job, Lang, Media, Performance, Progressioni, Setting, Sigma, Tenant, UI, User, Xot

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Policies/SchedaPolicy.php`

[Riflessione: Presente in 13 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `toMail` (10 occorrenze)

**Moduli coinvolti:** Job, Notify, Progressioni, Ptv, User

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Notifications/SchedaPdfNotification.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `validate` (9 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, Pdnd, Progressioni, UI, User

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Scheda.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `schede` (9 occorrenze)

**Moduli coinvolti:** Incentivi, Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/CriteriEsclusione.php`
- `./laravel/Modules/Progressioni/app/Models/MaxCatecoPosfunAnno.php`
- `./laravel/Modules/Progressioni/app/Models/StabiDirigente.php`
- `./laravel/Modules/Progressioni/app/Models/Valutatore.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getActions` (9 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, Progressioni, Rating

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Filament/Resources/SchedaResource/Pages/CompilaScheda.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `envelope` (8 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Notify, Performance, Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Mail/SchedaMail.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `authenticate` (8 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma, User

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Presente in 7 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `attachments` (8 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Notify, Performance, Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Mail/SchedaMail.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `stabiDirigente` (7 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `mailInviate` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `index` (7 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Policies/SchedaPolicy.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getXlsFields` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Filament/Resources/ProgressioniResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getColumns` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni, UI, Xot

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Filament/Imports/CedDiffImporter.php`
- `./laravel/Modules/Progressioni/app/Imports/CedDiffImport.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `edit` (7 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Policies/SchedaPolicy.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `criteriOptions` (7 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `content` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Notify, Performance, Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Mail/SchedaMail.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `authorizeAccess` (7 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv, Xot

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Filament/Resources/SchedaResource/Pages/CompilaScheda.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `anag` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni, Ptv, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `rules` (6 occorrenze)

**Moduli coinvolti:** Job, Media, Performance, Progressioni, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Filament/Resources/SchedaResource/Pages/CompilaScheda.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `redirectTo` (6 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `mails` (6 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `destroy` (6 occorrenze)

**Moduli coinvolti:** Job, Performance, Progressioni, Sigma, User

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Policies/SchedaPolicy.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `collection` (6 occorrenze)

**Moduli coinvolti:** Lang, Progressioni, Ptv, Xot

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Imports/CedDiffImport.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `back` (6 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Filament/Resources/SchedaResource/Pages/CompilaScheda.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `valutatore` (5 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `populate` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Policies/ProgressioniPolicy.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `messages` (5 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, Media, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getModule` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getContextName` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `filter` (5 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/MaxCatecoPosfunAnno.php`
- `./laravel/Modules/Progressioni/app/Models/Scheda.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `build` (5 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni, Xot

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Emails/SchedaPdfMail.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `benificiariProgressione` (5 occorrenze)

**Moduli coinvolti:** Incentivi, Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/StabiDirigente.php`
- `./laravel/Modules/Progressioni/app/Models/Valutatore.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getNomeStabiAttribute` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Valutatore.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `xlsProgressioni` (4 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriEsclusionePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriPrecedenzaPolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriValutazionePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/ValutatorePolicy.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `trovaEsclusi` (4 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriEsclusionePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriPrecedenzaPolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriValutazionePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/ValutatorePolicy.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `syncProgressioniRepQua` (4 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriEsclusionePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriPrecedenzaPolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriValutazionePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/ValutatorePolicy.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `setMotivoAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Progressioni.php`
- `./laravel/Modules/Progressioni/app/Models/Scheda.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `setHaDirittoAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Progressioni.php`
- `./laravel/Modules/Progressioni/app/Models/Scheda.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `sendMail` (4 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Notify, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Policies/ProgressioniPolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/SchedaPolicy.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `ggInSedeTot` (4 occorrenze)

**Moduli coinvolti:** Progressioni, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Scheda.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getFieldsYear` (4 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Services/CriteriPrecedenzaService.php`
- `./laravel/Modules/Progressioni/app/Services/CriteriValutazioneService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `forAnno` (4 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/database/factories/AssenzaFactory.php`
- `./laravel/Modules/Progressioni/database/factories/CriteriValutazioneFactory.php`
- `./laravel/Modules/Progressioni/database/factories/SchedaFactory.php`
- `./laravel/Modules/Progressioni/database/factories/StipendioTabellareFactory.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `findStabi0` (4 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriEsclusionePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriPrecedenzaPolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriValutazionePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/ValutatorePolicy.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `criteriOptionsArr` (4 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `criteriEsclusione` (4 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `check` (4 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, User

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `checkGgCatecoPosfunNoAsz` (4 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriEsclusionePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriPrecedenzaPolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CriteriValutazionePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/ValutatorePolicy.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `updateFields` (3 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/EsclusiExtra.php`
- `./laravel/Modules/Progressioni/app/Models/Scheda.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `isRegionale` (3 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `isPo` (3 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getSchedaCollection` (3 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/CriteriEsclusione.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getListaTipoCodiceAspettative` (3 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getAventiDirittoEffAttribute` (3 occorrenze)

**Moduli coinvolti:** Progressioni, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/MaxCatecoPosfunAnno.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getAventiDirittoAttribute` (3 occorrenze)

**Moduli coinvolti:** Progressioni, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/MaxCatecoPosfunAnno.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `criteriOptionsCollection` (3 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/CriteriEsclusione.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `checkMinGgAnno` (3 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `categoriaPropro` (3 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `budgetAssegnato` (3 occorrenze)

**Moduli coinvolti:** Incentivi, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/StabiDirigente.php`
- `./laravel/Modules/Progressioni/app/Models/Valutatore.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `myLogs` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `stipendioTabellare` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `setYear` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Filament/Infolists/CriteriPrecedenzaSection.php`
- `./laravel/Modules/Progressioni/app/Filament/Infolists/CriteriValutazioneSection.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `schedas` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Assenza.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `peso` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `ProgressioniRelationshipTrait::peso()` — relazione `HasOne` verso `Pesi` (tabella `peso`)
- `Scheda::resolveCoeffPesoFromParams()` — calcolo coefficiente da `coeff` (ex `peso(array $params)`)

**Fix (2026):** il metodo business su `Scheda` non deve chiamarsi `peso()`: Laravel lo interpreta come relazione in `attributesToArray()` e rompe `CompilaScheda` (`ArgumentCountError`). Vedi [scheda-peso-relationship-homonym.md](scheda-peso-relationship-homonym.md).

[Riflessione: in Performance `peso()` è solo relazione; in Progressioni la logica coeff è stata rinominata]

---

## Metodo: `performanceIndividuale` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `perfInd` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `mutateFormDataBeforeFill` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Filament/Resources/SchedaResource/Pages/CompilaScheda.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `msg` (2 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `minValutazioni` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/database/factories/CriteriEsclusioneFactory.php`
- `./laravel/Modules/Progressioni/database/factories/CriteriOptionFactory.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `minGgRuolo` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/database/factories/CriteriEsclusioneFactory.php`
- `./laravel/Modules/Progressioni/database/factories/CriteriOptionFactory.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `minGgAnno` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/database/factories/CriteriEsclusioneFactory.php`
- `./laravel/Modules/Progressioni/database/factories/CriteriOptionFactory.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `listaCodiciAspettative` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `ggInSedeTotByArray` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Scheda.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getValueForCriterio` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/database/factories/CriteriEsclusioneFactory.php`
- `./laravel/Modules/Progressioni/database/factories/CriteriOptionFactory.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFieldsNamesYear` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Services/CriteriPrecedenzaService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getDateMax` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getCompletedNotificationBody` (2 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Filament/Imports/CedDiffImporter.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `forYear` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/database/factories/CriteriEsclusioneFactory.php`
- `./laravel/Modules/Progressioni/database/factories/CriteriOptionFactory.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `fillForm` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Filament/Resources/SchedaResource/Pages/CompilaScheda.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `criteriValutazione` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `content_PDF` (2 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Scheda.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `cloneLastYear` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Policies/AssenzePolicy.php`
- `./laravel/Modules/Progressioni/app/Models/Policies/CedDiffPolicy.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `checkNoproproList` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `checkNoposizList` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `checkNoposfunList` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `checkNodisci1List` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `checkMinGgRuolo` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `checkMinGgPropro` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `checkMinGgProproPosfun` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `checkMinGgPosiz1InSede` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `checkMinGgCatecoPosfunNoAsz` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `checkMinGgCatecoPosfunLavoratiInSede` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `checkMaxGgAssenzeAnno` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `checkListaPropro` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `checkListaProproPosfun` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `checkListaPosiz` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `checkListaAszTipCodEsclusoSubito` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `checkDisci` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`
- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `checkDateMinAssunz` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Actions/TrovaEsclusiAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `canSendEmail` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `avversariCategoriaEco` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Ptv

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ConvertedTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `aszEff` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `asz00k1` (2 occorrenze)

**Moduli coinvolti:** Progressioni, Sigma

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Scheda.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `asz00fs` (2 occorrenze)

**Moduli coinvolti:** Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Assenza.php`
- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Duplicato interno al modulo Progressioni — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `assenze` (2 occorrenze)

**Moduli coinvolti:** Performance, Progressioni

**File in Progressioni:**

- `./laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Riflessioni per Progressioni

- **Totale metodi duplicati che coinvolgono Progressioni:** 106
- **Di cui cross-modulo:** 81
- **Di cui interni al modulo:** 25

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 74 metodi
- **altro:** 32 metodi

### Moduli con maggiori duplicazioni incrociate

- **Performance:** 74 metodi in comune
- **Ptv:** 39 metodi in comune
- **IndennitaResponsabilita:** 35 metodi in comune
- **Notify:** 28 metodi in comune
- **Sigma:** 26 metodi in comune
- **IndennitaCondizioniLavoro:** 11 metodi in comune
- **Job:** 9 metodi in comune
- **User:** 8 metodi in comune
- **Xot:** 8 metodi in comune
- **UI:** 4 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
