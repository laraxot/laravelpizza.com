---
title: "Contratto — SubmitIndexNowAction"
type: contract
action: "Modules\Seo\Actions\IndexNow\SubmitIndexNowAction"
tags: [contract, action, indexnow]
created: 2026-11-19
updated: 2026-11-19
---

# SubmitIndexNowAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/IndexNow/SubmitIndexNowAction.php`. Perché: [ADR](../adr/search-engine-presence.md).

## Input

- Lista di URL assolute (`list<string>`), di solito le URL nuove della sitemap.
- Chiave IndexNow dalla configurazione Seo del tenant (`SeoConfigData::indexNowKey()`).
- Host del sito da `url('/')`.

## Output

- `array{submitted: int, skipped: int, statuses: list<int>}`:
  - `submitted`: URL dei blocchi accettati (200 o 202);
  - `skipped`: URL scartate prima dell'invio (non valide, di un altro host, doppie) o tutte, se IndexNow è spento;
  - `statuses`: un codice HTTP per blocco inviato, `0` se il servizio non è raggiungibile.

## Invarianti

- Senza chiave valida (8-128 caratteri, lettere, cifre, trattini) non parte nessuna richiesta.
- Si inviano solo URL dell'host del sito, una volta ciascuna, a blocchi di al massimo 10.000.
- `keyLocation` usa schema e host delle URL inviate (`/{chiave}.txt`), mai l'host di un'altra richiesta.
- Endpoint unico `https://api.indexnow.org/indexnow`: i motori aderenti si condividono l'invio.

## Effetti collaterali

- Una richiesta HTTP `POST` JSON per blocco, timeout 15 secondi.
- Un `Log::warning` se il servizio non risponde o rifiuta l'invio (codice diverso da 200/202).

## Errori

- Nessuna eccezione verso il chiamante: rete giù → `statuses` contiene `0`; rifiuto (400, 403, 422, 429) → il codice
  in `statuses` e `submitted` non conta quel blocco.

## Non fa

- Non ricorda cosa ha inviato né quando: lo fa il comando `seo:indexnow` (`storage/app/seo/indexnow-submitted.json`,
  URL => data dell'ultimo invio), che reinvia una URL solo se il suo `<lastmod>` è più recente.
- Non legge la sitemap: le URL le passa il chiamante.
- Non serve il file della chiave: lo fa `ServeIndexNowKeyAction` sulla rotta `/{chiave}.txt`.
- Non avvisa Google (non aderisce a IndexNow): per Google valgono sitemap e Search Console.
- Non garantisce l'indicizzazione: 200 vuol dire solo «ricevute».
