# PHPStan Modules corrente

Data: 2026-07-06

Stato:

- `./vendor/bin/phpstan analyse Modules --no-progress --error-format=table`: OK, zero errori.
- Fix principali: confine helper `ente/matr`, relazioni Sigma tipizzate, mutator scheda senza accessi a `Model` generico, SQL raw con binding.
- `InteractiveMap.php` resta disattivato come `.old`: il modulo UI non deve dipendere da Geo.

Verifiche:

- PHPMD sui singoli file modificati: OK.
- PHP Insights sui file modificati: fallisce per debito storico di complessita'/stile, non per PHPStan.
- Pest:
  - `Modules/Sigma/tests`: OK.
  - `Modules/IndennitaCondizioniLavoro/tests`: fallisce per resolver DB nullo e mock non configurati.
  - `Modules/Ptv/tests`: fallisce per resolver DB nullo e boot model Profile.
  - `Modules/Performance/tests`: fallisce per classi testate mancanti e resolver DB nullo.
- `bashscripts/quality-gates/verify-llm-wiki.sh`: fallisce per directory Folio semantiche proibite; presenti anche warning archivio/backup/MCP.

Nota:

- Non usare `migrate:fresh`, `migrate:refresh`, `RefreshDatabase` o reset dati per rendere verdi i test.
