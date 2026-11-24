---
title: "INDEX — User"
type: index
status: active
created: 2026-11-23
updated: 2026-11-23
decision-makers: []
---

<!-- File: docs/contracts/INDEX.md · formato MADR breve. -->
# <!-- Titolo: indice operativo User -->

## Contratti di comportamento

I contratti descritti qui sono i contratti di comportamento auditi per il modulo
User. Legacy behavior è documentato così com'è e non è un modello per codice nuovo.

| Operazione | Contract | Classe | Invarianti |
|---|---|---|---|
| Create user | [hasverified-identity-action](hasverified-identity-action.md) | `App\Actions\User\HasVerifiedIdentityAction` | USER-IDV-INV-1..3 |
| Add user to team | [hasteamsandusercontract](hasteamsandusercontract.md) | `HasTeamsAndUserContract` | TEAM-USER-INV-1..4 |
| Get owner | [teamcontract](teamcontract.md) | `UserContract` | USER-OWNER-INV-1 |
| Remove user from team | [hasteamsandusercontract](hasteamsandusercontract.md) | `HasTeamsContract` | TEAM-REMOVE-INV-1 |

(End of file - total 21 lines)