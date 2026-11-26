---
qmd: "activity wiki readme md"
title: Readme
module: Activity
---

# Wiki del modulo Activity

[![Module](https://img.shields.io/badge/Module-LLM Wiki (module)-8B0000.svg)]()
[![Laravel](https://img.shields.io/badge/Laravel-13-red?style=for-the-badge)](https://laravel.com/)
[![Filament](https://img.shields.io/badge/Filament-5-ffab00?style=for-the-badge)](https://filamentphp.com/)
[![PHP](https://img.shields.io/badge/PHP-8.4+-777BB4?style=for-the-badge)](https://php.net/)
[![PHP](https://img.shields.io/badge/PHP-8.4+-777BB4?style=for-the-badge)](https://phpstan.org/)
[![PSR-12](https://img.shields.io/badge/Code-PSR--12-blue?style=for-the-badge)](https://www.php-fig.org/psr/psr-12/)
[![Architecture](https://img.shields.io/badge/Architecture-Modular-purple?style=for-the-badge)](https://martinfowler.com/articles/paradigm-shifts.html)

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
| 🇮🇹 Presentazione | [../README.md](../README.md) |
| 📚 Wiki tecnica | [index.md](./index.md) |

---

Pagine brevi e riusabili (concetti, regole, memorie) che completano le story. Misurato il 2026-11-25: 48 file `.md`, di cui 6 nella radice di `wiki/`.

## Da dove partire

- [index.md](./index.md): indice della wiki (catalogo fermo al 2026-06-10, vedi il suo piede di pagina).
- [log.md](./log.md): registro datato di cio' che e' cambiato nel modulo e nei suoi docs.
- Identita' e contenuto reale del modulo: [../README.md](../README.md). Indice operativo di tutta la cartella docs: [../index.md](../index.md).

## Sottocartelle con pagine

| Cartella | File | Indice |
|---|---|---|
| `topics/` | 29 | [topics/00-index.md](./topics/00-index.md) |
| `concepts/` | 2 | [concepts/index.md](./concepts/index.md) |
| `rules/` | 1 | [rules/index.md](./rules/index.md) |
| `memories/` | 3 | [memories/index.md](./memories/index.md) |
| `skills/` | 1 | [skills/index.md](./skills/index.md) |
| `commands/` | 1 | [commands/index.md](./commands/index.md) |
| `_templates/` | 3 | nessuno |
| `troubleshooting/` | 2 | nessuno |

Cartelle previste dal modello ma senza alcun `.md`: `decisions/`, `entities/`, `glossary/`, `comparisons/`, `queries/`, `reference/`, `summaries/`, `lint/`, `index/`. Le decisioni del modulo stanno in [../adr/README.md](../adr/README.md).

## Come cercare

```bash
qmd search "Activity <argomento>" --limit 5
```

Prima di creare una pagina nuova controllare [index.md](./index.md) e le pagine di `concepts/` e `topics/` per non duplicarla.

---

**Modulo** `Activity` · **Laraxot** · **FixCity Platform** · PHPStan 10 · Filament 5
