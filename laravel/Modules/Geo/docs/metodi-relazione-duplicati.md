# Metodi Relazione Duplicati

## `schede` (7 occorrenze) — hasMany
- `laravel/Modules/Incentivi/app/Models/StabiDirigente.php`
- `laravel/Modules/Ptv/app/Models/CriteriEsclusione.php`
- `laravel/Modules/Ptv/app/Models/Valutatore.php`
- `laravel/Modules/Progressioni/app/Models/StabiDirigente.php`
- `laravel/Modules/Progressioni/app/Models/MaxCatecoPosfunAnno.php`
- `laravel/Modules/Progressioni/app/Models/CriteriEsclusione.php`
- `laravel/Modules/Progressioni/app/Models/Valutatore.php`

[Riflessione: Metodo definito in 3 moduli diversi: Ptv (2 file), Incentivi (1 file), Progressioni (4 file). Possibile candidato per trait condiviso o interfaccia.]

## `user` (7 occorrenze) — belongsTo
- `laravel/Modules/User/app/Models/BaseTeamUser.php`
- `laravel/Modules/User/app/Models/TeamPermission.php`
- `laravel/Modules/User/app/Models/SocialiteUser.php`
- `laravel/Modules/User/app/Models/DeviceUser.php`
- `laravel/Modules/User/app/Models/Traits/IsProfileTrait.php`
- `laravel/Modules/Job/app/Models/TaskComment.php`
- `laravel/Modules/Rating/app/Models/RatingMorph.php`

[Riflessione: Metodo definito in 3 moduli diversi: User (5 file), Rating (1 file), Job (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `criteriOptions` (6 occorrenze) — hasMany
- `laravel/Modules/Ptv/app/Models/CriteriEsclusione.php`
- `laravel/Modules/Ptv/app/Models/BaseScheda.php`
- `laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`
- `laravel/Modules/Performance/app/Models/Organizzativa.php`
- `laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`
- `laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Metodo definito in 3 moduli diversi: Ptv (2 file), Performance (3 file), Progressioni (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `mailInviate` (6 occorrenze) — hasMany
- `laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`
- `laravel/Modules/Performance/app/Models/Organizzativa.php`
- `laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`
- `laravel/Modules/IndennitaResponsabilita/app/Models/LettI.php`
- `laravel/Modules/IndennitaResponsabilita/app/Models/LettF.php`
- `laravel/Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Metodo definito in 2 moduli diversi: Performance (3 file), IndennitaResponsabilita (3 file). Possibile candidato per trait condiviso o interfaccia.]

## `mails` (6 occorrenze) — hasMany
- `laravel/Modules/Performance/app/Models/IndividualeDirigente.php`
- `laravel/Modules/Performance/app/Models/IndividualeDip.php`
- `laravel/Modules/Performance/app/Models/IndividualePo.php`
- `laravel/Modules/Performance/app/Models/IndividualeRegionale.php`
- `laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`
- `laravel/Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Metodo definito in 3 moduli diversi: Performance (4 file), Progressioni (1 file), IndennitaResponsabilita (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `indennitaTipoDettaglio` (5 occorrenze) — hasOne
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsternoIndennitaTipoDettaglioPivot.php`
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/CrossCondizioniLavoroIndennitaTipoDettaglio.php`
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroIndennitaTipoDettaglioPivot.php`

[Riflessione: Metodo definito in 5 file dello stesso modulo (IndennitaCondizioniLavoro). Potrebbe essere estratto in un trait per DRY. ATTENZIONE: tipo di relazione non uniforme (belongsToMany, hasOne). Possibile conflitto semantico o naming inappropriato.]

## `project` (5 occorrenze) — belongsTo
- `laravel/Modules/Incentivi/app/Models/Activity.php`
- `laravel/Modules/Incentivi/app/Models/EmployeeWorkgroup.php`
- `laravel/Modules/Incentivi/app/Models/Settlement.php`
- `laravel/Modules/Incentivi/app/Models/Phase.php`
- `laravel/Modules/Incentivi/app/Models/EmployeeProject.php`

[Riflessione: Metodo definito in 5 file dello stesso modulo (Incentivi). Potrebbe essere estratto in un trait per DRY.]

## `stabiDirigente` (5 occorrenze) — hasOne
- `laravel/Modules/Ptv/app/Models/Traits/HasStabiDirigente.php`
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/Traits/RelationshipTrait.php`
- `laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`
- `laravel/Modules/IndennitaResponsabilita/app/Models/LettI.php`
- `laravel/Modules/Sigma/app/Models/Traits/Relationships/SchedaRelationship.php`

[Riflessione: Metodo definito in 5 moduli diversi: Sigma (1 file), Performance (1 file), IndennitaCondizioniLavoro (1 file), Ptv (1 file), IndennitaResponsabilita (1 file). Possibile candidato per trait condiviso o interfaccia. ATTENZIONE: tipo di relazione non uniforme (hasMany, hasOne). Possibile conflitto semantico o naming inappropriato.]

## `valutatore` (5 occorrenze) — belongsTo
- `laravel/Modules/Ptv/app/Models/Traits/HasValutatore.php`
- `laravel/Modules/Performance/app/Models/IndividualeTotValutatoreId.php`
- `laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`
- `laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`
- `laravel/Modules/Sigma/app/Models/Traits/Relationships/SchedaRelationship.php`

[Riflessione: Metodo definito in 4 moduli diversi: Progressioni (1 file), Sigma (1 file), Performance (2 file), Ptv (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `anag` (4 occorrenze) — hasOne
- `laravel/Modules/Ptv/app/Models/BaseScheda.php`
- `laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`
- `laravel/Modules/IndennitaResponsabilita/app/Models/LettI.php`
- `laravel/Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Metodo definito in 3 moduli diversi: Progressioni (1 file), IndennitaResponsabilita (2 file), Ptv (1 file). Possibile candidato per trait condiviso o interfaccia. ATTENZIONE: tipo di relazione non uniforme (belongsTo, hasOne). Possibile conflitto semantico o naming inappropriato.]

## `codici` (4 occorrenze) — hasOne
- `laravel/Modules/Sigma/app/Models/Asz00k1.php`
- `laravel/Modules/Sigma/app/Models/Asz00f.php`
- `laravel/Modules/Sigma/app/Models/Wgiu03f.php`
- `laravel/Modules/Sigma/app/Models/Mov01k2.php`

[Riflessione: Metodo definito in 4 file dello stesso modulo (Sigma). Potrebbe essere estratto in un trait per DRY.]

## `criteriEsclusione` (4 occorrenze) — hasMany
- `laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`
- `laravel/Modules/Performance/app/Models/Organizzativa.php`
- `laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`
- `laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Metodo definito in 2 moduli diversi: Progressioni (1 file), Performance (3 file). Possibile candidato per trait condiviso o interfaccia.]

## `task` (4 occorrenze) — belongsTo
- `laravel/Modules/Job/app/Models/Result.php`
- `laravel/Modules/Job/app/Models/Parameter.php`
- `laravel/Modules/Job/app/Models/Frequency.php`
- `laravel/Modules/Job/app/Models/TaskComment.php`

[Riflessione: Metodo definito in 4 file dello stesso modulo (Job). Potrebbe essere estratto in un trait per DRY.]

## `team` (4 occorrenze) — belongsTo
- `laravel/Modules/User/app/Models/BaseTeamUser.php`
- `laravel/Modules/User/app/Models/TeamInvitation.php`
- `laravel/Modules/User/app/Models/TeamPermission.php`
- `laravel/Modules/User/app/Models/Role.php`

[Riflessione: Metodo definito in 4 file dello stesso modulo (User). Potrebbe essere estratto in un trait per DRY.]

## `template` (4 occorrenze) — belongsTo
- `laravel/Modules/Notify/app/Models/MailTemplateLog.php`
- `laravel/Modules/Notify/app/Models/NotificationTemplateVersion.php`
- `laravel/Modules/Notify/app/Models/NotificationLog.php`
- `laravel/Modules/Notify/app/Models/MailTemplateVersion.php`

[Riflessione: Metodo definito in 4 file dello stesso modulo (Notify). Potrebbe essere estratto in un trait per DRY.]

## `cards` (3 occorrenze) — hasMany
- `laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`
- `laravel/Modules/Performance/app/Models/Organizzativa.php`
- `laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Metodo definito in 3 file dello stesso modulo (Performance). Potrebbe essere estratto in un trait per DRY.]

## `categoriaPropro` (3 occorrenze) — hasOne
- `laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`
- `laravel/Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php`
- `laravel/Modules/Sigma/app/Models/Traits/Relationships/SchedaRelationship.php`

[Riflessione: Metodo definito in 3 moduli diversi: IndennitaResponsabilita (1 file), Progressioni (1 file), Sigma (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `condizioniLavoro` (3 occorrenze) — hasOne
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsternoIndennitaTipoDettaglioPivot.php`
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/CrossCondizioniLavoroIndennitaTipoDettaglio.php`
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoroIndennitaTipoDettaglioPivot.php`

[Riflessione: Metodo definito in 3 file dello stesso modulo (IndennitaCondizioniLavoro). Potrebbe essere estratto in un trait per DRY.]

## `criteriMaggiorazione` (3 occorrenze) — belongsTo
- `laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`
- `laravel/Modules/Performance/app/Models/Organizzativa.php`
- `laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Metodo definito in 3 file dello stesso modulo (Performance). Potrebbe essere estratto in un trait per DRY. ATTENZIONE: tipo di relazione non uniforme (belongsTo, hasOne). Possibile conflitto semantico o naming inappropriato.]

## `employee` (3 occorrenze) — belongsTo
- `laravel/Modules/Incentivi/app/Models/EmployeeWorkgroup.php`
- `laravel/Modules/Incentivi/app/Models/ActivityEmployee.php`
- `laravel/Modules/Incentivi/app/Models/EmployeeProject.php`

[Riflessione: Metodo definito in 3 file dello stesso modulo (Incentivi). Potrebbe essere estratto in un trait per DRY.]

## `indennitaTipo` (3 occorrenze) — hasOne
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/IndennitaTipoDettaglioAnno.php`
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/IndennitaTipoDettaglio.php`

[Riflessione: Metodo definito in 3 file dello stesso modulo (IndennitaCondizioniLavoro). Potrebbe essere estratto in un trait per DRY. ATTENZIONE: tipo di relazione non uniforme (hasManyThrough, hasOne). Possibile conflitto semantico o naming inappropriato.]

## `linkable` (3 occorrenze) — morphTo
- `laravel/Modules/Incentivi/app/Models/Settlement.php`
- `laravel/Modules/Lang/app/Models/Post.php`
- `laravel/Modules/Notify/app/Models/NotifyTheme.php`

[Riflessione: Metodo definito in 3 moduli diversi: Lang (1 file), Notify (1 file), Incentivi (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `messages` (3 occorrenze) — hasMany
- `laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`
- `laravel/Modules/IndennitaResponsabilita/app/Models/IndennitaResponsabilita.php`
- `laravel/Modules/IndennitaResponsabilita/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Metodo definito in 2 moduli diversi: IndennitaResponsabilita (2 file), Progressioni (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `myLogs` (2 occorrenze) — morphMany
- `laravel/Modules/Ptv/app/Models/Traits/HasMyLogs.php`
- `laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Metodo definito in 2 moduli diversi: Progressioni (1 file), Ptv (1 file). Possibile candidato per trait condiviso o interfaccia. ATTENZIONE: tipo di relazione non uniforme (hasMany, morphMany). Possibile conflitto semantico o naming inappropriato.]

## `profile` (3 occorrenze) — belongsTo
- `laravel/Modules/User/app/Models/BaseUser.php`
- `laravel/Modules/User/app/Models/DeviceUser.php`
- `laravel/Modules/Rating/app/Models/RatingMorph.php`

[Riflessione: Metodo definito in 2 moduli diversi: User (2 file), Rating (1 file). Possibile candidato per trait condiviso o interfaccia. ATTENZIONE: tipo di relazione non uniforme (hasOne, belongsTo). Possibile conflitto semantico o naming inappropriato.]

## `repart` (3 occorrenze) — hasOne
- `laravel/Modules/Incentivi/app/Models/StabiDirigente.php`
- `laravel/Modules/Ptv/app/Models/BaseStabiDirigente.php`
- `laravel/Modules/Ptv/app/Models/Valutatore.php`

[Riflessione: Metodo definito in 2 moduli diversi: Incentivi (1 file), Ptv (2 file). Possibile candidato per trait condiviso o interfaccia.]

## `reparts` (3 occorrenze) — hasMany
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`
- `laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteStabiRelationship.php`

[Riflessione: Metodo definito in 2 moduli diversi: Sigma (1 file), IndennitaCondizioniLavoro (2 file). Possibile candidato per trait condiviso o interfaccia.]

## `tenant` (3 occorrenze) — belongsTo
- `laravel/Modules/User/app/Models/Traits/InteractsWithTenant.php`
- `laravel/Modules/Tenant/app/Models/TenantSubscription.php`
- `laravel/Modules/Tenant/app/Models/TenantSetting.php`

[Riflessione: Metodo definito in 2 moduli diversi: Tenant (2 file), User (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `wstr01lx` (3 occorrenze) — hasMany
- `laravel/Modules/Sigma/app/Models/Wstr02f.php`
- `laravel/Modules/Sigma/app/Models/Wmen00f.php`
- `laravel/Modules/Sigma/app/Models/Traits/Relationships/EnteMatrRelationship.php`

[Riflessione: Metodo definito in 3 file dello stesso modulo (Sigma). Potrebbe essere estratto in un trait per DRY.]

## `Tqu00f` (2 occorrenze) — hasOne
- `laravel/Modules/Sigma/app/Models/Qua03f.php`
- `laravel/Modules/Sigma/app/Models/Qua00k1.php`

[Riflessione: Metodo definito in 2 file dello stesso modulo (Sigma). Potrebbe essere estratto in un trait per DRY.]

## `assenze` (2 occorrenze) — hasMany
- `laravel/Modules/Performance/app/Models/Organizzativa.php`
- `laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Metodo definito in 2 moduli diversi: Performance (1 file), Progressioni (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `asz` (2 occorrenze) — hasMany
- `laravel/Modules/Ptv/app/Models/BaseScheda.php`
- `laravel/Modules/Performance/app/Models/Organizzativa.php`

[Riflessione: Metodo definito in 2 moduli diversi: Ptv (1 file), Performance (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `asz00fs` (2 occorrenze) — hasMany
- `laravel/Modules/Progressioni/app/Models/Assenza.php`
- `laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Metodo definito in 2 file dello stesso modulo (Progressioni). Potrebbe essere estratto in un trait per DRY.]

## `authenticatable` (2 occorrenze) — morphTo
- `laravel/Modules/User/app/Models/Authentication.php`
- `laravel/Modules/User/app/Models/AuthenticationLog.php`

[Riflessione: Metodo definito in 2 file dello stesso modulo (User). Potrebbe essere estratto in un trait per DRY.]

## `authentications` (2 occorrenze) — morphMany
- `laravel/Modules/User/app/Models/BaseUser.php`
- `laravel/Modules/User/app/Models/Traits/HasAuthenticationLogTrait.php`

[Riflessione: Metodo definito in 2 file dello stesso modulo (User). Potrebbe essere estratto in un trait per DRY.]

## `avversariCategoriaEco` (2 occorrenze) — hasMany
- `laravel/Modules/Ptv/app/Models/BaseScheda.php`
- `laravel/Modules/Progressioni/app/Models/Traits/ConvertedTrait.php`

[Riflessione: Metodo definito in 2 moduli diversi: Progressioni (1 file), Ptv (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `creator` (2 occorrenze) — belongsTo
- `laravel/Modules/Media/app/Models/Media.php`
- `laravel/Modules/Xot/app/Traits/Updater.php`

[Riflessione: Metodo definito in 2 moduli diversi: Xot (1 file), Media (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `criteriValutazione` (2 occorrenze) — hasMany
- `laravel/Modules/Ptv/app/Models/Traits/HasCriteriValutazione.php`
- `laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Metodo definito in 2 moduli diversi: Progressioni (1 file), Ptv (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `images` (2 occorrenze) — morphMany
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/BaseModel.php`
- `laravel/Modules/IndennitaResponsabilita/app/Models/BaseModel.php`

[Riflessione: Metodo definito in 2 moduli diversi: IndennitaResponsabilita (1 file), IndennitaCondizioniLavoro (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `individuale` (2 occorrenze) — hasMany
- `laravel/Modules/Performance/app/Models/IndividualePoPesi.php`
- `laravel/Modules/Performance/app/Models/IndividualePesi.php`

[Riflessione: Metodo definito in 2 file dello stesso modulo (Performance). Potrebbe essere estratto in un trait per DRY. ATTENZIONE: tipo di relazione non uniforme (hasMany, belongsTo). Possibile conflitto semantico o naming inappropriato.]

## `individualeAdm` (2 occorrenze) — belongsTo
- `laravel/Modules/Performance/app/Models/IndividualePoPesi.php`
- `laravel/Modules/Performance/app/Models/IndividualePesi.php`

[Riflessione: Metodo definito in 2 file dello stesso modulo (Performance). Potrebbe essere estratto in un trait per DRY. ATTENZIONE: tipo di relazione non uniforme (belongsTo, hasMany). Possibile conflitto semantico o naming inappropriato.]

## `individualePo` (2 occorrenze) — belongsTo
- `laravel/Modules/Performance/app/Models/IndividualePoPesi.php`
- `laravel/Modules/Performance/app/Models/IndividualePesi.php`

[Riflessione: Metodo definito in 2 file dello stesso modulo (Performance). Potrebbe essere estratto in un trait per DRY. ATTENZIONE: tipo di relazione non uniforme (belongsTo, hasMany). Possibile conflitto semantico o naming inappropriato.]

## `individualeRegionale` (2 occorrenze) — belongsTo
- `laravel/Modules/Performance/app/Models/IndividualePoPesi.php`
- `laravel/Modules/Performance/app/Models/IndividualePesi.php`

[Riflessione: Metodo definito in 2 file dello stesso modulo (Performance). Potrebbe essere estratto in un trait per DRY. ATTENZIONE: tipo di relazione non uniforme (belongsTo, hasMany). Possibile conflitto semantico o naming inappropriato.]

## `maxCatecoPosfun` (2 occorrenze) — hasOne
- `laravel/Modules/Ptv/app/Models/BaseScheda.php`
- `laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Metodo definito in 2 moduli diversi: Progressioni (1 file), Ptv (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `model` (2 occorrenze) — morphTo
- `laravel/Modules/Rating/app/Models/RatingMorph.php`
- `laravel/Modules/Xot/tests/Fixtures/Models/ExtraModelTest.php`

[Riflessione: Metodo definito in 2 moduli diversi: Rating (1 file), Xot (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `notifications` (2 occorrenze) — morphMany
- `laravel/Modules/User/app/Models/BaseUser.php`
- `laravel/Modules/Notify/app/Traits/HasTenantNotifications.php`

[Riflessione: Metodo definito in 2 moduli diversi: Notify (1 file), User (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `options` (2 occorrenze) — hasMany
- `laravel/Modules/Performance/app/Models/Organizzativa.php`
- `laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Metodo definito in 2 file dello stesso modulo (Performance). Potrebbe essere estratto in un trait per DRY.]

## `performanceIndividuale` (2 occorrenze) — hasMany
- `laravel/Modules/Ptv/app/Models/BaseScheda.php`
- `laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Metodo definito in 2 moduli diversi: Ptv (1 file), Progressioni (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `pesi` (2 occorrenze) — hasOne
- `laravel/Modules/Ptv/app/Models/BaseScheda.php`
- `laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Metodo definito in 2 moduli diversi: Progressioni (1 file), Ptv (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `ratingObjectives` (2 occorrenze) — hasMany
- `laravel/Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `laravel/Modules/Rating/app/Models/Traits/RatingTrait.php`

[Riflessione: Metodo definito in 2 file dello stesso modulo (Rating). Potrebbe essere estratto in un trait per DRY.]

## `schedas` (2 occorrenze) — hasMany
- `laravel/Modules/Ptv/app/Models/BaseStabiDirigente.php`
- `laravel/Modules/Progressioni/app/Models/Assenza.php`

[Riflessione: Metodo definito in 2 moduli diversi: Ptv (1 file), Progressioni (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `socialiteUsers` (2 occorrenze) — hasMany
- `laravel/Modules/User/app/Models/BaseUser.php`
- `laravel/Modules/User/app/Models/Traits/HasSocialite.php`

[Riflessione: Metodo definito in 2 file dello stesso modulo (User). Potrebbe essere estratto in un trait per DRY.]

## `stipendioTabellare` (2 occorrenze) — hasOne
- `laravel/Modules/Ptv/app/Models/BaseScheda.php`
- `laravel/Modules/Progressioni/app/Models/Traits/ProgressioniRelationshipTrait.php`

[Riflessione: Metodo definito in 2 moduli diversi: Progressioni (1 file), Ptv (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `teamUsers` (2 occorrenze) — hasMany
- `laravel/Modules/User/app/Models/BaseTeam.php`
- `laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Metodo definito in 2 file dello stesso modulo (User). Potrebbe essere estratto in un trait per DRY.]

## `tipoDettaglio` (2 occorrenze) — belongsToMany
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php`
- `laravel/Modules/IndennitaCondizioniLavoro/app/Models/ServizioEsterno.php`

[Riflessione: Metodo definito in 2 file dello stesso modulo (IndennitaCondizioniLavoro). Potrebbe essere estratto in un trait per DRY. ATTENZIONE: tipo di relazione non uniforme (belongsToMany, hasMany). Possibile conflitto semantico o naming inappropriato.]

## `totStabi` (2 occorrenze) — hasOne
- `laravel/Modules/Performance/app/Models/BaseIndividualeModel.php`
- `laravel/Modules/Performance/app/Models/Traits/RelationshipTrait.php`

[Riflessione: Metodo definito in 2 file dello stesso modulo (Performance). Potrebbe essere estratto in un trait per DRY. ATTENZIONE: tipo di relazione non uniforme (hasOne, belongsTo). Possibile conflitto semantico o naming inappropriato.]

## `users` (2 occorrenze) — hasMany
- `laravel/Modules/User/app/Models/SsoProvider.php`
- `laravel/Modules/Tenant/app/Models/Tenant.php`

[Riflessione: Metodo definito in 2 moduli diversi: Tenant (1 file), User (1 file). Possibile candidato per trait condiviso o interfaccia.]

## `workgroup` (2 occorrenze) — belongsTo
- `laravel/Modules/Incentivi/app/Models/EmployeeWorkgroup.php`
- `laravel/Modules/Incentivi/app/Models/Project.php`

[Riflessione: Metodo definito in 2 file dello stesso modulo (Incentivi). Potrebbe essere estratto in un trait per DRY.]

---

## Statistiche per Modulo

- **Performance**: 36 occorrenze
- **Progressioni**: 22 occorrenze
- **User**: 22 occorrenze
- **Ptv**: 18 occorrenze
- **IndennitaCondizioniLavoro**: 17 occorrenze
- **Incentivi**: 13 occorrenze
- **Sigma**: 13 occorrenze
- **IndennitaResponsabilita**: 11 occorrenze
- **Notify**: 6 occorrenze
- **Rating**: 5 occorrenze
- **Job**: 5 occorrenze
- **Tenant**: 3 occorrenze
- **Xot**: 2 occorrenze
- **Media**: 1 occorrenze
- **Lang**: 1 occorrenze

## Pattern Osservati

- Totale metodi duplicati: 58
- Cross-module: 31 (53%)
- Stesso modulo: 27 (47%)

### Distribuzione per tipo di relazione

- **hasMany**: 22 (38%)
- **belongsTo**: 15 (26%)
- **hasOne**: 13 (22%)
- **morphMany**: 4 (7%)
- **morphTo**: 3 (5%)
- **belongsToMany**: 1 (2%)

## Raccomandazioni per Refactoring

1. **Estrarre trait condivisi**: per metodi con lo stesso nome e tipo in moduli diversi, creare un trait in un modulo condiviso (es. Xot).
2. **Unificare naming**: se lo stesso nome ha tipi di relazione diversi, rinominare per chiarezza semantica.
3. **Centralizzare gerarchie**: relazioni `belongsTo` allo stesso modello target possono essere centralizzate in un trait.
4. **Verificare relazioni in trait vs classi utilizzatrici**: molte duplicazioni sono tra un trait e le classi che lo usano; valutare se il metodo è già nel trait.
5. **Priorità moduli**: concentrare il refactoring sui moduli con più duplicati.
