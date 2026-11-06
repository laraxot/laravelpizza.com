---
title: "[STORY] SushiToJsons legge solo i JSON del tenant attivo"
type: story
status: done
module: Tenant
priority: high
created: 2026-10-28
updated: 2026-10-28
tags: [tenant, sushi, json, bmad, second-brain]
qmd: "SushiToJsons collectRowsFromJsonFiles una sola sorgente tenant baseline overlay Fixcity directory assente dddx"
related:
  - ../wiki/concepts/sushi-json-row-source.md
  - ../models/traits/sushi-to-jsons.md
  - ../../PHILOSOPHY.md
---

# SushiToJsons legge solo i JSON del tenant attivo

## Richiesta

«in `laravel/Modules/Tenant/app/Models/Traits/SushiToJsons.php` ho dovuto correggere il metodo `collectRowsFromJsonFiles`, studia cosa ho dovuto modificare e capisci il tuo errore» (2026-10-28 20:25).

## Cosa è stato modificato dall'utente (file 17:51, commit `3346588` delle 17:53)

| Prima (`ec15dad` 10-26, `493af8b` 10-27) | Dopo |
|---|---|
| Sorgenti: cartella tenant + `Themes/Sixteen/config/<tenant>/…` + `Modules/*/config/…` + `Modules/*/…` | Una sola: `GetTenantFilePathAction` → `config/<tenant>/database/content/<tabella>` |
| Righe indicizzate per `id`, prima sorgente vince, dedupe per slug | Lista piatta, una riga per file |
| Guardia `isDirectory` per sorgente | Nessuna (regressione, vedi sotto) |

## L'errore (cause verificate)

1. **Scopo frainteso.** Il trait espone il contenuto JSON del tenant (PHILOSOPHY, regola 2). Un livello «baseline» da moduli e temi non era stato chiesto per questo repo.
2. **Bisogno di un altro progetto.** L'unico JSON di baseline su disco è `Themes/Sixteen/config/local/fixcity/database/content/pages/home.json`, del tenant `fixcity`; in questo checkout `config/local` ha solo `techplanner`. Per techplanner i livelli leggevano zero file. I 500/503 su login e segnalazioni (messaggio di `493af8b`) sono di Fixcity.
3. **Toppa sulla toppa.** Il livello creava il difetto «il tenant aggiunge una riga invece di sostituire» (il prefisso della sottocartella cambia l'id); `493af8b` ha aggiunto la dedupe per slug invece di chiedersi se il livello dovesse esistere.
4. **Costo.** A ogni boot di ogni modello Sushi: `File::directories(base_path('Modules'))` (17 moduli) più due `isDirectory` per modulo.

## Difetti rimasti nella riscrittura (corretti oggi)

| Difetto | Effetto | Correzione |
|---|---|---|
| `$slugOwners` non definita, `$tenantName`, `$key`, `$failed` inutilizzati | codice morto | tolti (sessione parallela 20:26) |
| `dddx($file)` ×2 in `mapJsonFileToRow` | fermano la richiesta su un JSON non-array o su un modello senza schema; contraddicono «ignorare i file non convertibili» | tolti |
| Nessuna guardia sulla cartella assente | `File::allFiles()` lancia `DirectoryNotFoundException`: `Menu` e `PageContent` (nessuna cartella in `local/techplanner`) | `if (! File::isDirectory($path)) return [];` |
| `array_values($rows)` su una lista | PHPStan `arrayValues.list` in 3 contesti (trait + 2 fixture di test) | `return $rows;` |

## Verifica

- `php -l` pulito; `phpstan analyse Modules/Tenant` → **0 errori** (prima: 3).
- Sonda in sola lettura (senza DB, reflection, tenant `local/techplanner`): `Page` 19 righe, `Section` 7, `Menu` 0, `PageContent` 0, nessuna eccezione.
- Aggiunto in `tests/Unit/Traits/SushiToJsonsTest.php` il caso «cartella assente → `[]`». **Non eseguito**: `.env.testing` punta a MySQL e il DB `*_test` non esiste (dati sacri).

## Decisioni aperte (utente)

1. **Fixcity:** se il tenant `fixcity` deve ancora ereditare `Themes/Sixteen/config/local/fixcity/…/home.json`, serve un meccanismo esplicito (file nel tenant `config/local/fixcity`, versionato) e non il loader condiviso.
2. Eseguire il test aggiunto quando esisterà un DB di test.
3. Il concept `wiki/concepts/sushi-json-row-source.md` e `models/traits/sushi-to-jsons.md` sono stati scritti da una sessione parallela con lo stesso messaggio; le due sessioni hanno scritto sugli stessi file.

## Lezione

Prima di aggiungere un livello a un componente condiviso: (a) leggere lo scopo nel modulo, (b) contare cosa esiste su disco per il tenant reale (non assumere `localhost`), (c) il sintomo di un altro progetto non si cura nel modulo di tutti.
