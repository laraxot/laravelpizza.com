---
title: "User — scopo, confini e come servirlo meglio"
type: concept
module: User
status: active
created: 2026-09-02
updated: 2026-09-02
tags: [scopo, confini, identita, autorizzazione, sti, contratti, dipendenze]
qmd: "scopo user identita autenticazione ruoli permessi team tenant oauth sti parental confini dipendenze"
---

# User — scopo, confini e come servirlo meglio

## Lo scopo, dedotto dal codice

Tre domande, un modulo solo che risponde: **chi sei, cosa ti è permesso, per conto
di quale organizzazione.** Non è una descrizione presa dal README: è quello che si
legge nell'elenco delle 34 migrazioni di `database/migrations/`, che non contengono
un solo concetto di dominio del cliente.

| Gruppo | Tabelle | Cosa risponde |
|---|---|---|
| Identità | `users`, `profiles`, `devices`, `device_user`, `authentications`, `authentication_log`, `password_resets` | chi sei, e da dove sei entrato |
| Autorizzazione | `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`, `permission_role`, `team_permissions` | cosa ti è permesso |
| Organizzazione | `teams`, `team_user`, `team_invitations`, `profile_team`, `tenants`, `tenant_user` | per conto di chi |
| Accesso programmatico | `oauth_access_tokens`, `oauth_auth_codes`, `oauth_clients`, `oauth_refresh_tokens`, `oauth_personal_access_clients`, `personal_access_tokens`, `socialite_user`, `sso_providers` | come si autentica una macchina, o un IdP esterno |
| Piattaforma | `features`, `user_extra` | feature flag e attributi liberi |

Gli altri numeri, misurati il 2026-09-02:

| Fatto | Comando | Valore |
|---|---|---|
| Modelli | `find Modules/User/app/Models -maxdepth 1 -name '*.php' \| wc -l` | **50** |
| Migrazioni | `find Modules/User/database/migrations -name '*.php' \| wc -l` | **34** |
| File PHP in `app/` / righe | `find Modules/User/app -name '*.php' \| xargs wc -l` | **666 / 38.558** |
| File Filament | `find Modules/User/app/Filament -name '*.php' \| wc -l` | **350** (26 Resource) |
| Actions | `find Modules/User/app/Actions -name '*.php' \| wc -l` | **57** |
| Classi che estendono `XotBase*` | `grep -rh 'extends XotBase' Modules/User/app \| wc -l` | **350** |

Il dato che chiude il ragionamento è la connection. `app/Models/BaseModel.php:15`
dichiara `protected $connection = 'user'`, e `config/local/ptvx/database.php:44`
mappa `'user' => 'ptv_user'`: User è uno dei pochi moduli con un **database fisico
dedicato dichiarato a mano** nella config del tenant (l'altro è `incentivi`). Gli
altri moduli ricevono una connection sintetizzata a runtime che punta al database
di default. L'identità sta separata perché è separata.

Da qui la formulazione in una riga:

> **User è l'anagrafica di chi accede e di cosa può fare: 50 modelli e 34
> migrazioni sulla connection dedicata `ptv_user` che coprono utenti, profili,
> ruoli, permessi, team, tenant e OAuth — e 350 classi Filament che ne fanno
> l'unico modulo dove l'identità si amministra, non solo si consulta.**

C'è un secondo mestiere, meno visibile e più importante: **User è la radice STI
dell'utente e del profilo del progetto.** `BaseUser` (`app/Models/BaseUser.php:132-136`)
e `BaseProfile` (`app/Models/BaseProfile.php:66-68`) usano `Parental\HasChildren`,
e i figli concreti vivono nelle foglie:

```
Modules/Ptv/app/Models/User.php:140     class User extends BaseUser
Modules/Ptv/app/Models/Profile.php:193  class Profile extends UserBaseProfile   // = User\Models\BaseProfile
```

Sono quelle due classi figlie che i 271 PHPDoc di Sigma nominano. Cambiare la forma
di `BaseProfile` non tocca un modulo: ne tocca tutta la catena.

Dodici moduli consumano User: Activity (10 file), IndennitaResponsabilita (8),
Xot (8), Pdnd (7), Notify (5), Ptv (5), Job (4), Performance, Progressioni, Sigma,
Tenant, UI (1 ciascuno). Non è una foglia: è infrastruttura condivisa che ha anche
un'interfaccia.

## I confini, e dove oggi sono rotti

Verso l'alto il confine è tenuto: User estende, non reimplementa. **489 dei 666
file PHP di `app/` importano `Modules\Xot\`** (73%), e i cinque import più
frequenti dicono esattamente quale forma User riceve dalla piattaforma:

```
 99  Modules\Xot\Contracts\UserContract
 53  Modules\Xot\Datas\XotData
 40  Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm
 39  Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable
 37  Modules\Xot\Contracts\ProfileContract
```

Zero estensioni dirette di classi `Filament\` fuori dalle `XotBase*`, zero
`app/Services` (l'unico file che matcha `*Service*.php` è
`app/Http/Livewire/TermsOfService.php`, un componente di UI: falso positivo). Su
queste due policy User è in regola.

Verso il basso c'è una riga sola, ma è la riga sbagliata:

```
app/Models/OauthPersonalAccessClient.php:9   use Modules\Ptv\Models\Profile;
```

Il modulo dell'identità importa il profilo concreto del portale — cioè la **classe
figlia** del suo stesso `BaseProfile`. È un ciclo `User → Ptv → User` chiuso su un
file, e la stessa violazione (in forma di PHPDoc) che rende Sigma non isolabile.
Il tipo giusto è `Modules\Xot\Contracts\ProfileContract`, che User già usa in 37
file.

C'è poi un confine ambiguo con Tenant, ed è più profondo di un import.
La migrazione `2026_09_01_150110_create_tenants_table.php` sta in **User**, non in
Tenant; esistono **due** modelli `Tenant`:

| Classe | Estende | File che la referenziano | Migrazione |
|---|---|---:|---|
| `Modules\User\Models\Tenant` | `BaseTenant` | 50 | `Modules/User/database/migrations/2026_09_01_150110_create_tenants_table.php` |
| `Modules\Tenant\Models\Tenant` | `Tenant\Models\BaseModel` | 26 | nessuna |

E `XotData` sceglie la prima come default (`Modules/Xot/app/Datas/XotData.php:72`,
`$tenant_class = 'Modules\User\Models\Tenant'`). Non è necessariamente sbagliato —
il tenant come **riga di anagrafica** è un fatto di identità, il tenant come
**risoluzione di configurazione** è un fatto di infrastruttura — ma oggi la
divisione non è dichiarata da nessuna parte e due modelli con lo stesso nome sono
raggiungibili da chiunque.

## Come servire meglio lo scopo

### 1. Chiudere il ciclo User → Ptv (1 riga)

`app/Models/OauthPersonalAccessClient.php:9` va tipizzato su
`Modules\Xot\Contracts\ProfileContract`. È l'unica dipendenza di User verso un
modulo foglia in tutto `app/`: una riga separa il modulo dall'essere completamente
indipendente dal portale.

```bash
cd laravel && grep -rn '^use Modules\\Ptv\\' --include='*.php' Modules/User/app | wc -l   # obiettivo: 0
```

### 2. Cancellare i tre contratti che duplicano quelli di Xot

`app/Contracts/` contiene tre nomi che esistono già in `Modules/Xot/app/Contracts/`
— `ModelContract.php`, `PassportHasApiTokensContract.php`, `UserContract.php` — e
la misura d'uso dice che sono zavorra:

| Interfaccia | Referenze in `Modules/` + `Themes/` |
|---|---:|
| `Modules\Xot\Contracts\UserContract` | **339** |
| `Modules\User\Contracts\UserContract` | 7 (di cui 2 file PHP vivi, il resto docs e `.to_widget`) |
| `Modules\Xot\Contracts\ModelContract` | 13 |
| `Modules\User\Contracts\ModelContract` | **0** |
| `Modules\Xot\Contracts\PassportHasApiTokensContract` | 2 |
| `Modules\User\Contracts\PassportHasApiTokensContract` | **0** |

Due si cancellano subito. Il terzo, `User\Contracts\UserContract`, è un alias di 12
righe (`interface UserContract extends \Modules\Xot\Contracts\UserContract {}`) —
la classica scorciatoia che diventa permanente: i due file che lo usano
(`app/Models/Profile.php`, `app/Http/Livewire/Profile/DeleteAccount.php`) vanno
puntati su quello di Xot, poi l'alias e il residuo `UserContract.php.to_xot`
spariscono. Due nomi identici per lo stesso concetto sono un bug che aspetta il
primo `instanceof`.

```bash
cd laravel && comm -12 <(ls Modules/Xot/app/Contracts | grep '\.php$' | sort) \
                       <(ls Modules/User/app/Contracts | grep '\.php$' | sort)   # obiettivo: vuoto
```

### 3. Dichiarare chi possiede il Tenant

Serve una decisione scritta e un solo modello raggiungibile. La divisione difendibile
è: **la riga `tenants` resta in User** (è anagrafica, sta sulla connection `user`,
`XotData` la usa già come default) e **`Modules\Tenant\Models\Tenant` sparisce o
diventa un alias deprecato**, perché non ha una migrazione che lo sostenga. In
alternativa si sposta tutto in Tenant — ma allora vanno spostate anche la migrazione
e le 50 referenze. Quello che non è difendibile è lo stato attuale.
Da chiudere insieme al doppione disattivato
`2023_01_01_000008_create_tenants_table.php.LARAXOT_CORRECT`, che nel frattempo
suggerisce che la migrazione "corretta" sia un'altra.

```bash
cd laravel && grep -rl 'Modules\\Tenant\\Models\\Tenant\b' Modules/ Themes/ | wc -l   # obiettivo: 0
```

### 4. Spezzare `HasTeams` e `BaseUser`

Due file superano le 500 righe, e sono i due che tutte le foglie ereditano:
`app/Models/Traits/HasTeams.php` (**621** righe) e `app/Models/BaseUser.php`
(**514** righe, con 8 interfacce implementate alla riga 132). Un trait da 621 righe
composto nella radice STI significa che ogni figlio concreto — compreso
`Ptv\Models\User` — porta con sé tutta la logica dei team anche quando non ha team.
La separazione naturale segue le tabelle: appartenenza (`team_user`), inviti
(`team_invitations`), permessi di team (`team_permissions`).

```bash
cd laravel && find Modules/User/app -name '*.php' | xargs wc -l | awk '$1>500 && $2!="total"'   # obiettivo: vuoto
```

### 5. Togliere da `app/` i 22 sorgenti disattivati

`app/` contiene 22 file di PHP spento: quattro residui Jetstream
(`Models/Team.Jetstream`, `Models/Membership.Jetstream`,
`Models/TeamInvitation.Jetstream`, più `Providers/UserPanelProvider.boh`), sette
`.test` che non sono test (sono trait e listener parcheggiati sotto
`app/Filament/Traits/` e `app/Listeners/`), quattro `.php.no`, due `.to_widget`,
`LogoutWidget.php.corrected` accanto a `LogoutWidget.php`. In un modulo con 50
modelli, `Models/Team.Jetstream` accanto a `Models/Team.php` è un file che qualcuno
prima o poi aprirà credendo sia quello giusto.

```bash
cd laravel && find Modules/User/app -type f ! -name '*.php' \
  | grep -Ev '\.(svg|png|jpg|jpeg|gif|webp|md|json|css|js|xml|yaml|yml|csv|txt)$|\.gitkeep$' | wc -l   # obiettivo: 0
```

## Cosa NON è compito di User

- **Non** conosce il dominio HR. Matricola, ente, stabilimento, anno sono chiavi di
  Sigma; se una colonna parla di anagrafica del personale, non nasce qui.
- **Non** conosce il portale. `Ptv\Models\Profile` e `Ptv\Models\User` sono figli
  STI dei suoi `BaseProfile`/`BaseUser`: la direzione è discendente, e il padre non
  deve mai nominare il figlio.
- **Non** risolve la configurazione per host. Sapere *quale* config caricare è
  compito di Tenant; User la consuma via `GetTenantConfigArrayAction`
  (`app/Datas/SocialProviderData.php:41`, `app/Datas/PasswordData.php:49`).
- **Non** reimplementa le basi Filament. 350 classi estendono `XotBase*` e nessuna
  estende `Filament\` direttamente: il confine è già tenuto, va solo non rotto.
- **Non** ha `app/Services`. La regola vale, ed è rispettata: business logic in
  `app/Actions/**` con `QueueableAction` ed `execute()`.

## Verifica

```bash
cd laravel

# scopo: il perimetro dichiarato dalle migrazioni e dai modelli
find Modules/User/database/migrations -name '*.php' | wc -l          # 34 il 2026-09-02
find Modules/User/app/Models -maxdepth 1 -name '*.php' | wc -l       # 50
grep -n "protected \$connection" Modules/User/app/Models/BaseModel.php  # 'user'
grep -n "'user' =>" config/local/ptvx/database.php                   # 'user' => 'ptv_user'

# radice STI: chi estende le basi di User
grep -rn 'extends BaseUser\|extends UserBaseProfile\|extends BaseProfile' \
  Modules/*/app/Models --include='*.php'

# confini
grep -rn '^use Modules\\Ptv\\' --include='*.php' Modules/User/app | wc -l    # obiettivo: 0
ls Modules/User/app/Services 2>/dev/null | wc -l                            # deve restare 0
comm -12 <(ls Modules/Xot/app/Contracts | grep '\.php$' | sort) \
         <(ls Modules/User/app/Contracts | grep '\.php$' | sort)            # obiettivo: vuoto
grep -rl 'Modules\\Tenant\\Models\\Tenant\b' Modules/ Themes/ | wc -l       # obiettivo: 0

# dimensione dei file che tutte le foglie ereditano
find Modules/User/app -name '*.php' | xargs wc -l | awk '$1>500 && $2!="total"'   # obiettivo: vuoto

# igiene di app/
find Modules/User/app -type f ! -name '*.php' \
  | grep -Ev '\.(svg|png|jpg|jpeg|gif|webp|md|json|css|js|xml|yaml|yml|csv|txt)$|\.gitkeep$' | wc -l

# analisi statica (config di progetto, mai con -c o --level)
./vendor/bin/phpstan analyse Modules/User
```

## Collegamenti

- [parental-sti-filament-schemas](../../../../docs/wiki/rules/parental-sti-filament-schemas.md) — perché `BaseUser`/`BaseProfile` con `HasChildren` obbligano ogni figlio a una propria classe Form
- [circular-dependency-prevention](../../../../docs/wiki/rules/circular-dependency-prevention.md) — il ciclo User → Ptv → User
- [actions-over-services](../../../../docs/wiki/rules/actions-over-services.md) — la policy che User rispetta
- [basemodel-connection-mandatory](../../../../docs/wiki/memories/basemodel-connection-mandatory.md) — la connection `user` non è opzionale
- [Xot — scopo](../../Xot/docs/scopo.md) · [Tenant — scopo](../../Tenant/docs/scopo.md) · [Sigma — scopo](../../Sigma/docs/scopo.md)
