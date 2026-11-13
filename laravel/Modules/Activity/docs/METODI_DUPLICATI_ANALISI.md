---
module: Activity
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi Activity

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Activity**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `before` (14 occorrenze)

**Moduli coinvolti:** Activity, Gdpr, Job, Lang, Media, Performance, Progressioni, Setting, Sigma, Tenant, UI, User, Xot

**File in Activity:**

- `./laravel/Modules/Activity/app/Models/Policies/ActivityBasePolicy.php`

[Riflessione: Presente in 13 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `user` (10 occorrenze)

**Moduli coinvolti:** Activity, Job, Rating, User, Xot

**File in Activity:**

- `./laravel/Modules/Activity/database/factories/BaseActivityFactory.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `logout` (5 occorrenze)

**Moduli coinvolti:** Activity, User

**File in Activity:**

- `./laravel/Modules/Activity/app/Actions/ActivityLogger.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `updated` (4 occorrenze)

**Moduli coinvolti:** Activity, Job, Performance, Ptv

**File in Activity:**

- `./laravel/Modules/Activity/app/Actions/ActivityLogger.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `registerConfig` (3 occorrenze)

**Moduli coinvolti:** Activity, Xot

**File in Activity:**

- `./laravel/Modules/Activity/app/Providers/ActivityServiceProvider.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `login` (3 occorrenze)

**Moduli coinvolti:** Activity, Notify, User

**File in Activity:**

- `./laravel/Modules/Activity/app/Actions/ActivityLogger.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `created` (3 occorrenze)

**Moduli coinvolti:** Activity, Job, User

**File in Activity:**

- `./laravel/Modules/Activity/app/Actions/ActivityLogger.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `withVersion` (2 occorrenze)

**Moduli coinvolti:** Activity

**File in Activity:**

- `./laravel/Modules/Activity/database/factories/SnapshotFactory.php`
- `./laravel/Modules/Activity/database/factories/StoredEventFactory.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `withUuid` (2 occorrenze)

**Moduli coinvolti:** Activity

**File in Activity:**

- `./laravel/Modules/Activity/database/factories/SnapshotFactory.php`
- `./laravel/Modules/Activity/database/factories/StoredEventFactory.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getBreadcrumb` (2 occorrenze)

**Moduli coinvolti:** Activity, Xot

**File in Activity:**

- `./laravel/Modules/Activity/app/Filament/Pages/ListLogActivities.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `displaySummary` (2 occorrenze)

**Moduli coinvolti:** Activity, User

**File in Activity:**

- `./laravel/Modules/Activity/database/seeders/ActivityMassSeeder.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `deleted` (2 occorrenze)

**Moduli coinvolti:** Activity, Job

**File in Activity:**

- `./laravel/Modules/Activity/app/Actions/ActivityLogger.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `custom` (2 occorrenze)

**Moduli coinvolti:** Activity, UI

**File in Activity:**

- `./laravel/Modules/Activity/app/Actions/ActivityLogger.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Riflessioni per Activity

- **Totale metodi duplicati che coinvolgono Activity:** 13
- **Di cui cross-modulo:** 11
- **Di cui interni al modulo:** 2

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 8 metodi
- **altro:** 5 metodi

### Moduli con maggiori duplicazioni incrociate

- **User:** 13 metodi in comune
- **Xot:** 6 metodi in comune
- **Job:** 5 metodi in comune
- **Performance:** 3 metodi in comune
- **UI:** 2 metodi in comune
- **Gdpr:** 1 metodi in comune
- **Lang:** 1 metodi in comune
- **Media:** 1 metodi in comune
- **Progressioni:** 1 metodi in comune
- **Setting:** 1 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
