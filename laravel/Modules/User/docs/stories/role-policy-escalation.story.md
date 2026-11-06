---
title: "User: gestione dei ruoli riservata al super-admin (niente escalation)"
type: story
status: review
priority: P0
created: 2026-11-05
updated: 2026-11-05
module: User
depends_on: []
related: [roosko-audit]
owned_scope: [app/Models/Policies/RolePolicy.php]
tags: [security, roles, privilege-escalation, policy]
qmd: "user role policy super-admin escalation privilegi attach detach ruoli"
---

# User: gestione dei ruoli riservata al super-admin

## Story

Come **titolare del sistema**
voglio **che solo il super-admin possa creare, modificare, eliminare e assegnare ruoli**
così da **impedire a un amministratore di utenti di attribuirsi il ruolo super-admin**.

## Perché (evidenza)

- `RolePolicy` restituiva `true` per create, update, delete e per le operazioni sui membri.
- Filament consente le abilità non dichiarate dalla policy (attach/detach nel relation manager Ruoli).
- Un utente con accesso al pannello User poteva rinominare `super-admin`, assegnarselo e ripristinare il nome (rilievo A1 dell'audit sicurezza Roosko).

## Acceptance criteria

1. Per chi non è super-admin `create`, `update`, `delete`, `addTeamMember`, `updateTeamMember`, `removeTeamMember` sui ruoli sono negati.
2. `attach`/`detach` e le altre abilità Filament non dichiarate sono negate (trait `DeniesUndeclaredFilamentAbilities` di Xot).
3. Il super-admin continua a gestire i ruoli (`XotBasePolicy::before`).

## Dev agent record

- 2026-11-05 — Claude: `RolePolicy` aggiornata; test di policy da aggiungere con l'ambiente vendor.
