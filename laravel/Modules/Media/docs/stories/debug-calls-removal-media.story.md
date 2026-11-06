---
title: "[STORY] Rimozione delle chiamate di debug dal codice di produzione (Media)"
type: story
status: done
priority: high
created: 2026-10-20
updated: 2026-10-20
module: Media
tags: [bmad, debug, dddx, media-library, video, generator, quality]
qmd: "media dddx Webm VideoGenerators ImageGenerator convert LogicException media-library image_generators"
related:
  - ../../../User/docs/stories/debug-calls-removal-user.story.md
  - ./16-4-media-case-variant-consolidation.md
---

# Rimozione delle chiamate di debug dal codice di produzione (Media)

## Fase BMAD

Fase di implementazione e verifica (quality gate), parte della wave sulle chiamate che fermano la richiesta (`dddx()` termina
con `dd()`).

## Sito: `Conversions/VideoGenerators/Webm.php`

**Scopo capito.** Un `ImageGenerator` di Spatie media-library che avrebbe dovuto produrre un'anteprima da video (`mp4`). E' nato come
copia di un generatore webp-to-png (il corpo commentato usava `imagecreatefromwebp` e `imagepng`) e non e' mai stato completato: il
percorso di uscita termina in `.webmXXX`, segnaposto. In piu' c'era un bug: `${$pathToImageFile}` e' una variabile variabile su
una stringa percorso, quindi anche senza il `dd()` quella riga avrebbe sollevato "Undefined variable".

La classe non e' registrata: `config/media-library.php` (`image_generators`) elenca solo i generatori di Spatie, tra cui
`Video::class`, che e' proprio l'anteprima video via ffmpeg. Il ramo e' quindi gia' coperto. Riferimenti alla classe: solo il test
`GeneratorsAndAttachmentDataTest` (verificato con `rg -P` e `git grep -w`). Nessun chiamante di `convert()`.

**Cosa ho fatto.** `convert()` ora fa `throw new \LogicException('Webm::convert() non implementato')`. Non ho tolto solo il
`dddx`: avrei riattivato `return $pathToImageFile`, cioe' la restituzione di un percorso di file inesistente, che media-library
avrebbe usato come anteprima. Tolto anche il commento morto del generatore webp. La classe non e' cancellata (nessun chiamante: si
segnala).

**Codice riattivato.** Nessuno, ed e' il motivo per cui ho sostituito invece di cancellare la riga.

**Rischio.** Nullo oggi (classe non registrata). Se la si registra, l'errore e' esplicito.

**Test.** In `tests/Unit/Conversions/GeneratorsAndAttachmentDataTest.php` ho aggiunto "the webm generator refuses to convert instead of
returning a bogus path" e aggiornato il commento di testa, che dichiarava `convert()` "non invocabile". Pest (gruppo `no-media-db`,
solo memoria): 6 test, 27 asserzioni, verdi.

## Non toccato

- `Console/Commands/ConvertVideoCommand.php:26-27`: `print_r($x, true)` restituisce una stringa, legittimo.
- La copia `app/conversions/videogenerators/Webm.php` (minuscolo) e' nell'indice git ma sul disco c'e' solo la cartella vuota:
  e' la variante di maiuscole della story [16-4](./16-4-media-case-variant-consolidation.md), fuori da questo perimetro.

## Decisioni aperte

1. **Cancellare `Webm` e il suo test di capability** (la classe e' ridondante con `Spatie\...\Video`) oppure completarla: oggi
   dichiara `mp4` ma non converte nulla.
2. Il commento di `Webm::requirementsAreInstalled()` e' il blocco GD copiato dal generatore webp e restituisce sempre `true`: se la
   classe resta, deve controllare `ffmpeg`.

## Verifica

- Tokenizer su `Modules/Media/app`: restano solo i due `print_r(..., true)` legittimi.
- `php -l` sui file toccati: nessun errore.
- PHPStan gated su `Modules/Media` intero: exit 0, nessun errore.
