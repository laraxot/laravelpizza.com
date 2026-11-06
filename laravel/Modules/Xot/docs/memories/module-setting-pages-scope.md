---
title: "Perimetro delle SettingPage dei moduli"
type: memory
status: active
created: 2026-11-04
updated: 2026-11-04
tags: [filament, settings, tenant, env, security]
qmd: "SettingPage BaseSettingPage Notify EnvWidget config tenant env segreti moduli decisione perimetro"
related:
  - ../stories/base-setting-page.story.md
  - ../stories/module-setting-pages.epic.md
  - ../../Notify/docs/bmad/stories/setting-page-base-migration.story.md
---

# Perimetro delle SettingPage dei moduli

`BaseSettingPage` è la base uniforme per le pagine impostazioni standalone. Il
form tenant è alimentato dalla Data `Modules\\{Modulo}\\Datas\\{Modulo}ConfigData`
e salva `config/{tenant}/{modulo}.php`; un `getFormSchema()` vuoto è valido
quando un modulo non ha impostazioni di dominio modificabili per tenant.

La gestione di `.env` resta un confine separato: chiavi infrastrutturali e
segreti non vanno replicate nella config tenant. Notify è il caso concreto:
`SettingPage` estende la base, non aggiunge campi tenant e mantiene `EnvWidget`
con whitelist. Questo evita che la forma della pagina venga confusa con la
proprietà dei dati gestiti.
