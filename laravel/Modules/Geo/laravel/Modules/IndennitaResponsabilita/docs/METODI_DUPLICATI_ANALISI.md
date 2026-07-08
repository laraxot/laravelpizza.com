---
module: IndennitaResponsabilita
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi IndennitaResponsabilita

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **IndennitaResponsabilita**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `getFormActions` (14 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Media, Pdnd, Ptv, Sigma, User, Xot

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Pages/UpdateDiriByCsv.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getModel` (13 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Media, Notify, Ptv, User, Xot

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `form` (13 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Ptv, Sigma, User, Xot

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Pages/UpdateDiriByCsv.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `validate` (9 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, Pdnd, Progressioni, UI, User

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettF.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getActions` (9 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, Progressioni, Rating

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource.php`
- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Resources/RatingMorphResource/Pages/EditRatingMorph.php`
- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Resources/RatingResource/Pages/EditRating.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `envelope` (8 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Notify, Performance, Progressioni, Ptv

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Mail/SchedaMail.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `authenticate` (8 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma, User

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Presente in 7 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `attachments` (8 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Notify, Performance, Progressioni, Ptv

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Mail/SchedaMail.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `stabiDirigente` (7 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv, Sigma

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettF.php`
- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettI.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `mailInviate` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettF.php`
- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettI.php`
- `./laravel/Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getXlsFields` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getColumns` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni, UI, Xot

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Exports/IndennitaResponsabilitaExporter.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `error` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, User, Xot

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Components/ProgressIndicator.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `content` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Notify, Performance, Progressioni, Ptv

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Mail/SchedaMail.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `authorizeAccess` (7 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv, Xot

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `anag` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni, Ptv, Sigma

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettI.php`
- `./laravel/Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `redirectTo` (6 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `mails` (6 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getTotAttribute` (6 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettF.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `broadcastOn` (6 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, User, Xot

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Events/DatiSalvati.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `back` (6 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `submit` (5 occorrenze)

**Moduli coinvolti:** Gdpr, IndennitaResponsabilita, User, Xot

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Pages/UpdateDiriByCsv.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `messages` (5 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, Media, Progressioni

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/IndennitaResponsabilita.php`
- `./laravel/Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getModule` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getContextName` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Http/Middleware/FilamentMiddleware.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `build` (5 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni, Xot

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Emails/LettFMail.php`
- `./laravel/Modules/IndennitaResponsabilita/app/Emails/LettIMail.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `setMotivoAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/IndennitaResponsabilita.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `setHaDirittoAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/IndennitaResponsabilita.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `sendMail` (4 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Notify, Progressioni

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/Policies/IndennitaResponsabilitaPolicy.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `infolist` (4 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Xot

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getToFieldAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Sigma

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/Traits/MutatorTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFromFieldAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Sigma

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/Traits/MutatorTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getEmailAttribute` (4 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Sigma

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettF.php`
- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettI.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `completed` (4 occorrenze)

**Moduli coinvolti:** DbForge, IndennitaResponsabilita

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Components/ProgressIndicator.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `updateFields` (3 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettI.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `importi` (3 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettF.php`
- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettI.php`
- `./laravel/Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Duplicato interno al modulo IndennitaResponsabilita — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getTableFiltersLayout` (3 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Ptv

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/ListIndennitaResponsabilitas.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `categoriaPropro` (3 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni, Sigma

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getTableFiltersFormColumns` (2 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Xot

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/ListIndennitaResponsabilitas.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `shouldPersistTableFiltersInSession` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/ListIndennitaResponsabilitas.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `msg` (2 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/Traits/FunctionTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `images` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/BaseModel.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getRouteParameters` (2 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Xot

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettI.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPosizTxtAttribute` (2 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Sigma

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettF.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGgPresenzaPeriodoAttribute` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/Traits/MutatorTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getDalAttribute` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/Traits/MutatorTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getCompletedNotificationBody` (2 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Filament/Exports/IndennitaResponsabilitaExporter.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getAlAttribute` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/Traits/MutatorTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `content_PDF` (2 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettI.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `calculateTot` (2 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita

**File in IndennitaResponsabilita:**

- `./laravel/Modules/IndennitaResponsabilita/app/Models/LettF.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Riflessioni per IndennitaResponsabilita

- **Totale metodi duplicati che coinvolgono IndennitaResponsabilita:** 50
- **Di cui cross-modulo:** 49
- **Di cui interni al modulo:** 1

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 42 metodi
- **altro:** 8 metodi

### Moduli con maggiori duplicazioni incrociate

- **Progressioni:** 32 metodi in comune
- **Xot:** 26 metodi in comune
- **Performance:** 25 metodi in comune
- **IndennitaCondizioniLavoro:** 21 metodi in comune
- **User:** 19 metodi in comune
- **Sigma:** 18 metodi in comune
- **Ptv:** 16 metodi in comune
- **Notify:** 13 metodi in comune
- **Job:** 7 metodi in comune
- **Pdnd:** 5 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
