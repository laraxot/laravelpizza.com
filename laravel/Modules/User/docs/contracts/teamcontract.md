---
title: "TeamContract"
type: concept
tags: [teamcontract, teams, nullability]
created: 2026-07-14
updated: 2026-10-20
qmd: "teamcontract nullability personalTeam belongsToTeam hasteams"
issues: []
discussions: []
related:
  - ./hasteamsandusercontract.md
  - ../team-contract-usage-reasoning.md
  - ../scopo.md
  - ../00-index.md
status: active
---

# TeamContract

L'interfaccia `TeamContract` definisce il contratto per i team nel sistema.

## Metodi

### Gestione Utenti

- `users(): BelongsToMany<Model&UserContract>` - Ottiene tutti gli utenti che appartengono al team
- `owner(): BelongsTo` - Ottiene il proprietario del team
- `hasUser(UserContract $user): bool` - Verifica se un utente appartiene al team
- `addUser(UserContract $user, ?string $role = null): void` - Aggiunge un utente al team
- `removeUser(UserContract $user): void` - Rimuove un utente dal team
- `allUsers(): Collection<int, Model&UserContract>` - Ottiene tutti gli utenti del team, incluso il proprietario
- `members(): Collection<int, Model&UserContract>` - Ottiene tutti i membri del team
- `hasUserWithEmail(string $email): bool` - Verifica se il team ha un utente con l'email specificata

### Gestione Permessi

- `getPermissionsFor(UserContract $user): array<string, bool>` - Ottiene i permessi per un utente specifico
- `userHasPermission(UserContract $user, string $permission): bool` - Verifica se un utente ha un permesso specifico

### Gestione Inviti

- `teamInvitations(): HasMany<TeamInvitation>` - Ottiene gli inviti pendenti per il team

### Altre Operazioni

- `purge(): void` - Elimina tutte le risorse del team
- `fresh($with = []): ?static` - Ricarica un'istanza fresca del modello dal database

## Note Importanti

- L'interfaccia estende `ModelContract`
- Richiede che la classe che la implementa estenda `Model` (`@phpstan-require-extends Model`)
- Gestisce sia gli utenti che i permessi del team
- Supporta il concetto di ruoli e permessi granulari

## Collegamenti Correlati

- [[ModelContract]]
- [[UserContract]]
- [[TeamInvitation]]
- [[Team]]
- [[User]]
Contratto del team come **unità organizzativa** (appartenenza, owner, inviti, permessi di team). L'implementazione tipica è `Models\Team`; i trait utente tipizzano sul contratto, non sulla classe concreta.

Indice: [../00-INDEX.md](../00-index.md) · perché: [../team-contract-usage-reasoning.md](../team-contract-usage-reasoning.md) · scopo modulo: [../scopo.md](../scopo.md).

## Perché `?TeamContract` (nullability)

Nel prodotto un utente **può non avere** team personale o corrente:

| API (trait `HasTeams`) | Firma | Perché nullable |
|---|---|---|
| `personalTeam()` | `?TeamContract` | nessun `ownedTeams` con `personal_team = true` |
| `belongsToTeam(?TeamContract $team)` | accetta `null` → `false` | chiamate con team assente non devono TypeError |
| `ownsTeam(?TeamContract $team)` | idem | stesso motivo |

`switchTeam(TeamContract $team)` resta **non-null**: cambiare team richiede un team reale.

I test devono tipizzare di conseguenza: passare un `TeamContract` (fixture/mock), oppure asserire `null` / usare `instanceof` prima di accedere a `->id`. Passare un `int` a `belongsToTeam` o accedere a `$personalTeam->id` senza guard viola il contratto di business, non solo PHPStan.

Nota: `HasTeamsContract` storicamente dichiara `belongsToTeam(TeamContract)` non-null; il trait vivo usa `?TeamContract`. Allineare il contratto all'implementazione, non i test a una firma obsoleta.

## Metodi (superficie)

### Utenti

- `users(): BelongsToMany`: membri
- `owner(): BelongsTo`: proprietario
- `hasUser(UserContract $user): bool`
- `addUser` / `removeUser`
- `allUsers()` / `members()`
- `hasUserWithEmail(string $email): bool`

### Permessi

- `getPermissionsFor(UserContract $user): array<string, bool>`
- `userHasPermission(UserContract $user, string $permission): bool`

### Inviti e lifecycle

- `teamInvitations(): HasMany`
- `purge(): void`
- `fresh($with = []): ?static`

## Vincoli

- Estende `ModelContract`; `@phpstan-require-extends Model`
- Dependency inversion: `HasTeams` dipende dal contratto → [team-contract-usage-reasoning.md](../team-contract-usage-reasoning.md)

## Collegamenti

- [hasteamsandusercontract.md](./hasteamsandusercontract.md)
- [stories/phpstan-test-wave-user-b.story.md](../stories/phpstan-test-wave-user-b.story.md)
