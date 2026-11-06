---
title: "Custom theme"
type: reference
status: active
created: 2026-08-27
updated: 2026-08-27
note: "Convertito da custom_theme.txt (documento) da convert-docs-txt-to-md.py."
---

# Custom theme

https://blog.jpat.dev/build-custom-components-inside-a-filament-v3-panel-with-livewire-and-tailwindcss


php artisan make:filament-theme admin

add resources/css/filament/admin/theme.css entry to vite.config.js

in app/Providers/Filament/AdminPanelProvider.php
->viteTheme('resources/css/filament/admin/theme.css')
