---
title: "Xot — documentazione"
<<<<<<< .merge_file_tnPJIn
qmd: "xot readme md"
type: note
tags: [documentation]
=======
<<<<<<< HEAD
qmd: "xot readme md"
type: note
tags: [documentation]
=======
qmd: "xot readme indice documentazione XotBase asset symlink bmad wiki"
type: index
status: active
module: Xot
updated: 2026-11-19
tags: [documentation, index, xot]
>>>>>>> laraxot/dev
>>>>>>> .merge_file_cci5Ch
---

# Xot — documentazione

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
Xot è il modulo fondazionale Laraxot. Questa è la sede canonica delle sue
decisioni architetturali, regole e storie BMAD.

- [Governance docs](governance/docs-structure.md)
- [BMAD](bmad/)
- [Architecture](architecture/)
- [Wiki](wiki/)
- [Standards](standards/)
- [Indice generale](../../../../docs/README.md)

Le directory storiche o duplicate vengono classificate progressivamente; non
sono cancellate automaticamente.
<<<<<<< .merge_file_tnPJIn
=======
<<<<<<< HEAD
=======
=======
Xot è il modulo fondazionale Laraxot: tutti gli altri moduli estendono le sue classi
`XotBase*` (resource, pagine, tabelle, policy, service provider), leggono la
configurazione da `XotData` e risolvono gli asset con `AssetAction`. Questo file è
l'**indice canonico** della cartella `docs/` (`00-index.md` rimanda qui).

## Da dove partire

- [Scopo e confini del modulo](purpose.md) — cosa sta in Xot e cosa no.
- [Architettura](architecture/) — XotBase, struttura dei moduli, regole Laraxot.
- [Standard](standards/) — naming, namespace, coding standard.
- [Governance docs](governance/docs-structure.md) — come è organizzata questa cartella.
- [Harness per agenti](concepts/agent-harness-guide.md) — perché ogni modulo e tema ha `docs/adr/` e `docs/contracts/`, guard, lezioni.
- [ADR di Xot](adr/README.md) · [Contratti di Xot](contracts/README.md) · [Regola ADR e contratti](rules/action-behavioral-contract.md).

## Asset, symlink e temi

- [Asset pubblici via symlink](wiki/concepts/public-html-symlink-assets.md) — `public_html/assets/<modulo>`
  e `public_html/themes/<Tema>` sono symlink relativi; `AssetAction` restituisce solo l'URL, non copia.
- [Workflow asset dei temi](theme-assets-workflow.md) — `npm run build` scrive direttamente nella
  `public/` del tema; non esiste più `npm run copy`.
- [Comandi `xot:module-link` / `xot:theme-link`](console/commands/xot-asset-links.md) — creano o
  riparano i symlink.
- [Regola symlink dei temi](wiki/rules/theme-public-symlink.md).

## Filament

- [Filament in Xot](filament/README.md) — XotBaseResource, pagine, tabelle, widget.
- [Best practice Filament](filament-best-practices.md).

## Qualità, test, PHPStan

- [Testing](testing/) — collocazione dei test e strategia dati reali.
- [Analisi qualità](quality-analysis/).
- [Standard di qualità del codice](code-quality.md).
- [Migrazioni](migrations-consolidated.md).

## BMAD, ECC e storie

- [Indice BMAD](bmad/00-index.md) — audit, piano di miglioramento, epiche, storie in `bmad/stories/`.
- [Indice ECC](ecc/00-index.md) — gate di verifica.
- [Storie operative](stories/) — tra cui [audit qualità](stories/audit-qualita.story.md).
- [Decision log](decision-log.md).

## Wiki (second brain)

- [Indice wiki](wiki/index.md) — concetti, regole, troubleshooting, memorie.

## Fuori dal modulo

- [Indice generale del progetto](../../../../docs/README.md)

Le directory storiche o duplicate (`consolidated/`, `parcheggio/`, `-integration/`, …) vengono
classificate progressivamente; non sono fonte canonica e non vengono cancellate automaticamente.
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> .merge_file_cci5Ch
