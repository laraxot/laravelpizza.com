# Knowledge Base Index

> Status: bootstrap
> Updated: 2026-04-15

This file indexes the compiled wiki in `docs/wiki/`. It is not a mirror of the whole `docs/` tree.

## Governance

- [README.md](./README.md): workflow and directory rules
- [log.md](./log.md): chronological operations log
- [Karpathy adoption — root](../project/karpathy-llm-wiki-adoption.md): pattern originale, mapping globale
- [Karpathy adoption — moduli/temi](../project/llm-wiki-module-adoption.md): mapping docs/=raw, docs/wiki/=wiki per ogni modulo/tema
- [QMD local docs search](../project/qmd-local-docs-search.md): ricerca locale BM25 + vector

## Tools

### QMD Search
QMD è configurato per ricerca locale su tutto il corpus markdown (14.177+ file indicizzati):

| Collezione | Path | Files | Descrizione |
|------------|------|-------|-------------|
| `root-docs` | `docs/` | 710 | Documentazione root progetto |
| `mod-fixcity` | `Modules/Fixcity/docs/` | 69 | Ticket, wizard, segnalazioni |
| `mod-xot` | `Modules/Xot/docs/` | 4409 | Core framework, modelli base |
| `mod-cms` | `Modules/Cms/docs/` | 711 | Gestione contenuti, pagine |
| `mod-user` | `Modules/User/docs/` | 1952 | Auth, profili, ruoli |
| `mod-geo` | `Modules/Geo/docs/` | 562 | Mappe, indirizzi |
| `mod-ui` | `Modules/UI/docs/` | 472 | Componenti interfaccia |
| `mod-ai` | `Modules/AI/docs/` | 84 | LLM, AI integration |
| `mod-lang` | `Modules/Lang/docs/` | 761 | Traduzioni |
| `mod-notify` | `Modules/Notify/docs/` | 827 | Notifiche |
| `mod-activity` | `Modules/Activity/docs/` | 430 | Log attività |
| `mod-tenant` | `Modules/Tenant/docs/` | 231 | Multi-tenancy |
| `mod-media` | `Modules/Media/docs/` | 252 | Gestione file |
| `mod-blog` | `Modules/Blog/docs/` | 63 | Articoli, post |
| `mod-gdpr` | `Modules/Gdpr/docs/` | 170 | Privacy, GDPR |
| `mod-job` | `Modules/Job/docs/` | 176 | Code lavoro |
| `mod-comment` | `Modules/Comment/docs/` | 35 | Commenti |
| `mod-seo` | `Modules/Seo/docs/` | 91 | SEO |
| `mod-rating` | `Modules/Rating/docs/` | 49 | Valutazioni |
| `theme-sixteen` | `Themes/Sixteen/docs/` | 964 | Design Comuni Italia |
| `theme-twentyone` | `Themes/TwentyOne/docs/` | 185 | Tema alternativo |
| `bashscripts` | `bashscripts/docs/` | 642 | Script, automazione |
| `agents-docs` | `.agents/docs/` | 332 | Istruzioni AI agents |

**MCP Plugin**: `qmd@qmd` (installato in Claude Code via plugin)

```bash
# Ricerca keyword (BM25, veloce ~30ms)
qmd search "wizard ticket" -c mod-fixcity -n 5

# Ricerca semantica (vector, ~2s)
qmd vsearch "come creare una segnalazione" -c mod-fixcity

# Ricerca ibrida + reranking (migliore qualità, ~10s)
qmd query "architettura moduli Laravel" -n 10

# Ricerca in una specifica collezione
qmd search "Bootstrap Italia header" -c theme-sixteen

# Re-indicizza dopo modifiche
qmd update
```

## Concepts

- [llm-wiki-governance](./concepts/llm-wiki-governance.md): repository mapping, ingest/query/lint, and source-of-truth rules
- [phpstan-central-config-rule](./concepts/phpstan-central-config-rule.md): always run module PHPStan via `laravel/phpstan.neon`, never via module-local config

## Modules

Ogni modulo ha il suo wiki locale in `laravel/Modules/<Name>/docs/wiki/`:

- [ai-module](./modules/ai-module.md): project-level routing page for the AI module and its local wiki

| Modulo | Wiki index | Wiki log |
|--------|-----------|---------|
| Modulo | Wiki index | Compiled pages |
|--------|-----------|----------------|
| Xot | [wiki/index.md](../../laravel/Modules/Xot/docs/wiki/index.md) | [xot-module](../../laravel/Modules/Xot/docs/wiki/overviews/xot-module.md) |
| Cms | [wiki/index.md](../../laravel/Modules/Cms/docs/wiki/index.md) | [cms-module](../../laravel/Modules/Cms/docs/wiki/overviews/cms-module.md) |
| UI | [wiki/index.md](../../laravel/Modules/UI/docs/wiki/index.md) | [ui-module](../../laravel/Modules/UI/docs/wiki/overviews/ui-module.md) |
| Lang | [wiki/index.md](../../laravel/Modules/Lang/docs/wiki/index.md) | [lang-module](../../laravel/Modules/Lang/docs/wiki/overviews/lang-module.md) |
| AI | [wiki/index.md](../../laravel/Modules/AI/docs/wiki/index.md) | [ai-module (root)](./modules/ai-module.md) |
| Fixcity, Geo, User, Media, Seo, Tenant, Blog, Activity, Comment, Rating, Notify, Job, Gdpr | wiki/ presenti | pending |

## Themes

Ogni tema ha il suo wiki locale in `laravel/Themes/<Name>/docs/wiki/`:

| Tema | Wiki index | Compiled pages |
|------|-----------|----------------|
| Sixteen | [wiki/index.md](../../laravel/Themes/Sixteen/docs/wiki/index.md) | [sixteen-theme](../../laravel/Themes/Sixteen/docs/wiki/overviews/sixteen-theme.md) |
| TwentyOne | [wiki/index.md](../../laravel/Themes/TwentyOne/docs/wiki/index.md) | [twentyone-theme](../../laravel/Themes/TwentyOne/docs/wiki/overviews/twentyone-theme.md) |

## Bashscripts

Separate git repository with shell scripts and utilities:

| Repo | Wiki index | Status |
|------|-----------|--------|
| bashscripts | [wiki/index.md](bashscripts/wiki/index.md) | bootstrap |

## Archived Queries

- Pending first archived answers
# Wiki Locale Index

## Karpathy LLM Wiki Standard

- [forbidden-folders-rule](../../../../docs/wiki/concepts/forbidden-folders.md): Strict structural constraints.
- [llm-wiki-standard](../../../../docs/wiki/concepts/karpathy-wiki.md): Repository mapping and knowledge lifecycle.

## Sacred Hierarchy

- [concepts/](./concepts/): Architectural patterns and methodologies.
- [entities/](./entities/): Key models and components.
- [sources/](./sources/): Research data and external links.
- [comparisons/](./comparisons/): Alternative implementations.
- [decisions/](./decisions/): ADL (Architectural Decision Log).
- [troubleshooting/](./troubleshooting/): Known issues and solutions.
- [_archive/](./_archive/): Legacy documentation.
- [_templates/](./_templates/): Standard templates.

## Compiled Pages

| Page | Type | Source | Updated |
|------|------|--------|---------|
| [.gitkeep](./concepts/.gitkeep) | Concept | - | 2026-04-21 |
| [llm-wiki-governance](./concepts/llm-wiki-governance.md) | Concept | - | 2026-04-21 |
| [module-test-location-rule](./concepts/module-test-location-rule.md) | Concept | - | 2026-04-21 |
| [phpstan-central-config-rule](./concepts/phpstan-central-config-rule.md) | Concept | - | 2026-04-21 |
| [xotbase-table-columns-enforcement](./concepts/xotbase-table-columns-enforcement.md) | Concept | 5 Table files populated — XotBaseResourceTable enforcement | 2026-05-07 |
