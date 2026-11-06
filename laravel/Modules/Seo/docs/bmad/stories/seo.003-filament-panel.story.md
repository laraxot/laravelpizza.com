---
title: "Seo — Filament panel: gestione metatag e sitemap"
id: "seo.003-filament-panel"
module: Seo
type: story
status: todo
priority: medium
created: 2026-11-04
---

# Seo.003 — Filament Panel Seo

## Contesto

Non esiste interfaccia admin Filament per gestire metatag e configurazione SEO.

## Filament Blueprint

```
AdminPanelProvider (app/Providers/Filament/AdminPanelProvider.php)
│
├── Resources
│   └── MetatagResource      → CRUD metatag per route/slug
│
├── Pages
│   ├── SitemapSettingsPage  → configurazione inclusione/esclusione URL
│   └── RobotsSettingsPage   → gestione robots.txt per tenant
│
└── Widgets
    └── SocialShareWidget    → widget social share (già in test)
```

## Acceptance criteria

- [ ] `AdminPanelProvider` creato con `$name = 'Seo'`
- [ ] `MetatagResource` con lista, create, edit, delete
- [ ] `SitemapSettingsPage` con form abilitazione/disabilitazione URL
- [ ] Tutte le classi Filament estendono XotBase*
- [ ] PHPStan zero errori sul pannello
- [ ] Test Pest per almeno 2 pagine Filament

## Note tecniche

- Metatag usa `MetatagData` (spatie/laravel-data) già presente
- SocialShareWidget già testato in `tests/Unit/Filament/Widgets/`
