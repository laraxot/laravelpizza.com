---
title: "Regole di estensione XotBase"
type: rule
status: active
module: Xot
qmd: "xotbase extension rules filament extends XotBaseResource XotBaseWidget XotBasePage XotBaseListRecords arch test famiglie XotBaseSchemaWidget formClass schemaMethod resolveResourcePartClass XotBaseManageRelatedRecords GetRelatedResourceClassAction HasXotTable header actions RecordAnchor return_to XotBasePolicy moduleAdminRole OperationalXotBasePolicy RequiresOperationalPermissions"
updated: 2026-11-25
---

# Regole di estensione XotBase

Regola unica: **nei moduli e nei temi non si estende mai una classe Filament (o Eloquent/Laravel di base) direttamente: si estende la sua base `XotBase*`
di `Modules/Xot`.** Le basi centralizzano traduzioni, etichette di navigazione, tabelle, form e hook: una modifica sulla base vale per tutti i moduli.

## Mappa delle basi (verificata sul codice)

| Si vuole estendere | Si estende | Percorso in `app/` di Xot |
|---|---|---|
| `Filament\Resources\Resource` | `XotBaseResource` | `Filament/Resources/XotBaseResource.php` |
| `ListRecords` / `CreateRecord` / `EditRecord` / `ViewRecord` | `XotBaseListRecords`, `XotBaseCreateRecord`, `XotBaseEditRecord`, `XotBaseViewRecord` | `Filament/Resources/Pages/` |
| `ManageRecords` / `ManageRelatedRecords` | `XotBaseManageRecords`, `XotBaseManageRelatedRecords` | `Filament/Resources/Pages/` |
| `RelationManager` | `XotBaseRelationManager` | `Filament/Resources/RelationManagers/` |
| `Filament\Pages\Page` / `Dashboard` | `XotBasePage`, `XotBaseDashboard` (pagina impostazioni: `BaseSettingPage`) | `Filament/Pages/` |
| `Widget` | `XotBaseWidget` (con `HasActions`, `HasForms`) | `Filament/Widgets/` |
| `ChartWidget`, `StatsOverviewWidget`, `TableWidget` | `XotBaseChartWidget`, `XotBaseStatsOverviewWidget`, `XotBaseTableWidget` | `Filament/Widgets/` |
| widget con schema/form, infolist, wizard | `XotBaseSchemaWidget`, `XotBaseInfolistWidget`, `XotBaseWizardWidget` | `Filament/Widgets/` |
| `PanelProvider` | `XotBasePanelProvider`, `XotBaseMainPanelProvider` | `Providers/Filament/` |
| `Illuminate\Database\Eloquent\Model` / pivot | `XotBaseModel`, `XotBaseUuidModel`, `XotBaseTreeModel`, `XotBasePivot`, `XotBaseMorphPivot` | `Models/` |
| policy | `XotBasePolicy` (operative: `OperationalXotBasePolicy`) | `Models/Policies/` |
| migration | `XotBaseMigration` | `Database/Migrations/` |
| service provider modulo | `XotBaseServiceProvider`, `XotBaseRouteServiceProvider`, `XotBaseEventServiceProvider`, `XotBaseThemeServiceProvider` | `Providers/` |

Il namespace e' `Modules\Xot\...` senza il segmento `app` (nwidart mappa `app/` sul namespace del modulo): `Modules\MyModule\Filament\Resources`, mai
`Modules\MyModule\App\Filament\Resources`.

## Errori tipici

- **"Class contains N abstract method"**: la base dichiara metodi astratti (per esempio `getFormSchema()` nei widget): vanno implementati tutti, mai con un
  array vuoto.
- **"Access level must be public"**: la visibilita' deve coincidere con quella della base; per i widget vedi [filament-conventions.md](filament-conventions.md).
- **"Cannot override final method"**: `form()` e `table()` di `XotBaseManageRelatedRecords` (e `form()` di `HasXotForm`) sono `final`: si estendono con gli hook
  (`getFormSchema()`, `modifyRelatedQuery()`, ...), non con un override.
- **Tabella vuota senza errori** su una list page: gli hook `getTable*` scritti sulla pagina risolvono allo stub deprecato di Filament; la tabella appartiene
  alla Resource (vedi [filament-conventions.md](filament-conventions.md)).
- Override di un hook = sostituzione; per estendere: `[...propri, ...parent::getTableXxx()]`.

## Cosa NON si fa

- `extends Filament\...` in un modulo (salvo i casi elencati nel debito di `tests/Arch/debt.php`, che puo' solo scendere).
- Estendere `Model`/`Pivot` Eloquent direttamente: si parte da `XotBaseModel` (vedi [models.md](models.md)) e per le many-to-many si usa
  `belongsToManyX` ([traits/relation-x.md](traits/relation-x.md)).
- Duplicare nei moduli metodi gia' presenti nelle basi (traduzioni, `registerViews`, ...): vedi
  [serviceprovider-minimal-structure.md](serviceprovider-minimal-structure.md).

## Guardie

- `tests/Arch/ArchitectureTest.php`: tabella `XOTBASE_FAMILIES` (Resource, Create/Edit/ManageRecords, RelationManager, Chart/StatsOverview/Table widget) e
  regola `xotbase`; il debito di ogni pacchetto sta in `tests/Arch/debt.php` (solo in discesa).
- `tests/Unit/XotBaseManageRelatedRecordsRegressionTest.php`, `tests/Unit/ListPageHasTableClassTest.php`.
- Ricerca manuale: `grep -rn "extends Filament\\\\" laravel/Modules --include=*.php`.

## Comportamento delle basi (cio' che i `@see` del codice richiamano)

### `XotBaseSchemaWidget`: il widget orchestra, la `*Form` class e' lo spartito

Widget con form Filament Schemas. Il widget gestisce `mount()`, submit e redirect; i campi stanno **solo** nella `*Form` class, mai duplicati nel widget.

- `formClass(): ?string` e' il FQCN della Form class; di default `null` e si usa `getFormSchema()` della sottoclasse (percorso legacy).
- `schemaMethod(): string` e' il metodo statico invocato sulla Form (default `getFormSchema`). Serve a condividere una Form tra widget con sotto-schemi diversi:
  nell'esempio del docblock `LoginWidget` e `RegisterWidget` usano `UserForm` con `getLoginFormSchema` e `getRegisterFormSchema`.
- `form()` lancia `LogicException` se la Form non espone `schemaMethod()`: un nome sbagliato fallisce subito invece di produrre un form vuoto. Lo stato sta in `statePath('data')`.
- Il submit legge `$this->form->getState()` (mai `validateForm()`): la validazione dei campi vive nello schema.

### `XotBaseResource`: come si trovano Form, Table e Infolist

`getFormClass()`, `getTableClass()` e `getInfolistClass()` passano per un solo metodo, `resolveResourcePartClass()`, con tre tentativi in ordine:

1. nome dal **modello**: `{Resource}\Schemas\{Modello}Form`, `{Resource}\Tables\{ModelloPlurale}Table`, `{Resource}\Schemas\{Modello}Infolist` (regola storica);
2. nome dalla **Resource**: `SchedaPoResource` => `SchedaPoForm`, `SchedaPosTable`, `SchedaPoInfolist`. Serve quando piu' Resource condividono un modello (varianti filtrate
   per `type`): il nome dal modello sarebbe uguale per tutte;
3. la Resource registrata per il modello (`GetResourceClassNameByModelClassAction`), cioe' la prima in ordine di discovery.

Perche' esiste il passo 2: senza, le varianti cadevano al passo 3, che restituiva la Resource sbagliata (la prima in ordine alfabetico) e la pagina si fermava con
`Expected a sub-class of XotBaseResourceTable`. Il passo 1 resta il primo, quindi dove il nome dal modello funzionava non cambia nulla. Scartati: rinominare i file delle
varianti (ogni nuova Resource con modello condiviso ricadrebbe nell'errore) e risalire la gerarchia delle Resource (comportamento implicito che nessun caso richiede).
Lezione: una struttura copiata da un modulo con un modello per variante (STI) non vale dove il modello e' condiviso; si verifica aprendo elenco, modifica e vista.

### `XotBaseManageRelatedRecords`: una pagina di relazione mostra la tabella della Resource correlata

La pagina mostra i record di una **relazione** dell'owner (es. i `Contact` di un `SurveyPdf`) con la qualita' (colonne, filtri, azioni, autorizzazioni) con cui la Resource del
modello mostrato li mostrerebbe, mai con quella dell'owner.

- `form()` e `table()` sono `final`: costruiscono schema e tabella della Resource correlata (`$resourceClass::form()` / `::table()`) e applicano sopra gli hook. Si cambia
  sovrascrivendo un hook: `getFormSchema()`; `getTableColumns()`, `getTableHeaderActions()`, `getTableActions()`, `getTableBulkActions()`, `getTableFilters()`;
  `modifyRelatedQuery()` per lo scoping della query. Un override **sostituisce** quell'hook, nessun merge implicito: per estendere `[...propri, ...parent::getTableXxx()]`.
  `Table::modifyQueryUsing()` accumula i callback, quindi `modifyRelatedQuery()` non perde lo scoping gia' applicato (es. tenant).
- **Nessun `HasXotTable` sulla pagina.** `HasXotTable::table()` imposta incondizionatamente una decina di aspetti (stripe, paginazione, ordinamento, poll, posizione delle azioni,
  layout dei filtri, ...): richiamarlo sul `Table` gia' prodotto dalla Resource correlata sovrascriverebbe in silenzio i valori della sua Table class con i default della pagina.
  Inoltre `HasXotTable` implementa hook del contratto `HasTable` che su pagine, relation manager e widget sono deprecati (costava `@phpstan-ignore` mirati; la story 18.27 ne
  contava 78 nel trait) e evita di proposito `getTableSortColumn()` / `getTableSortDirection()` (leggono `$tableSort` di Livewire: dichiararli romperebbe il click
  sull'intestazione), usando `getDefaultTableSort*`. Direzione della story 18.27: il trait vive solo su `XotBaseResourceTable` (oggi lo usano ancora `XotBaseTableWidget`,
  `XotBaseRelationManager` e la copia storica `Resources/XotBaseResource/Pages/XotBaseManageRelatedRecords`).
- `getModelClass()` sta **sempre direttamente sulla classe**, mai in un trait: una versione che toglieva `HasXotTable` senza spostarlo lasciava `getRelatedResourceClass()` a `null`
  per ogni pagina senza `$relatedResource` (`null::configure()` => "Class name must be a valid object or a string"). `getRelationship()` di Filament non restituisce mai una
  stringa: i casi validi sono `Builder` e `Relation`.
- Guardia: `tests/Unit/XotBaseManageRelatedRecordsRegressionTest.php` (nessun `HasXotTable`, `getModelClass()` sulla classe, `form()`/`table()` final, `columns()` e mai `pushColumns()`).

`GetRelatedResourceClassAction` risolve la Resource del modello **mostrato**: prima `$relatedResource` nativo di Filament se la pagina lo dichiara, poi la convenzione
`Modules\{Modulo}\Filament\Resources\{Modello}Resource` (modulo ricavato dal namespace `Modules\{Modulo}\Models\...` del modello), altrimenti `null` e la pagina lancia con un
messaggio esplicito: meglio fallire che mostrare una pagina vuota. Non riusa `GetResourceClassNameByModelClassAction` (e' limitata al pannello corrente: `null` per i modelli
di un altro modulo) ne' `XotBaseRelationManager::getResourceClass()` (risale dal namespace `{Resource}\RelationManagers\`, mentre la pagina sta in `{OwnerResource}\Pages\` e
risolverebbe la Resource proprietaria).

### `XotBaseListRecords`: azioni di intestazione

`getHeaderActions()` (barra in alto della **pagina**, protected) e `HasXotTable::getTableHeaderActions()` (barra in alto della **tabella**, `public`: la chiama Filament/Livewire
dall'esterno) sono due barre distinte, entrambe renderizzate. La pagina mette un solo `create`: omesso se la Resource non ha la pagina `create` (altrimenti `getUrl('create')`
lancia `RouteNotFound` e l'elenco va in 500), visibile solo se `canCreate()`, con `?return_to=` verso la riga di partenza (vedi `RecordAnchor`) ed etichetta
`<modulo>::<risorsa>.actions.create.label` se tradotta.

Punto di design aperto (letto sul codice, non verificato a schermo): anche `HasXotTable::getTableHeaderActions()` aggiunge un `CreateAction` (con la stessa regola sulla pagina
`create`), piu' associate/attach e il toggle di layout; una lista Xot puo' quindi mostrare due pulsanti "Nuovo". Quale barra tenga il "Nuovo" vale per tutte le List page di
tutti i moduli (candidata: la barra della tabella, dove stanno anche associate/attach/layout): non si toglie uno dei due senza decidere l'altro. Guardia esistente:
`tests/Unit/Filament/HeaderCreateActionFollowsCreatePageTest.php`.

### `RecordAnchor`: tornare all'elenco sulla riga giusta

Aperto un record dall'elenco, modificato e salvato, l'utente deve ritrovare l'elenco sulla riga appena toccata, non in cima. `Modules\Xot\Filament\Links\RecordAnchor` e' l'unico
posto che conosce il formato:

- `id($key)` e' `record-{chiave}` (il prefisso e' obbligatorio: un id che inizia per cifra non si seleziona in CSS ne' con `querySelector`), `fragment()` e' `#record-{chiave}`,
  `appendTo($url, $key)` mette il frammento in coda all'URL, dopo la query string.
- L'ancora HTML la emette `IDColumn` (UI) quando e' visibile; altrimenti l'azione di riga di `HasXotTable` (`withRecordReturnTo`), mai due `id` uguali. Filtri, ordinamento e pagina
  dell'elenco sono gia' conservati in sessione, quindi la riga e' nella pagina servita.
- `currentUrl()`: in una richiesta Livewire (filtro, ordinamento, paginazione) `request()` e' l'endpoint di aggiornamento, non la pagina, quindi si usa `Livewire::originalUrl()`.
- `appendReturnTo($url, $returnTo, $key)` aggiunge `?return_to=` (RFC 3986) ai link "Nuovo" e di riga; `XotBaseCreateRecord`, `XotBaseEditRecord` e `XotBaseViewRecord` lo
  leggono, lo validano con `resolveReturnTo()` e dopo il salvataggio (e su "Annulla") reindirizzano a `#record-{chiave}`; se non e' valido usano il comportamento standard di Filament.
- `previousWithinResource($previousUrl, $resourceIndexUrl)`: la pagina precedente vale come ritorno solo se e' una pagina della stessa Resource (elenco o dettaglio); chi arriva da
  dashboard o da un altro pannello va, dopo il salvataggio, alla Resource e non a un'ancora che li' non esiste. `$resourceIndexUrl` e' `mixed` di proposito: `static::getResource()::getUrl()`
  e' `mixed` per PHPStan (Filament dichiara `getResource(): string` con `@return class-string` senza generico) e restringerlo a `string` e' stato provato e respinto, perche'
  `assert`, `@var` e cast sono vietati ([ADR 0015](adr/0015-mixed-solo-come-ultima-spiaggia.md)).
- **Sicurezza (open redirect)**: `resolveReturnTo()` accetta solo la stessa origine: un percorso relativo che inizia con una sola `/`, oppure un URL che inizia con
  `schema://host[:porta]` della richiesta. Rifiuta i caratteri che il browser legge diversamente da `parse_url()` (`\`, tab, a capo, spazi iniziali, caratteri di controllo:
  `/\evil.example` e `/<TAB>/evil.example` si aprirebbero come `//evil.example`), `//host`, schemi senza host, userinfo che maschera l'host, altra porta o altro schema; il
  frammento ammesso e' solo `record-[A-Za-z0-9._~-]+`. Guardia: `tests/Unit/RecordAnchorReturnUrlTest.php`.

### `XotBasePolicy`: il ruolo `{modulo}::admin` e le policy operative

L'accesso al pannello Filament di un modulo richiede il ruolo `{modulo}::admin` (`user:assign-module`). Le policy dei modelli usavano regole diverse (`hasPermissionTo('menu.viewAny')`
di un permesso mai creato, ruoli di un altro progetto): chi aveva solo il ruolo del pannello vedeva un 500 `PermissionDoesNotExist` o un pannello vuoto, e lavoravano solo i
super-admin. Decisione: `XotBasePolicy::before()` concede tutto al `super-admin` e a chi ha il ruolo `{modulo}::admin` del modulo della policy, ricavato dal namespace
(`Modules\{Modulo}\...` => `strtolower({Modulo}).'::admin'`, metodo `moduleAdminRole()`). Restrizioni piu' fini si fanno con ruoli o permessi dedicati, non con policy che lanciano.
Conseguenza: `{modulo}::admin` e' amministratore completo dei dati di quel modulo, cancellazione inclusa.

Eccezione, i moduli con **permessi operativi** (es. Roosko: operatore di piazzale, accettazione, responsabile tecnico): li' il ruolo del pannello serve solo a entrare e cosa si puo'
fare lo dicono i permessi. Con il bypass, l'operatore che ha il ruolo del pannello per usare la pagina di scansione poteva rettificare pesi ed eliminare conferimenti. Le loro
policy estendono `OperationalXotBasePolicy`, che compone `Concerns\RequiresOperationalPermissions`: `moduleAdminRole()` restituisce `null`, quindi passa solo il super-admin.
Il trait ha consumatori veri solo in altri progetti (Roosko, 33 policy): in questo progetto `trait.unused` lo segnala, ma non si parcheggia ne' si cancella (censimento nella story
[0148](bmad/stories/0148-phpstan-modules-zero-swarm-standing.story.md)). Guardia: `tests/Unit/Models/Policies/RequiresOperationalPermissionsTest.php` (con `tests/Fixtures/Policies/OperationalPermissionsPolicyProbe.php`),
unico test del trait qui: non va cancellato.

## Decisioni collegate

- [adr/0006-xot-base-extension-points.md](adr/0006-xot-base-extension-points.md)
- [adr/0020-architecture-tests-pest-arch.md](adr/0020-architecture-tests-pest-arch.md)
