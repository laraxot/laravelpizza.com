---
title: "GetComponentsAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\File\\GetComponentsAction"
qmd: "GetComponentsAction componenti Blade cache _components.json scansione classi prefisso namespace astratte force recreate"
---

# GetComponentsAction

Scansiona una cartella di classi componente, ne ricava nome, classe e namespace, e li salva in `_components.json` come cache. Codice: `app/Actions/File/GetComponentsAction.php:17-157`.

## Input

- `string $path`: cartella da scansionare (`execute`, riga 27).
- `string $namespace`: namespace PHP della cartella; `/` è convertito in `\` (riga 27).
- `string $prefix`: prefisso dei nomi dei componenti (riga 27).
- `bool $force_recreate = false`: ignora la cache (riga 27).

## Output

- `DataCollection<int, ComponentFileData>` con le voci di `_components.json` o appena scansionate (righe 59, 136).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `FILE-COMPONENTS-INV-1` | La cartella è creata solo se è sotto `base_path('Modules')` e manca. | righe 41-45 | `tests/Unit/Actions/File/GetComponentsActionTest.php:27` |
| `FILE-COMPONENTS-INV-2` | Se `_components.json` esiste, non si forza il ricalcolo e ogni voce ha `name`, `class`, `ns` stringhe non vuote: ritorna la cache senza scansionare. Un file PHP aggiunto dopo non compare finché non si forza. | righe 47-66, 139-156 | `tests/Unit/Actions/File/GetComponentsActionTest.php:52` |
| `FILE-COMPONENTS-INV-3` | Altrimenti scansiona ricorsivamente i `.php`. Il nome è `prefix` + slug (con i segmenti di sottocartella uniti da `.`); il namespace include la sottocartella. | righe 68-95 | come sopra |
| `FILE-COMPONENTS-INV-4` | Se la classe non esiste, lancia `\Exception` rilanciata. Le classi astratte sono saltate. | righe 97-106, 125 | Test: nessuno |
| `FILE-COMPONENTS-INV-5` | `_components.json` è riscritto solo se il contenuto cambia. | righe 129-134 | Test: nessuno |

## Effetti collaterali

Creazione della cartella (condizionata), caricamento delle classi via autoload durante la scansione, scrittura di `_components.json`. Nessuna transazione.

## Errori

- `\Exception` per classe mancante, rilanciata (`throw $e`). Le `Assert` lanciano se la lettura o la codifica fallisce.

## Non fa

- Non rileva file aggiunti o rimossi quando la cache è valida: serve `force_recreate`.
- Dubbio: se il percorso non esiste e non è sotto `Modules`, `File::allFiles` può lanciare. Non verificato.
- Marker `@contract` aggiunto nel docblock della classe.
