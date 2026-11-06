---
title: "Blueprint: registro delle richieste dell'interessato (GDPR artt. 15-22)"
type: blueprint
status: draft
created: 2026-10-14
updated: 2026-10-15
module: Gdpr
tags: [blueprint, filament, gdpr, diritti-interessato, dcp-140, dcp-178, dcp-254]
qmd: "blueprint filament registro richieste interessato data subject request accesso cancellazione portabilita scadenza un mese art 12 gdpr dpo gdpr::admin"
issues: []
discussions: []
related:
  - ../stories/dcp-140-diritti-dellinteressato-procedura-e-strumenti.story.md
  - ../stories/dcp-178-registrazione-e-disiscrizione-a-norma.story.md
  - ../stories/dcp-254-revisione-blueprint-registro-richieste-interessato.story.md
  - ../register-widget.md
---

# Blueprint: registro delle richieste dell'interessato

Prodotto con la skill `planning-filament` di `filament/blueprint` 2.4.0 (Filament 5.10.1, Livewire 4.4.7, Laravel 13). E' una specifica per chi implementa: non contiene codice applicativo. **Revisione del 2026-10-15 (DCP-254): vedi la sezione 7; le correzioni puntuali nel testo sono marcate `[rev]`.** **Stato: bozza con decisioni aperte.** La skill vieta di presentare come definitive le scelte su dati, conservazione e azioni distruttive: sono nella sezione 0 con un default proposto, non ancora approvato dal DPO.

## 0. Decisioni aperte (da chiudere prima di implementare)
| # | Domanda | Default proposto in questo piano | Cosa cambia se la risposta e' diversa |
|---|---|---|---|
| D1 | Chi gestisce le richieste? | Chi ha il permesso `data_subject_request.*` (**[rev]** assegnato al ruolo esistente `gdpr::admin`, necessario per entrare nel pannello; il ruolo `dpo` della bozza e' rimandabile) | permessi e seeder |
| D2 | Chi registra una richiesta? | Solo il personale, da PEC, email, sportello o posta | con un modulo per il cittadino servono una pagina del front office e un limite ai tentativi (fase successiva, DCP-140) |
| D3 | La verifica dell'identita' e' obbligatoria per evadere? | Si: senza `identity_verified_at` non si puo' passare a `fulfilled` | regola R3 e relativo test |
| D4 | Proroga (art. 12 par. 3) | Ammessa fino a 3 mesi dal ricevimento, con motivazione obbligatoria (**[rev]** e registrabile solo entro il primo mese, come dice la nota di DCP-140: da confermare) | colonne `extended_until` e `extension_reason` |
| D5 | Per quanto tempo si conserva il registro? | Non si cancella mai nulla finche' il DPO non decide (DCP-141) | nessuna eliminazione prevista; se serve, un comando pianificato |
| D6 | Si registrano nome ed email del richiedente? | Si, come testo; `user_id` facoltativo | il registro contiene dati personali: va dichiarato nell'informativa |
| D7 | **Esecuzione** della cancellazione/anonimizzazione e destino delle segnalazioni | **Fuori da questo piano.** Il registro traccia e scadenza le richieste; non cancella nulla | vedi DCP-178, punto 4: `tickets.owner_id` e' NOT NULL e senza chiave esterna |

## 1. Commands
Eseguire dalla cartella `laravel/`, in quest'ordine. Il pannello e' `gdpr::admin` (path `gdpr/admin`). Verificato con `--help` il 2026-10-14: `module:make-model` accetta `--migration --policy --factory`, `make:filament-resource` accetta `--panel --soft-deletes --view`.
```bash
php artisan module:make-enum DataSubjectRequestType Gdpr --no-interaction
php artisan module:make-enum DataSubjectRequestStatus Gdpr --no-interaction
php artisan module:make-enum DataSubjectRequestChannel Gdpr --no-interaction
php artisan module:make-model DataSubjectRequest Gdpr --migration --factory --no-interaction
# [rev] NON lanciare module:make-policy: scrive in app/Policies, la policy va a mano in app/Models/Policies
php artisan module:make-policy DataSubjectRequestPolicy Gdpr --no-interaction
# [rev] facoltativo: ogni file generato va riscritto (vedi sotto)
php artisan make:filament-resource DataSubjectRequest --model-namespace='Modules\Gdpr\Models' --panel=gdpr::admin --view --no-interaction
```
**[rev]** Il pannello `gdpr::admin` ha un solo percorso di scoperta (`Modules\Gdpr\Filament\Resources`, letto a runtime), quindi `--panel=gdpr::admin` scrive dentro il modulo e non in `app/Filament` (sorgente: `vendor/filament/support/src/Commands/Concerns/HasResourcesLocation.php` righe 46-51). Ma il generatore usa la cartella `Resources/DataSubjectRequests/` (plurale) e classi che estendono Filament, non Xot: **ogni file generato va riscritto** nella struttura di `ConsentResource`: `Modules/Gdpr/app/Filament/Resources/DataSubjectRequestResource.php` e `.../DataSubjectRequestResource/{Pages,Schemas,Tables}/`, namespace `Modules\Gdpr\Filament\Resources\...`. Per ponytail e' piu' corto scrivere i file a mano dallo stampo di `ConsentResource` e non lanciare il generatore (comando sopra: facoltativo).
**[rev]** Classi base obbligatorie (altrimenti `Assert::subclassOf` fallisce in `XotBaseResource::getFormClass()/getTableClass()/getInfolistClass()`): la risorsa estende `Modules\Xot\Filament\Resources\XotBaseResource`; `Schemas\DataSubjectRequestForm` estende `Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm` (metodo `getFormSchema(): array`); `Schemas\DataSubjectRequestInfolist` estende `XotBaseResourceInfolist` (`getInfolistSchema()`); `Tables\DataSubjectRequestsTable` estende `Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable` (`getTableColumns(): array` chiavato per nome: il divieto di `getTableColumns()` vale per la *Resource*, non per la classe Table); le pagine estendono `XotBaseListRecords`, `XotBaseCreateRecord`, `XotBaseEditRecord`, `XotBaseViewRecord` (`Modules\Xot\Filament\Resources\Pages\`). `XotBaseResource::getPages()` registra da solo list/create/edit e `view` se la classe esiste.
**[rev]** `module:make-policy` e `module:make-model --policy` scrivono in `app/Policies` (`config/modules.php:132`), non in `app/Models/Policies` dove stanno le 5 policy del modulo: **non lanciarli**, creare il file a mano dallo stampo di `ConsentPolicy`. `module:make-model --migration --factory` produce una migrazione Laravel semplice: va riscritta come sotto. Verificato con `--help` il 2026-10-15: `module:make-enum <name> [<module>]`, `module:make-model <model> [<module>]` con `--migration --factory --policy`, `make:filament-resource` con `--panel --model-namespace --view --soft-deletes` esistono; nessun comando e' stato eseguito.

## 2. Models
### Enum `Modules\Gdpr\Enums\DataSubjectRequestType` (string, implementa `Filament\Support\Contracts\HasLabel`)
`access` (art. 15), `rectification` (16), `erasure` (17), `restriction` (18), `portability` (20), `objection` (21). **[rev]** Gli enum del modulo usano `Modules\Xot\Traits\EnumTrait` (come `ConsentType`): `getLabel()/getColor()/getIcon()` leggono `gdpr::<enum_snake>.values.<valore>.label|color|icon` (`EnumTrait.php` righe 16-28, `TransTrait::getKeyTransClass()` righe 54-70). Quindi **un file lang per enum** in `Modules/Gdpr/lang/{it,en,de,es}/`: `data_subject_request_type.php`, `data_subject_request_status.php`, `data_subject_request_channel.php`, chiavi `values.<valore>.label` (e `.color` per Status, es. `gray`, `warning`); NON `type.<valore>` in `data_subject_request.php`. Le etichette dei campi stanno in `data_subject_request.php` con `fields.<campo>.label` e `navigation.*` (stampo: `lang/it/consent.php`). Precedente di errore: per `ConsentType` non esiste nessun `consent_type.php` in nessuna lingua (L: `find`), quindi le sue etichette non hanno traduzione (dedotto dal sorgente, non renderizzato). Nessuna etichetta scritta nel codice (regola "translation first"): "Richiedente", "Richiesta", "In ritardo" sotto sono chiavi, non testi.
### Enum `DataSubjectRequestStatus` (string, `HasLabel`, `HasColor`)
`received` (gray), `identity_check` (warning), `in_progress` (info), `fulfilled` (success), `refused` (danger), `withdrawn` (gray). Stati terminali: `fulfilled`, `refused`, `withdrawn`. Metodo `isTerminal(): bool`. Transizioni ammesse (metodo `canTransitionTo(self $to): bool`): `received` -> `identity_check`, `in_progress`, `refused`, `withdrawn`; `identity_check` -> `in_progress`, `refused`, `withdrawn`; `in_progress` -> `fulfilled`, `refused`, `withdrawn`; i terminali non cambiano.
### Enum `DataSubjectRequestChannel` (string, `HasLabel`)
`pec`, `email`, `in_person`, `postal`, `phone`.

### Model `Modules\Gdpr\Models\DataSubjectRequest`
Estende `Modules\Gdpr\Models\BaseModel` (connessione `gdpr`, database `fixcity_data`, MariaDB; verificato con `config:show` e `db:table`), `use HasUuids` e `public $incrementing = false;` come `Consent`; `casts()` come metodo (non `$casts`), niente `SoftDeletes`. **[rev]** `$fillable` esplicito e minimo, solo i campi del form: `type, channel, requester_name, requester_email, user_id, received_at, assigned_to, extended_until, extension_reason, notes`. Mai in `$fillable`: `status, due_at, completed_at, identity_verified_at, identity_verification_method, outcome, refusal_basis, created_by, updated_by` (le scrive solo l'Action, per assegnazione esplicita; `XotBaseModel` non ha ne' `$fillable` ne' `$guarded` e non c'e' `unguard()` globale; `Consent` mette invece `created_by`/`updated_by` in `$fillable`: non imitare). **Nessuna chiave esterna verso `users`**: `users` sta nel database `fixcity_user` (connessione `user`), una FK tra database diversi non e' applicabile.
| Attributo | Tipo colonna | Cast / note |
|---|---|---|
| `id` | uuid | `HasUuids` |
| `type` | string(20) | cast `DataSubjectRequestType` |
| `status` | string(20), default `received`, indice | cast `DataSubjectRequestStatus` |
| `channel` | string(20) | cast `DataSubjectRequestChannel` |
| `requester_name` | string(255) | |
| `requester_email` | string(191), nullable, indice | |
| `user_id` | string(36), nullable, indice | `users.id` e' `varchar(36)`; nessun vincolo |
| `received_at` | timestamp | cast `datetime` |
| `due_at` | **[rev] date**, indice | cast `date`; calcolato, mai da form. Era `timestamp`: con l'ora, una richiesta ricevuta il 15/05 alle 10:00 risultava "in ritardo" il 15/06 alle 10:01, cioe' l'ultimo giorno utile. Il termine e' un giorno di calendario: si confronta per data (vedi R1) |
| `extended_until` | **[rev] date**, nullable | cast `date` |
| `extension_reason` | text, nullable | |
| `identity_verified_at` | timestamp, nullable | cast `datetime` |
| `identity_verification_method` | string(255), nullable | |
| `assigned_to` | string(36), nullable | id utente |
| `completed_at` | timestamp, nullable | cast `datetime` |
| `outcome` | text, nullable | |
| `refusal_basis` | text, nullable | obbligatoria se `refused` |
| `notes` | text, nullable | |
**[rev] Colonne di audit** (`created_at`, `updated_at`, `created_by`, `updated_by`): NON le aggiunge `tableCreate()` (`Modules/Xot/app/Database/Migrations/XotBaseMigration.php` riga 294: crea solo cio' che dice la closure). Le aggiunge `updateTimestamps()` (riga 351; `created_by`/`updated_by` con `foreignIdFor` righe 366-372, tipo `uuid` nullable perche' `users.id` e' stringa, senza vincolo) **solo se la migrazione la chiama**, dentro `tableUpdate()`, come in `2024_01_01_000001_create_treatments_table.php`. Per un registro che non si cancella la chiamata e' `$this->updateTimestamps(table: $table)` **senza** `hasSoftDeletes: true`: niente `deleted_at` ne' `deleted_by` (due colonne in meno rispetto alla bozza). La bozza diceva "le aggiunge XotBaseMigration, da non dichiarare a mano": falso, senza la chiamata la tabella non ha audit e il test 10 non puo' passare.
**[rev] Migrazione:** un solo file `create_data_subject_requests_table.php` (regola `docs/wiki/rules/one-migration-per-model.md`: una sola `create_*` per tabella, le evoluzioni si fanno nello stesso file con `hasColumn()` e bump del timestamp), `return new class extends XotBaseMigration { protected ?string $model_class = DataSubjectRequest::class; ... }` con `tableCreate()` (colonne) + `tableUpdate()` (`updateTimestamps`). Lo stampo da seguire e' `create_treatments_table`, **non** `2024_01_01_000006_create_consents_table.php` come scriveva la bozza: quel file e' una sola `tableUpdate` che aggiunge 3 colonne, e `consents` ha 4 file `create_consents_table` (000001, 000002, 000005, 000006), cioe' il contrario della regola. **Non eseguirla sul database di sviluppo** finche' l'utente non approva (DCP-204, DEC-09).
**[rev] `created_by`:** `Updater` (`Modules/Xot/app/Traits/Updater.php` righe 76-86) valorizza `created_by` in `creating` solo se la chiave e' gia' tra gli attributi, e la creazione da Filament non la porta: il registro avrebbe `created_by` nullo. Valorizzarlo nel `booted()` del model (`creating`: `created_by ??= authId()`), stesso punto in cui si calcola `due_at`. `updated_by` invece funziona in `updating` (righe 88-94).
Relazioni: nessuna Eloquent verso `User` (database diverso); un accessor `getRequesterAttribute()` puo' fare `User::find($this->user_id)` se serve; non e' richiesto.

**Regola R1 (scadenza), unica fonte:** `due_at = received_at->copy()->addMonthNoOverflow()`. Termine effettivo: `extended_until ?? due_at`, esposto come attributo `effective_deadline` sul model. Un termine non si calcola mai altrove (tabella, filtro, widget, azioni usano questo attributo o l'espressione SQL `COALESCE(extended_until, due_at)`). **Perche' `addMonthNoOverflow()`** (provato con Carbon in questo progetto il 2026-10-14): `2026-01-31` con `addMonth()` da' `2026-03-03`, con `addMonthNoOverflow()` `2026-02-28`; `2026-03-31` da' `2026-05-01` contro `2026-04-30`; `2026-05-15` da' `2026-06-15` in entrambi i casi. Il termine di un mese non deve slittare oltre la fine del mese. Per la proroga massima: `2026-01-31` + 3 mesi con `addMonthsNoOverflow(3)` = `2026-04-30`. `due_at` si imposta nel metodo `booted()` (`saving`) quando `received_at` e' modificato. **[rev]** Riprovato il 2026-10-15 con Carbon 3.14.2 (`composer.lock`): stessi risultati. `due_at` e' una **data** (`->toDateString()`), non un istante: una richiesta e' in ritardo solo se `effective_deadline < oggi` (l'ultimo giorno utile non e' in ritardo). Che il termine sia un giorno di calendario che include l'ultimo giorno e che a fine mese valga l'ultimo giorno del mese e' una lettura della norma da far confermare al DPO (non ho letto qui il testo del Reg. 1182/71 ne' le linee guida EDPB).
**Regola R5 (proroga):** `extended_until` (data) non oltre `received_at->copy()->addMonthsNoOverflow(3)->toDateString()`, e non prima di `due_at`; `extension_reason` obbligatoria quando `extended_until` e' valorizzato. **[rev]** La nota di DCP-140 (DCP-176) dice che la proroga va comunicata con avviso motivato **entro il primo mese**: la bozza non lo impone (si potrebbe registrare una proroga dopo la scadenza). Se D4 e' si, aggiungere la regola `extended_until` registrabile solo se oggi <= `due_at` (domanda a D4).

## 3. Resources
### `Modules\Gdpr\Filament\Resources\DataSubjectRequestResource`
- Command: vedi sezione 1. Location: `laravel/Modules/Gdpr/app/Filament/Resources/DataSubjectRequestResource.php`. Docs: https://filamentphp.com/docs/5.x/resources/overview
- `protected static ?string $model = DataSubjectRequest::class;`
- Pagine: `ListDataSubjectRequests` (`/`), `CreateDataSubjectRequest` (`/create`), `ViewDataSubjectRequest` (`/{record}`), `EditDataSubjectRequest` (`/{record}/edit`). Niente azione di eliminazione in nessuna pagina (nemmeno `DeleteAction`/`DeleteBulkAction`): il registro e' una prova. **[rev]** Le classi base di Xot le aggiungono da sole, quindi vanno disattivate esplicitamente: `XotBaseEditRecord::getHeaderActions()` ritorna `DeleteAction` (righe 71-76) -> la pagina Edit la sovrascrive con `[]`; `HasXotTable::getTableActions()` aggiunge `DeleteAction` per riga (righe 356-361) e `getTableBulkActions()` aggiunge `DeleteBulkAction` (righe 405-413) -> `DataSubjectRequestsTable` le sovrascrive (azioni di riga: solo `view`/`edit` e le transizioni; bulk: `[]`). Senza questo il test 8 (`assertActionDoesNotExist`) fallisce: la `DeleteAction` esiste, e' solo nascosta dalla policy.
- Etichette: navigation group `GDPR`, icona `heroicon-o-inbox-arrow-down`, label singolare/plurale da `lang`.

### Form (creazione e modifica) - `DataSubjectRequestResource\Schemas\DataSubjectRequestForm`
Colonne del form: 1 (**[rev]** gia' il default di `XotBaseResource::getFormColumns()`, riga 213: non serve `$schema->columns(1)`), con due `Section` a `columnSpanFull()`. Titoli delle `Section` e helper text sono chiavi lang, non testi.
**Section "Richiedente"** (`Filament\Schemas\Components\Section`, https://filamentphp.com/docs/5.x/schemas/sections)
- `requester_name`: `Filament\Forms\Components\TextInput`, Docs https://filamentphp.com/docs/5.x/forms/text-input, Validation `required, string, max:255`, Config `->required()->maxLength(255)`.
- `requester_email`: `Filament\Forms\Components\TextInput`, Validation `nullable, email, max:191`, Config `->email()->maxLength(191)`.
- `user_id`: `Filament\Forms\Components\TextInput`, Validation `nullable, string, size:36`, Config `->maxLength(36)->helperText(...)` (id dell'account, se noto).
**Section "Richiesta"**
- `type`: `Filament\Forms\Components\Select`, Docs https://filamentphp.com/docs/5.x/forms/select, Validation `required, Rule::enum(DataSubjectRequestType::class)`, Config `->options(DataSubjectRequestType::class)->required()`.
- `channel`: `Filament\Forms\Components\Select`, Validation `required, Rule::enum(DataSubjectRequestChannel::class)`, Config `->options(DataSubjectRequestChannel::class)->required()`.
- `received_at`: `Filament\Forms\Components\DateTimePicker`, Docs https://filamentphp.com/docs/5.x/forms/date-time-picker, Validation `required, date, before_or_equal:now`, Config `->required()->default(now())->maxDate(now())->seconds(false)`. **Modificabile solo in creazione.** **[rev]** `->disabled(...)` da solo NON basta: in Filament 5.10.1 un campo disabilitato resta salvato (`HasState::isDehydrated()` righe 782-791 usa `isSaved()`, `true` di default; `CanBeDisabled` non lo toglie), quindi una richiesta Livewire manomessa con `data.received_at` sposterebbe il termine tramite il hook `saving`. Config corretta: `->disabled(fn (string $operation): bool => $operation === 'edit')->dehydrated(fn (string $operation): bool => $operation === 'create')`, **piu'** una guardia nel model (`updating`: se `received_at` e' sporco, ripristina `getOriginal('received_at')`), perche' la garanzia vera sta sul server. Test aggiuntivo: su Edit, `fillForm(['received_at' => ...])` e salvataggio non cambiano `received_at` ne' `due_at`.
- `assigned_to`: `Filament\Forms\Components\TextInput`, Validation `nullable, string, size:36`.
- `extended_until` e `extension_reason`: visibili solo in modifica. `extended_until`: **[rev]** `Filament\Forms\Components\DatePicker` (Docs https://filamentphp.com/docs/5.x/forms/date-picker; la colonna e' `date`), Validation `nullable, date, after_or_equal:<due_at>, before_or_equal:<received_at + 3 mesi NoOverflow>` (regola R5 calcolata dal record, non dal client); `extension_reason`: `Filament\Forms\Components\Textarea`, Validation `required_with:extended_until, nullable, string, max:2000`.
- `notes`: `Filament\Forms\Components\Textarea`, Validation `nullable, string, max:5000`, Config `->rows(4)`.
**Il form NON contiene** `status`, `due_at`, `completed_at`, `identity_verified_at`, `identity_verification_method`, `outcome`, `refusal_basis`: si scrivono solo dalle azioni della sezione "Actions". I campi nascosti o disabilitati di Filament sono controllati dal client e non proteggono nulla: l'unico punto che scrive lo stato e' la `Action`, che autorizza e verifica la transizione sul server.

### Table - `DataSubjectRequestResource\Tables\DataSubjectRequestsTable`
Ordinamento predefinito: scadenza crescente. **[rev]** Non si chiama `->defaultSort()` nella classe Table: `HasXotTable::table()` applica `getDefaultTableSortColumn()` (righe 615-631, default `<tabella>.id`, per un UUID senza significato) e `getDefaultTableSortDirection()` (default `desc`) in coda (righe 278-282). Sovrascrivere i due metodi `protected`: colonna `due_at` (colonna reale; l'espressione `COALESCE(extended_until, due_at)` resta nella colonna `effective_deadline`), direzione `asc`. Filtri: si sovrascrive `getTableFilters()` (public, `HasXotTable` riga 303), non `$table->filters()`. Docs: https://filamentphp.com/docs/5.x/tables/overview
| Colonna | Componente | Config |
|---|---|---|
| `requester_name` | `Filament\Tables\Columns\TextColumn` | `->searchable()->sortable()` |
| `type` | `Filament\Tables\Columns\TextColumn` | `->badge()->sortable()` |
| `status` | `Filament\Tables\Columns\TextColumn` | `->badge()->sortable()` |
| `received_at` | `Filament\Tables\Columns\TextColumn` | `->dateTime('d/m/Y')->sortable()` |
| `effective_deadline` | `Filament\Tables\Columns\TextColumn` | `->state(fn (DataSubjectRequest $r) => $r->effective_deadline)->dateTime('d/m/Y')->color(fn (DataSubjectRequest $r): string => $r->isOverdue() ? 'danger' : 'gray')->sortable(query: fn (Builder $q, string $direction) => $q->orderByRaw('COALESCE(extended_until, due_at) '.$direction))` |
| `assigned_to` | `Filament\Tables\Columns\TextColumn` | `->toggleable(isToggledHiddenByDefault: true)` |
| `channel` | `Filament\Tables\Columns\TextColumn` | `->badge()->toggleable(isToggledHiddenByDefault: true)` |
Filtri (`Filament\Tables\Filters`):
- `status`: `SelectFilter`, `->options(DataSubjectRequestStatus::class)->multiple()`.
- `type`: `SelectFilter`, `->options(DataSubjectRequestType::class)`.
- `overdue`: `Filter`, label da lang (`In ritardo`), `->query(fn (Builder $q): Builder => $q->whereNotIn('status', [terminali])->whereRaw('COALESCE(extended_until, due_at) < ?', [today()->toDateString()]))` (**[rev]** data, non `now()`: vedi R1). Solo colonne fisse nell'SQL, nessun input dell'utente. **[rev]** Anche `orderByRaw('COALESCE(extended_until, due_at) '.$direction)` della colonna `effective_deadline` e' sicuro in Filament 5.10.1: `$direction` e' normalizzato a `asc`/`desc` prima di arrivare alla closure (`vendor/filament/tables/src/Concerns/CanSortRecords.php` riga 94); nessuna modifica necessaria.
`isOverdue()` sul model = non terminale e `effective_deadline` **precedente a oggi** (**[rev]** non `isPast()` sull'istante): stessa definizione del filtro (test di coerenza, sezione 6).

### Infolist (pagina View) - `Schemas\DataSubjectRequestInfolist`
`Filament\Schemas\Components\Section` "Richiedente" (`TextEntry` per `requester_name`, `requester_email`, `user_id`), "Termini" (`TextEntry` per `received_at`, `due_at`, `extended_until`, `extension_reason`, `effective_deadline`), "Esito" (`TextEntry` per `status` come badge, `identity_verified_at`, `identity_verification_method`, `completed_at`, `outcome`, `refusal_basis`, `notes`). Namespace `Filament\Infolists\Components\TextEntry`, Docs https://filamentphp.com/docs/5.x/infolists/text-entry.

### Actions (sulla pagina View e nella riga della tabella), namespace `Filament\Actions\Action`
Docs https://filamentphp.com/docs/5.x/actions/overview. Ogni azione: `->authorize('update')` (policy), visibile solo se la transizione e' ammessa (`->visible(fn (DataSubjectRequest $r): bool => $r->status->canTransitionTo(...))`), e il metodo che scrive rilegge il record e **rifiuta se la transizione non e' ammessa** (difesa lato server, non solo `visible`). Tutte chiamano un'unica `Spatie\QueueableAction` per non duplicare regole: `Modules\Gdpr\Actions\Request\TransitionDataSubjectRequestAction::execute(DataSubjectRequest $request, DataSubjectRequestStatus $to, array $data): DataSubjectRequest` (niente classi `*Service`).
1. **Verifica identita'** (`verify_identity`), Location: header della View + riga. Form: `identity_verification_method` `Select`/`TextInput` obbligatorio (max 255). Behavior: imposta `identity_verified_at = now()`; se lo stato e' `received` passa a `identity_check`, altrimenti lo stato non cambia. **[rev]** Visibilita': stato non terminale **e** `identity_verified_at` nullo (la bozza diceva solo `received`). Motivo: con `take_in_charge` ammesso da `received`, un record poteva arrivare a `in_progress` senza verifica; `verify_identity` spariva (visibile solo in `received`) e `fulfil` restava bloccata da R3 per sempre, a parte rifiuto o ritiro. Sequenza che lo mostra: `received` -> `take_in_charge` -> `in_progress` con `identity_verified_at` nullo -> nessuna via a `fulfilled`. Lo stato `identity_check` e' derivabile da `identity_verified_at`: rimandabile (vedi sezione 7).
2. **Prendi in carico** (`take_in_charge`), Behavior: `-> in_progress`, `assigned_to = auth()->id()`. Visibilita': `received` o `identity_check`.
3. **Evadi** (`fulfil`), `->requiresConfirmation()`. Form: `outcome` `Textarea` `required|string|max:5000`. Behavior: **blocca** (notifica di errore, nessuna scrittura, azione "halted") se `identity_verified_at` e' nullo (R3, D3); altrimenti `-> fulfilled`, `completed_at = now()`, `outcome`. Visibilita': `in_progress`.
4. **Rifiuta** (`refuse`), `->requiresConfirmation()`, `color('danger')`. Form: `refusal_basis` `Textarea` `required|string|max:5000` (art. 12 par. 4: motivi, diritto di reclamo al Garante e di ricorso giurisdizionale: testo di aiuto fisso). Behavior: `-> refused`, `completed_at = now()`.
5. **Ritirata dal richiedente** (`withdraw`), `->requiresConfirmation()`. Behavior: `-> withdrawn`, `completed_at = now()`.
Tutte le scritture avvengono in una transazione sulla connessione `gdpr`. Ogni transizione scrive una riga di attivita' (modulo `Activity`) con vecchio e nuovo stato. **[rev]** Il modulo Activity e' attivo (`modules_statuses.json`); si usa `Modules\Activity\Actions\LogActivityAction` (argomenti nel costruttore: `type`, `user`, `subject`, `properties`, `description`). `properties` contiene **solo** id del record e stati (`from`, `to`), mai nome, email, `outcome` o `refusal_basis`: sono dati personali o testo libero che finirebbero in un log con altra conservazione. La riga di attivita' e' consigliata ma non necessaria all'art. 12 (vedi sezione 7). La classe `TransitionDataSubjectRequestAction` va in `Modules/Gdpr/app/Actions/` (cartelle esistenti: Account, Consent, Cookie, Registration, Validation); la sottocartella `Request` della bozza puo' confondersi con le HTTP Request: usare `DataSubjectRequest/`.

## 4. Authorization
Policy `Modules\Gdpr\Models\Policies\DataSubjectRequestPolicy extends GdprBasePolicy` (cartella e stile di `ConsentPolicy`: `hasPermissionTo('<modello>.<abilita>')`).
- `viewAny`, `view`: permesso `data_subject_request.viewAny` / `.view`.
- `create`: `data_subject_request.create`. `update` (modifica e tutte le azioni): `data_subject_request.update`.
- `delete`, `deleteAny`, `forceDelete`, `forceDeleteAny`, `restore`, `restoreAny`: **sempre `false`**. **[rev]** Aggiungere `replicate` e `reorder` (sempre `false`) e definire **tutti** i metodi, non solo quelli usati: nella modalita' non strict di Filament, se il metodo manca nella policy l'accesso e' **consentito** (`vendor/filament/filament/src/helpers.php` righe 58-95: senza metodo e senza callback `Gate::before` che neghi, `Response::allow()`), e `before()` della policy non viene consultato in quel ramo. `ConsentPolicy` oggi non ha `deleteAny`, `restoreAny`, `forceDeleteAny`, `replicate`, `reorder`: non e' lo stampo da copiare per questo. `GdprBasePolicy::before()` restituisce `true` al super admin per qualsiasi abilita' (confronto con `XotData::make()->super_admin`): la policy deve **sovrascrivere `before()`** e restituire `false` per queste abilita' prima di delegare a `parent::before()`, altrimenti il super admin potrebbe cancellare il registro.
- Permessi da creare (seeder del modulo): `data_subject_request.viewAny`, `.view`, `.create`, `.update` (righe nella tabella `permissions` del database `fixcity_user`, guard `web`: dati, non schema). **[rev]** (a) `hasPermissionTo('nome')` di Spatie lancia `PermissionDoesNotExist` se la riga non esiste (le policy esistenti fanno lo stesso; nel database di sviluppo `permissions` ha **0 righe**, misurato con tinker in sola lettura il 2026-10-15): i permessi vanno seminati prima del primo accesso e i test devono creare la riga anche per i casi di diniego, altrimenti il diniego e' un'eccezione e non un 403. (b) Per aprire `gdpr/admin` serve il ruolo `gdpr::admin` (`BaseUser::canAccessPanel()`, `Modules/User/app/Models/BaseUser.php` righe 319-335: `hasRole($panel->getId())`); un ruolo `dpo` da solo non basta. Default proposto: dare i 4 permessi al ruolo **esistente** `gdpr::admin` (nel database di sviluppo c'e'), senza creare il ruolo `dpo` (rimandabile; se D1 lo vuole, l'utente deve avere entrambi i ruoli).
- Pannello: `->strictAuthorization()` nel provider `Modules/Gdpr/app/Providers/Filament/AdminPanelProvider.php` (oggi non impostato) fa lanciare un errore se manca un metodo di policy invece di aprire l'accesso; da valutare perche' cambia il comportamento delle risorse gia' presenti. **[rev]** Sconsigliato qui: con `strictAuthorization()` le quattro risorse esistenti (policy senza `deleteAny` ecc.) lancerebbero `LogicException` (`helpers.php` righe 66-80). Rimandabile a una story che completi prima le policy esistenti; per il registro basta la policy completa.

## 5. Widgets
**[rev] Rimandabile** (ponytail): il filtro "In ritardo" e l'ordinamento per scadenza gia' mostrano le richieste a rischio; il widget non serve all'art. 12. Se si fa: estende `Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget` (esiste), non `Filament\Widgets\StatsOverviewWidget` come scriveva la bozza (regola: mai estendere classi Filament direttamente). `Modules\Gdpr\Filament\Widgets\DataSubjectRequestsOverview` (namespace `Filament\Widgets\StatsOverviewWidget\Stat`), Docs https://filamentphp.com/docs/5.x/widgets/stats-overview. Tre `Stat`: "Aperte" (non terminali), "In scadenza entro 7 giorni", "In ritardo" (colore `danger` se > 0). Stesse definizioni di R1 e di `isOverdue()`. `canView()` rispetta `viewAny` della policy.

## 6. Tests
Pest, con gli helper di Filament verificati nel sorgente installato (`vendor/filament/actions/src/Testing/TestsActions.php`, `tables/src/Testing/*`): `callAction`, `assertActionHidden`, `assertActionVisible`, `assertActionHalted`, `assertActionDoesNotExist`, `filterTable`. **Scrivere in `Modules/Fixcity/tests/Feature/Gdpr/DataSubjectRequestTest.php`** e usare `bash bashscripts/tools/pest-scratch-db.sh` (DB di prova, mai quello di sviluppo). **[rev]** Il motivo della bozza ("i test di `Modules/Gdpr/tests` non avviano l'applicazione") non e' provato; quello verificato: `Modules/Gdpr/tests/TestCase.php` lavora su SQLite condiviso con `DatabaseTransactions` sulla connessione `sqlite`, mentre i test del repo girano su MariaDB (`pest-scratch-db.sh`, intestazione), e i test di pannello Filament esistenti stanno in `Modules/Fixcity/tests/Feature/Filament/` con `Modules\Fixcity\Tests\TestCase` (`Filament::setCurrentPanel('...')` + `actingAs`). **Trappola:** `pest-scratch-db.sh` clona solo le tabelle che esistono gia' nei database di sviluppo (righe 37-43 dello script): `data_subject_requests` non ci sara' finche' la migrazione non e' approvata ed eseguita. Il test deve quindi eseguire la migrazione sul database scratch (`(require $path)->up()` in un helper del file di test, mai sullo sviluppo). Non provato: va verificato alla prima esecuzione. Il test imposta `Filament::setCurrentPanel('gdpr::admin')`, assegna all'utente il ruolo `gdpr::admin` e crea le righe `permissions` necessarie.
Casi con ingressi che discriminano (valori attesi derivati dalla norma, non dal codice):
1. **R1, fine mese:** `received_at = 2026-01-31` -> `due_at = 2026-02-28`; `2026-03-31` -> `2026-04-30`; `2026-05-15` -> `2026-06-15`. Con `addMonth()` i primi due casi darebbero `2026-03-03` e `2026-05-01`: il test deve fallire in quel caso.
2. **R1, salvataggio invariato:** aprire e salvare il form senza modifiche non cambia `due_at`; cambiare `received_at` (solo in creazione) lo ricalcola.
3. **R5:** `extended_until` oltre `received_at + 3 mesi` rifiutata; prima di `due_at` rifiutata; senza `extension_reason` rifiutata; valida -> `effective_deadline = extended_until`.
4. **Transizioni (asimmetrico):** da `fulfilled` nessuna azione e' visibile (`assertActionHidden` per le cinque); da `received` solo "Verifica identita'", "Prendi in carico", "Rifiuta", "Ritirata". **[rev]** Da `in_progress` con `identity_verified_at` nullo "Verifica identita'" e' visibile; con `identity_verified_at` valorizzato e' nascosta.
5. **R3:** "Evadi" con `identity_verified_at` nullo e' `assertActionHalted`, lo stato resta `in_progress`; dopo "Verifica identita'" riesce. **[rev]** Percorso completo che la bozza non permetteva: `received` -> "Prendi in carico" -> "Verifica identita'" (stato resta `in_progress`) -> "Evadi" riesce.
6. **Rifiuto:** senza `refusal_basis` errore di validazione sul campo; con il testo `status = refused` e `completed_at` valorizzato.
7. **Manomissione:** il form di modifica non ha il campo `status` (`assertFormFieldDoesNotExist('status')`) e una richiesta Livewire che prova a impostare `data.status` non cambia il record.
8. **Autorizzazione (asimmetrica):** senza permesso `viewAny` la lista risponde 403; con `data_subject_request.viewAny` ma senza `.update` le azioni sono nascoste; **il super admin non puo' eliminare** (`Gate::forUser($superAdmin)->denies('delete', $record)`, e lo stesso per `deleteAny`, `restore`, `forceDelete`, `replicate`, `reorder`), e nel registro non esiste nessuna azione di eliminazione (riga, testata Edit, bulk: vedi sezione 3). **[rev]** Per i casi di diniego la riga `permissions` esiste ma non e' assegnata: altrimenti `PermissionDoesNotExist` darebbe un'eccezione che un test sbagliato scambia per un diniego.
9. **Coerenza filtro/colonna/widget:** su un insieme con una richiesta `fulfilled` scaduta, una `in_progress` scaduta e una `in_progress` nel termine, il filtro "In ritardo", `isOverdue()` e la statistica "In ritardo" (se il widget si fa) danno lo stesso insieme (1 elemento). **[rev]** Confine sul giorno: con `due_at = oggi` la richiesta `in_progress` NON e' in ritardo; con `due_at = ieri` lo e' (orario del test diverso da mezzanotte, per escludere il confronto sull'istante).
10. **Audit:** una transizione lascia `updated_by` e una riga di attivita' (se il modulo Activity e' attivo). **[rev]** Una creazione da Filament lascia `created_by` valorizzato (la bozza non lo copriva e `Updater` non lo fa); la riga di attivita' non contiene nome, email, `outcome` ne' `refusal_basis`.
11. **[rev] Campo disabilitato:** su Edit, un valore manomesso per `data.received_at` non cambia `received_at` ne' `due_at` (vedi sezione 3, Form).
12. **[rev] Mass assignment:** `DataSubjectRequest::create([... 'status' => 'fulfilled', 'due_at' => ..., 'created_by' => ...])` non imposta quei campi (restano default/calcolati).

## Verifiche fatte e non fatte
Fatte: esistenza e namespace dei componenti `Action`, `Select`, `TextInput`, `Textarea`, `DateTimePicker`, `TextColumn`, `SelectFilter`, `Filter`, `Section`, `TextEntry`, `StatsOverviewWidget`, `Stat`, contratti `HasLabel`, `HasColor`, `HasIcon` e helper di test nel sorgente installato (`vendor/filament/*`); opzioni dei comandi `module:make-model` e `make:filament-resource`; pannello `gdpr::admin`; tipi delle colonne `users.id` (`varchar(36)`), `consents.id` (`uuid`); comportamento di `GdprBasePolicy::before()`.
**Non fatte:** la ricerca nella documentazione (`search-docs` di Boost) non era raggiungibile in questa sessione (server MCP non connesso): gli URL `filamentphp.com/docs/5.x/...` seguono lo schema usato dalla skill e non sono stati aperti uno per uno. **[rev]** I due punti che la bozza lasciava aperti sono ora verificati sul sorgente installato: `->options(Enum::class)` (`forms/src/Components/Concerns/HasOptions.php` righe 20-45, richiede `HasLabel`) e `Action::authorize()` (`actions/src/Concerns/CanBeAuthorized.php` riga 34, usa il record da solo, righe 82-84). Il comportamento di `XotBaseResource` con risorse che usano `Schemas/` e `Tables/` e' stato dedotto da `ConsentResource`. Nessun codice e' stato scritto o eseguito per questo piano.

## 7. Revisione del 2026-10-15 (DCP-254, skill `reviewing-filament-plans` applicata al piano contro il repo)
Metodo: il piano e' stato confrontato con il codice e con il database di oggi, non con se stesso. Nessun codice e' stato scritto, nessuna migrazione creata o eseguita, nessun comando che scrive. Livello di prova di ogni riga: **sorgente letto** (S), **comando di sola lettura eseguito** (L: `route:list`, `config:show`, `db:table`, `--help`, tinker con sole letture), **non eseguito** (N). Story con l'elenco completo, le domande e l'esito di DCP-180/181: [`dcp-254`](../stories/dcp-254-revisione-blueprint-registro-richieste-interessato.story.md).

### 7.1 Errori trovati nella bozza e dove sono corretti
| ID | Errore nella bozza | Prova | Corretto in |
|---|---|---|---|
| RV-01 | "Il generatore scrive in `app/Filament`" | Il pannello ha un solo percorso di scoperta (L: tinker `getResourceNamespaces()` = `Modules\Gdpr\Filament\Resources`); `HasResourcesLocation.php` righe 46-51 (S) | sez. 1 |
| RV-02 | `module:make-policy` come passo del piano | scrive in `app/Policies` (`config/modules.php:132`, S), le policy del modulo stanno in `app/Models/Policies` (L: `ls`) | sez. 1 |
| RV-03 | "Le colonne di audit le aggiunge XotBaseMigration" | `tableCreate()` riga 294 non le aggiunge; `updateTimestamps()` riga 351 solo se chiamata (S); `create_treatments_table` la chiama | sez. 2 |
| RV-04 | Stampo migrazione `000006_create_consents_table` | e' solo `tableUpdate`; `consents` ha 4 file `create_*` (L: `ls`), contro `one-migration-per-model.md` | sez. 2 |
| RV-05 | `created_by` dato per scontato | `Updater.php` righe 76-86: lo imposta solo se la chiave e' gia' tra gli attributi (S) | sez. 2 |
| RV-06 | Nessun `$fillable` | `XotBaseModel` senza `$fillable`/`$guarded`, nessun `unguard()` (S); `Consent` mette `created_by` in `$fillable` | sez. 2 |
| RV-07 | `due_at`/`extended_until` timestamp, "in ritardo" con `< now()` | richiesta del 15/05 10:00: in ritardo il 15/06 10:01, cioe' l'ultimo giorno utile (ragionamento, N); Carbon 3.14.2 riprova `addMonthNoOverflow` (L: `php -r`) | sez. 2, R1, R5, filtro, `isOverdue()` |
| RV-08 | `verify_identity` visibile solo in `received`: vicolo cieco | `received` -> `take_in_charge` -> `in_progress` senza verifica; `fulfil` bloccata da R3 (ragionamento sul testo del piano, N) | sez. 3 Actions, test 4-5 |
| RV-09 | `received_at` protetto con `->disabled()` | `disabled()` non toglie la dehydration: `HasState.php` righe 782-791, `isSaved` vero di default (S); contraddice la frase finale della stessa sezione | sez. 3 Form, test 11 |
| RV-10 | "Niente DeleteAction" senza sovrascrivere le classi base | `XotBaseEditRecord` righe 71-76, `HasXotTable` righe 356-361 e 405-413 (S): il test 8 sulla non esistenza fallirebbe | sez. 3, pagine e Table |
| RV-11 | Classi base non indicate; `->defaultSort('due_at')` nella Table | `Assert::subclassOf` in `XotBaseResource` righe 157, 187 e 231 (inizio dei tre metodi); `HasXotTable::table()` righe 278-282 e 615-640 (S) | sez. 1, 3 Table |
| RV-12 | Policy senza `replicate`/`reorder`; `strictAuthorization` "da valutare" | `helpers.php` righe 58-95: metodo mancante = accesso consentito in modo non strict; con strict le 4 risorse esistenti lancerebbero `LogicException` (S) | sez. 4 |
| RV-13 | Permessi/ruolo `dpo` | `permissions` ha 0 righe in sviluppo, Spatie lancia `PermissionDoesNotExist` (L: tinker in lettura); `canAccessPanel` richiede il ruolo `gdpr::admin` (`BaseUser.php` 319-335, S); il ruolo `dpo` non esiste (L) | sez. 4, D1 |
| RV-14 | Etichette enum in `data_subject_request.php` chiave `type.<valore>` | `EnumTrait.php` righe 16-28 + `TransTrait::getKeyTransClass()` righe 54-70 (S): un file per enum, chiavi `values.<valore>.label` | sez. 2 |
| RV-15 | Widget che estende `Filament\Widgets\StatsOverviewWidget` | esiste `XotBaseStatsOverviewWidget` (L: `ls`); regola "mai estendere Filament direttamente" | sez. 5 |
| RV-16 | Motivo del luogo dei test non provato; tabella nel DB scratch | `pest-scratch-db.sh` righe 37-43 clona solo tabelle esistenti in sviluppo (S); `Gdpr/tests/TestCase.php` usa SQLite | sez. 6 |
| RV-17 | Riga di attivita' senza limite sui dati | `LogActivityAction` salva `properties` cosi' come arrivano (S): nome/email/`outcome` finirebbero nel log | sez. 3 Actions, test 10 |
| RV-18 | Proroga "entro il primo mese" non imposta | nota DCP-176 in `dcp-140` vs R5 | sez. 2 R5, D4 |

### 7.2 Confermato vero (non toccato)
Pannello `gdpr::admin`, path `gdpr/admin` (L: `route:list` e tinker). Versioni Filament 5.10.1, Livewire 4.4.7, Laravel 13.35.0, blueprint 2.4.0 (S: `composer.lock`). Connessione `gdpr` -> database `fixcity_data`, MariaDB 11.8.6 (L). `users.id` `varchar(36)` in `fixcity_user`, `consents.id` `uuid` (L). Righe di `XotBaseMigration` 294, 320 e 366-385 (S). `GdprBasePolicy::before()` restituisce `true` al super admin e va sovrascritta (S). Helper di test `assertActionHidden/Visible/Halted/DoesNotExist`, `assertFormFieldDoesNotExist`, `filterTable`, `assertTableBulkActionHidden` (S). Date di R1 (L: Carbon). `->options(Enum::class)` e `Action::authorize()` esistono (S). `orderByRaw(... $direction)` della colonna e' sicuro: direzione normalizzata in `CanSortRecords.php` riga 94 (S).

### 7.3 Parti speculative: rimandabili (non cancellate)
Il minimo per l'art. 12 e': registrare (tipo, canale, richiedente, data di ricevimento), scadenzare (R1, proroga se D4), tracciare l'esito (stato, `completed_at`, `outcome`, `refusal_basis`), con audit. Sono **rimandabili**: widget di sezione 5; stato `identity_check` (derivabile da `identity_verified_at`); riga di attivita' per transizione (consigliata, non richiesta); ruolo `dpo` e seeder dedicato (basta `gdpr::admin`); `strictAuthorization()`; colonne `assigned_to`, `identity_verification_method`, `notes`; indici su `status`, `requester_email`, `user_id` (poche righe: un ordinamento senza indice basta; resta l'indice su `due_at`); modulo pubblico per il cittadino (D2, gia' fase successiva).

### 7.4 Elenco esatto di cio' che richiede l'approvazione dell'utente
Nuova tabella `data_subject_requests`, connessione `gdpr`, database `fixcity_data` (MariaDB), un solo file `Modules/Gdpr/database/migrations/<timestamp>_create_data_subject_requests_table.php` (XotBaseMigration), **scritto ma non eseguito** sul database di sviluppo prima del si.
| Colonna | Tipo | Null / default | Indice | Note |
|---|---|---|---|---|
| `id` | uuid | PK | primaria | `HasUuids` |
| `type` | string(20) | no | no | enum a 6 valori |
| `status` | string(20) | no, `received` | `status` (rimandabile) | enum a 6 valori |
| `channel` | string(20) | no | no | enum a 5 valori |
| `requester_name` | string(255) | no | no | D6 |
| `requester_email` | string(191) | si | `requester_email` (rimandabile) | D6 |
| `user_id` | string(36) | si | `user_id` (rimandabile) | senza chiave esterna (altro database) |
| `received_at` | timestamp | no | no | |
| `due_at` | date | no | `due_at` | calcolata (R1) |
| `extended_until` | date | si | no | D4 |
| `extension_reason` | text | si | no | D4 |
| `identity_verified_at` | timestamp | si | no | D3 |
| `identity_verification_method` | string(255) | si | no | D3 (rimandabile) |
| `assigned_to` | string(36) | si | no | D1 (rimandabile) |
| `completed_at` | timestamp | si | no | |
| `outcome` | text | si | no | |
| `refusal_basis` | text | si | no | obbligatoria se rifiutata (art. 12 par. 4) |
| `notes` | text | si | no | (rimandabile) |
| `created_at`, `updated_at` | timestamp | si | no | `updateTimestamps()` |
| `created_by`, `updated_by` | uuid | si | no | `updateTimestamps()`, senza vincolo |
In tutto 22 colonne (18 proprie + 4 di audit; nessuna `deleted_at`/`deleted_by`). Se si tolgono le colonne e gli indici rimandabili restano 19 colonne e un solo indice oltre alla chiave. **Dati (non schema):** 4 righe in `fixcity_user.permissions` (`data_subject_request.viewAny|view|create|update`, guard `web`) assegnate al ruolo esistente `gdpr::admin`; nessun ruolo nuovo salvo D1. **Menu:** una voce, gruppo `GDPR`, icona `heroicon-o-inbox-arrow-down`, ordine da fissare con `lang` (`consent` usa 62); pannello e rotte non cambiano (`gdpr/admin/data-subject-requests`). **File lang** (non schema): 4 (resource) + 12 (3 enum) = 16 file in it, en, de, es.

### 7.5 D1-D7: domanda per l'utente (una riga)
| # | Default proposto | Domanda |
|---|---|---|
| D1 | permessi `data_subject_request.*` al ruolo `gdpr::admin` | Chi (ruolo e persone) vede e gestisce il registro, e c'e' gia' un DPO nominato (DEC-06)? |
| D2 | solo il personale registra (PEC, email, sportello, posta) | Le richieste le registra solo il personale o serve anche un modulo per il cittadino? |
| D3 | senza `identity_verified_at` non si evade | Per evadere serve sempre la verifica dell'identita', e con quale metodo ammesso? |
| D4 | proroga fino a 3 mesi totali con motivazione, registrabile solo entro il primo mese | Si usa la proroga dell'art. 12 par. 3 e chi la puo' registrare? |
| D5 | nessuna cancellazione del registro | Per quanto tempo si conserva il registro (nessun valore proposto, lo decide il DPO, DCP-141)? |
| D6 | nome ed email come testo, `user_id` facoltativo | Si possono registrare nome ed email del richiedente (va detto nell'informativa)? |
| D7 | cancellazione/anonimizzazione fuori dal registro | Confermi che l'esecuzione della cancellazione e il destino dei ticket restano fuori (DEC-10)? |

### 7.6 Non verificato
Il parere del DPO o di un legale su tutte le D e sul modo di contare il mese (R1). Il testo del Reg. 1182/71 e delle linee guida EDPB (non letti). Gli URL `filamentphp.com/docs/5.x` (non aperti, `search-docs` non raggiungibile). Il comportamento a runtime di RV-08, RV-09 e RV-10 (ricavato dal sorgente, nessun test eseguito). Che `(require $path)->up()` funzioni sul database scratch (RV-16). Il layout esatto prodotto dal generatore con `--no-interaction` (non lanciato). Che `LogActivityAction` accetti un `subject` di un'altra connessione senza problemi. Nessuna verifica nel browser.
