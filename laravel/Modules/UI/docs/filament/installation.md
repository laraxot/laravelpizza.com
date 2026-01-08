---
title: Installazione Filament
description: Installazione Filament
extends: _layouts.documentation
section: content
---

# Installazione Filament {#installazione-filament}

- composer require filament/filament

- php artisan vendor:publish --tag=filament-config

- php artisan migrate

- composer require artmin96/filament-jet:*

- php artisan filament-jet:install --teams

- npm run dev

- npm run build

- php artisan migrate

- php artisan vendor:publish --tag="filament-jet-views"

- mettere in composer 

```bash
"repositories": [
    {
        "type": "path",
        "url": "./packages/ArtMin96/FilamentJet"
    }
],
```

- nella cartella /packages/ArtMin96/FilamentJet git submodule add https://github.com/laraxot/filament-jet.git FilamentJet

- nella cartella /laravel/Modules/ git submodule add https://github.com/laraxot/module-user.git User

- disabilitare tutti i moduli (soprattutto Cms)

- su xra disabilitare routes frontend e backend

```bash
'disable_admin_dynamic_route' => true,
'disable_frontend_dynamic_route' => true,
```

- composer require savannabits/filament-modules versione 1.1

- php artisan module:use Modulo
- 
- php artisan module:make-filament-context Filament

- php artisan make:filament-user per creare utente