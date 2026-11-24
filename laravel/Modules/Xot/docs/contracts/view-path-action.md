---
title: "ViewPathAction (File) — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\File\\ViewPathAction"
qmd: "ViewPathAction percorso file blade vista namespace File GetViewNameSpacePathAction null punto slash"
---

# ViewPathAction (File)

Converte un nome di vista `ns::a.b` nel percorso del file `.blade.php` usando la cartella del namespace risolta da `File\GetViewNameSpacePathAction`. Codice: `app/Actions/File/ViewPathAction.php:11-28`.

## Input

- `string $key`: nome vista (`execute`, riga 15).

## Output

- `string`: percorso del file con separatori di sistema (righe 19-26).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `FILE-VIEWPATH-INV-1` | Percorso = cartella del namespace + `/` + gruppo (punti in slash) + `.blade.php`, poi normalizzato con `FixPathAction`. | righe 17-26 | `tests/Unit/Actions/File/FileActionsTest.php:34`; `tests/Unit/Actions/File/ViewPathActionTest.php:11,32` |
| `FILE-VIEWPATH-INV-2` | Se il namespace non ha hint e non è un tema, `File\GetViewNameSpacePathAction` ritorna `null`, e il percorso parte da `/` senza errore. | righe 19, 24 | Test: nessuno |

## Effetti collaterali

Nessuno.

## Errori

- `Webmozart\Assert` lancia se il gruppo non è una stringa (riga 20).

## Non fa

- Non verifica che il file esista.
- Non gestisce `null` da `GetViewNameSpacePathAction` (`INV-2`): da correggere in un intervento successivo.
- Marker `@contract` aggiunto nel docblock della classe.
