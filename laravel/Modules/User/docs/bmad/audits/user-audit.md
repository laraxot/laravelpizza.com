---
title: "Audit approfondito modulo User"
type: audit
status: review
updated: 2026-11-16
module: User
qmd: "audit User auth ruoli policy canAccessPanel super-admin user::admin escalation Permission Role Team PHPStan Pest"
---

# Audit approfondito — User

## Scopo (il perché)

User è l'unico punto in cui si decide **chi è chi e cosa può fare**: utenti, ruoli
Spatie, permessi, team, OAuth/Passport, accesso ai pannelli Filament. Ogni altro
modulo delega a `BaseUser::canAccessPanel()` e alle policy `XotBasePolicy`.
Un errore qui non è un bug di modulo: è un buco di sicurezza di tutto PTVX (HR,
indennità, performance). Business logic: [purpose.md](../purpose.md).

## Metodo

Source-first, 2026-11-16. Inventario con `find`/`grep` sul filesystem, lettura di
`BaseUser`, `XotBasePolicy`, `UserBasePolicy`, tutte le policy con `return true`,
riproduzione runtime del `before()` con utente mock (script fuori repo, nessun DB).
Nessuna UI inventata, nessuna scrittura su DB.

## Inventario misurato

| Area | N | Nota |
|---|---:|---|
| PHP in `app/` | 713 | |
| Test PHP | 233 | 191 file con `test()/it()/describe()` |
| Models | 123 | |
| Policy (`app/Models/Policies`) | 39 | 8 `return true` in 3 file |
| Resource Filament | 37 | 89 pagine |
| Widget | 31 | |
| Actions | 90 | `Services/` = 0 (ok: Actions-over-Services) |
| Migration | 83 | |
| Lang IT | 264 file | |
| Marker conflitto | 0 | |
| `->label('...')` non commentati | 24 | vietati dalla regola auto-traduzione |
| `extends` Filament diretto | 2 | `Widgets/Pulse/LoginWidget.php` (ChartWidget), `Resources/UserResource/Pages/BaseEditUser.php` (EditRecord) |
| `extends ServiceProvider` plain | 1 | `Providers/PassportServiceProvider.php:32` |
| `property_exists` su Eloquent | 0 | solo commenti |
| `dd/dddx` attivi | 0 | 1 in blocco commentato (`BaseUser.php:246`) |
| `migrate --force` | 1 | `tests/TestCase.php:121`, protetto da `TestDatabaseGuard` (solo DB `*_test`) |

## Come si entra in un pannello (`BaseUser::canAccessPanel`, `app/Models/BaseUser.php:289-319`)

- pannello `access` → sempre `true` (login pubblico, voluto).
- pannello `admin` → `super-admin`, `admin`, `restaurant::admin`.
- `restaurant::admin` → anche `super-admin`/`admin`.
- altri pannelli (`<modulo>::admin`) → `super-admin`, oppure ruolo omonimo
  `<modulo>::admin`, oppure `<modulo>::operator`.

Quindi un `user::operator` **entra** nel pannello `user::admin` "con permessi ridotti
definiti dalle policy" (commento nel codice). La sicurezza dipende interamente dalle policy.

## Finding

### P0-U1 — `user::admin` scavalca Role/Permission/Team (escalation)

`XotBasePolicy::before()` (`Xot/app/Models/Policies/XotBasePolicy.php:21-37`) restituisce
`true` a chi ha `{modulo}::admin`, ricavato dal namespace della policy. `BaseUserPolicy`
sovrascrive `before()` per togliere questo bypass; **`RolePolicy`, `PermissionPolicy`,
`TeamPolicy` no**.

Riproduzione runtime (mock `hasRole('user::admin') = true`, `before($u,'update',$model)`):

| Policy | `before()` |
|---|---|
| `RolePolicy` | `true` |
| `PermissionPolicy` | `true` |
| `TeamPolicy` | `true` |
| `BaseUserPolicy` | `null` (corretto) |

Il docblock di `RolePolicy.php:12-17` e il test `UserPolicyBehaviorTest.php:46` dicono
"gestione ruoli riservata al super-admin (escalation)": il test usa un utente senza ruoli e
non copre `user::admin`, quindi non rileva il bypass. Un `user::admin` può creare/rinominare
ruoli e permessi → auto-assegnarsi capacità. `RoleAssignableByTest` protegge solo
l'assegnazione di `super-admin` a un utente, non la modifica dei ruoli.

Fix minimo: `before()` solo-super-admin in `RolePolicy` e `PermissionPolicy` (stessa riga
di `BaseUserPolicy`), oppure in `UserBasePolicy` con eccezione esplicita. Regressione:
Pest con mock `['user::admin']` su `before/update/create/delete`.

### P0-U2 — `PermissionPolicy` concede tutto tranne `viewAny`

`app/Models/Policies/PermissionPolicy.php:25,33,41,50`: `view/create/update/delete` →
`return true`, `viewAny` → `false`. Filament autorizza le pagine Create/Edit con
`canCreate/canEdit`, non con `viewAny`. Dato `canAccessPanel`, un `user::operator` (ruolo da
creare a mano: `PanelRoleSeeder` semina solo `user::admin`) entra nel pannello "con permessi
ridotti" e raggiunge create/edit/delete dei Permission via URL; `user::admin` li ha già da P0-U1.
Fix: allineare a `RolePolicy` (tutto `false`, super-admin via `before`).

### P1-U3 — scritture DB dentro l'autorizzazione

`HasSpatiePermission::hasPermissionToOrCreate()` (`app/Models/Traits/HasSpatiePermission.php:14`)
fa `Permission::findOrCreate()` a ogni verifica. È usato da **18 policy** (Tenant, Oauth*,
Device*, ModelHasPermission, RoleHasPermission, Feature, Membership, …). Effetti: scrittura
su percorso di lettura, tabella `permissions` che cresce per ogni nuova policy/abilità
interrogata, fallimento su replica read-only, race su unique. Spatie lancia
`PermissionDoesNotExist` (ragione storica, vedi ADR in `Xot/docs/wiki/decisions/`):
la soluzione corretta è un seeder additivo, non la creazione a runtime.

### P1-U4 — dominio estraneo nel core

`restaurant::admin` è cablato in `BaseUser::canAccessPanel` (righe ~298 e ~318) e in
`BaseUserPolicy::ADMIN_ROLES`. PTVX è HR/performance: se un ruolo con quel nome viene creato,
amministra tutti gli utenti. Inerte finché non esiste, ma è un backdoor nominale.
Fix: leggere i ruoli amministrativi da config, o rimuovere.

### P1-U5 — copertura policy solo "istanziabile"

`tests/Unit/Models/Policies/PoliciesTest.php` verifica l'istanziazione; i test
comportamentali (`UserPolicyBehaviorTest`, `RoleAssignableByTest`, `SecurityCriticalPathsTest`)
coprono Role/Team/User ma con mock senza `*::admin`/`*::operator`. Nessun test su
`PermissionPolicy`. Pest non eseguibile in questo ambiente (vedi Gate).

### P2

- `app/Models/Policies/UserPermissionBasePolicy.php`: nessuna sottoclasse
  (`grep "extends UserPermissionBasePolicy"` = 0) e `catch (\Exception)` che ingoia errori
  → classe morta da eliminare.
- `BaseUser.php:243-250`: blocco `canAccessFilament` commentato con `dddx`.
- 24 `->label('...')` letterali (es. `Filament/Resources/UserResource/RelationManagers/ClientsRelationManager.php`,
  `Clusters/Passport/Resources/OauthPersonalAccessClientResource.php`,
  `Resources/TenantUserResource/Schemas/TenantUserForm.php`): violano l'auto-traduzione Lang.
- `LoginWidget` (ChartWidget) e `BaseEditUser` estendono Filament diretto: usare `XotBase*`.
- `PassportServiceProvider` estende `ServiceProvider` anziché `XotBaseServiceProvider`.
- Docs: 17 link relativi rotti preesistenti in `docs/bmad/decision-log.md` (es. `./filament-blueprint.md`, `../../../Xot/docs/wiki/memories/phpstan-modules-zero-standing-order.md`, `./stories/dcp-269-…story.md`): da risolvere o rimuovere.
- Vocabolario ruoli sparso: `admin`, `super-admin`, `user::admin`, `user::operator`,
  `restaurant::admin` — nessuna costante unica.

## Gate

```bash
cd laravel
php -d memory_limit=3G ./vendor/bin/phpstan analyse Modules/User --no-progress   # 0 errori (2026-11-16)
./vendor/bin/pest Modules/User/tests --no-coverage                                 # NON eseguito
```

- PHPStan `Modules/User`: **0 errori**.
- Pest: **skip documentato** — il DB di test `10.100.200.53:3306` è irraggiungibile
  (TCP chiuso, verificato) e con `DB_CONNECTION=sqlite` il bootstrap si ferma su
  `Xot/tests/Support/TestDatabaseGuard.php:63` (connessione `ptv` → `ptv_lara`, non `*_test`).
  Senza guard i test restano appesi sul connect MySQL (timeout 150 s osservato). Non si usa il
  MySQL locale `127.0.0.1` (dati sacri).

## Piano

Epic e story: [epics.md](../epics.md) · scelte: [decision-log.md](../decision-log.md) ·
[piano-miglioramento.md](../piano-miglioramento.md).

## Riferimenti

- [audit.md](../audit.md) · [story](../stories/module-bmad-audit.story.md) · [ECC](../../ecc/user-ecc-audit.md)
- [Xot module-boundary](../../../../Xot/docs/bmad/architecture/module-boundary.md)
