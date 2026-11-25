---
qmd: "media sync marker repair story"
issues: []
discussions: []
title: "Media: marcatori di conflitto committati dal sync nelle Action"
type: story
scope: module:Media
module: Media
story_id: "MEDIA-SYNC-MARKERS"
slug: media-sync-marker-repair
status: review
created: 2026-11-24
updated: 2026-11-24
tags: [sync, git, conflitti, phpstan]
related:
  - "../conflict-resolution.md"
  - "../../../Xot/docs/lessons/module-sync-merge-conflicts.md"
---
# Media: marcatori di conflitto committati dal sync nelle Action

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Obiettivo

Tre Action del modulo Media contenevano marcatori di conflitto (annidati) committati da `merge_remote_repo_2.sh`, e bloccavano l'avvio di PHPStan.
Obiettivo: file coerenti con il loro scopo.

## Perimetro

Solo `laravel/Modules/Media/app/Actions` (php).

## File, scopo e risoluzione

| File | Scopo | Risoluzione | Righe scartate |
|---|---|---|---|
| `app/Actions/Image/Merge.php` | unire piu' PNG (chart, conversioni) in un asset con Intervention Image v4 | unito: descrizione + `@see` + `@contract` | solo righe di marcatore |
| `app/Actions/Image/StripImageMetadataAction.php` | riscrivere JPEG/PNG senza EXIF/GPS/XMP | unito: `@see` + `@contract` | solo righe di marcatore |
| `app/Actions/SaveAttachmentsAction.php` | copiare gli allegati nelle collezioni Media Library e salvare i percorsi sul record | unite le due righe del docblock in conflitto: descrizione di un lato, `@see` dell'altro, `@contract` | solo righe di marcatore |

Il corpo delle tre classi coincide con il riferimento buono (commit root `6e32612c`): in conflitto c'erano solo docblock.

## Nota di processo

All'avvio della lane i marcatori risultavano gia' tolti nel working tree (file modificati tra le 20:59:21 e le 21:00:15 del 24/11/2026 da un'altra
passata, prima di qualsiasi scrittura di questa lane; `git diff HEAD` mostrava solo cancellazioni, cioe' il primo lato di ogni blocco). Questa lane non ha
sovrascritto quel lavoro: ha verificato **ogni file** contro lo scopo (chiamanti, test, contratto) e contro il riferimento buono (commit root `6e32612c`),
poi ha completato cio' che mancava (docblock `@see` nel formato di progetto, documentazione, verifica). Backup dello stato di partenza
prima delle scritture: archivio nello scratchpad della sessione (18 file). Lo stato con i marcatori resta leggibile con `git show 6291f121d:<percorso>`.

## Verifica

- `grep -rlE '^(<<<<<<<|>>>>>>>|=======$)' Modules/Media --include='*.php'`: 0 file (prima 3).
- `php -l` sui tre file: nessun errore.
- Controllo `@see` di `18-struttura-file-php.md`: `@see Modules/Media/docs/contracts/...` verso file esistenti; `@contract` mantenuto (richiesto da `ActionContractsAreCompleteTest`).
- Pint `--test`: pulito.

## Residui fuori perimetro

- `Media/tests/TestCase.php` (riga 66) elenca la connessione `quaeris_data`, assente in questo progetto: `StripImageMetadataActionTest` e `SaveAttachmentsActionTest`
  falliscono nel `setUp` con `Database connection [quaeris_data] not configured`, prima di eseguire le Action; non dipende dalla risoluzione dei marcatori.
- Il contratto `docs/contracts/strip-image-metadata-action.md` ha sezioni doppie e `save-attachments-action.md` marcatori: lane docs.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

- `grep -rlE '^(<<<<<<<|>>>>>>>|=======$)' Modules/Media --include='*.php'`: 0 file (prima 3).
- `php -l` sui tre file: nessun errore.
- Controllo `@see` di `18-struttura-file-php.md`: `@see Modules/Media/docs/contracts/...` verso file esistenti; `@contract` mantenuto (richiesto da `ActionContractsAreCompleteTest`).
- Pint `--test`: pulito.
