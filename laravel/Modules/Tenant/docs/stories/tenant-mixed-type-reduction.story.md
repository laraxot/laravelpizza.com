---
tags: [documentation]
qmd: "tenant mixed type reduction.story"
issues: []
discussions: []
title: "Tenant: riduzione uso mixed dove il tipo reale e' noto"
type: story
module: Tenant
slug: tenant-mixed-type-reduction
status: done
created: 2026-09-04
updated: 2026-09-04
owned_scope:
  - "laravel/Modules/Tenant/app/Actions/Config/FilterConfigStringKeysAction.php"
  - "laravel/Modules/Tenant/docs/coverage.md"
related:
  - ../../../../bashscripts/ai/wiki/rules/phpstan-neon-user-owned.md
  - ../../../../bashscripts/ai/wiki/rules/type-coverage-non-conta-mixed.md
  - ../../../../bashscripts/ai/wiki/rules/multi-agent-same-repo-race.md
---

# Tenant: riduzione uso mixed dove il tipo reale e' noto

## Contesto

Convenzione di progetto: "cerchiamo di non usare mixed, quando lo troviamo cerchiamo di
sostituirlo con qualcosa di adeguato" — best-effort, non copertura al 100%.

Al `git status --short` di apertura, `Modules/Tenant` risultava gia' con ~80 file
modificati da una sessione concorrente (riordino docs/README, whitespace, non tipizzazione).
Per la regola "non sovrascrivere il lavoro in corso di un'altra sessione" e "commit solo dei
file che modifichi tu", l'intervento e' stato limitato ai file puliti in git status
all'apertura del task.

## Cosa e' stato fatto

- Censiti 207 usi di `mixed` su 44 file (`app`, `tests`, `database`, `config`).
- Di 32 file sotto `app/config/database` con `mixed`, 16 erano gia' sporchi (incluse tutte
  le 4 occorrenze di `mixed` nativo — parametri/return type-hintati, non solo docblock) e
  sono stati lasciati intatti per non mischiare il commit con il WIP altrui.
- Sui 16 file puliti, revisionati tutti: la maggioranza usa gia' `array<string, mixed>` per
  payload di configurazione genuinamente polimorfici (verificato leggendo il body, non
  assunto) — lasciati cosi'.
- Un solo cambio applicato: `app/Actions/Config/FilterConfigStringKeysAction.php`,
  `@param array<mixed, mixed> $config` → `@param array<array-key, mixed> $config` (le chiavi
  di un array PHP sono sempre `int|string`, mai `mixed`; coerente col foreach che filtra
  `is_string($key)`).
- Tentativo di allineare `app/Services/TenantService.php::config()` a
  `array<string, mixed>` **revertito**: PHPStan segnalava `return.type` reale perche' la
  action delegata (`ResolveTenantConfigValueAction`, file sporco/non toccabile) resta
  tipizzata `array<mixed>`. Restringere solo il chiamante sarebbe stato un typing non
  onesto — vedi nota `var-override-before-git-log-check` sul non forzare narrowing che il
  runtime non garantisce.

Dettaglio completo, elenco file lasciati con motivazione, prima del/dopo PHPStan e risultati
pest/phpmd: `laravel/Modules/Tenant/docs/coverage.md`, sezione "2026-09-04 — Mixed type
reduction (best-effort)".

## Verifica

- PHPStan (`./vendor/bin/phpstan analyse Modules/Tenant --no-progress --error-format=table`):
  0 errori prima, 0 errori dopo.
- PHPMD: run sull'intero modulo crasha (bug noto, vedi memoria
  `quality-tooling-real-commands`); run scoped al file cambiato: nessuna violazione.
- Pest (`./vendor/bin/pest Modules/Tenant/tests -c Modules/Tenant/phpunit.xml --no-coverage`):
  81 passed / 64 failed / 28 skipped. I fallimenti sono pre-esistenti (file in WIP
  concorrente mai toccati in questa sessione, es. `tests/Unit/Traits/SushiToJsonTest.php`,
  errore `Accessing static property ... as non static`). Il test dedicato al file
  modificato in questa story, `tests/Unit/Actions/Config/FilterConfigStringKeysActionTest.php`,
  passa isolato (2/2).

## Follow-up

- I 4 usi di `mixed` nativo (parametro/return type-hintati, priorita' massima per la
  convenzione del progetto) restano in file attualmente in WIP concorrente:
  `app/Models/Traits/SushiToCsv.php:153,217`, `app/Models/Traits/SushiToJson.php:451`,
  `app/Actions/Config/ResolveTenantConfigValueAction.php:68`. Da riprendere in una sessione
  successiva quando quel WIP sara' committato/pushato.

### Aggiornamento 2026-09-06 (sessione claude sonnet 5, `phpstan-tenant-fix.md`)

Il WIP concorrente su quei 4 file e' stato committato (`git status --short` su
`Modules/Tenant` mostra solo `docs/*.md` modificati, i file `app/` sono puliti). Riverificati
tutti e 4:

- `resolveRowIdKey(mixed $id)` riceve `Model::getKey()`, dichiarato `@return mixed` senza
  cast nativo dal framework.
- `csvValue(mixed $value)` / `intValue(mixed $value)` ricevono valori da
  `array<string, mixed>` (righe Sushi) o `Model::getAttribute()`, entrambi genuinamente
  polimorfici (bool/int/float/string/Stringable/null).
- `assertValidConfigValue(mixed $res)` riceve `config($key, $default)`, anch'esso
  `mixed` lato framework.

In tutti e 4 i casi il corpo della funzione fa immediatamente narrowing a runtime
(`is_int`/`is_string`/`Assert::scalar`/`is_numeric`) prima di restituire un tipo specifico:
e' esattamente il pattern raccomandato per confinare un `mixed` di provenienza framework, non
un caso di "mixed non ancora sostituito". Nessun cambio applicato — follow-up chiuso come
"confermato corretto", non come "da fare".
