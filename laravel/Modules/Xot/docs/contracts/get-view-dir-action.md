---
title: "GetViewDirAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\View\\GetViewDirAction"
qmd: "GetViewDirAction cartella vista namespace percorso directory separator punti slash"
---

# GetViewDirAction

Converte un nome di vista `ns::a.b` nella cartella che la contiene su disco. Codice: `app/Actions/View/GetViewDirAction.php:10-26`.

## Input

- `string $view`: nome vista, es. `progressioni::scheda.index` (`execute`, riga 17).

## Output

- `string`: cartella assoluta, con separatori di sistema (righe 21-24).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `VIEW-DIR-INV-1` | Il namespace è il testo prima di `::`; il resto con `.` diventa `/`. | righe 19-20 | Test: nessuno |
| `VIEW-DIR-INV-2` | Cartella = cartella del namespace (`View\GetViewNameSpacePathAction`) + `/` + percorso relativo; separatori di sistema. | righe 21-24 | Test: nessuno |

## Effetti collaterali

Nessuno.

## Errori

- Nessuna eccezione propria. Le eccezioni di `View\GetViewNameSpacePathAction` si propagano.

## Non fa

- Non verifica che la cartella esista.
- Dubbio: senza `::` il namespace diventa l'intera stringa e il percorso relativo è vuoto. Non gestito; comportamento non verificato.
- Marker `@contract` aggiunto nel docblock della classe.
