---
qmd: "ui ignore suppressions audit md"
title: "Audit @phpstan-ignore: 48 soppressioni chiuse cancellando 3 test fantasma"
type: report
created_at: '2026-09-01'
---

# Audit `@phpstan-ignore` su Modules/UI

48 soppressioni concentrate in 3 file: `tests/Unit/Models/ThemeModelTest.php`,
`AssetModelTest.php`, `ComponentModelTest.php`. Tutti e tre testavano
`Modules\UI\Models\Theme`, `Asset`, `Component` — tre classi mai esistite in questo
repo: nessun `app/Models/{Theme,Asset,Component}.php`, nessuna factory, nessuna
migration, nessun altro file del modulo le referenzia (verificato con `grep -r` su
tutto `Modules/UI`, zero hit fuori dai tre test).

## Decisione: cancellati, non creati i modelli

I test contenevano un blocco di commento che citava
`docs/wiki/rules/no-phpstan-probe-models.md` come giustificazione del pattern
"modello opzionale, test annotato invece di creare un probe model". **Quel file non
esiste nel repo** — verificato con `find` su tutto l'albero, zero risultati. La
citazione era falsa: o una regola mai committata, o un riferimento inventato da un
agente precedente per dare peso a una scelta di per sé ragionevole (pillar 3 di questo
progetto: verificare sul codice, non fidarsi di una citazione).

A prescindere dalla citazione fasulla, la scelta di merito resta cancellare, non
creare, per tre motivi:

1. I test erano skippati a runtime da sempre (`class_exists()` guard +
   `Assert::markTestSkipped()`) — zero copertura reale prodotta, cancellarli non
   toglie nulla che girasse davvero.
2. Nessun consumer nel modulo referenzia Theme/Asset/Component: non è debito di
   funzionalità mancante, è test scaffolding per una feature mai iniziata.
3. Creare 3 modelli + factory + migration "per far tacere PHPStan" sarebbe esattamente
   il pattern vietato dal quality gate del progetto (codice scritto per il gate, non
   per un bisogno reale).

## Esito

- `@phpstan-ignore` in `Modules/UI`: 48 → **0**.
- `phpstan analyse Modules/UI`: 0 errori, exit 0 (verificato dopo la cancellazione).
- Nota per il second brain: la citazione a una regola inesistente è un caso concreto
  del pattern "falsa certezza su qualcosa di non verificato" osservato più volte in
  questa sessione — vedi
  `bashscripts/ai/wiki/memories/fork-hallucinated-user-turn.md`.
