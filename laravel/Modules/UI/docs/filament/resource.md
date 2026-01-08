---
title: Creazione di una Resource
description: Creazione di una Resource
extends: _layouts.documentation
section: content
---

# Creazione di una Resource {#creazione-resource}


- vedi doc savanna e crea le resource con:

```bash
#Page: Pass the Module name as an argument and the name of page.
php artisan module:make-filament-page {module?} {name?} {--R|resource=} {--T|type=} {--F|force}

#Resources: Pass the Module name as an argument and the name of resources.
php artisan module:make-filament-resource {module?} {name?} {--soft-deletes} {--view} {--G|generate} {--S|simple} {--F|force}

#Widgets: Pass the Module name as an argument and the name of widget.
php artisan module:make-filament-widget {module?} {name?} {--R|resource=} {--C|chart} {--T|table} {--S|stats-overview} {--F|force}

#RelationManagers: Pass the Module name as an argument and the name of RelationManager.
php artisan module:make-filament-relation-manager {module?} {resource?} {relationship?} {recordTitleAttribute?} {--attach} {--associate} {--soft-deletes} {--view} {--F|force}
```

- aggiungi Traits di Savanna alle resource:

namespace YourNamespace\Resources;

use Savannabits\FilamentModules\Concerns\ContextualResource;
use Filament\Resources\Resource;

```bash
class UserResource extends \Modules\Xot\Filament\Resources\XotBaseResource
{
    //
}
```
