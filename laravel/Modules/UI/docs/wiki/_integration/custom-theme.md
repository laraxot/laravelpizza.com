---
title: "custom_theme"
type: concept
tags: [custom, theme]
created: 2026-07-14
updated: 2026-07-14
qmd: "custom-theme custom_theme"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./api.md"
  - "./blocks.md"
  - "./carousel-slider-1.md"
  - "./carousel-slider.md"
  - "./chunk.md"
  - "./ci.md"
  - "./custom-firm-fields-1.md"
  - "./custom-firm-fields.md"
---

# custom_theme

<!-- Contenuto migrato da _docs/custom_theme.txt -->

https://blog.jpat.dev/build-custom-components-inside-a-filament-v3-panel-with-livewire-and-tailwindcss

php artisan make:filament-theme admin

add resources/css/filament/admin/theme.css entry to vite.config.js

in app/Providers/Filament/AdminPanelProvider.php
->viteTheme('resources/css/filament/admin/theme.css')
# custom_theme

<!-- Contenuto migrato da _docs/custom_theme.txt -->

https://blog.jpat.dev/build-custom-components-inside-a-filament-v3-panel-with-livewire-and-tailwindcss

php artisan make:filament-theme admin

add resources/css/filament/admin/theme.css entry to vite.config.js

in app/Providers/Filament/AdminPanelProvider.php
->viteTheme('resources/css/filament/admin/theme.css')
