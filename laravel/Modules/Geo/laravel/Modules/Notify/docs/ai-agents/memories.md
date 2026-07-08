# Agent Memory Updates

## 🚨 CRITICAL RULE: NEVER CREATE NEW MODULES

**ALWAYS use existing modules.** This is a fundamental architectural rule for Laraxot projects.

### Why This Rule Exists
- **DRY Compliance**: Avoid module duplication and maintenance burden
- **Consistency**: Ensure all modules follow the same patterns and standards
- **Quality**: Leverage existing tested and documented functionality
- **Efficiency**: Focus development effort on enhancing existing modules rather than creating new ones

Vedi [index](index.md) per navigazione completa.

Vedi [index](index.md) per navigazione completa.

## 2026-02-26

## 2026-03-15

## 2026-04-14

### Filament Placeholder policy — semantica prima del namespace
- `Filament\\Forms\\Components\\Placeholder` va trattato come legacy/deprecated.
- La domanda corretta non e` "con cosa lo sostituisco a priori?" ma "che tipo di contenuto sto rendendo?".
- Regola canonica:
  - input utente -> `Filament\\Forms\\Components\\*`
  - dato read-only strutturato -> `Filament\\Infolists\\Components\\*`
  - testo statico, notice, istruzioni, microcopy arbitrario -> `Filament\\Schemas\\Components\\*`
- Quindi:
  - `Placeholder` usato come falso field read-only -> migrare a `TextEntry` / entry equivalenti
  - `Placeholder` usato come contenuto statico -> migrare a `Text` / prime equivalents
- Documenti canonici:
  - `docs/schemas-unified-religion.md`
  - `laravel/Modules/Xot/docs/filament/widgets/infolists-for-summary.md`
  - `laravel/Modules/Fixcity/docs/form-vs-infolist-religion.md`

### config/database.php identico a Laravel 13.x
- `laravel/config/database.php` deve essere **identico** a https://github.com/laravel/laravel/blob/13.x/config/database.php
- Connessioni custom (predict, blog, cms, activity, user, quaeris, limesurvey, orbit) vanno in `config/local/<tenant>/database.php`
- Unica modifica ammessa: rimosso `use Pdo\Mysql` per compatibilita' PHP 8.3; uso `\Pdo\Mysql::ATTR_SSL_CA` nel ternary solo quando PHP >= 8.5
- Regola: `.cursor/rules/database-config-laravel-standard.mdc`

## 2026-03-10

### Spatie QueueableAction — regola corretta dopo studio approfondito del package
- `spatie/laravel-queueable-action` **supporta** constructor DI; non va piu` ripetuta la regola assoluta "mai constructor DI".
- Il vincolo corretto e`: una queued action viene rieseguita tramite `app(ActionClass::class)` dentro `ActionJob`, quindi deve restare **container-instantiable**.
- Anti-pattern critico: action con `QueueableAction` + costruttore privato/singleton statico. Funziona magari in sync, ma fallisce appena la action viene risolta via container o tramite job wrapper.
- Il trait sceglie `__invoke()` se esiste, altrimenti `execute()`. Nel progetto manteniamo `execute()` come convenzione primaria per uniformità.
- Per chaining queued usare `new ActionJob(AnotherAction::class, $args)`.
- Per test queued usare `Queue::fake()` + `Spatie\QueueableAction\Testing\QueueableActionFake`.

### Quaeris question-chart pipeline — prima lint, poi app boot
- Nei flussi `ViewQuestionChart` il primo blocker puo` essere sintattico e non applicativo.
- Prima di inseguire Livewire/Filament o query runtime, lintare l'intera catena caricata subito:
  - `QuestionChartChartData`
  - `BuildQuestionChartDatasetAction`
  - `BuildQuestionChartOptionsAction`
  - blade custom della pagina
- Se lo stack trace dell'utente punta a una riga che sul disco non corrisponde piu`, trattarlo come possibile errore stale e verificare il file attuale con `php -l` + `nl -ba`.

### QuestionChart root ancestor — distinguere metodo assente da runtime stale
- `QuestionChart::getRootQuestionAncestorId()` e` parte del contratto del modulo Quaeris.
- Se l'errore utente dice "undefined method" ma:
  - il metodo esiste sul file corrente
  - `method_exists()` restituisce `true`
  - il Pest dedicato passa
  allora il problema va trattato come autoload/runtime stale, non come assenza del metodo.
- Forward-only remediation ammessa:
  - `composer dump-autoload --no-scripts`
  - nuova verifica Pest sul model e sulla dependency chain della pagina.

### Token efficiency / context engineering
- Per ridurre token e latenza, tenere il prefisso statico stabile e spostare il contenuto volatile in coda.
- Non aprire file interi se basta una finestra con `rg -n`, `sed -n`, `nl -ba`.
- Nei bug flow usare prima il sottoinsieme minimo di file caricati dalla pagina/comando.
- Misurare quando il contesto cresce: e` disponibile un contatore locale in `laravel/storage/app/ai/tools/token_count.py` con venv dedicato in `laravel/storage/app/ai/venvs/token-tools`.

### Anti-Pattern: Chiamate Statiche per Colonne Condivise
- **PROBLEMA**: Codice come `ListCharts::getChartTableColumns()` e `self::getChartTableColumns()` crea accoppiamento statico forte
- **PATTERN CORRETTO**: Definire le colonne nel **Resource**, non nelle **Pages**
  ```php
  // Resource: ChartResource.php
  public static function getTableColumnsSchema(): array
  {
      return [
          'id' => TextColumn::make('id')->sortable(),
          // ...
      ];
  }
  
  // ListCharts.php
  public function getTableColumns(): array
  {
      return static::$resource::getTableColumnsSchema();
  }
  ```
- **MAI** usare `app(ListCharts::class)->getTableColumns()` — crea nuova istanza inutile
- Le colonne condivise devono risiedere nel Resource, non nelle Pages

### Nested resource Edit page — form vuoto, diagnosi corretta (2026-02-26)
- **DIAGNOSI PRECEDENTE ERRATA**: "Le rotte nested non trovano le pagine Edit/View" — quella e la causa del pulsante mancante, NON del form vuoto.
- **SINTOMO REALE**: La pagina `/survey-pdfs/{id}/question-charts/{id}/edit` si carica ma il form non ha campi.
- **CAUSA ROOT CORRETTA**:
  1. `QuestionChartResource::getFormSchema()` ritorna `[]` (placeholder mai implementato)
  2. `EditQuestionChart` non sovrascrive `getFormSchema()`
  3. `XotBaseEditRecord::getFormSchema()` ritorna `[]` per default
  4. Zero campi = form visivamente vuoto senza alcun errore
- **PERCHE ManageQuestionCharts FUNZIONA**: ha `$this->record` = SurveyPdf (padre) → accede a `$this->record->survey_id` direttamente
- **PERCHE EditQuestionChart NON FUNZIONA**: ha `$this->record` = QuestionChart (figlio) → deve navigare `$this->record->surveyPdf->survey_id` — metodo mai implementato
- **REGOLA**: se lo schema dipende dal padre, la Edit page DEVE sovrascrivere `getFormSchema()` come metodo istanza
- **DOC**: `laravel/Modules/Quaeris/docs/nested-resource-form-trap.md` (analisi completa)

### Filament Resources Overview — allineamento Laraxot
- L’overview ufficiale Filament (`resources/overview`) definisce `Resource::form(Schema)` e `Resource::table(Table)` come entry point unici per form e tabelle.
- In Laraxot questi entry point sono incapsulati in `XotBaseResource::getFormSchema()` e nei metodi `getTable*()` (HasXotTable): **mai** override diretto di `form()`/`table()` nelle risorse concrete.
- Per le nested resources il routing segue `getPages()` di Filament (`/parent/{parent}/children/{record}/edit`), mentre il nome del parametro parent deriva da `ParentResourceRegistration::getParentRouteParameterName()`; quando servono ID/attributi del parent (es. `survey_id`) vanno letti da `getParentRecord()` o dalla route, non “indovinati” dalla URL.

### Nuovi pacchetti installati
- `laravel/pulse` v1.6.0 - Monitoring e performance tracking
- `laravel/pennant` v1.20.0 - Feature flags
- `maatwebsite/excel` v3.1.67 - Excel import/export
- `intervention/image` v3.11.7 - Image processing
- `spatie/laravel-event-sourcing` v7.15.0 - Event sourcing

### Skills create
- `laravel-pulse` - Monitoring con dashboard, slow queries, custom metrics
- `laravel-pennant` - Feature flags con percentage rollouts, A/B testing
- `laravel-excel` - Exports, imports, validation, chunking, queue support
- `intervention-image` - Resize, crop, filters, watermarks

### Event Sourcing Pattern
- Usare `spatie/laravel-event-sourcing` per event sourcing
- Stored events con `StoredEvent`, `AggregateRoot`
- Projctions per read models

## 2026-02-24

### phpstan.neon IMMUTABILE
- `laravel/phpstan.neon` è l'unico file di config PHPStan. NON modificarlo. NON creare altri file phpstan*.neon.

### array_values() vietato sui metodi get* Filament
- MAI `array_values()` su `getHeaderActions()`, `getTableActions()`, `getTableColumns()`, `getFormSchema()`
- Le chiavi stringa sono obbligatorie; `array_values()` le distrugge
- FIX: `return $actions;` invece di `return array_values($actions);`
- File corretto: `LangBaseListRecords::getHeaderActions()` → `return $actions;`

### getTableColumns() — chiavi string OBBLIGATORIE
- `getTableColumns()` **DEVE SEMPRE** restituire `array<string, Column>` — chiavi string, mai indici numerici
- `return ['name' => TextColumn::make('name'), ...]` ✅
- `return [TextColumn::make('name'), ...]` ❌
- Vedi `.cursor/rules/gettablecolumns-string-keys.mdc`

### NO table() override — CRITICO in Filament 5
- In Filament 5 il metodo `table()` è `final` in `InteractsWithTable`
- **NON overridare `table()`** in nessuna classe
- Errore: `Cannot override final method ...::table()`
- Classi che avevano `table()` e devono essere corrette:
  - `LocationMapTableWidget` (Geo)
  - `OptOutWidget` (Quaeris)
  - `ManageRolePermissions` (User)
  - `GoogleDriveFileListPage` (CloudStorage)
- Usare invece: `getTableColumns()`, `getTableHeaderActions()`, `getTableActions()`, `getTableBulkActions()`, `getTableFilters()`

### ManageRelatedRecords — NO table() override
- ManagePdfStyle, ManageCharts, ManageContacts: **NON** implementare `table()` che delega a `Resource::table()`
- `table()` in HasXotTable è `final` — override impossibile/vietato
- Override `getTableColumns()` e restituisci colonne (es. `PdfStyleResource::getTableColumnsSchema()`)
- Pattern: aggiungere `getTableColumnsSchema()` al Resource per condividere colonne tra List e Manage

### getTableHeading() return type Filament 5
- Deve essere `Htmlable|string|null`, MAI `?string`
- Aggiungere `use Illuminate\Contracts\Support\Htmlable;` in tutti i widget che lo overridano

### Coverage PCOV/Xdebug
- `pcov.enabled` e `xdebug.mode` sono `PHP_INI_SYSTEM` — non modificabili via `ini_set()`
- Usare `XDEBUG_MODE=off` come env var quando si esegue con copertura PCOV
- Non usare `<ini name="pcov.enabled">` in phpunit.xml — silently fails → 0% coverage

## 2026-02-24 (HasFactory ridondante)

### HasFactory/HasXotFactory — NON aggiungere se ereditato
- Modelli che estendono `BaseModel` del modulo hanno già la factory via: `BaseModel → XotBaseModel → HasXotFactory` (che usa `EloquentHasFactory`)
- **NON** aggiungere `use HasFactory` o `use HasXotFactory` a modelli tipo `Team extends BaseTeam` — è ridondante
- Catena: `Team → BaseTeam → BaseModel → XotBaseModel` (usa HasXotFactory)
- Vedi: `laravel/Modules/Xot/docs/traits/hasxotfactory.md`, `.cursor/rules/model-extension-rules.mdc`

## 2026-02-24 (form() final)

### form() DEVE essere final
- `form()` in `HasXotForm` e `XotBaseRelationManager` DEVE restare `final`
- Non va mai rimosso o reso non-final
- Le classi figlie si adattano implementando `getFormSchema()`
- Vedi: `laravel/Modules/Xot/docs/hasxotform-form-final.md`

## 2026-02-24 (table() final)

### table() DEVE essere final
- `table()` in `HasXotTable` trait DEVE restare `final`
- Non va mai rimosso o reso non-final
- Le classi figlie si adattano implementando `getTableColumns()`, `getTableHeaderActions()`, `getTableActions()`, `getTableBulkActions()`, `getTableFilters()`
- MAI fare override di `table()` — genera errore PHP "Cannot override final method"
- Vedi: `laravel/Modules/Xot/app/Filament/Traits/HasXotTable.php`

## 2026-01-29

### JpGraph Integration Memory
- **Hybrid Chart Strategy**: Chart.js per dashboard interattive, JpGraph per PDF/exports
- **JpGraph Service Pattern**: namespace `Amenadiel\JpGraph`, strict typing, exception handling
- **Cache Management**: sempre implementare caching per chart JpGraph

### JpGraph vs Chart.js Decision Matrix
- **JpGraph**: report PDF, allegati email, batch processing, chart avanzate
- **Chart.js**: dashboard interattive, real-time updates, mobile responsive

## 2026-01-28

### Livewire Widget Constructor Pattern
- "Cannot call constructor" causato da `__construct()` custom nei widget
- Livewire Factory istanzia i widget con `new $class()` senza parametri
- Pattern corretto: proprietà nullable + lazy init in `getData()` o `mount()`

### Chart Widget getOptions()
- `getOptions()` può restituire `array | RawJs | null` (Filament accetta tutti)
- RawJs OBBLIGATORIO quando options via `@js()` e contengono formatter JS

### Form vuoto su Edit nested resource (QuestionCharts)
- URL tipo `.../survey-pdfs/16/question-charts/230/edit` può mostrare la pagina Edit ma **form vuoto**.
- **Causa**: la Edit usa `Resource::form()` → `Resource::getFormSchema()`. Se la nested resource (es. QuestionChartResource) ha `getFormSchema()` vuoto e i campi veri in un altro metodo (es. `getFormSchemaBySurveyId($survey_id)`), il form resta vuoto perché quel secondo metodo non viene mai chiamato nel flusso Edit/Create.
- **Regola**: per nested resource con form dipendente dal parent, lo schema effettivo deve essere restituito da `getFormSchema()` (o dalla pagina che override), eventualmente recuperando il parent dal contesto. Documentazione: `laravel/Modules/Quaeris/docs/edit-question-chart-form-empty-cause.md`, rule `filament-nested-resources.mdc` e `filament-form-schema.mdc`.

### HasXotTable / XotBaseManageRelatedRecords pattern (ManageCharts)
- Le pagine `XotBaseManageRelatedRecords` devono riusare la configurazione tabellare esistente invece di ricreare `table()`
- Esempio: `SurveyPdfResource\Pages\ManageCharts` usa `ListCharts::getChartTableColumns()` in `getTableColumns()` per avere le stesse colonne del `ListRecords` Chart
- Le azioni tabellari vanno estese partendo da `parent::getTableActions()` e aggiungendo solo ciò che serve (es. `DissociateAction`, `ForceDeleteAction`, `RestoreAction`) mantenendo le azioni standard
- La visibilità di `AssociateAction` in header si controlla tramite `protected function shouldShowAssociateAction(): bool`, senza ridefinire manualmente `getTableHeaderActions()`

## Riferimenti

- [critical-rules](critical-rules.md)
- [project-rules](project-rules.md)
