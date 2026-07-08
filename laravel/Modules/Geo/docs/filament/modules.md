---
title: Moduli Filament
description: Moduli Filament
extends: _layouts.documentation
section: content
---

# Moduli Filament {#moduli-filament}

Url di riferimento https://github.com/savannabits/filament-modules  
Installare il pacchetto di savannabits
```php
composer require coolsam/modules
```
Al suo interno si avrà già inglobato nwidart/laravel-modules.  

Per creare un modulo eseguire i comandi artisan di nwidart  
url di riferimento https://nwidart.com/laravel-modules/v6/advanced-tools/artisan-commands
```php
php artisan module:make NomeModulo
```
Per creare l'AdminPanelProvider di filament nel modulo eseguire  
```php
php artisan module:make-filament-panel admin NomeModulo # php artisan module:make-filament-panel [id] [module]
```
Sostituire il codice generato con 
```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Providers\Filament;

use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'NomeModulo';
}

```

