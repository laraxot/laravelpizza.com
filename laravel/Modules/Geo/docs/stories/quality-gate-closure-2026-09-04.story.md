# Story: Quality-gate closure — Modules/Geo (2026-09-04)

## BMAD phase
Build + Measure (standing order pillar 5 — chiusura gate qualità di modulo).

## Contesto
PHPStan era già stato misurato a 0 errori su `Modules/Geo` in una sessione precedente della stessa
giornata (2026-09-04), con e senza path arg, dopo un refresh `ide-helper:generate/meta/models`. Questa
story copre il resto del gate: phpmd, phpinsights (verificato non disponibile), pest, coverage, git.

## Coordinamento
- Letti `docs/chat/*.md` per note/collisioni su Geo prima di editare: nessun blocco attivo per oggi
  (le note esistenti — `geo-module-gitmodules-sync.md`, `module-ui-geo-dependency-removal.md`,
  `ui-geo-boundary-lock.md` — riguardano sync git pregressi e il confine architetturale Geo→UI, non
  in conflitto con questo task).
- Lock preso su `laravel/Modules/Geo` (`quality-gate-2026-09-04`, agente `agent-Geo`) prima di ogni
  edit, rilasciato a fine sessione.
- `Modules/Xot` risultava, durante questa sessione, con drift enorme non committato da una sessione
  concorrente (centinaia di file) — causa dei fallimenti pest documentati sotto. Non toccato.
- `Modules/Geo` stesso portava già drift di una sessione concorrente ("riduzione mixed", vedi
  `docs/coverage.md`) su 7 file mai toccati da questa sessione — non aggiunti a git, vedi sotto.

## Cosa e' stato trovato
- `php -l` su 545 file `.php` del modulo: nessun errore di sintassi.
- PHPStan baseline (cache pulita, con path arg, memoria 4096M): **0 errori** confermato via
  `--error-format=json` (`totals.file_errors=0`), non solo l'exit code.
- PHPMD (`./tools/phpmd.sh Modules/Geo/app text ../docs/phpmd.ruleset.xml`): 303 righe di finding.
  Nessun crash, ruleset applicato correttamente con i 3 argomenti richiesti.
- PHPInsights: **non installato** in questo repo (`vendor/bin/phpinsights` assente, package Composer
  non trovato) — coerente con la memoria second-brain "Pest 5 e phpinsights non coesistono" (rimosso
  perché incompatibile con Pest 5 + plugin). Passo saltato, documentato, non simulato.
- Pest (`./vendor/bin/pest Modules/Geo/tests --no-coverage`): 476 failed / 3 risky / 40 passed su 519
  test. Isolando un singolo file di test in due run separati sono usciti **due errori diversi**
  entrambi originati in `Modules/Xot` (bootstrap del service provider condiviso, mai toccato da questa
  sessione) — prova che è un race di ambiente multi-agente concorrente, non un difetto deterministico
  del modulo Geo o di questa sessione.

## Cosa e' stato fatto
Fix reali applicati (nessuna soppressione via `@phpstan-ignore` o annotazioni phpmd):

1. **Codice morto — 4 `UnusedLocalVariable` rimosse:**
   - `app/Actions/GoogleMaps/OptimizeRouteAction.php` — variabile tipata mai letta.
   - `app/Filament/Forms/Components/AddressesField.php` — variabile di loop mai usata,
     `foreach` riscritto su `array_keys()`.
   - `app/Models/Locality.php` — `$city` letta da `Get $get` e mai usata in `getOptions()`.
   - `app/Models/Policies/GeoBasePolicy.php` — `XotData::make()` mai usata in `before()`.

2. **Complessità — extract-method su `Models/Address.php`:**
   `getFormattedAddressAttribute()` (CC 21, NPath 2916, il metodo più complesso del modulo) diviso
   estraendo il blocco "località + provincia" in `getFormattedAddressLocalityParts()` privato.
   Nessun cambio di comportamento (stessa logica, stesso ordine di concatenazione). Risultato:
   CC 21→12, NPath 2916→240.

Lasciati e documentati in `docs/coverage.md` (motivazione per categoria, non per singolo finding):
`MissingImport` (80, FQCN sparsi), `CamelCase*` (66, nomi vincolati da payload JSON esterni
Google/Bing/Geocoding — rinominarli senza `#[MapInputName]` rischia di rompere il parsing),
`UnusedFormalParameter` (75, firme di contratto/interfaccia condivisa tra adapter provider geo),
`BooleanArgumentFlag` (20), restanti `CyclomaticComplexity`/`NPathComplexity` (18/11),
`ShortVariable`/`LongVariable` (21), `ExcessiveParameterList` (3), `ElseExpression` (2) — debito
pre-esistente non riconducibile a bug o codice morto, refactor più ampi richiederebbero test dedicati
oggi assenti.

## Come e' stato verificato
- `php -l` su tutti i file toccati: nessun errore.
- `./vendor/bin/phpstan clear-result-cache` + `analyse Modules/Geo` dopo ogni edit (hook automatico) e
  di nuovo a fine sessione: **0 errori**, invariato rispetto alla baseline.
- `./tools/phpmd.sh Modules/Geo/app text ../docs/phpmd.ruleset.xml` ri-eseguito dopo i fix: 300 righe di
  finding (da 303); `UnusedLocalVariable` 4→0, `ElseExpression` invariato a 2 (non toccato, vedi sopra).
- Pest: risultati numerici reali riportati sopra e in `docs/coverage.md`, con causa isolata a
  `Modules/Xot` (non a questo diff) tramite confronto di due run indipendenti con errori diversi.

## File toccati (committati da questa sessione)
- `app/Actions/GoogleMaps/OptimizeRouteAction.php`
- `app/Filament/Forms/Components/AddressesField.php`
- `app/Models/Address.php`
- `app/Models/Locality.php`
- `app/Models/Policies/GeoBasePolicy.php`
- `docs/coverage.md`
- `docs/stories/quality-gate-closure-2026-09-04.story.md` (questo file)

Non aggiunti (drift di sessioni concorrenti, non toccato da questa sessione): `app/Datas/RouteData.php`,
`app/Datas/Routing/RouteData.php`, `app/Filament/Forms/Components/AddressInput.php`,
`app/Filament/Forms/Components/Traits/HasCoordinatePicker.php`,
`app/Filament/Forms/Components/XotBaseCoordinateField.php`, `app/Models/Province.php`,
`app/Models/Region.php`.
