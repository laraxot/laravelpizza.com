---
title: "Audit prestazionale statico — tutti i moduli"
type: audit
status: active
tags: [performance, audit, n-plus-one, eloquent, filament, cache, queue]
qmd: "performance audit statico moduli laravel filament n+1 accessor scrittura cache"
---

# Audit prestazionale statico — moduli Laraxot

Analisi statica del codice (nessun benchmark). Ambito: `laravel/Modules/*` (18 moduli,
~12.100 file PHP). Impatto stimato: **alto** = degrada linearmente/quadraticamente con
la dimensione dei dati in percorsi caldi; **medio** = costo su dataset medi o path non
frequenti; **basso** = costo limitato o mitigato.

## Sintesi esecutiva

Il collo di bottiglia strutturale del progetto è il **pattern "accessor che calcola e
scrive"** concentrato in `Ptv`/`Sigma` (SchedaMutator: 70 accessor, ~35 con
`update()`/`save()`/`firstOrCreate()` a ogni read) e la pipeline **TrovaEsclusi /
Check criteri** che materializza un'intera annata di schede e itera
scheda × criterio con query SQL per cella. A ciò si aggiungono N+1 classici nelle
Action bulk di `Performance`/`IndennitaCondizioniLavoro`, `whereRaw` non sargable
(`find_in_set`, `SUBSTR`, `year()`) su tabelle Sigma quasi prive di indici, e cache
essenziamente assente (6 occorrenze di `Cache::remember` su tutto il codebase).

## Finding per categoria

### 1. N+1 — relazioni in loop / collezioni senza eager loading

| # | File:riga | Pattern | Impatto | Rimedio |
|---|-----------|---------|---------|---------|
| N1 | `Performance/app/Actions/Organizzativa/CopyValutatoreIdFromIndividualeAction.php:36-44` | `foreach` su `Organizzativa::where()->get()` + `Individuale::where(4 colonne)->first()` + `save()` per riga | **alto** | `whereIn`/join + `update` bulk o upsert; caricare mappa `matr→valutatore_id` una volta |
| N2 | `Performance/app/Actions/Individuale/UpdateImportoTotaleByValutatoreIdAction.php:52-56` | `foreach` schede + `TotValutatoreId::where()->first()` per riga | **alto** | Pre-caricare `TotValutatoreId` in mappa per `valutatore_id` |
| N3 | `Performance/app/Filament/Actions/Header/CopyFromOrganizzativaAction.php:75-95` | `foreach` + `Individuale::where($where)->get()` + `create()`/`update()` per riga | **alto** | Stessa mappa; `upsert()` SQL |
| N4 | `Performance/app/Filament/Actions/Header/CopyFromIndividualeAction.php` (gemello) | idem | **alto** | idem |
| N5 | `IndennitaCondizioniLavoro/app/Actions/ReplicateIndennita.php:41-56` | `->get()` + per riga `$row->indennitaTipoDettaglio` (relazione lazy, 2 accessi = 2 query) + `sync()` | **medio-alto** | `->with('indennitaTipoDettaglio')` sulla query; sync in chunk |
| N6 | `IndennitaCondizioniLavoro/app/Models/CondizioniLavoro.php:442-530` e `ServizioEsterno.php:348-530` | `foreach ($rows0->get())` + `firstOrCreate` + query `qua00f` con `whereRaw` date-range **per riga** | **alto** | Eager/pre-fetch qua00f per chiavi; spostare in job |
| N7 | `Progressioni/app/Actions/TrovaEsclusiAction.php:52-70` (deprecated ma attivo nei test) | `Scheda::where()->get()` + `save()` per scheda; `checkScheda` rilancia query criteri se non passati | **medio** | Usare pipeline Ptv; chunking |
| N8 | `Incentivi/app/Filament/Resources/EmployeeResource/Actions/UploadEmpoyeesAction.php:43-56` | `foreach` + `Employee::updateOrCreate()` per riga (2 query/riga) | **medio** | `upsert()` batch o `insert ... on duplicate key` |
| N9 | `Incentivi/app/Filament/Resources/ProjectResource/Pages/ManageProjectEmployees.php:110,140` e `PdfDownloadController.php:106` | `activities()->with('employees')->get()` ok, ma poi iterazioni PHP su relazioni figlie non verificate | **basso-medio** | Verificare `->with('employees.x')` per i campi usati |
| N10 | `Xot/app/Actions/ModelClass/CopyFromLastYearAction.php:25-39` | Due `->get()` di annate intere in memoria + `save()` per riga | **medio** | `chunkById`, `insert` bulk |
| N11 | `Rating/app/Models/Traits/HasRating.php:27-42,95-132` | `ratings()->where()->get()` e `->count()` ripetuti per opzioni in loop | **medio** | `withCount`/una query aggregata |
| N12 | Filament: `Ptv/.../AnagResource/RelationManagers/Qua00fRelationManager.php:30-60` | Colonne `_gg`, `_gg_cateco` con `default(fn → $record->gg([...]))`: **una query Sigma per cella** | **alto** | Pre-aggregare in `with`/subquery o disabilitare in lista |
| N13 | Filament: `Ptv/.../CriteriEsclusioneColumn.php:44` + `BaseSchedaResource` (nessun `getEloquentQuery`) | `getStateUsing` legge `$record->criteriEsclusione` → N+1 per pagina lista | **medio** | `->with('criteriEsclusione')` in `getEloquentQuery` della Resource |

### 2. Query — `get()`/`all()` senza limiti, count in loop, full-scan

| # | File:riga | Pattern | Impatto | Rimedio |
|---|-----------|---------|---------|---------|
| Q1 | `Xot/app/Filament/Actions/Header/SanitizeFieldsHeaderAction.php:35-60` | `$modelClass::query()->get()` = **intera tabella in memoria** + `save()` per riga sporca | **alto** | `chunkById(500)` + `saveQuietly` dove possibile |
| Q2 | `Xot/app/Actions/Export/XlsByModelClassAction.php:56` | `$query->get()` senza limite per export XLS | **medio-alto** | Usare `ExportXlsByLazyCollection`/`cursor()` |
| Q3 | `Progressioni/app/Filament/Resources/CedDiffResource/Tables/CedDiffsTable.php:47` e `Pages/ListCedDiffs.php:65` | `CedDiff::all()->pluck('matricola')` per popolare filtro — full table scan a ogni render | **medio-alto** | `distinct()->pluck()` con `where` anno, o tabella lookup |
| Q4 | `Incentivi/.../ProjectForm.php:89,97`, `AttachSingleEmployeeAction.php:28`, `AttachGroupAction.php:21,31` | `Employee::all()`, `Workgroup::all()` per `->options()` | **medio** | `->searchable()->getSearchResultsUsing()` o limit |
| Q5 | `Notify/.../SendSmsPage.php:95`, `SendSpatieEmailPage.php:82` | `MailTemplate::all()` per select | **basso** | piccolo; ok se tabella resta piccola |
| Q6 | `Ptv/app/Actions/TrovaEsclusiByYearAction.php` e `Ptv/app/Actions/Scheda/TrovaEsclusiByModelClassYearAction.php:29-31` | `inRandomOrder()->get()` — carica **tutte** le schede di un anno in RAM | **alto** | `chunkById` + processing per chunk |
| Q7 | `Sigma/app/Models/Traits/Extras/FunctionExtra.php:268-290` (`updateFieldQuaRepForm`) | `self::where('anno')->get()` + `map` con accessor che interrogano relazioni | **medio-alto** | Solo path batch; va in job + chunk |
| Q8 | `IndennitaResponsabilita/app/Actions/Populate.php:32-80` | `->get()` annata + `firstOrCreate` per riga + query `valutatore_id=id` | **medio** | Lookup mappa + `insertOrIgnore` |
| Q9 | `Activity/app/Models/Activity.php:75` (`typedGet`) | Filtra `instanceof` in PHP invece di `where` | **basso** | `where` su type nel query builder |
| Q10 | `Activity/app/Actions/ActivityLogger.php:245-275` | `count()` + `groupBy(event)->get()` + `count()` "today" = 3 query su `activity_log` (tabella che cresce) a ogni render widget | **medio** | `Cache::remember` 1-5 min o view aggregata |

### 3. Accessor che scrivono (read → write)

Pattern noto del progetto: `get*Attribute()` calcola da relazioni Sigma e persiste il
risultato con `update()`/`save()`/`firstOrCreate()`. **Ogni read = 1+ SELECT + 1
UPDATE**; in liste, form, PDF e export l'impatto è moltiplicato per riga.

**Censimento principale — `Ptv/app/Models/Traits/Mutators/SchedaMutator.php`**
(3.278 righe, 70 accessor `get*Attribute`, **~35 con scrittura**):

`getCodquaAttribute` (r.90-140, include helper `getCodqua()` con `$this->update()`),
`getCodquaTxtAttribute` (r.161), `getContAttribute` (r.209), `getDisci1Attribute`
(r.246), `getDisci1TxtAttribute` (r.310), `getEtaAttribute` (r.380),
`getGgAnnoAttribute` (r.435/490), `getGgAszCatecoPosfunInSedeAttribute` (r.557),
`getGgEsperienzaNoAszAttribute` (r.624), `getGgIntegParamsAttribute` (r.865),
`getGgIntegParamsNoAszAttribute` (r.1218), `getPercParttimepond*Attribute` (r.1359,
1554, 1597), `getPosfunvalAttribute` (r.1658), `getPosizioneEcoAttribute` (r.1836),
`getProproAttribute` (r.1913), `getPosfunAttribute` (r.1959), `getTipcoAttribute`
(r.2080), `getExcellencesCountLast3yearsAttribute` (r.2231), `getGgFuoriSedeAttribute`
(r.2305), `getGgInSedeAttribute` (r.2326), `getGgInSedeNoAszAttribute` (r.2339),
`getGgPresenzaAnnoAttribute` (r.2408), `getPerfIndCountLast3YearsAttribute` (r.2570),
`getValutatoreIdAttribute`, `getDalAttribute`, `getAlAttribute`, `getTypeAttribute`.

Altri censiti con lo stesso pattern (conteggio approssimato via regex):

| File | Accessor con write (stima) |
|------|---------------------------|
| `IndennitaCondizioniLavoro/app/Models/Traits/ServizioEsternoMutatorsTrait.php` | ~6 (es. `update` a r.144, accessor `gg_assenza_anno`) |
| `IndennitaCondizioniLavoro/app/Models/Traits/CondizioniLavoroMutatorsTrait.php` | ~4 |
| `Incentivi/app/Models/Traits/StabiDirigenteMutatorsTrait.php`, `EmployeeMutatorsTrait.php`, `ActivityMutatorsTrait.php` | alcuni |
| `Performance/app/Models/Traits/MutatorTrait.php` | ~3 |
| `IndennitaResponsabilita/app/Models/LettI.php` (r.500,518,583,653) e `LettF.php` (r.540,586,655,701) | ~8 (`update` dentro accessor) |
| `Sigma/app/Models/Traits/Mutators/EnteMatrAnnoMutator.php` | `getPercPTimeYearAttribute` (r.23-37) e simili: `->update()` in `withoutEvents` |
| `Sigma/app/Models/Traits/Mutators/EnteMatrDateRangeMutator.php`, `PostTypeWorkerCategoryAccessor.php`, `IntegparamMutator.php` ecc. | pattern ricorrente |

**Impatto: ALTO.** Una `ListRecords` Filament di 25 schede può generare centinaia di
UPDATE. In `EnteMatrAnnoMutator::getPercPTimeYearAttribute` il write è wrappato in
`withoutEvents` ma resta un UPDATE per ogni istanza letta.

**Rimedio:** spostare i calcoli in azione esplicita (`Refresh*Action`, job di
notte) e rendere gli accessor read-only (ritornare il valore senza persistere);
se la persistenza serve, farla solo quando `getKey() !== null` **e** il valore è
stale, con dirty-check prima di `update` (alcuni lo fanno già parzialmente).

### 4. Cache

- `Cache::remember` presente in **6 punti soltanto**: `Xot/.../GetNavigationItemByModulename.php:131`,
  `GetModulesNavigationItems.php:130`, `StateOverviewWidget.php:95`,
  `Activity/.../GetActivityStatisticsAction.php:37`, `Job/.../ScheduleService.php:53`
  (`rememberForever`).
- **Assente** su: opzioni/form lookup (`GetValutatoriOptions.php:62`,
  `GetAllValutatoriOptions.php:31`, `GetValutatoriOptionsByWhere.php:63` —
  `whereRaw('valutatore_id = id')` eseguito a **ogni render di form**),
  liste propro/`HasCategoriaPropro` (`find_in_set` per riga),
  `stabi_opts()` (`Progressioni/app/Models/Scheda.php:761`), `CriteriOption`/
  `CriteriEsclusione` per anno (ricaricati in `Check` per ogni scheda? no — ma
  `checkScheda` li ricarica se non passati).
- `ScheduleService::getActiveSchedules` usa `rememberForever` — bene, ma verificare
  invalidazione su modifiche schedule.

**Impatto: medio-alto** (lookup ripetuti per riga/render). **Rimedio:** `Cache::remember`
con chiave `(modulo, anno, campo)` su opzioni e mappe propro; tag-cache se disponibili.

### 5. Job / Queue

- **Positivo:** `Notify` notifications implementano `ShouldQueue`
  (`RecordNotification`, `SmsNotification`, `TelegramNotification`, `GenericNotification`,
  `ThemeNotification`); `QueueableAction` (Spatie) usato su quasi tutte le Action.
- **Da verificare:** `SendRecordsNotificationAction` itera record × canali
  sincronicamente (`Notify/app/Actions/SendRecordsNotificationAction.php:44-80`):
  se il chiamante non fa `->onQueue()`, l'invio bulk è sincrono (la notification
  interna è queued, ma il loop e la risoluzione destinatario sono sync).
- **Operazioni pesanti sincrone:** `TrovaEsclusiByModelClassYearAction`,
  `FunctionExtra::updateFieldQuaRepForm`, `Update*` Performance (una decina di
  Action), `Populate`, `ReplicateIndennita`, export XLS — nessuna evidenza di
  dispatch su queue nei Filament header action (verificare `->onQueue()`).
- **Chunking quasi assente:** solo 8 occorrenze di `chunk/lazy/cursor` nel codebase
  (`Xot/.../FakeSeederAction.php`, `Job/.../Task::autoCleanup()` che fa delete
  chunked da 50 — positivo). `ExportXlsLazyAction` usa `cursor()` ma vedi Q11.

### 6. Filament — tabelle, filtri, ordinamenti

- **Nessun `getEloquentQuery()->with()`** fuori dal boilerplate `User` (OAuth/Teams).
  Le Resource di business (`SchedaResource`, `CondizioniLavoroResource`, `LettI/F`,
  `Individuale/Organizzativa` Performance) ereditano la query base senza eager load:
  ogni colonna calcolata/relation = query extra per riga.
- `ExportXlsLazyAction.php:55-62`: `$lazy->count()` poi `$lazyCursor->count()` —
  `LazyCollection::count()` **itera l'intero result set**; poi `map` itera di nuovo.
  Totale: 2 count-query + fino a 3 passate complete. **Impatto medio-alto** su export
  >3000 righe. Rimedio: un'unica `cursor()` e contatore durante il dump.
- `Notify/.../NotificationsTable.php` e `NotificationLogsTable.php`: `sortable()` su
  `notifiable_type`, `notifiable_id`, `type` — su tabelle Laravel notifications che
  crescono molto; indici compositi da verificare.
- Relation managers `Ptv/AnagResource` (Qua00f/Qua03f/AszEff): colonne calcolate con
  query per cella (vedi N12).
- Filtri `find_in_set` in `RelationshipTrait` (Performance, IndennitaResponsabilita,
  Progressioni, Ptv `HasCategoriaPropro`): relazioni `hasOne/hasMany` con
  `whereRaw('find_in_set(?, lista_propro)')` → **full scan** ogni volta che la
  relazione viene risolta (incluse liste e form).

### 7. Query non sargable (whereRaw)

105 occorrenze di `whereRaw` (non-test). Le più costose:

- `find_in_set(?, lista_propro)` — **20 file**: `Sigma/app/Support/FunctionExtraQuery.php`,
  `Sigma/app/Models/{Asz00f,Asz00k1}.php`, `Traits/Mutators/{Qua00f,Qua03f}Mutator.php`,
  `MassExtra.php`, `GgFilterData.php`, `BaseAsz00f.php`, `Ptv/.../HasCategoriaPropro.php:38`,
  `Performance/.../RelationshipTrait.php:106`, `OrganizzativaRelationship.php:31`,
  `Progressioni/.../ProgressioniFunctionTrait.php:328`, `IndennitaResponsabilita/.../RelationshipTrait.php:86,126`.
  `lista_propro` è una CSV → `find_in_set` non usa indici: full scan per join logico.
- `SUBSTR(q3fun,-1)=?` — `Sigma/.../FunctionExtra.php:150` (ggFuoriSedeTot).
- `id=valutatore_id` / `valutatore_id = id` — self-join raw in `IndennitaResponsabilita/.../Populate.php:42`,
  `MakePdfByRecord.php:31`, `Ptv/.../GetValutatoriOptions*.php`, `ValutatoreSelectColumn.php:56`,
  `SelectValutatore.php:75`, `ImportValutatoriAction.php:263`, `Ptv/.../MakePdfAction.php:127`,
  `FixValutatoreIdByAnno.php:41`.
- `year(rep2kd)` / `repann=""` — `IndennitaCondizioniLavoro/.../CondizioniLavoro.php:430-445`,
  `Progressioni/.../Scheda.php:1045-1055`, `Ptv/.../GetWorkersByYear.php:34-40`,
  `StabiDirigenteMutator.php:51`, `LettI.php:697`, `LettF.php:442-472`.
- Correlated UPDATE con `find_in_set` — `Performance/.../UpdateQuotaTeoricaAction.php:71,81,122,161`
  (Individuale + gemelli Organizzativa), `Ptv/.../UpdateQuotaTeoricaAction.php`,
  `Progressioni/.../Scheda.php::updatePeso()` (r.~920, SQL con `find_in_set` in
  sottoquery per ogni campo peso), `updateVincitori()` (r.~876-895: update +
  `groupBy()->limit()->update()` per categoria).

**Impatto: alto** sulle tabelle Sigma (rep00f, qua00f, qua03f, asz00k1 — le più
grandi del sistema). **Rimedio:** normalizzare `lista_propro` in tabella pivot
(`scheda_propro`), o aggiungere colonna generata/`FIND_IN_SET` solo se indicizzata
non è possibile → almeno `where` su anno prima del join; verificare indici su
`(anno, ente, matr)` e date `qua2kd/qua2ka`.

### 8. Indici (stima)

- Migrazioni Sigma+Ptv: ~28 occorrenze di `index(`/`unique(` su centinaia di file
  (Sigma e Ptv contengono molte tabelle data-warehouse: rep00f, qua00f, qua03f,
  asz00k1, anag). **Stima: indici assenti o incompleti** sulle chiavi di join
  `(ente, matr, anno)`, `(qua2kd, qua2ka)`, `(stabi, repar, anno)` e sulle colonne
  filtrate `ha_diritto`, `type`, `vincitore`. Da verificare tabella per tabella:
  priorità `schede` (Ptv/Performance/Progressioni/Indennita*), `rep00f`, `qua00f`.

## Cosa funziona già (non toccare)

- `IndennitaCondizioniLavoro/.../GetFlussoIndennitaRowsAction.php`: aggregazione
  interamente in SQL (join + GROUP BY) — modello da seguire. Nota: `pluck` di tutti
  gli id poi `whereIn` può superare i limiti DB con filtri larghi → valutare
  sottoquery `whereIn` o join diretto.
- `Job/app/Models/Task.php::autoCleanup()`: delete chunked da 50.
- `Job/.../ScheduleService.php`: `rememberForever` sulle schedule attive.
- `Notify`: `ShouldQueue` sulle notification.
- `Xot/.../GetModulesNavigationItems.php`, `GetNavigationItemByModulename.php`:
  cache 10 min sulla navigazione.

## Top-10 priorità

1. **SchedaMutator: disaccoppiare write da read** (~35 accessor scrivono) —
   `Ptv/app/Models/Traits/Mutators/SchedaMutator.php`. Ogni tabella/lista/form/PDF
   paga UPDATE per riga. **Alto.**
2. **Pipeline TrovaEsclusi**: `inRandomOrder()->get()` di annata intera +
   `Check` con `app()` resolve per criterio × `CheckCriterio::getSchedaCollection()`
   (O(criteri×schede) query) + `save()` per scheda.
   `Ptv/.../TrovaEsclusiByModelClassYearAction.php:29`, `Check.php:32-58`,
   `CheckCriterio.php:45`, `BaseCriteriEsclusione.php:122-126`. **Alto.**
3. **`find_in_set(lista_propro)` non sargable** in 20 file su tabelle Sigma —
   normalizzare o indicizzare. **Alto.**
4. **UPDATE raw correlati con `find_in_set`/`substr`**:
   `Performance/.../UpdateQuotaTeoricaAction.php` (4 statement), gemelli
   Organizzativa, `Progressioni/.../Scheda::updatePeso/updateVincitori`. **Alto.**
5. **N+1 bulk Performance**: `CopyValutatoreIdFromIndividualeAction.php:36`,
   `UpdateImportoTotaleByValutatoreIdAction.php:52`, `CopyFromOrganizzativaAction.php:75`
   (+ gemelli Individuale). **Alto.**
6. **Eager loading Filament assente** sulle Resource di business + colonna
   `CriteriEsclusioneColumn` e RM `Qua00fRelationManager` con query per cella.
   **Alto** sulle liste schede. **Alto.**
7. **`SanitizeFieldsHeaderAction` carica l'intera tabella** e fa `save()` per riga —
   `Xot/.../SanitizeFieldsHeaderAction.php:35`. **Alto** se usato su tabella grande.
8. **`::all()`/`->get()` senza limiti in path caldi**: `CedDiff::all()` nei filtri
   Progressioni, `Employee::all()`/`Workgroup::all()` in Incentivi, `XlsByModelClassAction`
   export. **Medio-alto.**
9. **Cache assente sui lookup statici** (valutatori/propro/opzioni) ricalcolati a
   ogni form render e per riga; `ActivityLogger` 3 count su `activity_log`. **Medio.**
10. **Chunking/lazy assente** sui batch (Populate, ReplicateIndennita, CopyFromLastYear,
    export >3000) e `ExportXlsLazyAction` che conta/itera 3 volte. **Medio.**

## Note metodologiche

- Analisi solo su `app/`/`database/`/`resources/` dei moduli; test esclusi.
- `Notify/` (556M) include asset/vendor non PHP di rilevanza per l'audit.
- Le stime di "righe" si riferiscono al file allo stato attuale; il codice muta
  velocemente (moduli Prefect/Enti con mutator gemelli).
- Verifica consigliata prima di interventi: `EXPLAIN` sulle query `find_in_set` e
  conteggio reale delle righe tabelle Sigma per calibrare priorità 3-4.
