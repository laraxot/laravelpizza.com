---
title: "[STORY] PHPStan zero errori: modulo User"
type: story
status: done
priority: high
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, user, typecoverage, seeder, pest, bmad, swarm]
related:
  - "./7.4.phpstan-paramtype-coverage.story.md"
  - "./phpstan-zero-errors-user.dev.md"
  - "../../../../../docs/stories/all-modules-phpstan-zero-errors.story.md"
---

# Story: PHPStan zero errori: modulo User

## User Request

Swarm PHPStan (2026-10-28): zero errori nel modulo `User` (31 errori di baseline), risolvendo la causa e non l'errore; codice migliore, DRY/KISS.

## Analysis

31 errori = 4 cause, non 31 problemi.

| Causa radice | Errori | Scopo del codice | Soluzione |
|---|---|---|---|
| `typeCoverage.paramTypeCoverage` (soglia 99 % **di progetto**, vedi story 7.4) | 28 | closure Filament e callback dei test con parametri senza tipo | tipo nativo sul parametro, scelto leggendo cosa Filament/Laravel inietta davvero |
| `return.unusedType` su `getConsoleCommand(): ?Command` | 2 | `RolesSeeder` e `UserMassSeeder` scrivono sull'output dell'artisan command solo se esiste | helper privato inutile eliminato: `$this->command?->info()` diretto (come Activity, Geo) |
| `method.notFound` `PasswordBroker::createToken()` | 1 | `AuthFlowRedirectsTest` genera il token di reset per montare `ResetPasswordWidget` | `Password::createToken($user)`: la facade lo documenta e lo inoltra al broker di default |

Scelte sui tipi (nessun `mixed` di comodo):

- `$context` Filament (`required()`, `disabled()`, `visible()`) → `string` (e' `getOperation(): string`).
- `$livewire` → `Livewire\Component`; `$record` nel `state()` di `UserForm` → `?Model` (nullo in creazione, il corpo gia' lo gestiva); `$record` nel `getStateUsing` di `DomainsRelationManager` → `Model` (relation manager = sempre Eloquent), tolto il `is_object` ridondante.
- `$state` di un `TextInput` → `?string` (nome tenant, password). `mixed` solo in `OauthTokensRelationManager` (`expires_at`): il tipo dello stato dipende dal cast del modello e il corpo lo verifica gia' con `instanceof Carbon`.
- `CreateRole`/`EditRole`: il filtro usava solo la chiave, il valore `$_permission` era inutile → `collect($data)->keys()->filter(fn (string $key))->values()`; stessa semantica, un parametro in meno.
- Test: `ReflectionProperty`, `ReflectionParameter`, `stdClass`, `Permission`, `Filament\Tables\Columns\Column`.

## Result (verificato 2026-10-28)

- Modulo: `phpstan analyse Modules/User Modules/Gdpr Modules/UI` → **31 → 0** errori in User.
- Full-tree (`phpstan analyse`, perimetro `Modules/`): 0 errori in User e **0 `paramTypeCoverage` nell'intero albero** (soglia 99 % raggiunta con il contributo degli altri moduli). Il controllo di modulo da solo non lo vede: `tomasvotruba/type-coverage` salta il calcolo se non sono analizzati tutti i path.
- `php -l` pulito su tutti i file toccati (17).
- **Pest non eseguito**: `.env.testing` punta a MySQL. I test toccati cambiano solo i tipi dei callback e la chiamata `Password::createToken`.

## Acceptance Criteria

- [x] 0 errori PHPStan in `Modules/User` (modulo e full-tree)
- [x] Nessun `@phpstan-ignore`, baseline o modifica a `phpstan.neon`
- [x] Nessun file cancellato o spostato
- [ ] Pest in sqlite sui test toccati (`AuthFlowRedirectsTest`, `PermissionTest`, `PasswordDataTest`, `OauthLocaleBindingContractTest`, `AuthenticationBusinessLogicTest`)
- [ ] Commit nel `.git` del modulo (non richiesto dall'utente)

## Decisioni aperte

- `TenantResource/Schemas/CustomerForm.php` e' identico a `TenantForm.php` (cambia solo il nome della classe) e nessuno lo referenzia: duplicato da eliminare o da collegare a una risorsa Customer, decisione dell'utente.
- `CreateRole`/`EditRole` duplicano lo stesso filtro dei permessi dal form: candidato per una Action condivisa.
- Listener duplicato segnalato il 2026-10-06: lasciato intatto, come richiesto.

## GitHub (tracciamento)

### Issues
- TODO (`gh` non installato su questa macchina)
### Discussions
- TODO
