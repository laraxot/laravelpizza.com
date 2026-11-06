---
title: "UserContract boundary: contract over abstract base"
type: decision
status: active
updated: 2026-10-18
tags: [bmad, second-brain, architecture, contracts, user]
qmd: "usercontract boundary xot"
---

# UserContract boundary

## Decision

Quando un componente deve riconoscere un utente, usa
`Modules\Xot\Contracts\UserContract` (oppure `Modules\User\Contracts\UserContract`)
e non `Modules\User\Models\BaseUser`.

## Perché

`BaseUser` è un dettaglio di implementazione astratto. `UserContract` descrive
la capacità richiesta: autenticazione, ruoli, profilo, tenant, media e token.
Un modello concreto può implementare il contratto senza estendere quella base;
il controllo sulla classe astratta lo rifiuterebbe erroneamente.

## Regola operativa

- parametri e return type: `UserContract`;
- guard runtime: `$user instanceof UserContract`;
- mock e fixture: `UserContract`;
- capability opzionali: contratto dedicato (es. `HasAuthentications` per i log);
- intersezione tipizzata quando serve entrambi: `UserContract&HasAuthentications`;
- `BaseUser`: solo ereditarietà, test della base o API strettamente interne.

Ogni nuova violazione va corretta alla fonte e accompagnata da un test statico
o comportamentale senza reset del database.

## Stato 2026-10-18

`RecordAuthenticationLogAction` e i listener Auth del modulo User rispettano
questa regola: nessun type-hint / `instanceof BaseUser` nei consumer.

## Collegamenti

- Wiki User: [usercontract-boundary.md](../../../User/docs/wiki/concepts/usercontract-boundary.md)
- Tema Sixteen: [user-contract-boundary.md](../../../../Themes/Sixteen/docs/auth/user-contract-boundary.md)
- Log BMAD User: [bmad-second-brain.md](../../../User/docs/bmad-second-brain.md)
- Campagna test PHPStan (Assert vs `expect()` higher-order): [phpstan-pest-patterns-modulo-notify.md](../../../Notify/docs/wiki/memories/phpstan-pest-patterns-modulo-notify.md)
