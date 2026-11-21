---
title: "Epic 1 — Superficie pubblica di identità: login, logout, creazione utente, Passport"
type: epic
tags: [bmad, user, epic, auth, passport, socialite]
created: 2026-09-28
updated: 2026-09-28
qmd: "User epic superficie pubblica identita login logout creazione utente passport socialite duplicazioni"
module: User
status: proposed
related:
  - ./module-roadmap.md
  - ../architecture.md
  - ../brainstorming.md
  - ../prd.md
  - ../../../Xot/docs/bmad-method.md
---

# Epic 1 — Superficie pubblica di identità

> **SUMMARY**: epic che porta a una sola sorgente i punti d'ingresso autenticazione e creazione utente del modulo User (login, logout, `CreateUserAction`, `GetPermissionModelAction`), allinea le Resource OAuth2 del cluster `Passport` alle Action esistenti e rende unica la sorgente delle migrazioni. Scope limitato a `Modules/User`.

## Numero e nome

Epic 1 — "User public surface: un solo login, un solo logout, una sola creazione utente".

## Perché ora

L'epic nasce dalle duplicazioni elencate in [../brainstorming.md](../brainstorming.md) (A1–A5): ogni entry point duplicato moltiplica traduzioni da allineare, test da mantenere e superficie esposta ad altri moduli. Il modulo ha già 187 file di test: aggiungere un quinto percorso di login non è sostenibile.

## Scope

**In scope**

- Login: `app/Http/Livewire/Auth/Login.php`, `app/Filament/Pages/Auth/Login.php`, `app/Filament/Widgets/Auth/LoginWidget.php`, `app/Filament/Widgets/LoginWidget.php`.
- Logout: `app/Http/Livewire/Auth/Logout.php`, `app/Http/Livewire/Auth/AuthLogout.php`, `app/Filament/Widgets/LogoutWidget.php`, `app/Filament/Widgets/Auth/AuthLogoutWidget.php`.
- Creazione utente: `app/Actions/CreateUserAction.php`, `app/Actions/User/CreateUserAction.php`, `app/Actions/Socialite/CreateUserAction.php`.
- Permessi: `app/Actions/GetPermissionModelAction.php` e `app/Actions/Shield/GetPermissionModelAction.php` con i consumatori in `app/Actions/Shield/`.
- Passport: `app/Filament/Clusters/Passport/` e `app/Actions/Passport/` (9 Action).
- Migrazioni: `database/migrations/`, `database/Database/Migrations/`, `database/migrations/_bak/`, `database/migrations/_legacy/`.
- Traduzioni: `resources/lang/{it,en,es,fr,hi,zh}` per le schermate auth toccate.

**Fuori scope**

- Team, tenant e RBAC oltre il minimo necessario ai contratti toccati.
- Modifiche a moduli consumatori: eventuali adattamenti sono story separate.
- Pulizia dei file congelati `.Jetstream`/`.old`/`.bak` (A6): trattata come story dedicata, non dentro questa epic.

## Acceptance Criteria

1. **Login unico**: un solo percorso di login è dichiarato SSoT; gli altri diventano wrapper che delegano o sono rimossi. Verifica: `grep -rn 'class Login' app/` non restituisce più di una classe attiva, e `tests/Feature/UserAuthenticationTest.php`, `tests/Unit/Filament/Widgets/LoginWidgetTest.php`, `tests/Unit/Filament/Widgets/AuthLoginTranslationContractTest.php` restano verdi.
2. **Logout unico**: idem per `Logout`/`AuthLogout`, con `tests/Unit/Listeners/LogoutListenerBehaviorTest.php` e `tests/Feature/Authentication/ApiLogoutControllerTest.php` verdi.
3. **Creazione utente unica**: `app/Actions/User/CreateUserAction.php` è il SSoT; le varianti root e Socialite delegano con dati espliciti. Copertura: `tests/Unit/Actions/User/CreateUserActionTest.php` e `tests/Feature/Actions/Socialite/RegisterOauthUserActionTest.php`.
4. **Permessi**: una sola `GetPermissionModelAction`; `tests/Unit/SpatiePermissionTeamConfigTest.php` e `tests/Unit/Actions/AdditionalActionsTest.php` verdi.
5. **Passport**: ogni Resource del cluster `Passport` invoca una Action in `app/Actions/Passport/`, senza logica inline. Copertura: `tests/Feature/Filament/Clusters/Passport/Resources/OauthAccessTokenResourceTest.php`, `tests/Feature/Filament/Clusters/Passport/Pages/PassportDashboardNewCredentialsTest.php`, `tests/Unit/Actions/Passport/*`.
6. **Migrazioni uniche**: una sola directory sorgente per i tipi del modulo; `_bak` e `_legacy` non vengono applicate. Copertura: `tests/Feature/MigrateDbTest.php`, `tests/Feature/Database/migrations/UserMigrationSyntaxTest.php`.
7. **Traduzioni**: le schermate auth modificate hanno chiavi presenti in tutte e 6 le lingue, senza stringhe hardcoded.
8. **Qualità**: `./vendor/bin/pint` pulito, PHPStan su `Modules/User` senza regressioni, Pest verde in ambiente non produzione (host `10.100.200.15` escluso).
9. **Documentazione allineata**: [../architecture.md](../architecture.md) e [../brainstorming.md](../brainstorming.md) aggiornati; esito in `docs/sprint-status.yaml`.

## Rischi

- Rimuovere un entry point può rompere link diretti (`wire:`) o route: mitigazione = `grep` su `resources/views` e su `app/Filament/Resources` prima della rimozione.
- La riorganizzazione di `CreateUserAction` tocca i flussi social: mitigazione = test Socialite come gate.
- Le directory `_bak`/`_legacy` possono contenere l'unica versione aggiornata di una migrazione: verificare con diff prima di scegliere la sorgente.

## Tracciabilità

- Epiche di roadmap: [module-roadmap.md](module-roadmap.md) — "Epic A — Contratto e architettura", "Epic C — UX e integrazione".
- Requisiti: [../prd.md](../prd.md), contesto: [../project-context.md](../project-context.md).
- Metodo: [bmad-method.md](../../../Xot/docs/bmad-method.md).
- Stato di avanzamento: story in `../stories/` (non create in questa campagna).
