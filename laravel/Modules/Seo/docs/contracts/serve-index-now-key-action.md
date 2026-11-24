---
title: "Contratto — ServeIndexNowKeyAction"
type: contract
action: "Modules\Seo\Actions\IndexNow\ServeIndexNowKeyAction"
tags: [contract, action, indexnow, route]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../adr/search-engine-presence.md
  - ../../app/Actions/IndexNow/ServeIndexNowKeyAction.php
  - ../../routes/web.php
  - ../../tests/Feature/IndexNow/IndexNowTest.php
---

# ServeIndexNowKeyAction

Il file di verifica IndexNow: `GET /{chiave}.txt` risponde con la chiave, solo se è quella configurata. Rotta
`seo.indexnow.key` in `routes/web.php`, alla radice del sito (senza lingua), registrata **dopo** `/robots.txt`.
Sorgente: `app/Actions/IndexNow/ServeIndexNowKeyAction.php`.

Test: `cd laravel && vendor/bin/pest Modules/Seo/tests/Feature/IndexNow/IndexNowTest.php --group=SEO-INDEXNOW-KEY-INV-1`.

## Input

- `string $key`: la parte del percorso prima di `.txt` (la rotta ammette solo `[A-Za-z0-9-]{8,128}`).
- La chiave del tenant da `SeoConfigData::make()->indexNowKey()`.

## Output

- `Response` 200, `Content-Type: text/plain; charset=UTF-8`, corpo = la chiave configurata.
- Altrimenti `NotFoundHttpException` (404), come se la rotta non esistesse.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| SEO-INDEXNOW-KEY-INV-1 | Risponde 200 solo per la chiave configurata; qualunque altra `/{x}.txt` è 404. | `SEO-INDEXNOW-KEY-INV-1` |
| SEO-INDEXNOW-KEY-INV-2 | Con IndexNow spento o chiave malformata (corta, caratteri non ammessi) non esiste nessun file: sempre 404. | `SEO-INDEXNOW-KEY-INV-2` |
| SEO-INDEXNOW-KEY-INV-3 | Il confronto è a tempo costante (`hash_equals`): la rotta non aiuta a indovinare la chiave per tentativi. | — |

## Effetti collaterali

- Nessuno: legge la configurazione del tenant e risponde.

## Errori

- `abort(404)` per ogni chiave non configurata; nessun altro errore.

## Non fa

- Non serve altri file `.txt` (es. `robots.txt`, che ha la sua rotta registrata prima, o `llms.txt`, escluso dall'ADR).
- Non invia nulla ai motori: lo fa [SubmitIndexNowAction](submit-index-now-action.md).
- Non scrive un file su disco: la chiave vive nella configurazione del tenant e la risposta è dinamica.
