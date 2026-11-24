---
title: "GetViewPathAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\View\\GetViewPathAction"
qmd: "GetViewPathAction percorso file blade vista namespace punti blade.php separatori"
---

# GetViewPathAction

Converte un nome di vista `ns::a.b` nel percorso del file `.blade.php` su disco. Codice: `app/Actions/View/GetViewPathAction.php:10-28`.

## Input

- `string $view`: nome vista, es. `progressioni::scheda.index` (`execute`, riga 17).

## Output

- `string`: percorso del file con separatori di sistema e suffisso `.blade.php` (righe 21-27).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `VIEW-PATH-INV-1` | Il percorso è la cartella della vista (come `GetViewDirAction`) + `/` + ultimo segmento + `.blade.php`. | righe 19-27 | Test: nessuno |

## Effetti collaterali

Nessuno.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non verifica che il file esista.
- Usa `View\GetViewNameSpacePathAction`, mentre `File\ViewPathAction` usa `File\GetViewNameSpacePathAction` (hint del view finder). I due risolutori possono dare percorsi diversi per lo stesso namespace: incoerenza da allineare.
- Marker `@contract` aggiunto nel docblock della classe.
