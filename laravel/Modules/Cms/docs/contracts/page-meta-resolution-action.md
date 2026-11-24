---
title: "Contratto — ResolvePageMetaAction"
type: contract
action: "Modules\\Cms\\Actions\\ResolvePageMetaAction"
tags: [contract, action, metadata, seo]
created: 2026-11-23
updated: 2026-11-23
---

# ResolvePageMetaAction

Contratto per titolo e descrizione della pagina in corso di rendering.

## Input

- Slug CMS della pagina.
- Iterable di `BlockData`.
- Data bag opaco, con eventuale `item` Eloquent.

## Output

`execute()` restituisce `array{title: string|null, description: string|null}`.
`remember()` registra gli stessi valori negli attributi della richiesta
`cms.meta.title` e `cms.meta.description`.

## Invarianti

- Priorità del titolo: modello (`title`, poi `name`), pagina CMS.
- Priorità della descrizione: modello (`description`, poi `content`), primo
  blocco con `description` o `subtitle`.
- Le descrizioni derivate da un modello sono ripulite e limitate a 160 caratteri.
- Un valore già registrato nella richiesta non viene sovrascritto da un
  rendering successivo dello stesso ciclo.

## Effetti collaterali

- Solo `remember()` modifica gli attributi della richiesta corrente.
- `execute()` è una lettura e non scrive dati persistenti.

## Errori

- Dati non stringa o vuoti vengono ignorati come metadata assenti.
- L'assenza di pagina, modello o blocco produce valori `null`, non un'eccezione.

## Non fa

- Non determina la visibilità del modello.
- Non esegue query di dominio oltre alla pagina CMS indicata dallo slug.
- Non genera il markup HTML dell'head.
