---
title: "File parcheggiati — User"
document_type: index
category: documentation
module: User
status: active
updated_at: '2026-11-12'
---

# File parcheggiati

File `.wip` spostati qui da `app/` e da `database/migrations/` il 2026-11-12
([module_quaeris_fila5#61](https://github.com/laraxot/module_quaeris_fila5/issues/61)).

| File | Stato | Nota |
|---|---|---|
| `ModulesRelationManager.wip` | **nessuna versione viva** | Relation manager dei moduli su `UserResource`, mai attivato: zero riferimenti nel monorepo |
| `2024_03_27_000001_create_user_authentications_table.wip` | **unica migration per quella tabella** | Vedi sotto |

## La migration parcheggiata

Era in `database/migrations/`, e il posto era il problema.

Non finendo in `.php` non viene eseguita, quindi la tabella
`user_authentications` **non esiste** su nessun database. E nessun codice la
usa: `grep -rln "user_authentications\|UserAuthentication"` su tutti i moduli
non trova niente. Quindi oggi non manca nulla a nessuno.

Il rischio era un altro, ed e' il motivo per cui l'ho spostata: chi la trovava
fra le migration poteva rinominarla in `.php` per "farla partire". A quel punto
sarebbe partita **con la data del 2024**, cioe' prima di decine di migration
committate dopo — e l'ordine delle migration e' l'unica garanzia che le
dipendenze fra tabelle siano rispettate. Da qui dentro, quel passo falso non si
fa per sbaglio.

Se la tabella serve davvero, si scrive una migration nuova con la data di
oggi, prendendo lo schema da questo file.
