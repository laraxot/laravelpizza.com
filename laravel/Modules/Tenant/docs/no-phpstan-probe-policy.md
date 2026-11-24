---
title: "no phpstan probe policy"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "no phpstan probe policy"
issues: []
discussions: []
description: Divieto di creare cartelle o file probe per PHPStan in questo modulo.
---

# No PHPStan probe files in Tenant

## Regola

Nel modulo `Tenant` non devono esistere:

- directory `app/Phpstan`
- file che finiscono per `PhpstanProbeModel.php`
- file che finiscono per `PhpstanTraitProbe.php` o nomi simili (probe fittizi)

## Perché

Questi file sono modelli o classi artificiali create solo per far passare PHPStan.
Se un trait risulta non usato nel modulo, si aggiunge `@phpstan-ignore trait.unused`
nel docblock del trait. Se un test deve esercitare un trait, si usa una classe
anonima o una fixture reale collegata a un test Pest esistente (non un probe).

Il ragionamento completo (logica/politica/filosofia/religione/zen di questo divieto) è
in `Modules/Xot/docs/wiki/concepts/phpstan-trait-probes.md`.

## Storico (2026-07-27)

Rimossi `tests/Fixtures/Traits/{SushiToCsvPhpstanProbe,SushiToJsonsPhpstanProbe,
SushiToPhpArrayPhpstanProbe,TenantPhpstanProbeModel}.php`. Nessuna azione è stata
necessaria sui trait sottostanti: `SushiToCsv` e `SushiToPhpArray` avevano già
`@phpstan-ignore trait.unused`; `SushiToJsons` è già consumato in produzione
(`Modules/Tenant/app/Models/BaseModelJsons.php` e diversi modelli Cms), quindi
visibile a PHPStan senza bisogno di probe o ignore. I probe duplicavano fix già
applicati altrove o coprivano un falso problema — pura zavorra.

## Riferimento

Vedi anche:

- `bashscripts/ai/wiki/rules/no-phpstan-probe-models.md`
- `Modules/Xot/docs/phpstan-modules-fix-log.md`
