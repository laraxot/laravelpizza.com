---
title: Readme
module: Activity
type: index
status: draft
updated: 2026-10-22
tags: [docs, activity, wiki]
qmd: "llm wiki (module) activity"
---

# LLM Wiki (module)

This folder is the module's LLM wiki (docs/wiki). Use it to store synthesized, curated docs optimized for LLM ingestion.

Structure:
- raw/: original source docs
- wiki/: distilled summaries and canonical pages for LLM
- archived/: historical/obsolete docs

## Perché esiste

Core module for the FixCity Platform.

## Superpoteri

- Modular component with XotBase patterns
- Professional-grade implementation
- Integrated with FixCity Platform

## Documentazione

| Lingua | Link |
|--------|------|
| 🇮🇹 Presentazione | Questo file (`README.md`) |
| 🇬🇧 Business card | [docs/readme-en.md](./docs/readme-en.md) |
| 📚 Wiki tecnica | [./docs/wiki/](./docs/) |

---

**Modulo** `Activity` · **Laraxot** · **FixCity Platform** · PHPStan 10 · Filament 5

---

<!-- merged from README.md -->

# Wiki del modulo Activity

Pagine brevi e riusabili (concetti, regole, memorie) che completano le story. Misurato il 2026-10-14: 118 file `.md`, di cui 39 nella radice di `wiki/`.

## Da dove partire

- [INDEX.md](./INDEX.md): indice della wiki (catalogo fermo al 2026-06-10, vedi il suo piede di pagina).
- [log.md](./log.md): registro datato di cio' che e' cambiato nel modulo e nei suoi docs.
- Identita' e contenuto reale del modulo: [../README.md](../README.md). Indice operativo di tutta la cartella docs: [../00-INDEX.md](../00-INDEX.md).
- `00-INDEX.md`, `00-index.md`, `00-index-documentation.md`, `index.md` di questa cartella sono copie marcate `stale`: non vanno aggiornate.

## Sottocartelle con pagine

| Cartella | File | Indice |
|---|---|---|
| `concepts/` | 37 | [concepts/INDEX.md](./concepts/INDEX.md) |
| `testing/` | 11 | nessuno |
| `rules/` | 4 | [rules/INDEX.md](./rules/INDEX.md) |
| `memories/` | 4 | [memories/INDEX.md](./memories/INDEX.md) |
| `skills/` | 2 | [skills/INDEX.md](./skills/INDEX.md) |
| `howto/`, `_templates/` | 3 ciascuna | nessuno |
| `troubleshooting/`, `integrations/`, `features/`, `commands/`, `analysis/` | 2 ciascuna | nessuno |
| `sources/`, `product/`, `patterns/`, `overviews/`, `how-to/` | 1 ciascuna | nessuno |

Cartelle previste dal modello ma senza alcun `.md`: `decisions/`, `entities/`, `glossary/`, `comparisons/`, `queries/`, `reference/`, `summaries/`, `lint/`, `index/`. Le decisioni del modulo stanno in [../decision-log.md](../decision-log.md).

## Come cercare

```bash
qmd search "Activity <argomento>" --limit 5
```

I documenti sorgente grezzi stanno in `../raw/` (immutabile). Prima di creare una pagina nuova controllare [INDEX.md](./INDEX.md) e le pagine di `concepts/` per non duplicarla.
