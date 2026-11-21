---
title: "[STORY] PHPStan cleanup modulo User (scopo prima dell'errore)"
type: story
status: done-with-blocker
priority: medium
created: 2026-10-06
module: User
---

# [STORY] PHPStan cleanup modulo User

## User Request

> «sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalita', non sull'errore;
> aumenta la qualita' del codice; usa enum al posto delle costanti».

Gruppo: `User` — 108 errori in 43 file (`laravel/Modules/User/**`), livello `max`.

## Analysis

Ogni segnalazione e' stata letta come sintomo dello *scopo* del codice, non come riga da zittire.

| Area | Scopo del codice | Cosa diceva l'errore davvero |
|------|------------------|------------------------------|
| Migrazione `2026_10_05_174817_create_permission_tables` (+ 2 copie legacy) | Creare le tabelle Spatie **con i nomi di `config/permission.php`** (immutabili: `model_has_permission`, ...) | `config()` e' `mixed`: i `@var` inline erano finti e PHPStan (`treatPhpDocTypesAsCertain: false`) non li accetta. Serve restringere il tipo a runtime |
| `FetchUserApiTokenCommand` | Emettere un token di debug; utente assente => messaggio + exit code 2 | `$user_class` inutilizzato rivelava che `getUserByEmail()` (lancia eccezione) aveva reso **morto** il ramo "User not found" |
| `OauthAccessTokenResource` (bulk revoke) | Dire all'admin *quanti* token ha revocato | `$count` calcolato e mai mostrato: la lang `it` ha gia' `:count token revocati`, mancava il parametro |
| `ChangeTypeCommand` | Messaggio "User type changed to '<label>'" | `$labelString` assegnato 2 volte; label `null` produceva stringa vuota |
| `InteractsWithTenant::tenant()` | Relazione `belongsTo` | Caricava il tenant di sessione per poi scartarlo: side effect inutile in una relazione (che non dipende dalla sessione) |
| `Login/FailedLoginListener` | Registrare l'accesso in `authentications` | `$log` serviva solo alle notifiche, disattivate (commento aggiornato) |
| `ProcessCallbackController`, `UpgradeController`, `Assign{Role,Tenant}Command` | - | Variabili/query morte (`UpgradeController` caricava TUTTI gli utenti per niente; la route e' commentata) |
| `UserSeeder::seedSystemTeams` | Creare 5 team di sistema | 5 variabili mai lette: ora il conteggio loggato deriva dai team davvero creati |
| `Confirm` (Livewire) | `->extends('pub_theme::layouts.auth')` | Un `@var View` (contratto) mentiva sul tipo: `view()` ritorna `Illuminate\View\View`, che ha la macro Livewire |
| Test "has X" senza assert | Verificare l'esistenza di metodi/proprieta'/relazioni/hash password | Il nome prometteva un assert, il corpo no (test vuoti = falsi verdi). Ora asseriscono davvero |
| Helper test `enableTwoFactorForUser` | Abilitare 2FA con eventuali override | `$attributes` ignorato: ora e' applicato con `forceFill` |
| Costanti di classe | Tipizzate (`typeCoverage.constantTypeCoverage`) o enum se sono un insieme di valori | Vedi AC enum |

### Decisioni enum

- `NameSearchEnum` (`before`/`after`): erano i nomi dei metodi `Stringable` chiamati dinamicamente (`->$searchMethod()`) + `validateSearchMethod()` duplicato in 3 classi. Con l'enum lo stato non valido non e' rappresentabile.
- `DefaultRoleId` (1/2/3): sostituisce `Role::ROLE_ADMINISTRATOR|OWNER|USER` (consumatore unico: `RoleTest`; il resto e' codice commentato).
- `FetchUserApiTokenExitCode` (1/2): exit code del comando.
- `UserType::API|WEB`: erano nomi di guard (`config/auth.php`), usati una volta ciascuno nel `match`: **eliminati** (inline `'web'`/`'api'`), non sono un dominio dell'enum.
- `FREE_STARTING_CREDITS` (500) e `DEFAULT_NAME` (colonne Filament): parametri di configurazione, restano costanti **tipizzate** (stesso pattern del modulo UI).

## Acceptance Criteria

- [x] Tutte le 108 segnalazioni analizzate partendo dallo scopo del codice (chiamanti + doc + history)
- [x] Nessun `@phpstan-ignore*`, nessun `@var` bugiardo, nessun cast/assert finto, `phpstan.neon` intatto
- [x] Nomi tabelle permission sempre da `config('permission.table_names.*')` (config non toccata)
- [x] Costanti che sono insiemi di valori => backed enum (3 nuovi enum), aggiornati tutti i consumatori
- [x] Nessun file cancellato/spostato/rinominato; duplicati segnalati, non toccati
- [x] Test "vuoti" ora con assert reali
- [x] `php -l` OK su tutti i file toccati
- [ ] `phpstan analyse Modules/User` a 0: **restano 4** `classConstant.nativeTypeNotSupported` (vedi sotto), bloccati da una decisione fuori scope

## Blocker (decisione umana)

`laravel/composer.json` dichiara `"php": "^8.2"` => PHPStan deduce PHP minimo 8.2 e segnala come errore ogni costante con tipo nativo
(`classConstant.nativeTypeNotSupported`), mentre senza tipo scatta `typeCoverage.constantTypeCoverage`. Le due regole sono in conflitto finche' il vincolo e' `^8.2`.
Il runtime e' 8.4: serve alzare a `^8.3`/`^8.4` (file fuori scope User, tocca tutti i moduli). Errori residui in User:
`Listeners/AssignFreeCreditsListener.php:21`, `app/Listeners/AssignFreeCreditsListener.php:21`, `UserColumn.php:27`, `SingleRoleSelectColumn.php:25`.

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO
