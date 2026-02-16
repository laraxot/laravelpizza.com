# Case-Insensitive File Conflicts

Duplicati individuati nel modulo `Notify`:

- `Modules/Notify/_docs`: `Test_SMTP.txt`, `test_smtp.txt`
- `Modules/Notify/app/Filament/Auth`: `FilamentLogin.fila2`, `filamentlogin.fila2`
- `Modules/Notify/app/Http/Livewire/Auth`: `FilamentLogin.fila2`, `filamentlogin.fila2`
- `Modules/Notify/app/Http/Middleware`: `FilamentMiddleware.fila2`, `filamentmiddleware.fila2`
- `Modules/Notify/app/Providers`: `FilamentServiceProvider.fila2`, `filamentserviceprovider.fila2`
- `Modules/Notify/docs`: `Test_SMTP.txt`, `test_smtp.txt`
- `Modules/Notify/docs`: `INDEX.md`, `index.md`
- `Modules/Notify/docs/integrations`: `README.md`, `readme.md`
- `Modules/Notify/docs/notifications`: `README.md`, `readme.md`
- `Modules/Notify/docs/templates`: `README.md`, `readme.md`

Per ogni coppia mantenere un'unica versione coerente (es. PascalCase per classi, maiuscolo per file documentali globali) e rimuovere quella ridondante.
