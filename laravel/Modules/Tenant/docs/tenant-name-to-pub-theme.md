# Dal nome tenant al tema pubblico (pub_theme)

La **risoluzione del tema** dipende dal modulo Tenant: il nome tenant determina la cartella di config da cui si legge `xra.php` e quindi `pub_theme`.

## Catena

1. **`APP_URL`** (`.env`) → es. `http://<nome progetto>.local`
2. **`GetTenantNameAction::execute()`** → ricava l’host da `config('app.url')` (o `$_SERVER['SERVER_NAME']`), inverte le parti (es. `<nome progetto>.local` → `local/<nome progetto>`)
3. **Cartella config** → `config_path($tenantName)` = `laravel/config/local/<nome progetto>/`
4. **`TenantService::getConfig('xra')`** → carica `config/local/<nome progetto>/xra.php`
5. **`pub_theme`** → in `xra.php` la chiave `pub_theme` (es. `'Meetup'`) identifica il tema pubblico
6. **Percorso tema** → `laravel/Themes/{pub_theme}` (es. `laravel/Themes/Meetup`)

## Ruolo del modulo Tenant

- **GetTenantNameAction**: nome tenant a partire da `APP_URL` (e verifica esistenza della cartella config).
- **GetTenantFilePathAction**: path del file di config per un dato tenant (es. `xra.php`).
- **GetTenantConfigArrayAction**: caricamento dell’array di config (usato da `TenantService::getConfig('xra')`).

`XotData::make()` usa `TenantService::getConfig('xra')` e quindi il valore di `pub_theme` proviene dalla config tenant caricata dal modulo Tenant.

## Riferimenti

- [configuration](configuration.md) – risoluzione tenant-aware dei valori di config
- Tema Meetup: `laravel/Themes/Meetup/docs/theme-resolution-and-workflow.md`
- Regola agenti: `.cursor/rules/theme-resolution-critical.md`
