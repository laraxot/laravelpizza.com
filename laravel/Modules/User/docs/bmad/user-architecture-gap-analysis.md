---
title: "User: Analisi architetturale e gap (BMAD, 2026-09-22)"
type: note
status: draft
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "user   analisi architetturale e gap (bmad, 2026-09-22) user"
---
# User: Analisi architetturale e gap (BMAD, 2026-09-22)

Ricerca a sola lettura condotta sul modulo `laravel/Modules/User` (Laravel 13 + Filament 5, architettura Laraxot/Xot).

## 1. Inventario sintetico

| Area | Conteggio | Note |
|---|---|---|
| Models `app/Models` | 50 classi top-level + 2 duplicati morti (`Models/Models/BaseUser`, `Passport/Client`) | 38 policy, 16 traits, 1 scope |
| Actions `app/Actions` | 54 file PHP: 53 con `execute()`, 54 con `QueueableAction` | 8 domini + 2 duplicazioni |
| Adapters | 3 file | copie di `Actions/Otp` e `Actions/Socialite/Utils`, 0 consumatori (rimossi in clean-up) |
| Contracts | 24 | ~20 senza implementor nel modulo (vestigia Fortify) |
| Enums | 5 file, 4 enum | `LanguageEnum` duplicata (rimosse le copie) |
| Events | 27 | 19 senza listener; `Login`/`Registered` ombra di Laravel |
| Listeners | 4 | |
| Observers | 1 (`UserObserver`) | mai registrato, usa config inesistente |
| Datas | 18 | |
| Http | 11 controller (5 morti), 4 middleware, 2 Resources, 1 Response, 1 Volt, 3 Livewire residui | |
| Filament | 26 resource top-level + 9 in cluster (5+3 coppie duplicati), ~25 widgets, 19 pages | |
| Console | 16 comandi | |
| Migrations | 74 `.php` → 36 tabelle | 14 tabelle con ≥2 create; 5 file-junk non-php (rimossi) |
| Factories | 38 | coprono i model concreti |
| Seeders | 43 | `RolesSeeder`/`RoleSeeder`, `PermissionsSeeder`/`PermissionSeeder`, `UserSeeder`/`UserMassSeeder`/`DemoUserSeeder` duplicati |

## 2. Top gap architetturali

1. **`app/Actions/CreateUserAction.php`**: non-Spatie (ctor + `handle()`), duplicato di `Actions/User/CreateUserAction.php`, 0 consumatori. *(rimosso in clean-up)*
2. **Modelli duplicati/morti**: `app/Models/Models/BaseUser.php` (ns errato, 0 usi), `app/Models/Passport/Client.php` (duplica `OauthClient`).
3. **3 risorse sul tabella `oauth_clients`**: `ClientResource`, `OauthClientResource`, `Clusters/Passport/Resources/OauthClientResource`.
4. **2 modelli per `oauth_access_tokens`**: `OauthAccessToken` e `OauthToken`; `PersonalAccessTokenResource` su `OauthAccessToken` con copie proprie di Form/Table.
5. **`BasePivot` estende `Pivot` Eloquent** (non `XotBasePivot`) mentre `BaseMorphPivot` estende `XotBaseMorphPivot`.
6. **Abuso ereditarietà**: `DeviceProfile extends DeviceUser`, `ProfileTeam extends TeamUser`, `PermissionUser extends ModelHasPermission`.
7. **Write-on-read**: getter `name` esegue `$this->update()` durante letture (`app/Models/BaseUser.php:429`).
8. **Tipi chiave misti**: User UUID-org, `teams`/`team_user` bigint (conversioni `2026_01_12_*`); `User.current_team_id` docblock `int|null`.
9. **`UserObserver` mai registrato** + `config('user.create_personal_team')` inesistente.
10. **Policy non registrate** (`registerPolicies()` vuoto in `UserServiceProvider`; commentato in `PassportServiceProvider`).
11. **`app/Application/UseCases/Owners/`**: 2 contract, 0 impl/consumer.
12. **Eventi ombra** (custom `Login`/`Registered` vs `Illuminate\Auth\Events\*`): nessun listener sugli eventi custom.
13. **~19 Eventi e ~20 Contracts senza consumatori** (Fortify).
14. **Controller morti**: `Api/Login`, `Api/Register`, `Auth/EmailVerification`, `Auth/VerifyEmail`, `Upgrade`; `routes/auth.php` commentato; `routes/web_tall.php` non caricato (`XotBaseRouteServiceProvider` carica solo `web.php`+`api.php`).
15. **`Api/LogoutController`** con TODO su cleanup token/sessioni.
16. **Business logic fuori dalle Action**: `app/View/Pages/ProfileEditVoltComponent.php`, `Filament/Widgets/Auth/RegisterWidget.php`, controller API.
17. **Migrations** duplicate e file spazzatura nella cartella; convenzione "owner migration" solo su `2026_09_01_*`.
18. **Bloat residui**: `resources/views/node_modules` (92 MB, non versionato), `tests/Unit/graphify-out`, file `.bak/.old/.no/.boh/.test/.wip/.to_xot`.
19. **Env types/role**: seeders duplicati (Role/Permission/User).

## 3. Punti sani

- Tutte le risorse Filament estendono `XotBaseResource`.
- Logica di business in Spatie Queueable Action con `execute()` nella quasi totalità.
- **0 label hardcoded**; nessuna violazione reale di `property_exists` (solo commenti).
- `Modules\User\Contracts\UserContract` è alias tipizzato del contratto Xot.
- Gate phpstan/quality: 0 violazioni note a livello max.

## 4. Work item (esito clean-up fase 1, 2026-09-22)

- Rimossi 49 file tracked morti (duplicati, residui `.bak/.old/.boh/.test/.wip/.no`, `.php-cs-fixer.dist.php` in `app/Filament/`, junk non-php in `database/migrations`, copie Adapters + relativi test) + `resources/views/node_modules` e `tests/Unit/graphify-out`.
- Test aggiornato (`tests/Unit/Datas/UserDatasAndEnumsCoverageTest.php`) per la rimozione di `Enums\Enums\LanguageEnum`.
- Verifica: phpstan `Modules/User` = 1665 file, 0 errori; nessun riferimento orfano residuo.
- **Da fare (backlog)**: deduplicazione risorse Passport/Socialite, unificazione pivot, harden di BaseUser (write-on-read, hashed, tipi chiave), registrazione observer/policy, cleanup eventi/contratti Fortify, unificazione logout/Livewire-Volt, ligue migrazioni "owner", seeders duplicati.