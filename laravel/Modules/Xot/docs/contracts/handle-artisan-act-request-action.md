---
title: "HandleArtisanActRequestAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Artisan\\HandleArtisanActRequestAction"
qmd: "HandleArtisanActRequestAction parametro act artisan migrate route cache clear module enable disable errore log ArtisanActEnum"
---

# HandleArtisanActRequestAction

Entrypoint unico del parametro legacy `act` (ex `ArtisanService::act()`). Traduce un `ArtisanActEnum` in una o più azioni artisan. Codice: `app/Actions/Artisan/HandleArtisanActRequestAction.php:20-99`.

## Input

- `string $act`: valore dell'enum `ArtisanActEnum` (`execute`, riga 27).
- Dalla request: `module` (stringa, default `''`), letto con `Request::input` (riga 34).

## Output

- `string`: output testuale dell'azione (`RunArtisanCommandAction`), o testo dei sotto-Action. Stringa vuota se `act` non è un valore dell'enum (riga 31).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `ARTISAN-ACT-INV-1` | Un `act` non presente nell'enum restituisce `''` senza eseguire nulla. | righe 29-32 | `tests/Unit/Actions/Artisan/HandleArtisanActRequestActionTest.php:30` |
| `ARTISAN-ACT-INV-2` | Il `match` è esaustivo: ogni caso dell'enum ha un ramo (migrate, route, queue, optimize, clear, cache, view, debugbar, module, error). | righe 39-57 | `tests/Unit/Actions/Artisan/HandleArtisanActRequestActionTest.php:47` (copertura dei rami non verificata) |
| `ARTISAN-ACT-INV-3` | `migrate` purga e riconnette la connessione di default prima di eseguire. | righe 63-66 | Test: nessuno esplicito |
| `ARTISAN-ACT-INV-4` | Con `module` valorizzato, `migrate` esegue `module:migrate` su quel modulo, senza `--force` (dati sacri). | righe 68-73 | Test: nessuno |
| `ARTISAN-ACT-INV-5` | `clear` esegue in sequenza i comandi di pulizia, poi svuota sessioni, log e debugbar, e chiude con `DONE`. | righe 78-90 | Test: nessuno |

## Effetti collaterali

Ordine: purge e reconnect della connessione DB (per `migrate`), output diretto con `echo '<h3>Module ...</h3>'` (solo `migrate` con modulo), poi esecuzione dei comandi artisan tramite `RunArtisanCommandAction` o delle Action di pulizia. Gli effetti dipendono dal comando scelto: migrazioni, cancellazioni di cache e log, riscrittura della cache di config e route. Nessuna transazione unica attorno alla sequenza.

## Errori

- Il docblock dichiara `FileNotFoundException`, ma questa Action non la lancia direttamente: eventuali eccezioni arrivano dalle Action figlie.
- Gli errori dei comandi artisan sono restituiti come testo da `RunArtisanCommandAction`, non come eccezione.

## Non fa

- Non valida il nome del modulo: `module:enable` e `module:disable` concatenano `$moduleName` nella stringa del comando. Un valore con spazi o opzioni (es. `Foo --force`) verrebbe interpretato come argomenti. Rischio da verificare con il solo accesso autorizzato.
- Dubbio: `clear` esegue `key:generate` senza `--force`. Impatto su `APP_KEY` e sui dati cifrati non verificato.
- Il ramo `migrate` non ha `--force`: il comportamento in produzione dipende dalla conferma di Artisan, non verificato.
- Marker `@contract` aggiunto nel docblock della classe.
