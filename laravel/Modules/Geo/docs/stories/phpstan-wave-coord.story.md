---
title: "Geo — coordinamento wave PHPStan"
type: story
module: Geo
status: review
created: 2026-10-20
updated: 2026-10-20
qmd: "geo phpstan wave coord cursor-scratch tsv lock test"
---

# Geo — wave PHPStan (coordinamento)

## Contratto

- Ground truth: `.cursor-scratch/phpstan-wave/Geo.tsv`.
- Nessun `analyse Modules` dalla lane.
- Non toccare file di test lockati da altre sessioni.
- Scopo: [../scopo.md](../scopo.md). Story dettagliata: [phpstan-test-wave-geo.story.md](./phpstan-test-wave-geo.story.md).

## Lane Geo+Xot (2026-10-20)

Bucket `.cursor-scratch/phpstan-wave/Geo.files` (18 file): baseline TSV **59** errori (`variable.unused`, assert ridondanti). Verifica `flock /tmp/phpstan-gate.lock` + analyse mirato: **0** residui.

Correzioni: test DTO/model/policy con assert comportamentali (`assertSame` su proprieta', `assertFalse($model->exists)`, `getRelationName()` su morph) al posto di istanze non lette; policy allineate al pattern Cms (`assertSame(FQCN::class, $policy::class)`).
