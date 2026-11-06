
---
title: "Meetup: ingresso alla documentazione"
type: readme
theme: Meetup
status: active
updated: 2026-10-27
tags: [meetup, theme, docs, readme]
qmd: "meetup theme docs readme ingresso scopo tema satellite eventi guscio senza codice legacy pub_theme sixteen"
related:
  - ./00-INDEX.md
---

# Meetup: documentazione

Meetup e' l'intento di un tema **satellite** (eventi e meetup) di Fixcity: superficie di presentazione alternativa o dimostrativa, senza logica di dominio propria. Oggi e' pero' un **guscio senza codice**, non un tema funzionante (verifica del 2026-10-14, sezione sotto). Le decisioni di supporto e di rilascio sono nel dossier BMAD ([bmad/README.md](bmad/README.md), stato `support-decision-required`).

## Stato verificato (2026-10-14): legacy, non attivo

| Domanda | Risposta | Prova |
|---|---|---|
| Quale tema pubblico usa Fixcity? | `Sixteen` | `'pub_theme' => 'Sixteen'` in tutti e 4 i file `laravel/config/**/xra.php` (local/fixcity, localhost, eu/fixcity, net/futurely); nessun altro valore di `pub_theme` |
| Meetup e' pubblicato? | no | `public_html/themes/` contiene solo il link `Sixteen` |
| Ha codice? | no | nel tema ci sono soltanto `package.json` (nome `laraxot/theme-meetup-fila5`, versione `0.0.0`, privato), `.releaserc.json`, `.gitignore`, `scripts/ci/contributor-lines-report.mjs`, `resources/mail-layouts/test-layout.html` (una riga di HTML di prova) e `docs/`; mancano `composer.json`, `theme.json`, `app/`, `resources/views`, css, js, `lang/`, `tests/`, configurazione Vite |
| E' un repo o un submodule? | no | non compare in `gitmodules.ini` e non ha `.git`: lo traccia la radice (introdotto in `bc58be108`, 2026-06-12) |
| Il suo namespace e' caricato? | no | `RegisterRuntimePsr4NamespacesAction` elenca `TwentyOne`, `Sixteen` e `Two`, non `Meetup` |
| Esiste un modulo `Meetup`? | no | `laravel/Modules/` non ha `Meetup`; `Cms/app/Actions/ResolvePageAction.php` cita `Modules\Meetup\Models\Event` e `Profile` come riferimenti a classi che qui non esistono |

Conseguenza: per il lavoro su Fixcity non serve leggere questa cartella, e nessuna regola di tema vale per Meetup. La decisione archiviare o rilanciare resta aperta (vedi dossier BMAD).

Questo file non e' un indice. **L'indice canonico e' [00-INDEX.md](00-INDEX.md)**, che elenca ogni documento con il suo stato.

Regole che valgono qui: radice del tema con al massimo 5 `.md` e zero `.txt` (`docs/wiki/rules/module-theme-root-md-files-limit.md`), frontmatter YAML su ogni `.md`, niente duplicati con altro case o separatore.

Non creare `docs/archive/`: la cartella e' esclusa dal `.gitignore` del tema e
la regola condivisa e' [no-docs-archive](../../../../bashscripts/ai/wiki/concepts/no-docs-archive-rule.md).
# Theme Documentation

This directory contains the documentation for the Meetup theme.

## Purpose

The purpose of this documentation is to provide comprehensive information about the Meetup's functionality, architecture, and usage. It aims to:
- Explain key features and their implementation details.
- Guide developers on how to use, extend, and maintain the theme.
- Ensure consistency with Laraxot architectural principles and coding standards.

## Structure

- `README.md`: This overview file.
- **Patterns & Architecture**:
    - [`volt-component-pattern.md`](./volt-component-pattern.md) - Pattern Volt Component con `new class extends Component`
    - [`helper-class-pattern.md`](./helper-class-pattern.md) - Pattern Helper Class per componenti Blade
    - [`agnostic-routing.md`](./agnostic-routing.md) - Routing agnostico con Laravel Folio
    - [`translations.md`](./translations.md) - Gestione traduzioni nel tema (namespace `pub_theme::`)
    - [`social-share.md`](./social-share.md) - Componente social share con Tailwind CSS
- **DevOps & Automation**:
    - [`github-bot-integration.md`](../../../.windsurf/rules/github-bot-integration.md) - GitHub Actions bot per commenti automatici
- Other Markdown files will detail specific aspects of the theme, such as:
    - `installation.md`
    - `usage.md`
    - `architecture.md`
    - `troubleshooting.md`

## Contribution

Developers are encouraged to contribute to this documentation to keep it accurate and up-to-date.

### Pages Structure & Data Loading

#### Events Page (`/events`)
- **Route**: Handles `/events` and other CMS pages via `Modules\Cms\Http\Controllers\PageController` (or Folio equivalent).
- **View**: `resources/views/pages/[slug].blade.php` acting as a wrapper.
- **Data Source**: Custom `BlockData` resolution.
    - **Configuration**: `config/local/laravelpizza/database/content/pages/events.json` defines the `query` parameters.
    - **Resolution**: `Modules\Cms\Datas\BlockData` constructor uses `ResolveBlockQueryAction` to fetch dynamic data (e.g., upcoming events) and merges it into the block's data.
    - **Strict Typing Note**: `HasBlocks::getBlocks` returns a standard `array` of `BlockData` objects to preserve this resolved data, bypassing `DataCollection` re-hydration which can cause data loss.
- **Component**: `resources/views/components/blocks/events/list.blade.php`.
    - **Props**: Receives `$eventsData` (array of `BlockData` objects).
    - **Visuals**: Uses Tailwind CSS grid layout.
