---
title: "HasTeamsAndUserContract"
type: concept
tags: [hasteamsandusercontract]
created: 2026-07-14
updated: 2026-07-14
qmd: "hasteamsandusercontract hasteamsandusercontract"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./teamcontract.md"
---

# HasTeamsAndUserContract

L'interfaccia `HasTeamsAndUserContract` estende sia `HasTeamsContract` che `UserContract`, fornendo un'unica interfaccia che combina le funzionalità di entrambe.

## Metodi

### Team Management

- `teamRole(Team $team): ?string`
  - Ottiene il ruolo dell'utente nel team specificato
  - Restituisce `null` se l'utente non appartiene al team
  - Restituisce `'owner'` se l'utente è il proprietario del team
  - Restituisce il ruolo specifico altrimenti

- `canRemoveTeamMember(Team $team, HasTeamsContract $user): bool`
  - Determina se l'utente può rimuovere un membro del team
  - Richiede che l'utente sia proprietario del team o abbia il permesso 'remove-member'

- `canUpdateTeamMember(Team $team, HasTeamsContract $user): bool`
  - Determina se l'utente può aggiornare un membro del team
  - Richiede che l'utente sia proprietario del team o abbia il permesso 'update-member'

## Interfacce Estese

- [[HasTeamsContract]] - Per la gestione dei team
- [[UserContract]] - Per la gestione degli utenti

## Implementazioni

- [[BaseUser]] - Implementazione principale dell'interfaccia

## Note Importanti

- L'interfaccia è stata creata per risolvere problemi di compatibilità tra `HasTeamsContract` e `UserContract`
- Tutti i metodi devono essere implementati rispettando i tipi di parametri e di ritorno specificati
- I metodi di gestione dei team richiedono il tipo `HasTeamsContract` per il parametro `$user`

## Collegamenti Correlati

- [[Team]]
- [[Models]]
- [[Contracts]]
