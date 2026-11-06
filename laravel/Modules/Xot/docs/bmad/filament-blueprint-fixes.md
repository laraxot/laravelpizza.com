---
title: "Filament Blueprint Fixes: 2026-10-21"
type: note
status: draft
updated: 2026-10-21
tags: [docs, xot, bmad]
qmd: "filament blueprint fixes   2026-10-21 xot"
---
# Filament Blueprint Fixes: 2026-10-21

## Stato

Audit eseguito su 12 moduli con Filament Resources. Deviations trovate: 3.

## Fix applicati

1. **Sigma: WebServiceImportResource.php** (line 14): già corretto (`protected static ?string $model = WebServiceImport::class;`). Nessun cambio necessario: audit precedente riferiva stato precedente.

2. **Ptv: BaseSchedaResource.php** (line 30): già corretto (`protected static ?string $model = Scheda::class;`). Nessun cambio necessario.

3. **Pdnd: Filament Resources assenti**: directory `Modules/Pdnd/app/Filament/` contiene `Clusters/` e `Pages/` ma nessuna `Resources/`. Intento: amministrazione via cluster/pages (C030/C003/C015 ecc.), non via Resource. Documentato come omissione intenzionale. Nessun Resource inventato.

## Verifica

- Nessun label hardcoded trovato su 12 moduli (tutti passano da `NavigationLabelTrait::transFunc()`).
- Zero errori PHPStan su Sigma dopo `scopeOfYear` implementato.
- BaseSchedaResource segue il contratto Xot (estende `XotBaseResource`).
