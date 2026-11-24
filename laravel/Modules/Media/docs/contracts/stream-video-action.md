---
title: "StreamVideoAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Stream\\StreamVideoAction"
qmd: "StreamVideoAction streaming video HTTP range 206 416 autorizzazione owner super-admin disco path"
---

# StreamVideoAction

Invia un file video dal disco al client con supporto all'header `Range`. Codice: `app/Actions/Stream/StreamVideoAction.php:21-178`.

## Input

- `string $disk`, `string $path`: disco e percorso del file.
- `?Media $media`: se presente, il proprietario è verificato.

## Output

- `void`. Scrive header e corpo direttamente sulla risposta, poi termina il processo con `exit`.

## Invarianti

- **STREAM-VIDEO-INV-1** — Un utente non autenticato riceve `401` (`abort`).
  Test: `tests/Unit/MediaGapAttackCoverageTest.php:88` (solo presenza della classe; nessun test del caso 401 trovato).
- **STREAM-VIDEO-INV-2** — Se `$media` è presente, `created_by` deve coincidere con l'utente (confronto `!=`) oppure l'utente deve avere `super-admin`; altrimenti `403`.
  Test: nessuno.
- **STREAM-VIDEO-INV-3** — Un file inesistente o senza MIME leggibile lancia `Exception`.
  Test: `tests/Unit/MediaCoverage100RemainingTest.php:71` («rifiuta un path inesistente sul disco»).
- **STREAM-VIDEO-INV-4** — Un intervallo non valido (unità diversa da `bytes`, `start > end`, oltre la dimensione) risponde `416` e termina.
  Test: nessuno.

## Effetti collaterali

- Header HTTP (`Content-Type`, `Cache-Control` 30 giorni, `Expires`, `Last-Modified`, `Accept-Ranges`, `Content-Length`/`Content-Range`).
- Lettura a blocchi da 100 KiB con `echo` e `flush`, `set_time_limit(0)`.
- `fclose` e `exit`: il ciclo di risposta Laravel non viene completato.

## Errori

- `abort(401)` e `abort(403)`; `Exception` per file mancante, MIME non determinabile o stream non valido.
- `416` senza eccezione, seguito da `exit`.

## Non fa

- Se `$media` è `null` non c'è nessun controllo di proprietà: chiunque sia autenticato può leggere qualunque percorso del disco indicato.
- Anche con `$media` presente, il `$path` non viene confrontato con il percorso del media: il controllo di proprietà autorizza un percorso qualsiasi.
- Range suffisso (`bytes=-500`) non è gestito come da RFC: `explode` produce inizio `0`, quindi restituisce i primi 501 byte invece degli ultimi 500.
- Nessun chiamante in produzione (verificato con grep); il contratto descrive il codice, non un flusso attivo.
