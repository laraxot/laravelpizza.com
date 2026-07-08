---
title: "elenco metodi relazioni duplicate"
type: analysis
updated: 2026-06-15
related:
  - ./wiki/method-name-homonym-census.md
  - ./wiki/rules/laraxot-relationship-integrity.md
  - ../laravel/Modules/Sigma/docs/wiki/concepts/ente-matr-field-ownership.md
---

# Elenco metodi che restituiscono relazioni duplicate

> Metodi Eloquent (`hasMany`, `hasOne`, `belongsTo`, …) con **stesso nome** in **classi/trait diverse**.
> Scan: `laravel/Modules/**/*.php` (esclusi test/vendor).
> Generato: **2026-06-15** — **69** metodi.

## Scopo

Identificare dove la stessa relazione è dichiarata più volte (trait + modello, moduli diversi, override con scope extra). Non tutte le occorrenze sono errori: alcune sono override intenzionali (`ofRangeDate`, filtri `quaann`).

## Riepilogo categorie

| Categoria | Conteggio | Azione suggerita |
|-----------|-----------|------------------|
| `sigma_ente_matr` | 7 | Owner: `EnteMatrRelationship`; override solo con scope documentato |
| `scheda_stack` | 8 | Owner: `BaseScheda` + trait scheda unificato |
| `cross_module` | 21 | Estrarre trait in Ptv/Xot o modulo owner |
| `module_local` | 33 | Trait di modulo se logica identica |

## Dati machine-readable

- JSON: [duplicate-relationship-methods.json](../bashscripts/docs/duplicate-relationship-methods.json)

## Rigenerazione

```bash
python3 bashscripts/tools/census-duplicate-relationships.py
```

## Sigma — relazioni ente/matr (priorità P0)

**7** metodi.

### `anag()` — 7 implementazioni, 7 classi

- **Moduli:** IndennitaResponsabilita, Progressioni, Ptv, Sigma
- **Target:** Anag

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| IndennitaResponsabilita | `LettI` | `Anag` | `Modules/IndennitaResponsabilita/app/Models/LettI.php` | no |
| IndennitaResponsabilita | `RelationshipTrait` | `Anag` | `Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php` | no |
| Progressioni | `ProgressioniRelationshipTrait` | `Anag` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |
| Ptv | `BaseScheda` | `Anag` | `Modules/Ptv/app/Models/BaseScheda.php` | no |
| Sigma | `EnteMatrRelationship` | `—` | `Modules/Sigma/app/Models/Traits/Relationships/EnteMatrRelationship.php` | sì |
| Sigma | `Wstr01lx` | `—` | `Modules/Sigma/app/Models/Wstr01lx.php` | sì |
| Sigma | `Wstr02f` | `—` | `Modules/Sigma/app/Models/Wstr02f.php` | sì |

### `qua00f()` — 4 implementazioni, 4 classi

- **Moduli:** Incentivi, Sigma
- **Target:** Qua00f

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Incentivi | `Employee` | `Qua00f` | `Modules/Incentivi/app/Models/Employee.php` | no |
| Sigma | `Asz00k1` | `—` | `Modules/Sigma/app/Models/Asz00k1.php` | sì |
| Sigma | `Rep00f` | `—` | `Modules/Sigma/app/Models/Rep00f.php` | sì |
| Sigma | `EnteMatrRelationship` | `—` | `Modules/Sigma/app/Models/Traits/Relationships/EnteMatrRelationship.php` | sì |

### `wstr01lx()` — 3 implementazioni, 3 classi

- **Moduli:** Sigma
- **Target:** Wstr01lx

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Sigma | `EnteMatrRelationship` | `Wstr01lx` | `Modules/Sigma/app/Models/Traits/Relationships/EnteMatrRelationship.php` | no |
| Sigma | `Wmen00f` | `Wstr01lx` | `Modules/Sigma/app/Models/Wmen00f.php` | no |
| Sigma | `Wstr02f` | `Wstr01lx` | `Modules/Sigma/app/Models/Wstr02f.php` | no |

### `ana02f()` — 2 implementazioni, 2 classi

- **Moduli:** Sigma
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Sigma | `Qua00f` | `—` | `Modules/Sigma/app/Models/Qua00f.php` | sì |
| Sigma | `EnteMatrRelationship` | `—` | `Modules/Sigma/app/Models/Traits/Relationships/EnteMatrRelationship.php` | sì |

### `ana10f()` — 2 implementazioni, 2 classi

- **Moduli:** Sigma
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Sigma | `Qua00f` | `—` | `Modules/Sigma/app/Models/Qua00f.php` | sì |
| Sigma | `EnteMatrRelationship` | `—` | `Modules/Sigma/app/Models/Traits/Relationships/EnteMatrRelationship.php` | sì |

### `qua00fYear()` — 2 implementazioni, 2 classi

- **Moduli:** Sigma
- **Target:** Qua00f

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Sigma | `EnteMatrAnnoRelationship` | `Qua00f` | `Modules/Sigma/app/Models/Traits/Relationships/EnteMatrAnnoRelationship.php` | no |
| Sigma | `EnteMatrYearRelationship` | `Qua00f` | `Modules/Sigma/app/Models/Traits/Relationships/EnteMatrYearRelationship.php` | no |

### `rep00f()` — 2 implementazioni, 2 classi

- **Moduli:** Sigma
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Sigma | `Qua00f` | `—` | `Modules/Sigma/app/Models/Qua00f.php` | sì |
| Sigma | `EnteMatrRelationship` | `—` | `Modules/Sigma/app/Models/Traits/Relationships/EnteMatrRelationship.php` | sì |

## Stack scheda (Ptv / Progressioni / Performance — P1)

**8** metodi.

### `stabiDirigente()` — 7 implementazioni, 6 classi

- **Moduli:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv, Sigma
- **Target:** StabiDirigente

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| IndennitaCondizioniLavoro | `RelationshipTrait` | `StabiDirigente` | `Modules/IndennitaCondizioniLavoro/app/Models/Traits/RelationshipTrait.php` | no |
| IndennitaResponsabilita | `LettF` | `StabiDirigente` | `Modules/IndennitaResponsabilita/app/Models/LettF.php` | no |
| IndennitaResponsabilita | `LettI` | `StabiDirigente` | `Modules/IndennitaResponsabilita/app/Models/LettI.php` | no |
| Performance | `RelationshipTrait` | `StabiDirigente` | `Modules/Performance/app/Models/Traits/RelationshipTrait.php` | no |
| Progressioni | `ProgressioniRelationshipTrait` | `StabiDirigente` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |
| Ptv | `HasStabiDirigente` | `—` | `Modules/Ptv/app/Models/Traits/HasStabiDirigente.php` | no |
| Sigma | `SchedaRelationship` | `—` | `Modules/Sigma/app/Models/Traits/Relationships/SchedaRelationship.php` | no |

### `valutatore()` — 5 implementazioni, 5 classi

- **Moduli:** Performance, Progressioni, Ptv, Sigma
- **Target:** StabiDirigente, Valutatore

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Performance | `BaseIndividualeModel` | `StabiDirigente` | `Modules/Performance/app/Models/BaseIndividualeModel.php` | no |
| Performance | `IndividualeTotValutatoreId` | `Valutatore` | `Modules/Performance/app/Models/IndividualeTotValutatoreId.php` | no |
| Progressioni | `ProgressioniRelationshipTrait` | `Valutatore` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |
| Ptv | `HasValutatore` | `—` | `Modules/Ptv/app/Models/Traits/HasValutatore.php` | no |
| Sigma | `SchedaRelationship` | `—` | `Modules/Sigma/app/Models/Traits/Relationships/SchedaRelationship.php` | no |

### `categoriaPropro()` — 3 implementazioni, 3 classi

- **Moduli:** IndennitaResponsabilita, Progressioni, Sigma
- **Target:** CategoriaPropro

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| IndennitaResponsabilita | `RelationshipTrait` | `CategoriaPropro` | `Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php` | no |
| Progressioni | `ProgressioniRelationshipTrait` | `CategoriaPropro` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |
| Sigma | `SchedaRelationship` | `—` | `Modules/Sigma/app/Models/Traits/Relationships/SchedaRelationship.php` | no |

### `assenze()` — 2 implementazioni, 2 classi

- **Moduli:** Performance, Progressioni
- **Target:** Assenza, IndividualeAssenze

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Performance | `Organizzativa` | `IndividualeAssenze` | `Modules/Performance/app/Models/Organizzativa.php` | no |
| Progressioni | `ProgressioniRelationshipTrait` | `Assenza` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |

### `asz()` — 2 implementazioni, 2 classi

- **Moduli:** Performance, Ptv
- **Target:** Asz00k1

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Performance | `Organizzativa` | `Asz00k1` | `Modules/Performance/app/Models/Organizzativa.php` | no |
| Ptv | `BaseScheda` | `Asz00k1` | `Modules/Ptv/app/Models/BaseScheda.php` | no |

### `aszEff()` — 2 implementazioni, 2 classi

- **Moduli:** Performance, Progressioni
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Performance | `Organizzativa` | `—` | `Modules/Performance/app/Models/Organizzativa.php` | no |
| Progressioni | `ProgressioniRelationshipTrait` | `—` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |

### `performanceIndividuale()` — 2 implementazioni, 2 classi

- **Moduli:** Progressioni, Ptv
- **Target:** Individuale, PerformanceIndividuale

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Progressioni | `ProgressioniRelationshipTrait` | `PerformanceIndividuale` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |
| Ptv | `BaseScheda` | `Individuale` | `Modules/Ptv/app/Models/BaseScheda.php` | no |

### `schedas()` — 2 implementazioni, 2 classi

- **Moduli:** Progressioni, Ptv
- **Target:** Scheda

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Progressioni | `Assenza` | `Scheda` | `Modules/Progressioni/app/Models/Assenza.php` | no |
| Ptv | `BaseStabiDirigente` | `—` | `Modules/Ptv/app/Models/BaseStabiDirigente.php` | no |

## Cross-modulo (copy-paste da unificare — P2)

**21** metodi.

### `mailInviate()` — 7 implementazioni, 6 classi

- **Moduli:** IndennitaResponsabilita, Performance, Progressioni
- **Target:** MyLog

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| IndennitaResponsabilita | `LettF` | `MyLog` | `Modules/IndennitaResponsabilita/app/Models/LettF.php` | no |
| IndennitaResponsabilita | `LettI` | `MyLog` | `Modules/IndennitaResponsabilita/app/Models/LettI.php` | no |
| IndennitaResponsabilita | `RelationshipTrait` | `MyLog` | `Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php` | no |
| Performance | `BaseIndividualeModel` | `MyLog` | `Modules/Performance/app/Models/BaseIndividualeModel.php` | no |
| Performance | `Organizzativa` | `MyLog` | `Modules/Performance/app/Models/Organizzativa.php` | no |
| Performance | `RelationshipTrait` | `MyLog` | `Modules/Performance/app/Models/Traits/RelationshipTrait.php` | no |
| Progressioni | `ProgressioniRelationshipTrait` | `—` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |

### `schede()` — 7 implementazioni, 5 classi

- **Moduli:** Incentivi, Progressioni, Ptv
- **Target:** Scheda

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Incentivi | `StabiDirigente` | `Scheda` | `Modules/Incentivi/app/Models/StabiDirigente.php` | no |
| Progressioni | `CriteriEsclusione` | `—` | `Modules/Progressioni/app/Models/CriteriEsclusione.php` | no |
| Progressioni | `MaxCatecoPosfunAnno` | `—` | `Modules/Progressioni/app/Models/MaxCatecoPosfunAnno.php` | no |
| Progressioni | `StabiDirigente` | `—` | `Modules/Progressioni/app/Models/StabiDirigente.php` | no |
| Progressioni | `Valutatore` | `—` | `Modules/Progressioni/app/Models/Valutatore.php` | no |
| Ptv | `Modules` | `—` | `Modules/Ptv/app/Models/CriteriEsclusione.php` | no |
| Ptv | `Valutatore` | `—` | `Modules/Ptv/app/Models/Valutatore.php` | no |

### `user()` — 7 implementazioni, 7 classi

- **Moduli:** Job, Rating, User
- **Target:** User

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Job | `TaskComment` | `User` | `Modules/Job/app/Models/TaskComment.php` | no |
| Rating | `RatingMorph` | `—` | `Modules/Rating/app/Models/RatingMorph.php` | no |
| User | `BaseTeamUser` | `—` | `Modules/User/app/Models/BaseTeamUser.php` | no |
| User | `DeviceUser` | `—` | `Modules/User/app/Models/DeviceUser.php` | no |
| User | `SocialiteUser` | `—` | `Modules/User/app/Models/SocialiteUser.php` | no |
| User | `TeamPermission` | `User` | `Modules/User/app/Models/TeamPermission.php` | no |
| User | `implementa` | `—` | `Modules/User/app/Models/Traits/IsProfileTrait.php` | no |

### `criteriOptions()` — 6 implementazioni, 6 classi

- **Moduli:** Performance, Progressioni, Ptv
- **Target:** CriteriOption, static

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Performance | `BaseIndividualeModel` | `CriteriOption` | `Modules/Performance/app/Models/BaseIndividualeModel.php` | no |
| Performance | `Organizzativa` | `CriteriOption` | `Modules/Performance/app/Models/Organizzativa.php` | no |
| Performance | `RelationshipTrait` | `CriteriOption` | `Modules/Performance/app/Models/Traits/RelationshipTrait.php` | no |
| Progressioni | `ProgressioniRelationshipTrait` | `CriteriOption` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |
| Ptv | `BaseScheda` | `static` | `Modules/Ptv/app/Models/BaseScheda.php` | no |
| Ptv | `Modules` | `—` | `Modules/Ptv/app/Models/CriteriEsclusione.php` | no |

### `mails()` — 6 implementazioni, 6 classi

- **Moduli:** IndennitaResponsabilita, Performance, Progressioni
- **Target:** IndennitaResponsabilita, Scheda, self

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| IndennitaResponsabilita | `RelationshipTrait` | `IndennitaResponsabilita` | `Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php` | no |
| Performance | `IndividualeDip` | `self` | `Modules/Performance/app/Models/IndividualeDip.php` | no |
| Performance | `IndividualeDirigente` | `self` | `Modules/Performance/app/Models/IndividualeDirigente.php` | no |
| Performance | `IndividualePo` | `self` | `Modules/Performance/app/Models/IndividualePo.php` | no |
| Performance | `IndividualeRegionale` | `self` | `Modules/Performance/app/Models/IndividualeRegionale.php` | no |
| Progressioni | `ProgressioniRelationshipTrait` | `Scheda` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |

### `users()` — 6 implementazioni, 6 classi

- **Moduli:** Tenant, User
- **Target:** User

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Tenant | `Tenant` | `User` | `Modules/Tenant/app/Models/Tenant.php` | no |
| User | `BaseTeam` | `—` | `Modules/User/app/Models/BaseTeam.php` | no |
| User | `BaseTenant` | `—` | `Modules/User/app/Models/BaseTenant.php` | no |
| User | `Device` | `—` | `Modules/User/app/Models/Device.php` | no |
| User | `SsoProvider` | `User` | `Modules/User/app/Models/SsoProvider.php` | no |
| User | `IsTenant` | `—` | `Modules/User/app/Models/Traits/IsTenant.php` | no |

### `benificiariProgressione()` — 4 implementazioni, 3 classi

- **Moduli:** Progressioni, Ptv
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Progressioni | `StabiDirigente` | `—` | `Modules/Progressioni/app/Models/StabiDirigente.php` | no |
| Progressioni | `Valutatore` | `—` | `Modules/Progressioni/app/Models/Valutatore.php` | no |
| Ptv | `BaseStabiDirigente` | `—` | `Modules/Ptv/app/Models/BaseStabiDirigente.php` | no |
| Ptv | `Valutatore` | `—` | `Modules/Ptv/app/Models/Valutatore.php` | no |

### `criteriEsclusione()` — 4 implementazioni, 4 classi

- **Moduli:** Performance, Progressioni
- **Target:** CriteriEsclusione

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Performance | `BaseIndividualeModel` | `CriteriEsclusione` | `Modules/Performance/app/Models/BaseIndividualeModel.php` | no |
| Performance | `Organizzativa` | `CriteriEsclusione` | `Modules/Performance/app/Models/Organizzativa.php` | no |
| Performance | `RelationshipTrait` | `CriteriEsclusione` | `Modules/Performance/app/Models/Traits/RelationshipTrait.php` | no |
| Progressioni | `ProgressioniRelationshipTrait` | `CriteriEsclusione` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |

### `repart()` — 4 implementazioni, 4 classi

- **Moduli:** Incentivi, Ptv, Sigma
- **Target:** Repart

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Incentivi | `StabiDirigente` | `Repart` | `Modules/Incentivi/app/Models/StabiDirigente.php` | no |
| Ptv | `BaseStabiDirigente` | `Repart` | `Modules/Ptv/app/Models/BaseStabiDirigente.php` | no |
| Ptv | `Valutatore` | `Repart` | `Modules/Ptv/app/Models/Valutatore.php` | no |
| Sigma | `Rep00f` | `Repart` | `Modules/Sigma/app/Models/Rep00f.php` | no |

### `reparts()` — 4 implementazioni, 4 classi

- **Moduli:** IndennitaCondizioniLavoro, Sigma
- **Target:** Rep00f, Repart

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| IndennitaCondizioniLavoro | `CondizioniLavoro` | `Repart` | `Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php` | no |
| IndennitaCondizioniLavoro | `ServizioEsterno` | `Rep00f` | `Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php` | no |
| Sigma | `Rep00f` | `Repart` | `Modules/Sigma/app/Models/Rep00f.php` | no |
| Sigma | `EnteStabiRelationship` | `Repart` | `Modules/Sigma/app/Models/Traits/Relationships/EnteStabiRelationship.php` | no |

### `linkable()` — 3 implementazioni, 3 classi

- **Moduli:** Incentivi, Lang, Notify
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Incentivi | `Settlement` | `—` | `Modules/Incentivi/app/Models/Settlement.php` | no |
| Lang | `Post` | `—` | `Modules/Lang/app/Models/Post.php` | no |
| Notify | `NotifyTheme` | `—` | `Modules/Notify/app/Models/NotifyTheme.php` | no |

### `messages()` — 3 implementazioni, 3 classi

- **Moduli:** IndennitaResponsabilita, Progressioni
- **Target:** Message

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| IndennitaResponsabilita | `IndennitaResponsabilita` | `Message` | `Modules/IndennitaResponsabilita/app/Models/IndennitaResponsabilita.php` | no |
| IndennitaResponsabilita | `RelationshipTrait` | `Message` | `Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php` | no |
| Progressioni | `ProgressioniRelationshipTrait` | `Message` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |

### `myLogs()` — 3 implementazioni, 2 classi

- **Moduli:** Progressioni, Ptv
- **Target:** MyLog

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Progressioni | `ProgressioniRelationshipTrait` | `MyLog` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |
| Progressioni | `ProgressioniRelationshipTrait` | `—` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |
| Ptv | `HasMyLogs` | `—` | `Modules/Ptv/app/Models/Traits/HasMyLogs.php` | no |

### `profile()` — 3 implementazioni, 3 classi

- **Moduli:** Rating, User
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Rating | `RatingMorph` | `—` | `Modules/Rating/app/Models/RatingMorph.php` | no |
| User | `BaseUser` | `—` | `Modules/User/app/Models/BaseUser.php` | no |
| User | `DeviceUser` | `—` | `Modules/User/app/Models/DeviceUser.php` | no |

### `tenant()` — 3 implementazioni, 3 classi

- **Moduli:** Tenant, User
- **Target:** Tenant

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Tenant | `TenantSetting` | `Tenant` | `Modules/Tenant/app/Models/TenantSetting.php` | no |
| Tenant | `TenantSubscription` | `Tenant` | `Modules/Tenant/app/Models/TenantSubscription.php` | no |
| User | `InteractsWithTenant` | `—` | `Modules/User/app/Models/Traits/InteractsWithTenant.php` | no |

### `avversariCategoriaEco()` — 2 implementazioni, 2 classi

- **Moduli:** Progressioni, Ptv
- **Target:** Scheda, static

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Progressioni | `ConvertedTrait` | `Scheda` | `Modules/Progressioni/app/Models/Traits/ConvertedTrait.php` | no |
| Ptv | `BaseScheda` | `static` | `Modules/Ptv/app/Models/BaseScheda.php` | no |

### `creator()` — 2 implementazioni, 2 classi

- **Moduli:** Media, Xot
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Media | `Media` | `—` | `Modules/Media/app/Models/Media.php` | no |
| Xot | `Updater` | `—` | `Modules/Xot/app/Traits/Updater.php` | no |

### `criteriValutazione()` — 2 implementazioni, 2 classi

- **Moduli:** Progressioni, Ptv
- **Target:** CriteriValutazione

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Progressioni | `ProgressioniRelationshipTrait` | `CriteriValutazione` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |
| Ptv | `HasCriteriValutazione` | `—` | `Modules/Ptv/app/Models/Traits/HasCriteriValutazione.php` | no |

### `images()` — 2 implementazioni, 1 classi

- **Moduli:** IndennitaCondizioniLavoro, IndennitaResponsabilita
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| IndennitaCondizioniLavoro | `BaseModel` | `—` | `Modules/IndennitaCondizioniLavoro/app/Models/BaseModel.php` | no |
| IndennitaResponsabilita | `BaseModel` | `—` | `Modules/IndennitaResponsabilita/app/Models/BaseModel.php` | no |

### `notifications()` — 2 implementazioni, 2 classi

- **Moduli:** Notify, User
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Notify | `HasTenantNotifications` | `—` | `Modules/Notify/app/Traits/HasTenantNotifications.php` | no |
| User | `BaseUser` | `—` | `Modules/User/app/Models/BaseUser.php` | no |

### `stipendioTabellare()` — 2 implementazioni, 2 classi

- **Moduli:** Progressioni, Ptv
- **Target:** StipendioTabellare, static

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Progressioni | `ProgressioniRelationshipTrait` | `StipendioTabellare` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |
| Ptv | `BaseScheda` | `static` | `Modules/Ptv/app/Models/BaseScheda.php` | no |

## Solo dentro un modulo (valutare trait unico — P3)

**33** metodi.

### `indennitaTipoDettaglio()` — 6 implementazioni, 6 classi

- **Moduli:** IndennitaCondizioniLavoro
- **Target:** IndennitaTipoDettaglio

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| IndennitaCondizioniLavoro | `CondizioniLavoro` | `IndennitaTipoDettaglio` | `Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php` | no |
| IndennitaCondizioniLavoro | `CondizioniLavoroAdm` | `—` | `Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroAdm.php` | no |
| IndennitaCondizioniLavoro | `CondizioniLavoroIndennitaTipoDettaglioPivot` | `IndennitaTipoDettaglio` | `Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroIndennitaTipoDettaglioPivot.php` | no |
| IndennitaCondizioniLavoro | `CrossCondizioniLavoroIndennitaTipoDettaglio` | `IndennitaTipoDettaglio` | `Modules/IndennitaCondizioniLavoro/app/Models/CrossCondizioniLavoroIndennitaTipoDettaglio.php` | no |
| IndennitaCondizioniLavoro | `ServizioEsterno` | `IndennitaTipoDettaglio` | `Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php` | no |
| IndennitaCondizioniLavoro | `ServizioEsternoIndennitaTipoDettaglioPivot` | `IndennitaTipoDettaglio` | `Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsternoIndennitaTipoDettaglioPivot.php` | no |

### `codici()` — 4 implementazioni, 4 classi

- **Moduli:** Sigma
- **Target:** Codici

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Sigma | `Asz00f` | `Codici` | `Modules/Sigma/app/Models/Asz00f.php` | no |
| Sigma | `Asz00k1` | `Codici` | `Modules/Sigma/app/Models/Asz00k1.php` | no |
| Sigma | `Mov01k2` | `Codici` | `Modules/Sigma/app/Models/Mov01k2.php` | no |
| Sigma | `Wgiu03f` | `Codici` | `Modules/Sigma/app/Models/Wgiu03f.php` | no |

### `project()` — 4 implementazioni, 4 classi

- **Moduli:** Incentivi
- **Target:** Project

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Incentivi | `Activity` | `Project` | `Modules/Incentivi/app/Models/Activity.php` | no |
| Incentivi | `EmployeeProject` | `Project` | `Modules/Incentivi/app/Models/EmployeeProject.php` | no |
| Incentivi | `Phase` | `Project` | `Modules/Incentivi/app/Models/Phase.php` | no |
| Incentivi | `Settlement` | `Project` | `Modules/Incentivi/app/Models/Settlement.php` | no |

### `task()` — 4 implementazioni, 4 classi

- **Moduli:** Job
- **Target:** Frequency, Task

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Job | `Frequency` | `Task` | `Modules/Job/app/Models/Frequency.php` | no |
| Job | `Parameter` | `Frequency` | `Modules/Job/app/Models/Parameter.php` | no |
| Job | `Result` | `Task` | `Modules/Job/app/Models/Result.php` | no |
| Job | `TaskComment` | `Task` | `Modules/Job/app/Models/TaskComment.php` | no |

### `team()` — 4 implementazioni, 4 classi

- **Moduli:** User
- **Target:** Team

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| User | `BaseTeamUser` | `—` | `Modules/User/app/Models/BaseTeamUser.php` | no |
| User | `Role` | `—` | `Modules/User/app/Models/Role.php` | no |
| User | `TeamInvitation` | `—` | `Modules/User/app/Models/TeamInvitation.php` | no |
| User | `TeamPermission` | `Team` | `Modules/User/app/Models/TeamPermission.php` | no |

### `template()` — 4 implementazioni, 4 classi

- **Moduli:** Notify
- **Target:** MailTemplate, NotificationTemplate

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Notify | `MailTemplateLog` | `MailTemplate` | `Modules/Notify/app/Models/MailTemplateLog.php` | no |
| Notify | `MailTemplateVersion` | `MailTemplate` | `Modules/Notify/app/Models/MailTemplateVersion.php` | no |
| Notify | `NotificationLog` | `NotificationTemplate` | `Modules/Notify/app/Models/NotificationLog.php` | no |
| Notify | `NotificationTemplateVersion` | `NotificationTemplate` | `Modules/Notify/app/Models/NotificationTemplateVersion.php` | no |

### `cards()` — 3 implementazioni, 3 classi

- **Moduli:** Performance
- **Target:** Individuale

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Performance | `BaseIndividualeModel` | `Individuale` | `Modules/Performance/app/Models/BaseIndividualeModel.php` | no |
| Performance | `Organizzativa` | `Individuale` | `Modules/Performance/app/Models/Organizzativa.php` | no |
| Performance | `RelationshipTrait` | `Individuale` | `Modules/Performance/app/Models/Traits/RelationshipTrait.php` | no |

### `condizioniLavoro()` — 3 implementazioni, 3 classi

- **Moduli:** IndennitaCondizioniLavoro
- **Target:** CondizioniLavoro

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| IndennitaCondizioniLavoro | `CondizioniLavoroIndennitaTipoDettaglioPivot` | `CondizioniLavoro` | `Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroIndennitaTipoDettaglioPivot.php` | no |
| IndennitaCondizioniLavoro | `CrossCondizioniLavoroIndennitaTipoDettaglio` | `CondizioniLavoro` | `Modules/IndennitaCondizioniLavoro/app/Models/CrossCondizioniLavoroIndennitaTipoDettaglio.php` | no |
| IndennitaCondizioniLavoro | `ServizioEsternoIndennitaTipoDettaglioPivot` | `CondizioniLavoro` | `Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsternoIndennitaTipoDettaglioPivot.php` | no |

### `criteriMaggiorazione()` — 3 implementazioni, 3 classi

- **Moduli:** Performance
- **Target:** CriteriMaggiorazione

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Performance | `BaseIndividualeModel` | `CriteriMaggiorazione` | `Modules/Performance/app/Models/BaseIndividualeModel.php` | no |
| Performance | `Organizzativa` | `CriteriMaggiorazione` | `Modules/Performance/app/Models/Organizzativa.php` | no |
| Performance | `RelationshipTrait` | `CriteriMaggiorazione` | `Modules/Performance/app/Models/Traits/RelationshipTrait.php` | no |

### `devices()` — 3 implementazioni, 3 classi

- **Moduli:** User
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| User | `BaseUser` | `—` | `Modules/User/app/Models/BaseUser.php` | no |
| User | `HasDevices` | `—` | `Modules/User/app/Models/Traits/HasDevices.php` | no |
| User | `implementa` | `—` | `Modules/User/app/Models/Traits/IsProfileTrait.php` | no |

### `employee()` — 3 implementazioni, 3 classi

- **Moduli:** Incentivi
- **Target:** Employee

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Incentivi | `ActivityEmployee` | `Employee` | `Modules/Incentivi/app/Models/ActivityEmployee.php` | no |
| Incentivi | `EmployeeProject` | `Employee` | `Modules/Incentivi/app/Models/EmployeeProject.php` | no |
| Incentivi | `EmployeeWorkgroup` | `Employee` | `Modules/Incentivi/app/Models/EmployeeWorkgroup.php` | no |

### `employees()` — 3 implementazioni, 3 classi

- **Moduli:** Incentivi
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Incentivi | `Activity` | `—` | `Modules/Incentivi/app/Models/Activity.php` | no |
| Incentivi | `Project` | `—` | `Modules/Incentivi/app/Models/Project.php` | no |
| Incentivi | `Workgroup` | `—` | `Modules/Incentivi/app/Models/Workgroup.php` | no |

### `permissions()` — 3 implementazioni, 3 classi

- **Moduli:** User
- **Target:** TeamPermission

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| User | `Role` | `—` | `Modules/User/app/Models/Role.php` | no |
| User | `Team` | `TeamPermission` | `Modules/User/app/Models/Team.php` | no |
| User | `HasSpatiePermission` | `—` | `Modules/User/app/Models/Traits/HasSpatiePermission.php` | no |

### `Tqu00f()` — 2 implementazioni, 2 classi

- **Moduli:** Sigma
- **Target:** Tqu00f

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Sigma | `Qua00k1` | `Tqu00f` | `Modules/Sigma/app/Models/Qua00k1.php` | no |
| Sigma | `Qua03f` | `Tqu00f` | `Modules/Sigma/app/Models/Qua03f.php` | no |

### `activities()` — 2 implementazioni, 2 classi

- **Moduli:** Incentivi
- **Target:** Activity

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Incentivi | `Employee` | `—` | `Modules/Incentivi/app/Models/Employee.php` | no |
| Incentivi | `Project` | `Activity` | `Modules/Incentivi/app/Models/Project.php` | no |

### `asz00fs()` — 2 implementazioni, 2 classi

- **Moduli:** Progressioni
- **Target:** Asz00f

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Progressioni | `Assenza` | `Asz00f` | `Modules/Progressioni/app/Models/Assenza.php` | no |
| Progressioni | `ProgressioniRelationshipTrait` | `Asz00f` | `Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php` | no |

### `authenticatable()` — 2 implementazioni, 2 classi

- **Moduli:** User
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| User | `name` | `—` | `Modules/User/app/Models/Authentication.php` | no |
| User | `AuthenticationLog` | `—` | `Modules/User/app/Models/AuthenticationLog.php` | no |

### `indennitaTipo()` — 2 implementazioni, 2 classi

- **Moduli:** IndennitaCondizioniLavoro
- **Target:** IndennitaTipo

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| IndennitaCondizioniLavoro | `IndennitaTipoDettaglio` | `IndennitaTipo` | `Modules/IndennitaCondizioniLavoro/app/Models/IndennitaTipoDettaglio.php` | no |
| IndennitaCondizioniLavoro | `IndennitaTipoDettaglioAnno` | `IndennitaTipo` | `Modules/IndennitaCondizioniLavoro/app/Models/IndennitaTipoDettaglioAnno.php` | no |

### `individuale()` — 2 implementazioni, 2 classi

- **Moduli:** Performance
- **Target:** Individuale

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Performance | `IndividualePesi` | `Individuale` | `Modules/Performance/app/Models/IndividualePesi.php` | no |
| Performance | `IndividualePoPesi` | `Individuale` | `Modules/Performance/app/Models/IndividualePoPesi.php` | no |

### `individualeAdm()` — 2 implementazioni, 2 classi

- **Moduli:** Performance
- **Target:** IndividualeAdm

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Performance | `IndividualePesi` | `IndividualeAdm` | `Modules/Performance/app/Models/IndividualePesi.php` | no |
| Performance | `IndividualePoPesi` | `IndividualeAdm` | `Modules/Performance/app/Models/IndividualePoPesi.php` | no |

### `individualePo()` — 2 implementazioni, 2 classi

- **Moduli:** Performance
- **Target:** IndividualePo

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Performance | `IndividualePesi` | `IndividualePo` | `Modules/Performance/app/Models/IndividualePesi.php` | no |
| Performance | `IndividualePoPesi` | `IndividualePo` | `Modules/Performance/app/Models/IndividualePoPesi.php` | no |

### `individualeRegionale()` — 2 implementazioni, 2 classi

- **Moduli:** Performance
- **Target:** IndividualeRegionale

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Performance | `IndividualePesi` | `IndividualeRegionale` | `Modules/Performance/app/Models/IndividualePesi.php` | no |
| Performance | `IndividualePoPesi` | `IndividualeRegionale` | `Modules/Performance/app/Models/IndividualePoPesi.php` | no |

### `latestAuthentication()` — 2 implementazioni, 2 classi

- **Moduli:** User
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| User | `BaseUser` | `—` | `Modules/User/app/Models/BaseUser.php` | no |
| User | `provides` | `—` | `Modules/User/app/Models/Traits/HasAuthenticationLogTrait.php` | no |

### `members()` — 2 implementazioni, 2 classi

- **Moduli:** User
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| User | `BaseTeam` | `—` | `Modules/User/app/Models/BaseTeam.php` | no |
| User | `BaseTenant` | `—` | `Modules/User/app/Models/BaseTenant.php` | no |

### `options()` — 2 implementazioni, 2 classi

- **Moduli:** Performance
- **Target:** Option

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Performance | `Organizzativa` | `Option` | `Modules/Performance/app/Models/Organizzativa.php` | no |
| Performance | `RelationshipTrait` | `Option` | `Modules/Performance/app/Models/Traits/RelationshipTrait.php` | no |

### `ratingObjectives()` — 2 implementazioni, 2 classi

- **Moduli:** Rating
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Rating | `HasRatingsTrait` | `—` | `Modules/Rating/app/Models/Traits/HasRatingsTrait.php` | no |
| Rating | `RatingTrait` | `—` | `Modules/Rating/app/Models/Traits/RatingTrait.php` | no |

### `roles()` — 2 implementazioni, 2 classi

- **Moduli:** User
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| User | `HasRoles` | `—` | `Modules/User/app/Models/Traits/HasRoles.php` | no |
| User | `HasSpatiePermission` | `—` | `Modules/User/app/Models/Traits/HasSpatiePermission.php` | no |

### `socialiteUsers()` — 2 implementazioni, 2 classi

- **Moduli:** User
- **Target:** SocialiteUser

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| User | `BaseUser` | `SocialiteUser` | `Modules/User/app/Models/BaseUser.php` | no |
| User | `HasSocialite` | `SocialiteUser` | `Modules/User/app/Models/Traits/HasSocialite.php` | no |

### `teamUsers()` — 2 implementazioni, 2 classi

- **Moduli:** User
- **Target:** TeamUser

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| User | `BaseTeam` | `TeamUser` | `Modules/User/app/Models/BaseTeam.php` | no |
| User | `handles` | `TeamUser` | `Modules/User/app/Models/Traits/HasTeams.php` | no |

### `teams()` — 2 implementazioni, 2 classi

- **Moduli:** User
- **Target:** —

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| User | `Profile` | `—` | `Modules/User/app/Models/Profile.php` | no |
| User | `handles` | `—` | `Modules/User/app/Models/Traits/HasTeams.php` | no |

### `tipoDettaglio()` — 2 implementazioni, 2 classi

- **Moduli:** IndennitaCondizioniLavoro
- **Target:** CondizioniLavoroIndennitaTipoDettaglioPivot, IndennitaTipoDettaglio

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| IndennitaCondizioniLavoro | `CondizioniLavoro` | `CondizioniLavoroIndennitaTipoDettaglioPivot` | `Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php` | no |
| IndennitaCondizioniLavoro | `ServizioEsterno` | `IndennitaTipoDettaglio` | `Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php` | no |

### `totStabi()` — 2 implementazioni, 2 classi

- **Moduli:** Performance
- **Target:** IndividualeTotStabi

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Performance | `BaseIndividualeModel` | `IndividualeTotStabi` | `Modules/Performance/app/Models/BaseIndividualeModel.php` | no |
| Performance | `RelationshipTrait` | `IndividualeTotStabi` | `Modules/Performance/app/Models/Traits/RelationshipTrait.php` | no |

### `tqu00f()` — 2 implementazioni, 2 classi

- **Moduli:** Sigma
- **Target:** Tqu00f

| Modulo | Classe | Target | File | Helper ente/matr |
|--------|--------|--------|------|------------------|
| Sigma | `Qua00f` | `Tqu00f` | `Modules/Sigma/app/Models/Qua00f.php` | no |
| Sigma | `TquRelationship` | `Tqu00f` | `Modules/Sigma/app/Models/Traits/Relationships/TquRelationship.php` | no |


## Riflessioni

### Cosa è duplicazione vera

1. **`anag()`** — sette implementazioni (`EnteMatrRelationship`, `BaseScheda`, trait Progressioni/Indennità, `Wstr01lx`/`Wstr02f`): stesso concetto anagrafica su chiavi `ente`+`matr`, implementazioni diverse (`hasOneByEnteMatr` vs `hasOne(Anag::class, 'matr', 'matr')` senza ente).
2. **`asz()`** — `BaseScheda` vs `Organizzativa` (Performance): stesso target `Asz00k1`; la versione su `BaseScheda` dovrebbe essere l'unica per tutte le schede.
3. **`stabiDirigente()`**, **`mailInviate()`**, **`categoriaPropro()`** — ripetuti su trait scheda/indennità/performance; candidati a trait condiviso in Ptv o Xot.

### Cosa è override legittimo

- **`Rep00f::qua00f()`** — estende il trait con `ofRangeDate(rep2kd, rep2ka)`.
- **`Qua00f::rep00f()`** — filtro `repann` + `ofRangeDate` sul periodo qualifica.
- **`Asz00k1::qua00f()`** — filtro `quaann` attivo.

In questi casi il nome è uguale ma la **semantica** è più stretta del trait base: vanno tenuti, non eliminati.

### Filosofia

- **Un owner per relazione di dominio** ([laraxot-relationship-integrity](./wiki/rules/laraxot-relationship-integrity.md)).
- **Helper `hasManyByEnteMatr`** al posto di `hasMany` con chiavi hardcoded.
- **Non confondere** con omonimi Filament (`getTableColumns`) — qui solo metodi che restituiscono `Relation`.

## Collegamenti

- [Censimento omonimi metodi (689)](./wiki/method-name-homonym-census.md)
- [Ente/matr field ownership](../laravel/Modules/Sigma/docs/wiki/concepts/ente-matr-field-ownership.md)
