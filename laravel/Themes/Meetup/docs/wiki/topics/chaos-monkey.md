---
title: "Topic chaos-monkey"
type: digest
status: active
qmd: "digest ceiling 100 chaos-monkey"
---

# Topic chaos-monkey

Sintesi automatica di 4 documenti (chiave `chaos-monkey`).

## Chaos monkey checklist (meetup theme)

_Fonte: `chaos-monkey-checklist.md`_

# Chaos monkey checklist (meetup theme)

## Scopo

Checklist operativa lato tema per ripristinare velocemente la UI quando il chaos monkey rompe:

- registrazione/risoluzione `pub_theme::`
- layout (`<x-layouts.*>` + `<x-metatags>`) e asset
- componenti sezione (`<x-section slug="..." />`)
- Volt blocks (detected da `BlockData`)

Questa checklist complementa:

- `Themes/Meetup/docs/chaos-monkey-debug-skills.md`
- `Modules/Cms/docs/chaos-monkey-checklist.md`

## Entry points (theme)

- Folio pages: `Themes/Meetup/resources/views/pages/*`
- Layouts: `Themes/Meetup/resources/views/components/layouts/*`
- Blocks: `Themes/Meetup/resources/views/components/blocks/*`
- Sections: `Themes/Meetup/resources/views/components/sections/*`

## Incident playbook (ordine consigliato)

### 1) View namespace rotto (`pub_theme::...` non risolve)

- **Sintomo**
  - `View [pub_theme::...] not found`

## Chaos Monkey Debugging Skills

_Fonte: `chaos-monkey-debug-skills.md`_

# Chaos Monkey Debugging Skills

## Overview

This document provides debugging skills and patterns for fixing the LaravelPizza project when "chaos monkey" scenarios occur. These skills are essential for reasoning through and resolving issues in the Template, Theme, and CMS systems.

## Core Debugging Philosophy

1. **Understand Before Fixing** - Always understand the architecture before making changes
2. **Follow the Flow** - Trace the complete request lifecycle
3. **Check Configuration First** - Many issues stem from misconfiguration
4. **Validate Assumptions** - Don't assume something works without testing
5. **Use Systematic Approach** - Start with the most likely cause

## Common Chaos Monkey Scenarios

### Scenario 1: Page Returns 404

**Symptoms:**
- Visiting `/it/events` returns 404
- Page exists in JSON but not accessible

**Debugging Steps:**

1. **Check Folio Route Registration:**
   ```bash
   php artisan route:list --path=it/events
   ```

2. **Verify Page Exists:**

## Chaos Monkey Incident Playbook (Meetup Theme)

_Fonte: `chaos-monkey-incident-playbook.md`_

# Chaos Monkey Incident Playbook (Meetup Theme)

## Obiettivo
Ridurre i tempi di diagnosi/ripristino per rotture casuali su rendering tema, blocchi CMS e asset.

## Ambito
- `Themes/Meetup/resources/views/**`
- `Themes/Meetup/lang/**`
- `Themes/Meetup/package.json`, `vite.config.js`
- integrazione `pub_theme::` con CMS/Folio

## Failure Modes
1. View non risolta su namespace `pub_theme::`.
2. Asset non allineati tra source e `public_html`.
3. Traduzioni tema con namespace/key errati.
4. Route frontend non localizzate o URL hardcoded.

## Protocollo Operativo
1. Riprodurre con URL assoluto localizzato (`/it/...`, `/en/...`).
2. Verificare errore blade/view e path reale del componente.
3. Verificare build asset tema e copy in public.
4. Verificare traduzioni tema in `pub_theme::...`.
5. Eseguire smoke test su homepage, events list, events detail.

## Comandi Operativi
```bash
cd laravel/Themes/Meetup
npm run build
# niente copy: public_html/themes/Meetup è un symlink a public/
```

## Chaos Monkey Recovery Playbook (Meetup Theme)

_Fonte: `chaos-monkey-theme-recovery-playbook.md`_

# Chaos Monkey Recovery Playbook (Meetup Theme)

## Objective

Recover UI rendering and navigation behavior in the active frontoffice theme after randomized breakages.

## Theme Critical Surfaces

1. Layout stack: `main` -> `app` -> page content.
2. Section rendering: `<x-section slug=\"header\"/>`, `<x-section slug=\"footer\"/>`.
3. Page blocks loaded through CMS `data.view` paths.
4. Theme translations under `pub_theme::`.
5. Event pages relying on localized `event.url` values.

## First Response Sequence

1. Open layout files and verify syntax and includes.
2. Validate section templates exist (`components/sections/header|footer/v1.blade.php`).
3. Validate JSON section block views point to existing files.
4. Validate event list/detail blocks still resolve their data source.
5. Validate language-prefixed links in UI still include locale.

## Known Sensitive Points

- Header/footer JSON may contain stale or invalid view namespaces.
- Legacy layout files can point to old theme asset build targets.
- Detail page can fail if `slug0` flow breaks in Folio route file.
- Some blocks implement fallback DB queries; this can mask upstream failures and create inconsistent behavior.

## Hard Rules Under Incident
