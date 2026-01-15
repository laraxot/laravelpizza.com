# Checklist per la Struttura delle Directory nei Moduli Windsurf/Xot

## Panoramica
Questo documento fornisce una checklist per verificare la corretta struttura delle directory nei moduli Windsurf/Xot, con particolare attenzione ai casi d'uso più comuni.

## Regola fondamentale
**Tutto il codice PHP deve essere sotto la directory `app/` del modulo.**

## Checklist per i percorsi (case-sensitive!)

### ✅ Codice PHP (Controllers, Models, Actions, ecc.)

- ✅ `Modules/User/app/Http/Controllers/UserController.php`
- ✅ `Modules/User/app/Models/User.php`
- ✅ `Modules/User/app/Actions/User/DeleteUserAction.php`
- ✅ `Modules/User/app/Filament/Resources/UserResource.php`
- ✅ `Modules/User/app/Filament/Widgets/LoginWidget.php`
- ✅ `Modules/User/app/Providers/UserServiceProvider.php`
- ✅ `Modules/User/app/Datas/UserData.php`

### ✅ Resources (viste, assets, traduzioni)

- ✅ `Modules/User/resources/views/filament/widgets/auth/login.blade.php`
- ✅ `Modules/User/resources/views/livewire/auth/login.blade.php`
- ✅ `Modules/User/resources/js/components/auth-form.js`
- ✅ `Modules/User/resources/css/auth.css`
- ✅ `Modules/User/resources/assets/images/logo.png`

### ✅ Traduzioni (SEMPRE minuscolo!)

- ✅ `Modules/User/lang/it/auth.php`
- ✅ `Modules/User/lang/en/auth.php`

### ✅ Altri file (sempre minuscolo)

- ✅ `Modules/User/config/module.php`
- ✅ `Modules/User/routes/web.php`
- ✅ `Modules/User/database/migrations/create_users_table.php`
- ✅ `Modules/User/docs/USER_GUIDE.md`

### ✅ Migration (tabelle, colonne, relazioni)
- ✅ `Modules/User/database/migrations/2025_05_16_221811_add_owner_id_to_teams_table.php`
- ❌ `laravel/database/migrations/2025_05_16_221811_add_owner_id_to_teams_table.php` (errore grave!)

### ❌ Errori comuni da evitare

- ❌ `Modules/User/Resources/views/auth/login.blade.php` (case errata!)
- ❌ `Modules/User/Actions/DeleteUserAction.php` (manca app/)
- ❌ `Modules/User/Http/Controllers/UserController.php` (manca app/)
- ❌ `Modules/User/App/Http/Controllers/UserController.php` (App maiuscolo errato!)
- ❌ Migration custom fuori dalla cartella del modulo (es: in laravel/database/migrations)

## Mnemonica per ricordare

1. Il codice PHP va in: `/app/**/*.php`
2. Le viste Blade vanno in: `/resources/views/**/*.blade.php`
3. Le traduzioni vanno in: `/lang/{locale}/*.php`
4. **Lowercase sempre** per le directory fisiche: resources, lang, config, routes, docs

## Verifiche automatiche

```bash

# Verifica percorsi PHP errati (fuori da app/)
find Modules/User -type f -name "*.php" -not -path "*/app/*" -not -path "*/routes/*" -not -path "*/config/*" -not -path "*/database/*" -not -path "*/lang/*" -not -path "*/resources/*" -not -path "*/tests/*" -not -path "*/docs/*" | grep -v composer.json

# Verifica case sensitivity
find Modules/User -type d -name "Resources" -o -name "Lang" -o -name "Config" -o -name "Routes"
```

## Per saperne di più
Consultare il documento completo: `/Modules/Xot/docs/DIRECTORY-STRUCTURE-GUIDE.md`
