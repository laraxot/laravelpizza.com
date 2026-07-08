# 2026-07-08 Session Start Gate

## Scope

Esecuzione del prompt `bashscripts/tools/prompts/start.txt`.

## Comandi eseguiti

- `bash bashscripts/tools/sync-wiki-junctions.sh`
- `bash bashscripts/tools/sync-ide-junctions.sh`
- `bash bashscripts/tools/run-session-gate.sh --markdown --phpstan`
- `rg -l '<<<<<<< HEAD' laravel/Modules --glob '*.php'`

## Esito gate

- Wiki junction: 20 aggiornati.
- IDE junction: 7 aggiornati; warning iniziali per cartelle IDE assenti, poi create come symlink/junction.
- Gate sessione: exit 1.
- PHPStan: 33 errori.
- Bloccanti residui riportati dal gate: `guard-model-policy-delete`, `runtime-psr4`, `cartelle-root-php-vietate`.
- Warning principali: PHPUnit legacy, test naming lowercase, junction, policy mirror, ponytail sync/claude hooks, composer skeleton.

## Marker merge PHP

Il controllo rapido ha trovato marker in:

- `laravel/Modules/Geo/tests/Fixtures/Traits/GeoPhpstanProbeModel.php`
- `laravel/Modules/Geo/tests/fixtures/traits/GeoPhpstanProbeModel.php`

Non corretti in questa sessione perche' il task richiesto era l'esecuzione del prompt di avvio.
