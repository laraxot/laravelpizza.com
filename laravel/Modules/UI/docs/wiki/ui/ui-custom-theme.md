---
qmd: "ui wiki ui ui custom theme md"
title: "UI custom theme"
type: reference
tags: [ui]
created: 2026-08-24
updated: 2026-08-24
---

https://blog.jpat.dev/build-custom-components-inside-a-filament-v3-panel-with-livewire-and-tailwindcss


php artisan make:filament-theme admin

add resources/css/filament/admin/theme.css entry to vite.config.js

in app/Providers/Filament/AdminPanelProvider.php
->viteTheme('resources/css/filament/admin/theme.css')


