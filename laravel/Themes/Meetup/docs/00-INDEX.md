---
title: "Meetup: indice docs"
type: index
theme: Meetup
status: active
canonical: true
updated: 2026-10-14
tags: [meetup, theme, docs, index, canonical]
qmd: "meetup theme docs indice canonico stub stale superseded bmad wiki pilot docs-organization"
related:
  - ./README.md
  - ./stories/docs-organization-pilot.story.md
  - ../../../../bmad-output/docs-organization-audit.md
---

# Meetup: indice docs

**Stato del tema (verificato 2026-10-14): legacy, guscio senza codice, non attivo.** Fixcity usa `pub_theme = Sixteen`; Meetup ha solo `package.json`, `.releaserc.json`, `scripts/ci/` e `resources/mail-layouts/test-layout.html`, nessun `composer.json`, `app/`, view, css o js, e non e' un submodule. Prove in [README.md](README.md). Di conseguenza nessuna di queste cartelle descrive codice che esiste: sono documenti di governance, stub e materiale di supporto.

**Indice canonico di `docs/`** (tutti i 37 file `.md`, uno per riga). Non esistono altri indici di radice: `README.md` e' l'ingresso al tema e rimanda qui.

Classificazione delle cartelle:

| Cartella | Ruolo | Nota |
|---|---|---|
| `stories/` | canonica (cronologia BMAD) | due story, mai cancellate ne' rinumerate |
| `bmad/` | canonica (decisione di supporto) | dossier `support-decision-required`, doppio da unificare |
| `wiki/` | locale, quasi vuota | indici on-demand e concetti stale; `wiki/index.md` elenca cartelle assenti |
| radice (`*.md`) | stub e igiene | rimandano a canonici condivisi, alcuni non trovati |
| `raw/`, `outputs/` | evidence, immutabili | non si toccano |
| `root-md-files/`, `llm-wiki/` | legacy / supporto | changelog archiviato e istruzioni dell'agente wiki |

Legenda `status` nel frontmatter: `active` (valido), `stub` (rimanda a un canonico), `stale` (obsoleto, con nota datata sotto il frontmatter), `superseded` (copia di un altro file). Nessun file e' stato cancellato, spostato o rinominato.

## Ingresso e radice

| File | Stato | Nota |
|------|-------|------|
| [README.md](README.md) | active | ingresso a `docs/`, scopo del tema |
| [project-structure.md](project-structure.md) | stub | rimanda alla struttura di progetto condivisa |
| [contracts-naming.md](contracts-naming.md) | active | regola `*Contract` in `app/Contracts/` |
| [on-demand-pattern.md](on-demand-pattern.md) | stub | rimanda a `docs/wiki/rules/on-demand-pattern.md` |
| [performance-optimization.md](performance-optimization.md) | stub | canonico condiviso non trovato |
| [qmd-setup.md](qmd-setup.md) | stub | rimanda a `docs/wiki/qmd-setup.md` |

## Igiene e ridondanze

| File | Stato | Nota |
|------|-------|------|
| [REDUNDANCY_ANALYSIS.md](REDUNDANCY_ANALYSIS.md) | stub | canonico `shared-components` inesistente |
| [redundancy-audit.md](redundancy-audit.md) | active | audit del 2026-05-21 |
| [root-file-policy.md](root-file-policy.md) | stale | soglia e conteggi della radice superati |
| [root-files-hygiene.md](root-files-hygiene.md) | stale | cita un `.code-workspace` che non esiste |
| [codex-error-fix.md](codex-error-fix.md) | stub | canonico `shared-components` inesistente |
| [merge-conflicts-list.md](merge-conflicts-list.md) | stub | canonico `shared-components` inesistente |

## BMAD e stories

- [bmad/README.md](bmad/README.md) e [bmad/bmad-dossier.md](bmad/bmad-dossier.md) - dossier BMAD del tema (stesso contenuto in due forme, da unificare a cura del proprietario BMAD)
- [stories/2026-10-08-docs-organization-pilot.story.md](stories/docs-organization-pilot.story.md) - pilota di riordino di questa cartella
- [stories/2026-10-14-docs-studio-stato-e-ingressi.story.md](stories/docs-studio-stato-e-ingressi.story.md) - studio del tema reale, stato legacy provato, link riparati negli ingressi

## Wiki locale (`wiki/`)

- [wiki/index.md](wiki/index.md) (stale: elenca cartelle che non esistono) e [wiki/README.md](wiki/README.md), registro [wiki/log.md](wiki/log.md)
- Concetti: [concepts/INDEX.md](wiki/concepts/INDEX.md), [meetup-completion-roadmap.md](wiki/concepts/meetup-completion-roadmap.md) (stale), [testing.md](wiki/concepts/testing.md) (stale), [cross-theme-redundancy-doc-stub.md](wiki/concepts/cross-theme-redundancy-doc-stub.md) (stale), [second-brain-local-discipline.md](wiki/concepts/second-brain-local-discipline.md), [visual-testing-playwright-puppeteer.md](wiki/concepts/visual-testing-playwright-puppeteer.md)
- Indici on-demand: [commands](wiki/commands/INDEX.md), [memories](wiki/memories/INDEX.md), [rules](wiki/rules/INDEX.md), [skills](wiki/skills/INDEX.md), [troubleshooting](wiki/troubleshooting/INDEX.md)
- Template (stub verso `shared-components` inesistente): [concept](wiki/_templates/concept.md), [entity](wiki/_templates/entity.md), [source](wiki/_templates/source.md)

## Altro

- [llm-wiki/AGENTS.md](llm-wiki/AGENTS.md) - istruzioni dell'agente wiki (schema frontmatter incluso)
- [root-md-files/CHANGELOG.md](root-md-files/CHANGELOG.md) - changelog archiviato dalla radice del tema
- [raw/README.md](raw/README.md) - stub `raw/` (immutabile)
