---
title: "Contratti del modulo Seo"
type: index
tags: [contracts, actions, seo, indexnow]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti del modulo Seo

Cosa promettono le Action di Seo che parlano con l'esterno: l'invio delle URL a IndexNow e il file pubblico della chiave
che i motori scaricano per verificarlo. Le altre Action del modulo (metatag, sitemap, robots, URL) costruiscono testo o
risposte senza effetti collaterali e sono coperte dagli ADR e dai loro test.

Leggili prima di chiamare o modificare l'invio a IndexNow o la rotta `/{chiave}.txt`. Le invarianti con group si
verificano con `cd laravel && vendor/bin/pest Modules/Seo/tests --group=<ID>`; `—` è debito dichiarato.

Formato (sei sezioni, tabella invarianti con ID, `@contract` nel docblock):
[0012-behavioral-contract-governance](../../../Xot/docs/adr/0012-behavioral-contract-governance.md).

## Indice

- [SubmitIndexNowAction](submit-index-now-action.md) — invia a `api.indexnow.org` solo URL dell'host, una volta, a blocchi da 10.000; spenta senza chiave valida.
- [ServeIndexNowKeyAction](serve-index-now-key-action.md) — `/{chiave}.txt` risponde solo per la chiave configurata, 404 per tutto il resto.
