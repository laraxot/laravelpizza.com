---
title: "File parcheggiati — User"
document_type: index
category: documentation
module: User
status: active
updated_at: '2026-11-18'
<<<<<<< HEAD
=======
qmd: "parcheggiati user"
>>>>>>> laraxot/dev
---

# File parcheggiati

File `.wip` spostati qui da `app/` e da `database/migrations/` il 2026-11-12
<<<<<<< HEAD
([module_<nome progetto>_fila5#61](https://github.com/laraxot/module_<nome progetto>_fila5/issues/61)).
=======
([module_quaeris_fila5#61](https://github.com/laraxot/module_quaeris_fila5/issues/61)).
>>>>>>> laraxot/dev

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

---

## Aggiunti il 2026-11-18 — estensioni finte sotto `app/`

I file qui sopra sono `.wip`. Il 2026-11-18 ne sono arrivati altri con
estensioni diverse — `.up`, `.test`, `.disabled`, `.boh`, `.to_migra` — trovati
cercando **tutte** le estensioni finte sotto `app/`, non solo `.wip`: erano 64
in dodici moduli. Un'estensione finta non tiene un file fuori dal codice, lo
rende invisibile a chi cerca e vivo per chi lo trova.

Per questi il percorso dentro `parcheggio/` e' quello d'origine, quindi si sa
sempre da dove venivano.

| File (percorso d'origine sotto `app/`) | Byte |
|---|---|
| `app/Filament/Traits/CanDeleteAccount.test` | 814 |
| `app/Filament/Traits/CanLogoutOtherBrowserSessions.test` | 1369 |
| `app/Filament/Traits/HasCachedAction.test` | 476 |
| `app/Filament/Traits/HasHiddenAction.test` | 4138 |
| `app/Filament/Traits/HasTwoFactorAuthentication.test` | 4336 |
| `app/Listeners/Auth/SendEmailVerificationNotification.test` | 1033 |
| `app/Models/Project.test` | 832 |
| `app/Providers/UserPanelProvider.boh` | 527 |

Sette trait e classi con estensione `.test`, piu' un `UserPanelProvider.boh`.

`UserPanelProvider.boh` merita un'occhiata prima degli altri: un pannello
parcheggiato e' una delle cose che in questo monorepo ha fatto piu' danno
quando e' rimasta a meta' — i provider dei pannelli fanno discovery per
modulo, e una copia morta accanto a quella viva confonde chi cerca di capire
quali pagine vengono registrate.

I `.test` sono funzioni d'account (eliminazione, logout dalle altre sessioni,
due fattori): roba che tocca l'autenticazione, quindi non si riattiva di
sfuggita.

**Questi non sono stati esaminati riga per riga**, a differenza dei `.wip` qui
sopra: sono stati spostati, non giudicati. Prima di copiarne uno nel codice
vivo, confrontalo con quello che c'e' adesso.

