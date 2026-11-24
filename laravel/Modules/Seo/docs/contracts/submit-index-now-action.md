---
title: "Contratto — SubmitIndexNowAction"
type: contract
action: "Modules\Seo\Actions\IndexNow\SubmitIndexNowAction"
tags: [contract, action, indexnow, http]
created: 2026-11-19
updated: 2026-11-24
related:
  - ../adr/search-engine-presence.md
  - ../../app/Actions/IndexNow/SubmitIndexNowAction.php
  - ../../app/Console/Commands/SubmitIndexNowCommand.php
  - ../../tests/Feature/IndexNow/IndexNowTest.php
---

# SubmitIndexNowAction

Avvisa i motori IndexNow (Bing, Yandex, Seznam, Naver…) che delle URL del sito sono nuove o cambiate. Perché:
[ADR presenza nei motori di ricerca](../adr/search-engine-presence.md). Sorgente:
`app/Actions/IndexNow/SubmitIndexNowAction.php`; chiamante: il comando `seo:indexnow`
(`app/Console/Commands/SubmitIndexNowCommand.php`).

Test: `cd laravel && vendor/bin/pest Modules/Seo/tests/Feature/IndexNow/IndexNowTest.php` (oppure `--group=SEO-INDEXNOW-INV-<N>`).

## Input

| Fonte | Valore | Note |
|---|---|---|
| `$urls` | `list<string>` | URL assolute, di solito quelle nuove o cambiate della sitemap |
| `SeoConfigData::make()->indexNowKey()` | `?string` | chiave del tenant (`indexnow_key`), valida solo se `^[A-Za-z0-9-]{8,128}$`; altrimenti `null` = spento |
| `url('/')` | host del sito | le URL di un altro host si scartano |

## Output

`array{submitted: int, skipped: int, statuses: list<int>}`:

- `submitted`: URL dei blocchi accettati (200 o 202);
- `skipped`: URL scartate prima dell'invio (non valide, di un altro host, doppie), oppure tutte se IndexNow è spento;
- `statuses`: un codice HTTP per blocco inviato, `0` se il servizio non è raggiungibile.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| SEO-INDEXNOW-INV-1 | Senza chiave valida non parte nessuna richiesta: `submitted = 0`, `skipped = count($urls)`, `statuses = []`. | `SEO-INDEXNOW-INV-1` |
| SEO-INDEXNOW-INV-2 | Si inviano solo URL valide dell'host del sito, ciascuna una volta. | `SEO-INDEXNOW-INV-2` |
| SEO-INDEXNOW-INV-3 | Endpoint unico `https://api.indexnow.org/indexnow` (`DEFAULT_ENDPOINT`): i motori aderenti si condividono l'invio. | `SEO-INDEXNOW-INV-3` |
| SEO-INDEXNOW-INV-4 | Il corpo è `{host, key, keyLocation, urlList}` con `keyLocation = <schema delle URL>://<host>/<chiave>.txt`, mai l'host della richiesta corrente. | `SEO-INDEXNOW-INV-4` |
| SEO-INDEXNOW-INV-5 | Blocchi di al massimo 10.000 URL (`MAX_URLS_PER_REQUEST`), una richiesta per blocco. | `SEO-INDEXNOW-INV-5` |
| SEO-INDEXNOW-INV-6 | Un rifiuto (codice diverso da 200/202) non conta le URL del blocco in `submitted` e il codice compare in `statuses`. | `SEO-INDEXNOW-INV-6` |
| SEO-INDEXNOW-INV-7 | Servizio irraggiungibile = `0` in `statuses`, nessuna eccezione. | — |

## Effetti collaterali

- Una richiesta HTTP `POST` JSON per blocco a `api.indexnow.org`, timeout 15 secondi.
- `Log::warning` (`IndexNow unreachable` / `IndexNow refused the submission`) con il numero di URL, mai le URL.

## Errori

- Nessuna eccezione verso il chiamante per errori di rete o rifiuti del servizio (400, 403, 422, 429): sono codici in
  `statuses`. Il comando decide cosa ricordare come inviato.

## Non fa

- Non ricorda cosa ha inviato né quando: lo stato (`storage/app/seo/indexnow-submitted.json`, URL => data dell'ultimo
  invio) e la scelta delle URL «nuove o cambiate» per `<lastmod>` sono del comando `seo:indexnow`.
- Non legge la sitemap: le URL le passa il chiamante.
- Non serve il file della chiave: lo fa [ServeIndexNowKeyAction](serve-index-now-key-action.md).
- Non avvisa Google (non aderisce a IndexNow): per Google valgono sitemap e Search Console.
- Non ritenta né mette in coda dopo un 429: aggiungere un retry automatico va contro la richiesta del protocollo di
  inviare solo URL cambiate.
- Non garantisce l'indicizzazione: 200 vuol dire solo «ricevute».
