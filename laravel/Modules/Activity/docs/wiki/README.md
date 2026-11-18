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

[![Module](https://img.shields.io/badge/Module-LLM Wiki (module)-8B0000.svg)]()
[![Laravel](https://img.shields.io/badge/Laravel-13-red?style=for-the-badge)](https://laravel.com/)](https://laravel.com/)
[![Filament](https://img.shields.io/badge/Filament-5-ffab00?style=for-the-badge)](https://filamentphp.com/)](https://filamentphp.com/)
[![PHP](https://img.shields.io/badge/PHP-8.4+-777BB4?style=for-the-badge)](https://php.net/)](https://php.net/)
[![PHP](https://img.shields.io/badge/PHP-8.4+-777BB4?style=for-the-badge)](https://php.net/)](https://phpstan.org/)
[![PSR-12](https://img.shields.io/badge/Code-PSR--12-blue?style=for-the-badge)](https://www.php-fig.org/psr/psr-12/)](https://www.php-fig.org/psr/psr-12/)
[![Architecture](https://img.shields.io/badge/Architecture-Modular-purple?style=for-the-badge)](https://martinfowler.com/articles/paradigm-shifts.html)]()
]()

> **Core module for the FixCity Platform.**

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
