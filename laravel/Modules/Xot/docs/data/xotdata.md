---
title: XotData
description: XotData
extends: _layouts.documentation
section: content
---

# XotData

Sono le variabili di xra.php (caricato dalla config tenant: `TenantService::getConfig('xra')`).

**pub_theme**: tema pubblico attivo (es. `Meetup`). Determina il percorso `Themes/{pub_theme}` e il namespace view `pub_theme::`. La risoluzione è: APP_URL → nome tenant → cartella config (es. `config/local/laravelpizza`) → `xra.php` → `pub_theme`. Vedi modulo Tenant (risoluzione tenant) e `laravel/Themes/Meetup/docs/theme-resolution-and-workflow.md`.
