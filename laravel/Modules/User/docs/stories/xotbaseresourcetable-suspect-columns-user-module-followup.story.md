---
title: "Follow-up — colonne sospette/bug reale trovati nell'audit \$model (modulo User)"
type: story
module: User
epic: xotbaseresourcetable-model-property-and-column-audit
created: '2026-09-11'
updated: '2026-09-11'
status: resolved
---

# Follow-up — colonne sospette e bug reale (modulo User)

## Story

Durante l'audit `$model`+colonne (epic root
`xotbaseresourcetable-model-property-and-column-audit`, workflow
2026-09-11), i batch User-A/B/C hanno segnalato — senza correggerli,
fuori `owned_scope` del batch — questi elementi. Il primo e' un bug
reale con rischio di errore SQL a runtime, gli altri sono drift di
migrazione da verificare.

## Bug reale (priorita' alta)

**`OauthClientResource.php`** e' rimasto configurato sul model Passport
vanilla (`Laravel\Passport\Client`, connessione default) invece del
model custom del progetto (`Modules\User\Models\OauthClient`, connessione
`user`). Conseguenza verificata: `grant_types`, `redirect_uris`,
`owner_id`, `owner_type` — colonne dichiarate in
`OauthClientResource/Tables/OauthClientsTable.php:getTableColumns()` —
NON esistono sulla tabella `oauth_clients` vista dal model Passport
vanilla (esistono solo su quella vista dal model custom via connessione
`user`). `->searchable()`/`->sortable()` su quelle colonne puo' produrre
un errore SQL reale a runtime se la Resource resta sul model sbagliato.

**Azione richiesta**: verificare quale dei due model `OauthClientResource`
dovrebbe usare (probabile fix: allineare a `ClientResource::getModel()`,
gia' corretto, che risolve via `Passport::clientModel()` →
`config('user.passport.client_model', OauthClient::class)`), poi
decidere il destino dei 3 file Table duplicati collegati (vedi
`docs/stories/xotbaseresourcetable-dead-code-duplicate-table-classes-followup.story.md`
in root).

## Drift di migrazione da verificare (non bug di codice, verificare in staging/prod)

1. `PermissionResource/Tables/PermissionsTable.php` — `display_name`/
   `description` non sono mai esistite nello schema `permissions`
   (nessuna migration le ha mai create, solo in `$fillable`). Un batch
   parallelo aveva aggiunto `searchable()/sortable()` su `display_name`
   (rischio SQL error) — gia' revertito da User-B durante l'audit; le
   colonne restano comunque nel `getTableColumns()`, decisione di design
   pendente (rimuoverle o crearle via migration?).
2. `DeviceResource/Tables/DevicesTable.php` — `uuid` presente nella
   migration di CREATE e nel model, assente sulla tabella live.
3. `TenantsTable.php:28-30` (`domain`, `is_active`, `trial_ends_at`) —
   esistono solo sul model nativo `Modules\User\Models\Tenant`, non sul
   model realmente attivo via `tenant_class`
   (`Modules\Quaeris\Models\Customer`) — probabile residuo di un vecchio
   switch di config, verificare quale tenant model e' davvero in uso.
4. `TenantUsersTable.php:27,29` (`role`, `uuid`) — assenti da schema live
   e da entrambe le migration (`role` letteralmente commentata nel
   sorgente).
5. `TeamUsersTable.php:29` (`uuid`) — assente da schema live e da tutte
   le 4 migration, solo un docblock nel model senza backing reale.
6. Model `OauthDeviceCode` — non dichiara `$connection = 'user'` a
   differenza dei 5 model Oauth* fratelli, tabella introvabile in nessuna
   connection nell'ambiente di sviluppo corrente.

## Verifica tecnica gia' fatta

Tutte le colonne sopra sono state verificate con
`Schema::connection($model->getConnectionName())->getColumnListing(...)`
(mai senza specificare la connection — un primo giro senza aveva
prodotto 8 falsi positivi, vedi commit `095973bd`), e incrociate con
`git log -S`/le migration reali dove la tabella era assente nell'ambiente
dev.

## Second brain

Nuovo pattern: verificare lo schema di un model con `Schema::` senza
specificare `->connection()` e' cieco su un modulo che usa connection
DB multiple (`user` vs default vs `quaeris`) — produce falsi positivi
sistematici, non solo occasionali.

## Risoluzione (2026-09-11, sessione follow-up)

### Task A — bug reale, FIXATO

`OauthClientResource.php` (`app/Filament/Resources/OauthClientResource.php`)
aveva `protected static ?string $model = Client::class;` (Passport
vanilla). Allineato al pattern gia' corretto di `ClientResource`:
override di `getModel()` che risolve `Passport::clientModel()` con
fallback a `Client::class` se la classe non esiste. Dopo il fix:

- `Passport::clientModel()` = `Modules\User\Models\OauthClient`
  (risolto da `PassportServiceProvider` via
  `config('user.passport.client_model', OauthClient::class)`, gia'
  impostato correttamente in `Modules/User/config/passport.php:77`).
- `OauthClientResource::getModel()` = `Modules\User\Models\OauthClient`
  (connessione `user`).
- `OauthClientResource::getTableClass()` ora risolve a
  `OauthClientResource\Tables\OauthClientsTable` (prima risolveva a
  `OauthClientResource\Tables\ClientsTable`, la classe "gemella" sul
  model sbagliato).
- Verificato con `Schema::connection('user')->getColumnListing('oauth_clients')`:
  `grant_types`, `redirect_uris`, `owner_id`, `owner_type` tutte
  presenti. Nessun rischio SQL residuo.

Effetto collaterale del fix: `OauthClientResource/Tables/ClientsTable.php`
(che prima era la classe live) e' diventato dead code — vedi Task B.

### Task B — dead code / duplicati, deciso file per file

Verificato ogni file con `git log --follow` prima di cancellare (tutti
mostravano solo il commit iniziale `c24b0725 first` + il commit bulk
`71a61955 feat(tables): aggiunge $model esplicito...` dell'audit di
oggi, nessun refactor a meta' in corso):

- **Cancellato** `ClientResource/Tables/ClientsTable.php` — mai
  risolto: `ClientResource::getModel()` risolve a `OauthClient`, plurale
  `OauthClients`, non `Clients`.
- **Cancellato** `OauthClientResource/Tables/ClientsTable.php` — era la
  classe live prima del fix Task A, ora dead code (vedi sopra).
- **Cancellato** `PersonalAccessTokenResource/Tables/PersonalAccessTokensTable.php`
  — `PersonalAccessTokenResource::getModel()` = `OauthAccessToken`,
  plurale `OauthAccessTokens`; la classe live e' sempre stata
  `OauthAccessTokensTable.php`.
- **Cancellato** `BaseUserResource.php` + l'intera dir
  `BaseUserResource/` (Tables/Schemas) — `grep -rn "extends BaseUserResource"`
  su tutto il repo non trova nessuna occorrenza; `UserResource` estende
  `XotBaseResource` direttamente e duplica gia' il contenuto utile
  (stesso docblock/struttura, senza il modificatore `abstract`).
- **Cancellato** `BaseProfileResource/Tables/BaseProfilesTable.php` —
  `ProfileResource extends BaseProfileResource` e' l'unico extender,
  ma `ProfileResource::getTableClass()` risolve alla propria
  `ProfileResource\Tables\ProfilesTable.php` (verificato via tinker),
  mai a `BaseProfileResource\Tables\BaseProfilesTable.php`. **Nota**:
  `BaseProfileResource` stesso NON e' dead code (la sua
  `Pages\ListProfiles` e' ereditata e usata da `ProfileResource`) — solo
  quel singolo file Table lo era.
- **Mantenuto e corretto** `OauthClientResource/Tables/OauthClientsTable.php`
  — ora e' la classe live (post Task A). Aveva un `protected static
  string $model = Client::class;` vestigiale (mai letto da
  `XotBaseResourceTable`, solo un residuo di copia-incolla): corretto a
  `OauthClient::class` per coerenza col resto del file. Colonne
  (`grant_types`, `redirect_uris`, `owner_id`, `owner_type`) verificate
  esistenti, nessuna modifica a `searchable()/sortable()` necessaria.

**Nuovo finding fuori dall'elenco originale** (documentato, nessuna
azione presa: fuori scope Task B/C, nessuna delle due story lo
elencava): `TenantResource/Tables/TenantsTable.php` dichiara
`$model = Customer::class` ma usa colonne (`domain`, `is_active`,
`trial_ends_at`) che esistono solo sul model `Tenant`, non su
`Customer`. Verificato via tinker che
`TenantResource::getTableClass()` risolve oggi a
`TenantResource\Tables\CustomersTable.php` (esistente, colonne
coerenti col model `Customer`) — quindi `TenantsTable.php` e'
**gia' dead code indipendentemente dalle colonne sospette**, nessun
rischio SQL a runtime. Probabile residuo di un vecchio switch
`tenant_class: Tenant → Customer` mai ripulito. Raccomandazione:
story separata per decidere se cancellare `TenantsTable.php` (non
fatto qui — non era nell'elenco delle 2 story di partenza e tocca
`Modules\Quaeris\Models\Customer`, modulo diverso da quello owner di
questa story).

### Task C — drift di migrazione, verificato e documentato (nessun fix necessario)

Tutte le colonne verificate con
`Schema::connection($model->getConnectionName())->getColumnListing(...)`
+ `git log`/grep sulle migration reali del modulo:

1. **`PermissionsTable.php`** — `display_name`/`description`: confermato
   MISSING su connessione `user` e in NESSUNA delle 4 migration
   `create_permission(s)_table.php` del modulo. Nessuna `searchable()`/
   `sortable()` presente su queste colonne (gia' rimossa da User-B in
   un batch precedente, commento in-code che cita l'issue #90) — nessun
   fix necessario, nessun rischio SQL. Decisione di design (rimuovere le
   colonne da `getTableColumns()` o crearle via migration) resta
   pendente, non presa qui per rispettare "NON creare nuove migration".
2. **`DevicesTable.php`** — `uuid`: confermato MISSING sulla tabella
   live (`user` connection) ma la migration `create_devices_table.php`
   la crea (`$table->string('uuid', 36)->nullable()->index();`) — drift
   ambientale puro (migration non applicata in questo ambiente dev, non
   un bug di codice). Nessuna `searchable()/sortable()` su `uuid` nel
   Table file — nessun fix necessario.
3. **`TenantsTable.php:28-30`** — vedi Task B sopra: il file e' dead
   code oggi (tenant model attivo e' `Customer`, non `Tenant`); quando
   `Tenant` era/sara' il model attivo le colonne `domain`/`is_active`/
   `trial_ends_at` esistono davvero su quella connessione (verificato).
   Nessun fix necessario.
4. **`TenantUsersTable.php:27,29`** (`role`, `uuid`) — confermato
   MISSING su connessione `user` (tabella `tenant_user`) e in
   NESSUNA delle 2 migration (`role` e' letteralmente commentata:
   `// $table->string('role')->nullable();`; nessuna colonna `uuid` mai
   dichiarata, solo `user_id` di tipo uuid). Nessuna `searchable()/
   sortable()` presente su `role`/`uuid` nel Table file — nessun fix
   necessario nonostante la colonna non esista in nessuna migration.
5. **`TeamUsersTable.php:29`** (`uuid`) — confermato MISSING sulla
   tabella live (`team_user`), ma DUE migration (`2025_01_22_120000` e
   `2026_01_12_114416_create_team_user_table.php`) rinominano
   condizionalmente `id` → `uuid` ("Se non esiste gia', rinominiamo id
   a uuid per preservare i dati") — drift ambientale, non colonna mai
   esistita. Nessuna `searchable()/sortable()` presente — nessun fix
   necessario.

Conclusione Task C: nessuna delle colonne sospette ha
`searchable()/sortable()` attivo oggi (gia' bonificate in batch
precedenti dell'audit), quindi la condizione per il "fix sicuro"
esplicitamente autorizzato (rimuovere searchable/sortable da colonna
confermata inesistente ovunque) non si applica a nessun caso: non e'
stato necessario alcun fix di codice, solo verifica e documentazione.

### Task D — fix isolato, FIXATO

`Modules\User\Models\OauthDeviceCode` non dichiarava `protected
$connection = 'user';` a differenza dei 5 model Oauth* fratelli
(`OauthClient`, `OauthAccessToken`, `OauthAuthCode`,
`OauthPersonalAccessClient`, `OauthRefreshToken`). Aggiunta la riga per
coerenza col pattern. **Nota verificata**: la tabella
`oauth_device_codes` non esiste oggi in NESSUNA connection configurata
(`user`, `mysql`, `quaeris`, ecc.) ne' in nessuna migration del modulo
`User` — esiste solo la migration vendor
`vendor/laravel/passport/database/migrations/2024_06_01_000001_create_oauth_device_codes_table.php`,
mai pubblicata/adattata alla connessione `user` come fatto per gli
altri modelli Oauth*. Il fix e' corretto e coerente ma **non risolve**
l'assenza della tabella: nessuna migration creata qui (esplicitamente
vietato dal task), segnalato come gap pre-esistente per una story
futura del modulo Passport/User.

### Verifica finale

- PHPStan `Modules/User`: vedi rito di chiusura in fondo al report.
- Pest `Modules/User`: vedi rito di chiusura.
- Tutti i file toccati/cancellati sono stati lockati prima della
  modifica con `bashscripts/lock/lock.sh` e sbloccati dopo, come da
  regola di sicurezza multi-agente.
