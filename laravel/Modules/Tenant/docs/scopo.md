---
issues: []
discussions: []
title: "Tenant — scopo, confini e come servirlo meglio"
type: concept
module: Tenant
status: active
created: 2026-09-02
updated: 2026-09-02
tags: [scopo, confini, configurazione, bootstrap, connection, dipendenze]
qmd: "scopo tenant configurazione per host bootstrap database connections morph map confini dipendenze"
---

# Tenant — scopo, confini e come servirlo meglio

## Lo scopo, dedotto dal codice

Il README di questo modulo promette isolamento dei dati per tenant, subscription e
routing multi-dominio. Il codice fa un'altra cosa, più piccola e più critica:
**decide quale configurazione esiste, prima che esista l'applicazione.**

La catena è leggibile in tre file.

1. `app/Actions/GetTenantNameAction.php:23-32` prende `SERVER_NAME`, ne inverte i
   segmenti (`ptvx.local` → `local/ptvx`) e verifica con `file_exists()` che esista
   la cartella `config_path('local/ptvx')`. Non interroga il database: non può, il
   database non è ancora configurato. La riga 98 lo dice esplicitamente —
   *«Durante LoadConfiguration le facade non sono ancora disponibili — usare getenv»*.
2. Quella cartella esiste davvero: `config/local/ptvx/` contiene **22 file**
   (`app.php`, `auth.php`, `database.php`, `morph_map.php`, `permission.php`,
   `xra.php`, …) che sovrascrivono la config globale per quell'host.
3. `app/Providers/TenantServiceProvider.php:61-77` (`registerDB`) sostituisce
   **interamente** `config('database')` con quello del tenant, e prima di scriverlo
   chiama `mergeModuleConnections()` (riga 138): per ogni modulo installato,
   se non esiste già una connection con il suo nome snake, ne crea una copiando
   quella di default.

L'ultimo passaggio è il più importante e il meno documentato. In
`config/local/ptvx/database.php` sono dichiarate a mano **20** connection —
`ptv`, `generale`, `performance`, `user`, `incentivi`, … — ognuna verso un database
fisico diverso. Le connection **`xot` e `tenant` non compaiono in nessun file di
configurazione del progetto**, eppure `Modules\Xot\Models\XotBaseModel:40` dichiara
`protected $connection = 'xot'` e `Modules\Tenant\Models\BaseModel:12` dichiara
`'tenant'`. Esistono solo perché `mergeModuleConnections()` le sintetizza a runtime.
Se questo modulo non fa il suo lavoro, ogni modello che non sovrascrive la
connection va in errore.

| Fatto | Comando | Valore |
|---|---|---|
| Modelli | `find Modules/Tenant/app/Models -maxdepth 1 -name '*.php' \| wc -l` | **9** |
| Migrazioni | `ls Modules/Tenant/database/migrations/*.php \| wc -l` | **3** |
| Actions | `find Modules/Tenant/app/Actions -name '*.php' \| wc -l` | **15** |
| File Filament | `find Modules/Tenant/app/Filament -name '*.php' \| wc -l` | **8** (1 sola Resource: `DomainResource`) |
| File PHP in `app/` / righe | `find Modules/Tenant/app -name '*.php' \| xargs wc -l` | **52 / 3.684** |
| File oltre 500 righe | `... \| awk '$1>500'` | **0** |

Da qui la formulazione in una riga:

> **Tenant traduce un nome host in una cartella di configurazione e da lì riscrive
> `config('database')`, sintetizzando una connection per ogni modulo installato.
> È il pezzo che gira per primo: non isola i dati di un tenant, decide quali dati
> l'applicazione è in grado di raggiungere.**

Il modulo è piccolo — 52 file, 3.684 righe, nessun file oltre 500 — e questo è
coerente con lo scopo, non un difetto. Fa una cosa sola in un momento in cui non
esiste nient'altro.

## I confini, e dove oggi sono rotti

Verso l'alto il confine è pulito: **25 file su 52 importano `Modules\Xot\`**, uno
solo importa un altro modulo (`app/Models/Tenant.php:17`, `use Modules\User\Models\User`),
e verso Ptv non c'è una sola riga di codice — solo tre PHPDoc in
`app/Models/TestSushiModel.php:23-25` che nominano `\Modules\Ptv\Models\Profile`
invece di `ProfileContract`. È la stessa violazione che rende Sigma non isolabile,
qui presa in tempo: tre righe.

Il problema vero non è una dipendenza. È che **metà del modulo descrive un
meccanismo che nessuno usa.**

| Modello | Migrazione | Referenze fuori da `Modules/Tenant/` |
|---|---|---:|
| `TenantSetting` | `2026_07_24_000000_create_tenant_settings_table.php` | **0** |
| `TenantSubscription` | `2026_07_24_000001_create_tenant_subscriptions_table.php` | **0** |
| `DatabaseConfig` | `2026_07_24_000002_create_database_configs_table.php` | **0** |
| `TenantDomain` | nessuna | **0** |
| `Tenant` | nessuna | 3, tutti file di test |

`Modules\Tenant\Models\Tenant` non ha migrazione, non ha `$table`, non ha
`$connection` proprio: eredita `tenant` da `BaseModel` e per convenzione punta alla
tabella `tenants`. Ma la tabella `tenants` è creata da **User**
(`Modules/User/database/migrations/2026_09_01_150110_create_tenants_table.php`, che
dichiara `protected ?string $model_class = Tenant::class` con `Modules\User\Models\Tenant`)
e vive sulla connection `user` → `ptv_user`. Due modelli con lo stesso nome
puntano allo stesso nome di tabella su due database diversi, e solo uno dei due ha
lo schema. `XotData:72` sceglie quello di User come default.

Il README amplifica il disallineamento invece di segnalarlo: dichiara «15 models»
(sono 9), «Complete data separation per tenant via database/schema/scoping
strategies», e mostra esempi d'uso con `Tenant::currentTenant()` e
`$tenant->domains()` — **nessuno dei due metodi esiste** (`app/Models/Tenant.php`
espone `users()`, `isActive()`, `getUrlAttribute()` e nient'altro). Documentazione
che descrive un modulo diverso da quello installato è peggio di nessuna
documentazione: manda a cercare bug in un posto che non c'è.

## Come servire meglio lo scopo

### 1. Unificare le due implementazioni della stessa regola

`TenantServiceProvider::mergeModuleConnections()` (righe 138-158) e
`Services/Config/Resolvers/DatabaseConfigResolver::addModuleConnections()`
(righe 73-100) fanno la **stessa cosa**: iterare i moduli e creare una connection
per ognuno copiando il default. Differiscono nel modo di ottenere l'elenco
(`Module::getOrdered()` contro `Module::toCollection()`). È la regola su cui poggia
la connection `xot` di ogni modello del progetto, scritta due volte: una correzione
a una delle due non raggiunge l'altra. Va tenuta una sola Action —
`Actions/Config/MergeModuleConnectionsAction` — chiamata da entrambi i punti.

```bash
cd laravel && grep -rn 'getSnakeName()' Modules/Tenant/app | wc -l   # obiettivo: 1
```

### 2. Sciogliere `TenantService` — non ha chiamanti

`app/Services/TenantService.php` è una facade di **11 metodi statici** che delegano
tutti ad Action già esistenti (il docblock lo dichiara: *«Business logic delegata
alle Actions»*). Fuori dal modulo Tenant, `TenantService::` compare in **due**
posti, entrambi commentati (`Modules/User/resources/views/pages/index.blade.php:17`,
`Modules/Notify/app/Datas/SmtpData.php:45`). Chi ha davvero bisogno della config
tenant chiama l'Action direttamente — `GetTenantConfigArrayAction` è usata in 10
file, fra cui `Xot\Datas\XotData:89` e `User\Datas\PasswordData:49`.

La facade non semplifica niente e viola la policy no-services
([actions-over-services](../../../../docs/wiki/rules/actions-over-services.md)):
si cancella, dopo aver spostato in Action le poche righe non ancora delegate. Stesso
esame per le altre 6 classi sotto `app/Services/Config/`: i tre `*Resolver` sono
strategie con interfaccia, non use case — se restano, devono uscire da
`app/Services/` e chiamarsi per quello che sono.

```bash
cd laravel && ls Modules/Tenant/app/Services 2>/dev/null | wc -l   # obiettivo: 0
```

### 3. Decidere che fine fa la tenancy a database

Quattro modelli e tre migrazioni descrivono un modello di tenancy con settings,
subscription e connection per tenant che **nessun file fuori dal modulo usa**.
Delle due l'una: o è il piano e va collegato (chi legge `DatabaseConfig` per
costruire le connection? oggi nessuno: le costruisce `mergeModuleConnections`
copiando il default), o è scaffolding e va rimosso dal codice vivo. Tenerlo così
costa: chi legge `docs/` crede che l'isolamento per tenant esista, e scrive codice
che ci conta.

Nel frattempo va sciolto il doppio `Tenant`: `Modules\Tenant\Models\Tenant`, senza
migrazione e con 3 sole referenze tutte nei test, o si allinea a
`Modules\User\Models\Tenant` o sparisce.

```bash
cd laravel
for C in TenantSetting TenantSubscription DatabaseConfig TenantDomain; do
  printf '%-20s %s\n' "$C" "$(grep -rl "Modules\\\\Tenant\\\\Models\\\\$C" Modules/ Themes/ --include='*.php' | grep -vc 'Modules/Tenant/')"
done   # ogni riga a 0 = modello mai usato fuori dal modulo
```

### 4. Riscrivere il README su quello che il codice fa

`README.md` va allineato ai file: 9 modelli, non 15; il meccanismo attivo è la
risoluzione della config per host più la sintesi delle connection, non
l'isolamento a database; gli esempi `Tenant::currentTenant()` e `$tenant->domains()`
vanno sostituiti con codice che esiste. Se la tenancy a database resta come piano,
va marcata come piano e non come stato «Production».

```bash
cd laravel && grep -rn 'currentTenant\|->domains()' Modules/Tenant/README.md Modules/Tenant/app | grep -v README   # obiettivo: nessun hit fuori dal README, quindi zero righe una volta corretto
```

### 5. Rendere strutturale l'invariante `xot` e `tenant`

Nessun file di configurazione dichiara le connection `xot` e `tenant`: esistono
perché questo modulo le crea. È l'invariante più importante che Tenant garantisce
e non è verificata da niente — basta un `return` anticipato in `registerDB()` e
l'intero progetto perde la connection di default dei modelli. Un test di
architettura che asserisca la presenza di `database.connections.xot` dopo il boot
costa poche righe e trasforma una convenzione muta in un errore rosso. Da scrivere
in `tests/`, mai eseguito su 10.100.200.15.

```bash
cd laravel && grep -rn "'xot' =>\|'tenant' =>" config/ | wc -l   # 0: le connection nascono a runtime, non da config
```

## Cosa NON è compito di Tenant

- **Non** è identità. Chi è l'utente, che ruoli ha e a quale team appartiene è di
  User; l'unico import verso User (`app/Models/Tenant.php:17`) serve a una relazione
  `users()` ed è il massimo accettabile.
- **Non** possiede la tabella `tenants`. La migrazione sta in User e ne dichiara
  `Modules\User\Models\Tenant` come owner: finché resta così, Tenant non deve avere
  un secondo modello che punti allo stesso nome di tabella.
- **Non** conosce il portale. Nessun `use Modules\Ptv\` — e nemmeno nei PHPDoc: il
  tipo giusto è `Modules\Xot\Contracts\ProfileContract`.
- **Non** è un router HTTP. Mappa host → cartella di configurazione; le rotte di
  dominio le definiscono i moduli applicativi.
- **Non** deve fare query nel boot. `GetTenantNameAction` usa `getenv()` e
  `file_exists()` perché gira prima che le facade esistano: qualunque accesso al
  database in quel punto è un errore di ordine, non di stile.

## Verifica

```bash
cd laravel

# scopo: la catena host -> cartella config -> database
grep -n 'function execute' Modules/Tenant/app/Actions/GetTenantNameAction.php     # riga 23
ls config/local/ptvx | wc -l                                                      # 22 file il 2026-09-02
grep -n 'function registerDB\|function mergeModuleConnections' \
  Modules/Tenant/app/Providers/TenantServiceProvider.php                          # righe 61 e 138
grep -rn "'xot' =>\|'tenant' =>" config/ | wc -l                                  # 0: sintetizzate a runtime

# duplicazione della regola sulle connection
grep -rn 'getSnakeName()' Modules/Tenant/app                                      # obiettivo: 1 occorrenza

# policy no-services
ls Modules/Tenant/app/Services 2>/dev/null | wc -l                                # obiettivo: 0
grep -rn 'TenantService::' Modules/ Themes/ --include='*.php' | grep -v 'Modules/Tenant/'

# modelli senza consumatori
for C in TenantSetting TenantSubscription DatabaseConfig TenantDomain Tenant; do
  printf '%-20s %s\n' "$C" \
    "$(grep -rl "Modules\\\\Tenant\\\\Models\\\\$C" Modules/ Themes/ --include='*.php' | grep -vc 'Modules/Tenant/')"
done

# confini
grep -rn 'Modules\\Ptv\\' Modules/Tenant/app | wc -l                              # obiettivo: 0
grep -rl '^use Modules\\User\\' --include='*.php' Modules/Tenant/app | wc -l      # 1: la relazione users()

# analisi statica (config di progetto, mai con -c o --level)
./vendor/bin/phpstan analyse Modules/Tenant
```

## Collegamenti

- [basemodel-connection-mandatory](../../../../docs/wiki/memories/basemodel-connection-mandatory.md) — perché ogni `BaseModel` dichiara la sua connection, e chi gliela fornisce
- [actions-over-services](../../../../docs/wiki/rules/actions-over-services.md) — la policy violata da `app/Services/`
- [circular-dependency-prevention](../../../../docs/wiki/rules/circular-dependency-prevention.md) — perché i PHPDoc verso Ptv vanno chiusi ora che sono tre
- [data-sacred-no-destructive-db](../../../../docs/wiki/rules/data-sacred-no-destructive-db.md) — vincolo su qualunque intervento alle 3 migrazioni
- [Xot — scopo](../../Xot/docs/scopo.md) · [User — scopo](../../User/docs/scopo.md) · [Sigma — scopo](../../Sigma/docs/scopo.md)
