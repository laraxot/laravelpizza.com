---
qmd: "cases"
issues: []
discussions: []
title: "Case-Insensitive File Conflicts"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
<<<<<<< .merge_file_MWjGuc
updated: 2026-11-23
=======
<<<<<<< HEAD
updated: 2026-08-24
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> .merge_file_Aq4h1P
---

# Case-Insensitive File Conflicts

Duplicati individuati nel modulo `Notify`:

- `Modules/Notify/_docs`: `Test_SMTP.txt`, `test_smtp.txt`
- `Modules/Notify/app/Filament/Auth`: `FilamentLogin.fila2`, `filamentlogin.fila2`
- `Modules/Notify/app/Http/Livewire/Auth`: `FilamentLogin.fila2`, `filamentlogin.fila2`
- `Modules/Notify/app/Http/Middleware`: `FilamentMiddleware.fila2`, `filamentmiddleware.fila2`
- `Modules/Notify/app/Providers`: `FilamentServiceProvider.fila2`, `filamentserviceprovider.fila2`
- `Modules/Notify/docs`: `Test_SMTP.txt`, `test_smtp.txt`
- `Modules/Notify/docs`: `index.md`, `index.md`
- `Modules/Notify/docs/integrations`: `README.md`, `README.md`
- `Modules/Notify/docs/notifications`: `README.md`, `README.md`
- `Modules/Notify/docs/templates`: `README.md`, `README.md`

Per ogni coppia mantenere un'unica versione coerente (es. PascalCase per classi, maiuscolo per file documentali globali) e rimuovere quella ridondante.
