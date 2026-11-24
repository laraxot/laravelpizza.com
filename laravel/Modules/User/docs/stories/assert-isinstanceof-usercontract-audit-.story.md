---
id: story-assert-isinstanceof-usercontract-audit-2026-09-21
slug: assert-isinstanceof-usercontract-audit-2026-09-21
title: "STORY — Assert::isInstanceOf contro Model concreto invece di UserContract, audit repo-wide"
description: "Modules\\User\\Models\\User e Modules\\Quaeris\\Models\\User sono sorelle (entrambe figlie di BaseUser), non genitore/figlio: instanceof/Assert contro il model concreto sbagliato e' sempre falso a runtime per l'auth model reale. Pattern ricorrente, gia' documentato in user-profile-volt-instanceof-wrong-user-class.md; oggi trovate altre occorrenze, una gia' corretta da sessione concorrente."
document_type: story
category: bmad
scope: module:User
status: review
version: 1.0.0
language: it-IT
ecosystem: Laraxot
priority: medium
created_at: '2026-09-21'
updated_at: '2026-09-21'
tags: [bmad, story, user, auth, contract, phpstan, cross-module, production-bug]
related:
  - ../../../laravel/Modules/User/app/Models/Traits/IsProfileTrait.php
  - ../../../laravel/Modules/User/app/Filament/Resources/UserResource/Pages/BaseEditUser.php
  - ../../../laravel/Modules/User/app/Filament/Resources/UserResource/Pages/EditUser.php
  - ../../../laravel/Modules/Cms/app/Http/Volt/VerifyComponent.php
  - ../../../laravel/Modules/Tenant/tests/Unit/TenantModelsTest.php
  - ../../../laravel/Modules/Xot/app/Contracts/UserContract.php
  - user-profile-volt-instanceof-wrong-user-class.md
github:
  repository: https://github.com/laraxot/module_user_fila5
  issues: https://github.com/laraxot/module_user_fila5/issues
---

# STORY — Assert::isInstanceOf contro Model concreto invece di UserContract, audit repo-wide

## Contesto

Utente, mid-turn su un altro task: "fare Assert::isInstanceOf($user,
User::class); e' sbagliato meglio confrontare con UserContract!" — stesso
principio architetturale gia' documentato in
`user-profile-volt-instanceof-wrong-user-class.md` (2026-09-03/04):
`config/auth.php` usa `Modules\Quaeris\Models\User` come auth model reale,
`Modules\User\Models\User` e' una classe **sorella** (entrambe estendono
`Modules\User\Models\BaseUser`), non genitore/figlio. `instanceof`/`Assert`
contro il model concreto sbagliato fallisce sempre a runtime per l'utente
autenticato reale.

## Trovato durante l'audit

`Modules/User/app/Models/Traits/IsProfileTrait.php` aveva 5 occorrenze:
```php
Assert::isInstanceOf($user, User::class);
```
in `getFullNameAttribute`, `getFirstNameAttribute`, `getLastNameAttribute`,
`toggleSuperAdmin`, `userName()`.

**Gia' corretto** quando ho verificato (`git diff` mostrava
`UserContract::class` ovunque, import `use Modules\User\Models\User;`
rimosso): una sessione concorrente sulla stessa working tree condivisa aveva
appena applicato esattamente questo fix, in parallelo alla segnalazione
dell'utente. Nessuna mia azione necessaria su questo file — verificato solo
lo stato finale (`git diff` completo salvato in memoria
`profile-contract-over-model.md`).

## Non ancora corretto (stesso pattern, trovati ma fuori scope immediato)

Grep `isInstanceOf.*User::class` sul repo (esclude `vendor`) ha trovato altri
4 file con lo stesso `User::class` concreto, non toccati in questa sessione:

| File | Riga |
|---|---|
| `Modules/User/app/Filament/Resources/UserResource/Pages/BaseEditUser.php` | 36 |
| `Modules/User/app/Filament/Resources/UserResource/Pages/EditUser.php` | 35 |
| `Modules/Cms/app/Http/Volt/VerifyComponent.php` | 21 |
| `Modules/Tenant/tests/Unit/TenantModelsTest.php` | 72 |

`LoginController.php` e `AssignTeamCommand.php` usano gia' `BaseUser::class`
(il genitore comune concreto, non `UserContract`) — pattern diverso,
probabilmente accettabile (`BaseUser` e' comune a entrambe le sorelle), non
toccato, non auditato a fondo in questa story.

## Decisione

Fix da confermare con l'utente prima di procedere sui 4 file residui: stesso
tipo di modifica (swap `User::class` → `UserContract::class`, rimuovere
import inutilizzato se non serve altrove nel file), rischio basso ma tocca
4 file in 3 moduli diversi (User, Cms, Tenant) — fuori dall'Owned
File/Module Scope implicito di questa segnalazione puntuale.

## Second brain aggiornato

`profile-contract-over-model.md` esteso con la regola esplicita per
`Assert::isInstanceOf` + l'elenco dei 4 file residui.

## Status

`review` — fix confermato per `IsProfileTrait.php` (gia' fatto da altri),
audit completato per il resto del repo, correzione dei 4 file residui in
attesa di conferma esplicita dell'utente.
