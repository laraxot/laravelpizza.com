---
title: "[STORY] PHPStan cleanup — Media"
type: story
module: Media
status: done
priority: medium
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, media]
---

# [STORY] PHPStan cleanup — Media

## User Request

«sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalità, non sull'errore; aumenta la qualità del codice; usa enum al posto delle costanti».

Perimetro: segnalazioni PHPStan (level max) del modulo Media. Errori di partenza: 12 `constantTypeCoverage` (4 action diagnostiche, AwsTest, S3Test), 2 `array.offsetOverwritten`/`assign.overwritten` (diagnostica S3), 1 `assign.overwritten` (ConvertVideoCommand), 2 `assign.overwritten` (AddAttachmentAction x2), 3 `variable.unused` (AwsTest), 1 `variable.unused` (MediaBasePolicy).

## Analysis

**Scopo del codice.** Il modulo gestisce allegati/media (Spatie MediaLibrary), conversioni FFmpeg e una console di diagnostica AWS/S3/CloudFront
(`Test/Pages/S3Test`, `AwsTest`, con la logica estratta in `Actions/Diagnostic/*`).

| File | Cosa faceva davvero | Correzione |
| --- | --- | --- |
| `ConvertVideoCommand` | converte un MP4 in WebM e stampa l'URL. `$format` assegnato due volte; la transcodifica veniva **salvata due volte** (catena diretta + catena via `MediaExporterResolver`) | una assegnazione, una sola catena `MediaExporterResolver::from($export->toDisk($disk))->inFormat($format)->save($file_new)` (meta' del lavoro FFmpeg) |
| `TestBucketPermissionsAction` | sonda i permessi S3 (List/Put/Get/Delete) e restituisce `title/status/data`. `status='info'` iniziale sempre sovrascritto | ritorni diretti in `try/catch` come le action sorelle; titolo in `private const string TITLE` |
| `S3Test::test_s3_permissions` | duplicato di ~60 righe della stessa sonda (l'action non era referenziata da nessuno) | delega a `TestBucketPermissionsAction` (la logica sta nelle Action) |
| `AddAttachmentAction` (2 file identici) | aggiunge un file a una collection e imposta `created_by/updated_by`; `setName()` chiamato due volte (la prima in versione "lenient" sempre sovrascritta) | tenuta la seconda (comportamento effettivo, con `Assert::string`); rimossi import e `@param` duplicato |
| `AwsTest::test_s3_connection` / `test_s3_permissions` | `headBucket`/`listObjectsV2` lanciano `AwsException` in caso di errore: il `Result` non serve | chiamata senza assegnazione (con commento) |
| `AwsTest::test_s3_file_operations` | put -> get -> delete e dichiara `Download: OK`, ma il contenuto scaricato **non veniva mai confrontato** con `$testContent` | **logica mancante implementata**: confronto del `Body` con il contenuto caricato, esito `error` e notifica `danger` se diverso |
| `MediaBasePolicy` | `$xotData = XotData::make()` mai letto (residuo meccanico), la logica e' il bypass `super-admin` | rimosso |
| 12 costanti | non sono insiemi di valori (regione AWS, prefissi file di test, lunghezze di preview) | restano costanti, `private const string|int` |

## Acceptance Criteria

- [x] Costanti dei file segnalati tipizzate nativamente
- [x] `ConvertVideoCommand` esegue una sola transcodifica verso WebM
- [x] La sonda dei permessi S3 esiste in un solo posto (Action) e la pagina la usa
- [x] Il test file-operations AWS verifica il contenuto scaricato
- [x] Nessun `$result`/`$xotData` inutilizzato; nessuna doppia assegnazione
- [x] PHPStan: 0 errori sul modulo Media (run per path e run completo)

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO

Dev story: [2026-10-06-phpstan-cleanup-media.dev.md](./2026-10-06-phpstan-cleanup-media.dev.md)
