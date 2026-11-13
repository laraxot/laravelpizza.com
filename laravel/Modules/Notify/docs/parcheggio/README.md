---
title: "File parcheggiati — Notify"
document_type: index
category: documentation
module: Notify
status: active
updated_at: '2026-11-12'
---

# File parcheggiati

File `.wip` spostato qui da `app/` il 2026-11-12
([module_quaeris_fila5#61](https://github.com/laraxot/module_quaeris_fila5/issues/61)).

| File | Stato | Nota |
|---|---|---|
| `SpatieEmail.php.wip` | esiste anche viva, molto piu' grande | 1,2 KB contro 11 KB |

## Perche' questo stava nel posto peggiore di tutti

`SpatieEmail` e' la classe che manda **tutti gli inviti di Quaeris** dopo la
migrazione a RecordNotification
([#38](https://github.com/laraxot/module_quaeris_fila5/issues/38)). Avere
accanto al file vivo una versione da un decimo delle righe, senza niente che
dica di cosa sia la bozza, e' la condizione perfetta perche' qualcuno apra
quella sbagliata mentre cerca di capire perche' un invito non e' partito.

Non cancellata perche' contiene 28 righe che la versione viva non ha. Se non
servono piu', si cancella: `diff docs/parcheggio/SpatieEmail.php.wip app/Emails/SpatieEmail.php`
per decidere.
