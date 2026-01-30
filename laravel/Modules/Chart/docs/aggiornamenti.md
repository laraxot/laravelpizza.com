---
title: Aggiornamenti
description: Aggiornamenti
extends: _layouts.documentation
section: content
---

# Aggiornamenti {#aggiornamenti}

Chart consiste in un pacchetto PHP.

Quindi per aggiornare basta dare il comando in console:

composer update laraxot/module_chart

Assicurarsi di cancellare la cache delle viste di Laravel dopo l'aggiornamento:

```console
php artisan view:clear
```

Infine, se si sono pubblicati il file di configurazione o i modelli Blade, assicurarsi che le personalizzazioni siano aggiornate con i valori predefiniti.

### Verifica dei pacchetti installati

È possibile utilizzare il comando Artisan incorporato per visualizzare le versioni installate dei pacchetti:

```console
php artisan module_chart:show-versions
```
```
## Collegamenti tra versioni di aggiornamenti.md
* [aggiornamenti.md](laravel/Modules/Chart/docs/aggiornamenti.md)
* [aggiornamenti.md](laravel/Modules/Cms/docs/aggiornamenti.md)

