---
module: Xot
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi Xot

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Xot**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `getUser` (14 occorrenze)

**Moduli coinvolti:** Notify, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/XotBasePage.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFormActions` (14 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Media, Pdnd, Ptv, Sigma, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/MetatagPage.php`
- `./laravel/Modules/Xot/app/Filament/Pages/XotBasePage.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `before` (14 occorrenze)

**Moduli coinvolti:** Activity, Gdpr, Job, Lang, Media, Performance, Progressioni, Setting, Sigma, Tenant, UI, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Models/Policies/XotBasePolicy.php`

[Riflessione: Presente in 13 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getWidgets` (13 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Job, Ptv, Sigma, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/Dashboard.php`
- `./laravel/Modules/Xot/app/Filament/Pages/MainDashboard.php`
- `./laravel/Modules/Xot/app/Filament/Pages/XotBaseDashboard.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getModel` (13 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Media, Notify, Ptv, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/XotBasePage.php`
- `./laravel/Modules/Xot/app/Filament/Resources/Pages/XotBasePage.php`
- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getHeaderWidgets` (13 occorrenze)

**Moduli coinvolti:** Job, Media, Notify, Ptv, UI, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/HealthPage.php`
- `./laravel/Modules/Xot/app/Filament/Resources/CacheResource/Pages/ListCaches.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `form` (13 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Ptv, Sigma, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/Pages/XotBasePage.php`
- `./laravel/Modules/Xot/app/Filament/Resources/RelationManagers/XotBaseRelationManager.php`
- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource.php`
- `./laravel/Modules/Xot/app/Filament/Traits/HasXotForm.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseSchemaWidget.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `active` (13 occorrenze)

**Moduli coinvolti:** DbForge, Setting, Tenant, UI, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/database/factories/ModuleFactory.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getDescription` (12 occorrenze)

**Moduli coinvolti:** MobilitaVolontaria, Notify, Pdnd, Seo, UI, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Datas/MetatagData.php`
- `./laravel/Modules/Xot/app/Traits/EnumTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `get` (11 occorrenze)

**Moduli coinvolti:** Lang, Media, Notify, Seo, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeEloquentCastAction.php`
- `./laravel/Modules/Xot/app/Casts/PhoneCast.php`
- `./laravel/Modules/Xot/app/Relations/CustomRelation.php`
- `./laravel/Modules/Xot/helpers/Helper.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getRows` (11 occorrenze)

**Moduli coinvolti:** Lang, Setting, Sigma, Tenant, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Models/InformationSchemaTable.php`
- `./laravel/Modules/Xot/app/Models/Log.php`
- `./laravel/Modules/Xot/app/Models/Module.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getNavigationLabel` (11 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/Pages/XotBaseEditRecord.php`
- `./laravel/Modules/Xot/app/Filament/Resources/Pages/XotBaseManageRelatedRecords.php`
- `./laravel/Modules/Xot/app/Filament/Resources/Pages/XotBasePage.php`
- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource/RelationManager/XotBaseRelationManager.php`
- `./laravel/Modules/Xot/app/Filament/Traits/NavigationLabelTrait.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseInfolistWidget.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php`
- `./laravel/Modules/Xot/app/Traits/Filament/HasCustomModelLabel.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `user` (10 occorrenze)

**Moduli coinvolti:** Activity, Job, Rating, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/ProfileContract.php`
- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `supports` (10 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Services/Artisan/Contracts/CommandHandlerInterface.php`
- `./laravel/Modules/Xot/app/Services/Artisan/Handlers/CacheCommandHandler.php`
- `./laravel/Modules/Xot/app/Services/Artisan/Handlers/DebugbarCommandHandler.php`
- `./laravel/Modules/Xot/app/Services/Artisan/Handlers/ErrorCommandHandler.php`
- `./laravel/Modules/Xot/app/Services/Artisan/Handlers/MigrationCommandHandler.php`
- `./laravel/Modules/Xot/app/Services/Artisan/Handlers/ModuleCommandHandler.php`
- `./laravel/Modules/Xot/app/Services/Artisan/Handlers/OptimizeCommandHandler.php`
- `./laravel/Modules/Xot/app/Services/Artisan/Handlers/QueueCommandHandler.php`
- `./laravel/Modules/Xot/app/Services/Artisan/Handlers/RouteCommandHandler.php`
- `./laravel/Modules/Xot/app/Services/Artisan/Handlers/ViewCommandHandler.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getType` (10 occorrenze)

**Moduli coinvolti:** Performance, Seo, UI, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Datas/MetatagData.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/ModelTrendChartWidget.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/StatesChartWidget.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseChartWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `inactive` (9 occorrenze)

**Moduli coinvolti:** DbForge, Setting, Tenant, UI, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/database/factories/ModuleFactory.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getSchema` (9 occorrenze)

**Moduli coinvolti:** Ptv, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Models/InformationSchemaTable.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `trans` (8 occorrenze)

**Moduli coinvolti:** Lang, Media, Tenant, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Collection/TransCollectionAction.php`
- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource.php`
- `./laravel/Modules/Xot/app/Filament/Traits/TransTrait.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getHeading` (8 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/Pages/XotBasePage.php`
- `./laravel/Modules/Xot/app/Filament/Traits/NavigationPageLabelTrait.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/ModelTrendChartWidget.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/StatesChartWidget.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseChartWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getData` (8 occorrenze)

**Moduli coinvolti:** Lang, UI, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Widgets/ModelTrendChartWidget.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/StatesChartWidget.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseChartWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `format` (8 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/ErrorFormatterContract.php`
- `./laravel/Modules/Xot/app/Contracts/PdfBuilderContract.php`
- `./laravel/Modules/Xot/app/Exceptions/Formatters/WebhookErrorFormatter.php`
- `./laravel/Modules/Xot/app/Services/Trend/Adapters/AbstractAdapter.php`
- `./laravel/Modules/Xot/app/Services/Trend/Adapters/MySqlAdapter.php`
- `./laravel/Modules/Xot/app/Services/Trend/Adapters/PgsqlAdapter.php`
- `./laravel/Modules/Xot/app/Services/Trend/Adapters/SqliteAdapter.php`
- `./laravel/Modules/Xot/app/Support/PdfBuilderAdapter.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `failed` (8 occorrenze)

**Moduli coinvolti:** DbForge, Job, Notify, Xot

**File in Xot:**

- `./laravel/Modules/Xot/database/factories/HealthCheckResultHistoryItemFactory.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `status` (7 occorrenze)

**Moduli coinvolti:** Job, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/ModelWithStatusContract.php`
- `./laravel/Modules/Xot/app/Exceptions/ApplicationException.php`
- `./laravel/Modules/Xot/app/Exceptions/JsonEncodeException.php`
- `./laravel/Modules/Xot/app/Exceptions/ModelDeletionException.php`
- `./laravel/Modules/Xot/app/Filament/Support/ColumnBuilder.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `options` (7 occorrenze)

**Moduli coinvolti:** Notify, Performance, UI, Xot

**File in Xot:**

- `./laravel/Modules/Xot/helpers/Helper.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getColumns` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni, UI, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/MainDashboard.php`
- `./laravel/Modules/Xot/app/Filament/Pages/XotBaseDashboard.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `error` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Exceptions/ApplicationException.php`
- `./laravel/Modules/Xot/app/Exceptions/JsonEncodeException.php`
- `./laravel/Modules/Xot/app/Exceptions/ModelDeletionException.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `cast` (7 occorrenze)

**Moduli coinvolti:** Ptv, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeArrayCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeBooleanCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeFloatCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeIntCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeNullableStringCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeStringCastAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `canView` (7 occorrenze)

**Moduli coinvolti:** Gdpr, Lang, UI, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Widgets/ModulesOverviewWidget.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/TestWidget.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `authorizeAccess` (7 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Ptv, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/XotBasePage.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getSlug` (6 occorrenze)

**Moduli coinvolti:** Notify, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/MainDashboard.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getResource` (6 occorrenze)

**Moduli coinvolti:** Performance, Ptv, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/Pages/XotBaseListRecords.php`
- `./laravel/Modules/Xot/app/Filament/Resources/RelationManagers/XotBaseRelationManager.php`
- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource/RelationManager/XotBaseRelationManager.php`
- `./laravel/Modules/Xot/app/Filament/Traits/HasXotFormAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPluralModelLabel` (6 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/XotBasePage.php`
- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource/RelationManager/XotBaseRelationManager.php`
- `./laravel/Modules/Xot/app/Filament/Traits/NavigationLabelTrait.php`
- `./laravel/Modules/Xot/app/Filament/Traits/NavigationPageLabelTrait.php`
- `./laravel/Modules/Xot/app/Traits/Filament/HasCustomModelLabel.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getModuleName` (6 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/XotBasePage.php`
- `./laravel/Modules/Xot/app/Filament/Resources/RelationManagers/XotBaseRelationManager.php`
- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource.php`
- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource/RelationManager/XotBaseRelationManager.php`
- `./laravel/Modules/Xot/app/Filament/Traits/TransTrait.php`
- `./laravel/Modules/Xot/app/Services/RouteService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getInstance` (6 occorrenze)

**Moduli coinvolti:** Media, Notify, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Services/ConfigService.php`
- `./laravel/Modules/Xot/app/Services/ModuleService.php`
- `./laravel/Modules/Xot/app/Services/UrlService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFormModel` (6 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/Pages/XotBasePage.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseSchemaWidget.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getConnection` (6 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Database/Migrations/XotBaseMigration.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `collection` (6 occorrenze)

**Moduli coinvolti:** Lang, Progressioni, Ptv, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Datas/ComponentFileData.php`
- `./laravel/Modules/Xot/app/Exports/CollectionExport.php`
- `./laravel/Modules/Xot/app/Exports/LazyCollectionExport.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `broadcastOn` (6 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Events/CommandOutputEvent.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `afterSave` (6 occorrenze)

**Moduli coinvolti:** Incentivi, Lang, Setting, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/ModuleResource/Pages/EditModule.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `teams` (5 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/UserContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `switchTeam` (5 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/UserContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `submit` (5 occorrenze)

**Moduli coinvolti:** Gdpr, IndennitaResponsabilita, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Widgets/EnvWidget.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `profile` (5 occorrenze)

**Moduli coinvolti:** Rating, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/UserContract.php`
- `./laravel/Modules/Xot/helpers/Helper.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `mutateFormDataBeforeSave` (5 occorrenze)

**Moduli coinvolti:** Lang, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/ModuleResource/Pages/EditModule.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `map` (5 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Exports/CollectionExport.php`
- `./laravel/Modules/Xot/app/Exports/LazyCollectionExport.php`
- `./laravel/Modules/Xot/app/Exports/QueryExport.php`
- `./laravel/Modules/Xot/app/Providers/RouteServiceProvider.php`
- `./laravel/Modules/Xot/app/Providers/XotBaseRouteServiceProvider.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `isSuperAdmin` (5 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/ProfileContract.php`
- `./laravel/Modules/Xot/app/Datas/XotData.php`
- `./laravel/Modules/Xot/app/Services/ProfileTest.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `isActive` (5 occorrenze)

**Moduli coinvolti:** Sigma, Tenant, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Filament/Support/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Models/Traits/HasCommonScopes.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getStats` (5 occorrenze)

**Moduli coinvolti:** Rating, UI, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Widgets/HealthOverviewWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getNavigationGroup` (5 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/XotBasePage.php`
- `./laravel/Modules/Xot/app/Filament/Resources/Pages/XotBaseManageRelatedRecords.php`
- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource/Pages/XotBaseManageRelatedRecords.php`
- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource/RelationManager/XotBaseRelationManager.php`
- `./laravel/Modules/Xot/app/Filament/Traits/NavigationLabelTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getNavigationBadge` (5 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Performance, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getModelLabel` (5 occorrenze)

**Moduli coinvolti:** Incentivi, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Traits/NavigationPageLabelTrait.php`
- `./laravel/Modules/Xot/app/Traits/Filament/HasCustomModelLabel.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFormFill` (5 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseSchemaWidget.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getConnectionName` (5 occorrenze)

**Moduli coinvolti:** MobilitaVolontaria, Tenant, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Models/XotBaseMorphPivot.php`
- `./laravel/Modules/Xot/app/Models/XotBasePivot.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `download` (5 occorrenze)

**Moduli coinvolti:** Incentivi, Setting, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/PdfBuilderContract.php`
- `./laravel/Modules/Xot/app/Datas/PdfData.php`
- `./laravel/Modules/Xot/app/Support/PdfBuilderAdapter.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `count` (5 occorrenze)

**Moduli coinvolti:** Pdnd, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `canAccessSocialite` (5 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/UserContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `build` (5 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Performance, Progressioni, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Mail/RecordMail.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `token` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/PassportHasApiTokensContract.php`
- `./laravel/Modules/Xot/app/Contracts/UserContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `scopeActive` (4 occorrenze)

**Moduli coinvolti:** Job, Notify, Sigma, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Models/Traits/HasCommonScopes.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `roles` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/UserContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `ownsTeam` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/UserContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `name` (4 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/PdfBuilderContract.php`
- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Filament/Support/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Support/PdfBuilderAdapter.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `message` (4 occorrenze)

**Moduli coinvolti:** Media, Performance, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Rules/DateTimeRule.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `label` (4 occorrenze)

**Moduli coinvolti:** Notify, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/StateContract.php`
- `./laravel/Modules/Xot/app/States/XotBaseState.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `infolist` (4 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/Pages/XotBaseViewRecord.php`
- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseInfolistWidget.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `icon` (4 occorrenze)

**Moduli coinvolti:** Notify, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/StateContract.php`
- `./laravel/Modules/Xot/app/States/XotBaseState.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `headings` (4 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Export/ExportXlsStreamByLazyCollection.php`
- `./laravel/Modules/Xot/app/Exports/CollectionExport.php`
- `./laravel/Modules/Xot/app/Exports/LazyCollectionExport.php`
- `./laravel/Modules/Xot/app/Exports/QueryExport.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `hasTeamPermission` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/UserContract.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasRole` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/ModelProfileContract.php`
- `./laravel/Modules/Xot/app/Contracts/ProfileContract.php`
- `./laravel/Modules/Xot/app/Contracts/UserContract.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasPermissionTo` (4 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/ModelProfileContract.php`
- `./laravel/Modules/Xot/app/Contracts/ProfileContract.php`
- `./laravel/Modules/Xot/app/Contracts/UserContract.php`
- `./laravel/Modules/Xot/app/Filament/Pages/XotBasePage.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTable` (4 occorrenze)

**Moduli coinvolti:** Job, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Database/Migrations/XotBaseMigration.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPath` (4 occorrenze)

**Moduli coinvolti:** Media, Notify, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Datas/PdfData.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getNavigationIcon` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/Pages/XotBaseEditRecord.php`
- `./laravel/Modules/Xot/app/Filament/Traits/NavigationLabelTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getModules` (4 occorrenze)

**Moduli coinvolti:** Lang, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/UserContract.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/ModulesOverviewWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getGridTableColumns` (4 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/CacheResource/Pages/ListCaches.php`
- `./laravel/Modules/Xot/app/Filament/Resources/ModuleResource/Pages/ListModules.php`
- `./laravel/Modules/Xot/app/Filament/Resources/SessionResource/Pages/ListSessions.php`
- `./laravel/Modules/Xot/app/Filament/Traits/HasXotTable.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getCurrentCommand` (4 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Services/Artisan/Handlers/CacheCommandHandler.php`
- `./laravel/Modules/Xot/app/Services/Artisan/Handlers/ErrorCommandHandler.php`
- `./laravel/Modules/Xot/app/Services/Artisan/Handlers/ModuleCommandHandler.php`
- `./laravel/Modules/Xot/app/Services/Artisan/Handlers/RouteCommandHandler.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `createToken` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/PassportHasApiTokensContract.php`
- `./laravel/Modules/Xot/app/Contracts/UserContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `color` (4 occorrenze)

**Moduli coinvolti:** Notify, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/StateContract.php`
- `./laravel/Modules/Xot/app/States/XotBaseState.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `belongsToTeam` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/UserContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `begin` (4 occorrenze)

**Moduli coinvolti:** Job, Media, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Widgets/Clock.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `updateFilters` (3 occorrenze)

**Moduli coinvolti:** Ptv, UI, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseTableWidget.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `toggleSuperAdmin` (3 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/ProfileContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `tenants` (3 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/UserContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `set` (3 occorrenze)

**Moduli coinvolti:** Lang, Seo, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Casts/PhoneCast.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `sendNotification` (3 occorrenze)

**Moduli coinvolti:** Notify, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/ModelClass/FakeSeederAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `scopeWithExtraAttributes` (3 occorrenze)

**Moduli coinvolti:** Rating, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Traits/HasSchemalessAttributes.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `registerConfig` (3 occorrenze)

**Moduli coinvolti:** Activity, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Providers/XotBaseServiceProvider.php`
- `./laravel/Modules/Xot/app/Providers/XotServiceProvider.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `rangeIntersect` (3 occorrenze)

**Moduli coinvolti:** Sigma, Xot

**File in Xot:**

- `./laravel/Modules/Xot/Services/ArrayService.php`
- `./laravel/Modules/Xot/app/Services/ArrayService.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `passes` (3 occorrenze)

**Moduli coinvolti:** Media, Performance, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Rules/DateTimeRule.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `owner` (3 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `highPriority` (3 occorrenze)

**Moduli coinvolti:** Tenant, Xot

**File in Xot:**

- `./laravel/Modules/Xot/database/factories/ModuleFactory.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `help` (3 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Exceptions/ApplicationException.php`
- `./laravel/Modules/Xot/app/Exceptions/JsonEncodeException.php`
- `./laravel/Modules/Xot/app/Exceptions/ModelDeletionException.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `has` (3 occorrenze)

**Moduli coinvolti:** Seo, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeEloquentCastAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasCombinedRelationManagerTabsWithContent` (3 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getStepByName` (3 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/Schemas/XotBaseResourceForm.php`
- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getRobots` (3 occorrenze)

**Moduli coinvolti:** Seo, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Datas/MetatagData.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getName` (3 occorrenze)

**Moduli coinvolti:** Tenant, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Forms/Components/XotBaseFormComponent.php`
- `./laravel/Modules/Xot/app/States/XotBaseState.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getModelClass` (3 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Database/Migrations/XotBaseMigration.php`
- `./laravel/Modules/Xot/app/Filament/Traits/HasRelationshipModelClass.php`
- `./laravel/Modules/Xot/app/Filament/Traits/HasXotTable.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getLocale` (3 occorrenze)

**Moduli coinvolti:** Seo, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Datas/MetatagData.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getKeywords` (3 occorrenze)

**Moduli coinvolti:** Seo, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Datas/MetatagData.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getImage` (3 occorrenze)

**Moduli coinvolti:** Seo, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Datas/MetatagData.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getHead` (3 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Exports/CollectionExport.php`
- `./laravel/Modules/Xot/app/Exports/LazyCollectionExport.php`
- `./laravel/Modules/Xot/app/Exports/QueryExport.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFacadeAccessor` (3 occorrenze)

**Moduli coinvolti:** Seo, User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Facades/Profile.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getContent` (3 occorrenze)

**Moduli coinvolti:** Media, Notify, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Datas/PdfData.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getColors` (3 occorrenze)

**Moduli coinvolti:** Seo, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Datas/MetatagData.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getCanonical` (3 occorrenze)

**Moduli coinvolti:** Seo, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Datas/MetatagData.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getAuthor` (3 occorrenze)

**Moduli coinvolti:** Seo, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Datas/MetatagData.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `fromString` (3 occorrenze)

**Moduli coinvolti:** Pdnd, Rating, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/ValueObjects/PhoneValueObject.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `extendTableCallback` (3 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `ensureDirectoryExists` (3 occorrenze)

**Moduli coinvolti:** Tenant, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/File/AssetAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `email` (3 occorrenze)

**Moduli coinvolti:** Notify, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Filament/Support/ColumnBuilder.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `creator` (3 occorrenze)

**Moduli coinvolti:** Media, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Traits/Updater.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `configure` (3 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/Schemas/XotBaseResourceForm.php`
- `./laravel/Modules/Xot/app/Filament/Resources/Schemas/XotBaseResourceInfolist.php`
- `./laravel/Modules/Xot/app/Filament/Resources/Tables/XotBaseResourceTable.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `clients` (3 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/PassportHasApiTokensContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `clearCache` (3 occorrenze)

**Moduli coinvolti:** Job, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Services/Artisan/Handlers/CacheCommandHandler.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `authId` (3 occorrenze)

**Moduli coinvolti:** Tenant, Xot

**File in Xot:**

- `./laravel/Modules/Xot/helpers/Helper.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `assignRole` (3 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/ModelProfileContract.php`
- `./laravel/Modules/Xot/app/Contracts/ProfileContract.php`
- `./laravel/Modules/Xot/app/Contracts/UserContract.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `__call` (3 occorrenze)

**Moduli coinvolti:** Seo, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Exceptions/Handlers/HandlerDecorator.php`
- `./laravel/Modules/Xot/app/View/Composers/XotComposer.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `indexExists` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Query/CreateTableIndexByModelClassColumnsAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getTableFiltersFormColumns` (2 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Traits/HasXotTable.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `withBrowsershot` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/PdfBuilderContract.php`
- `./laravel/Modules/Xot/app/Support/PdfBuilderAdapter.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `withAccessToken` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/PassportHasApiTokensContract.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `validateForPassportPasswordGrant` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/UserContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `validateColumnsExist` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Query/CreateTableIndexByModelClassColumnsAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `updater` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Traits/Updater.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `updatedAt` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Filament/Support/ColumnBuilder.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `updateUser` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Database/Migrations/XotBaseMigration.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `translatableComponents` (2 occorrenze)

**Moduli coinvolti:** Lang, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Providers/XotServiceProvider.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `transFunc` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Traits/TransFuncTrait.php`
- `./laravel/Modules/Xot/app/Filament/Traits/TransTrait.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `tokens` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/PassportHasApiTokensContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `tokenCan` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/PassportHasApiTokensContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `toJson` (2 occorrenze)

**Moduli coinvolti:** Pdnd, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Exceptions/ApplicationError.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `title` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Filament/Support/ColumnBuilder.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `timestamps` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Filament/Support/ColumnBuilder.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `slug` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Filament/Support/ColumnBuilder.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `siblings` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `siblingsAndSelf` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `showRouteList` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Services/Artisan/Handlers/RouteCommandHandler.php`
- `./laravel/Modules/Xot/app/Services/ArtisanService.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `sendEmailCallback` (2 occorrenze)

**Moduli coinvolti:** Notify, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/ModelContactContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `scopeInactive` (2 occorrenze)

**Moduli coinvolti:** Job, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Models/Traits/HasCommonScopes.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `rootAncestor` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `rootAncestorOrSelf` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `resolveView` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseInfolistWidget.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `replaceClass` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Console/Commands/GenerateModelClassCommand.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `removeRole` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/UserContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `registerMyMiddleware` (2 occorrenze)

**Moduli coinvolti:** Gdpr, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Providers/RouteServiceProvider.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `registerLang` (2 occorrenze)

**Moduli coinvolti:** Lang, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Providers/RouteServiceProvider.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `registerCommands` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Providers/XotBaseServiceProvider.php`
- `./laravel/Modules/Xot/app/Providers/XotServiceProvider.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `registerBladeComponents` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Providers/XotBaseServiceProvider.php`
- `./laravel/Modules/Xot/app/Providers/XotBaseThemeServiceProvider.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `query` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Database/Migrations/XotBaseMigration.php`
- `./laravel/Modules/Xot/app/Exports/QueryExport.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `publishedAt` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Filament/Support/ColumnBuilder.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `provides` (2 occorrenze)

**Moduli coinvolti:** Seo, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Providers/XotBaseServiceProvider.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `parent` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `parentAndSelf` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `normalizeRow` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Exports/LazyCollectionExport.php`
- `./laravel/Modules/Xot/app/Exports/QueryExport.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `normalizeConnectionName` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Models/XotBaseMorphPivot.php`
- `./laravel/Modules/Xot/app/Models/XotBasePivot.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `newEloquentBuilder` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Contracts/ModelProfileContract.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `modalHeading` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/StateContract.php`
- `./laravel/Modules/Xot/app/States/XotBaseState.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `modalFormSchema` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/StateContract.php`
- `./laravel/Modules/Xot/app/States/XotBaseState.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `modalFillFormByRecord` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/StateContract.php`
- `./laravel/Modules/Xot/app/States/XotBaseState.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `modalDescription` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/StateContract.php`
- `./laravel/Modules/Xot/app/States/XotBaseState.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `modalActionByRecord` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/StateContract.php`
- `./laravel/Modules/Xot/app/States/XotBaseState.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `metatag` (2 occorrenze)

**Moduli coinvolti:** UI, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/View/Composers/XotComposer.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `mapWebRoutes` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Providers/RouteServiceProvider.php`
- `./laravel/Modules/Xot/app/Providers/XotBaseRouteServiceProvider.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `mapApiRoutes` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Providers/RouteServiceProvider.php`
- `./laravel/Modules/Xot/app/Providers/XotBaseRouteServiceProvider.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `isValidConnection` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Query/GetFieldnamesByTablenameAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `isPublished` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Models/Traits/HasCommonScopes.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `isIntegerAttribute` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `isFilamentAdminRequest` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Http/Middleware/FilamentMemoryMonitorMiddleware.php`
- `./laravel/Modules/Xot/app/Providers/FilamentOptimizationServiceProvider.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `increase` (2 occorrenze)

**Moduli coinvolti:** Notify, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/ModelContactContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `inAdmin` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Services/RouteService.php`
- `./laravel/Modules/Xot/helpers/Helper.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `importTablesIntoMySQL` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Console/Commands/ImportMdbToMySQL.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `image` (2 occorrenze)

**Moduli coinvolti:** Media, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Support/ColumnBuilder.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `id` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Filament/Support/ColumnBuilder.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `hasNonEmptyAttribute` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeAttributeCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeEloquentCastAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasNestedPath` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasAttribute` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeAttributeCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeEloquentCastAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasAttributeValue` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeAttributeCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeEloquentCastAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasAnyRole` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/ModelProfileContract.php`
- `./laravel/Modules/Xot/app/Contracts/ProfileContract.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `handleCommandStarted` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/ArtisanCommandsManager.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `handleCommandOutput` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/ArtisanCommandsManager.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `handleCommandFailed` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/ArtisanCommandsManager.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `handleCommandError` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/ArtisanCommandsManager.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `givePermissionTo` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/ModelProfileContract.php`
- `./laravel/Modules/Xot/app/Contracts/ProfileContract.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getWizardSubmitAction` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getValidatedAttribute` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeAttributeCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeEloquentCastAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTypedAttribute` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeAttributeCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeEloquentCastAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTenantClass` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Datas/XotData.php`
- `./laravel/Modules/Xot/app/Services/XotService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTableSearch` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Traits/HasXotTable.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseTableWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTableRecordTitleAttribute` (2 occorrenze)

**Moduli coinvolti:** Incentivi, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Traits/HasXotTable.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTablePaginated` (2 occorrenze)

**Moduli coinvolti:** Incentivi, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Traits/HasXotTable.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTableHeading` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/Pages/XotBaseManageRelatedRecords.php`
- `./laravel/Modules/Xot/app/Filament/Traits/HasXotTable.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getStub` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Console/Commands/GenerateModelClassCommand.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getStringAttribute` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeAttributeCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeEloquentCastAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getSteps` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/Schemas/XotBaseResourceForm.php`
- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getRouteParameters` (2 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Xot

**File in Xot:**

- `./laravel/Modules/Xot/helpers/Helper.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getResourceSlug` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Traits/HasTableFunctionsTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getQualifiedParentKeyName` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getQualifiedLocalKeyName` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPluralLabel` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Traits/NavigationLabelTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPathSeparator` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPathName` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getParentKeyName` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getNotificationData` (2 occorrenze)

**Moduli coinvolti:** Notify, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/States/Transitions/XotBaseTransition.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getLocalKeyName` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getKeyTrans` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource.php`
- `./laravel/Modules/Xot/app/Filament/Traits/TransTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getKeyTransFunc` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Traits/TransFuncTrait.php`
- `./laravel/Modules/Xot/app/Filament/Traits/TransTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getIntAttribute` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeAttributeCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeEloquentCastAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getHeight` (2 occorrenze)

**Moduli coinvolti:** Media, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Widgets/XotBaseChartWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFormSchemaColumns` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Resources/Schemas/XotBaseResourceForm.php`
- `./laravel/Modules/Xot/app/Filament/Resources/XotBaseResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFloatAttribute` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeAttributeCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeEloquentCastAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFirstPathSegment` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFilename` (2 occorrenze)

**Moduli coinvolti:** Lang, Xot

**File in Xot:**

- `./laravel/Modules/Xot/helpers/Helper.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getExpressionName` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getEasterDate` (2 occorrenze)

**Moduli coinvolti:** Notify, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Theme/GetThemeContextAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getDepthName` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getDefaultNamespace` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Console/Commands/GenerateModelClassCommand.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getCustomPaths` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getColumnDefinitions` (2 occorrenze)

**Moduli coinvolti:** Notify, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Traits/EnumTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getBreadcrumb` (2 occorrenze)

**Moduli coinvolti:** Activity, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Traits/Filament/HasCustomModelLabel.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getBooleanAttribute` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeAttributeCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeEloquentCastAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getBlockSchema` (2 occorrenze)

**Moduli coinvolti:** UI, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Blocks/XotBaseBlock.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getAvatarUrl` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/ProfileContract.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getArrayAttribute` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeAttributeCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeEloquentCastAction.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getAct` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Services/RouteDynService.php`
- `./laravel/Modules/Xot/app/Services/RouteService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `generateIndexName` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Query/CreateTableIndexByModelClassColumnsAction.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `fromHtml` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Pdf/ContentPdfAction.php`
- `./laravel/Modules/Xot/app/Datas/PdfData.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `fixType` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Arr/DiffAssocRecursiveAction.php`
- `./laravel/Modules/Xot/app/Actions/Array/DiffAssocRecursiveAction.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `findForPassport` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/UserContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `exportTablesToSQL` (2 occorrenze)

**Moduli coinvolti:** DbForge, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Console/Commands/ImportMdbToMySQL.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `executeWithRange` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeFloatCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeIntCastAction.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `executeOptimized` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/AI/Ollama/ChatOllamaAction.php`
- `./laravel/Modules/Xot/app/Actions/AI/Ollama/GenerateOllamaAction.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `executeMinimal` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/AI/Ollama/ChatOllamaAction.php`
- `./laravel/Modules/Xot/app/Actions/AI/Ollama/GenerateOllamaAction.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `executeCommand` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Pages/ArtisanCommandsManager.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `diff_assoc_recursive` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/Services/ArrayService.php`
- `./laravel/Modules/Xot/app/Services/ArrayService.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `description` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Filament/Support/ColumnBuilder.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `descendants` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `descendantsAndSelf` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `ddFile` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Filament/GenerateFormByFileAction.php`
- `./laravel/Modules/Xot/app/Actions/Filament/GenerateTableColumnsByFileAction.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `createdAt` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Builders/ColumnBuilder.php`
- `./laravel/Modules/Xot/app/Filament/Support/ColumnBuilder.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `children` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `childrenAndSelf` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `castWithRange` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeFloatCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeIntCastAction.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `canCast` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Actions/Cast/SafeArrayCastAction.php`
- `./laravel/Modules/Xot/app/Actions/Cast/SafeBooleanCastAction.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `bloodline` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `bgColor` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/StateContract.php`
- `./laravel/Modules/Xot/app/States/XotBaseState.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `base64` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/PdfBuilderContract.php`
- `./laravel/Modules/Xot/app/Support/PdfBuilderAdapter.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `avatar` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Filament/Support/ColumnBuilder.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `asset` (2 occorrenze)

**Moduli coinvolti:** UI, Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/View/Composers/XotComposer.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `ancestors` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `ancestorsAndSelf` (2 occorrenze)

**Moduli coinvolti:** Xot

**File in Xot:**

- `./laravel/Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`
- `./laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php`

[Riflessione: Duplicato interno al modulo Xot — valutare estrazione in trait di modulo o classe base]

---

## Riflessioni per Xot

- **Totale metodi duplicati che coinvolgono Xot:** 251
- **Di cui cross-modulo:** 148
- **Di cui interni al modulo:** 103

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 192 metodi
- **altro:** 59 metodi

### Moduli con maggiori duplicazioni incrociate

- **User:** 128 metodi in comune
- **Notify:** 45 metodi in comune
- **Seo:** 27 metodi in comune
- **Tenant:** 25 metodi in comune
- **Ptv:** 23 metodi in comune
- **Job:** 21 metodi in comune
- **UI:** 19 metodi in comune
- **Media:** 18 metodi in comune
- **Lang:** 16 metodi in comune
- **DbForge:** 15 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
