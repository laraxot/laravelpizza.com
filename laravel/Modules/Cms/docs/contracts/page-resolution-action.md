---
title: "Contratto — ResolvePageAction"
type: contract
action: "Modules\\Cms\\Actions\\ResolvePageAction"
tags: [contract, action, folio, cms]
created: 2026-11-23
updated: 2026-11-23
---

# ResolvePageAction

Contratto di comportamento della risoluzione CMS per le rotte Folio
`[container0]/[slug0]`.

## Input

- `container0`: contenitore della rotta, non vuoto.
- `slug0`: slug o identificativo della risorsa, non vuoto.
- Configurazione allowlist `cms.config.container0_models` o alias tenant
  `xra.container0_model_map`.

## Output

Restituisce `ResolvePageData` con:

- `renderMode`: `model` quando è stato trovato un modello autorizzato, altrimenti
  `cms`;
- `item`: modello dinamico pubblicabile oppure `null`;
- `pageSlug`: slug specifico (`container.slug`), contenitore generico
  (`container.view`) o slug richiesto come fallback.

## Invarianti

- Blog ed eventi passano esclusivamente dai finder dei contenuti pubblicati.
- Un contenitore non presente nell'allowlist non carica modelli dall'URL.
- La policy `view`, gli scope globali e la chiave di rotta del modello restano
  applicati; un record non autorizzato equivale a uno inesistente.
- La mappa `tickets` abilita il contenitore `tickets.view`, non rende pubblico
  un ticket: la visibilità del payload resta in Fixcity.

## Effetti collaterali

- Esegue letture Eloquent e policy Gate.
- Non modifica record, sessione o risposta HTTP.

## Errori

- Una `QueryException` durante il binding del modello viene trattata come
  modello non risolto.
- Modello assente, slug assente o policy negata producono `item: null`; il
  chiamante decide se rispondere 404.

## Non fa

- Non esegue redirect.
- Non costruisce markup o metadata.
- Non carica classi arbitrarie in base al nome presente nell'URL.
