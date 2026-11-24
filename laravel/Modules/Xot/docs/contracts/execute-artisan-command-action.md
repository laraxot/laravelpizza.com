---
title: "ExecuteArtisanCommandAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\ExecuteArtisanCommandAction"
qmd: "ExecuteArtisanCommandAction artisan allowlist comandi process php artisan timeout output migrate passport"
---

# ExecuteArtisanCommandAction

Esegue un comando Artisan da una lista chiusa di comandi consentiti. Codice: `app/Actions/ExecuteArtisanCommandAction.php` (classe a riga 16, `execute()` a riga 52).

## Input

- `string $command`: comando senza `php artisan`, deve coincidere con una voce della lista.

## Output

- `array{command, output: list<string>, status: 'completed'|'failed', exitCode}`.

## Invarianti

- `EXEC-ARTISAN-INV-1` — Il comando non può essere vuoto e deve coincidere esattamente (`in_array` strict) con una voce di `allowedCommands`, altrimenti `RuntimeException` prima di qualsiasi esecuzione. Test: `tests/Unit/Actions/ExecuteArtisanCommandActionTest.php`.
- `EXEC-ARTISAN-INV-2` — Il processo è `php artisan <comando>` nella radice dell'app, con timeout 300 secondi. Test: come sopra.
- `EXEC-ARTISAN-INV-3` — L'output è raccolto in polling di 50 ms; le righe di stderr sono prefissate `[ERROR]`. Test: come sopra.
- `EXEC-ARTISAN-INV-4` — `status` è `completed` solo se il processo termina con successo. Test: come sopra.

## Effetti collaterali

Esecuzione di un processo PHP. La lista include comandi che modificano dati o schema: `migrate`, `passport:purge` (cancella token), `passport:keys`, `queue:restart`, più i comandi di cache. Nessuna transazione.

## Errori

- `RuntimeException` per comando non consentito o per errori del processo (incapsulati con il codice originale).

## Non fa

- Non accetta argomenti aggiuntivi fuori dalla lista.
- Da valutare: `migrate` è in lista senza `--force`. Su produzione può applicare migrazioni pendenti: va confrontato con la regola sui dati sacri del progetto prima di mantenerlo.
