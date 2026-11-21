---
title: "PHPStan widget property types"
type: concept
tags: [phpstan, widget, property, types]
created: 2026-07-14
updated: 2026-07-14
qmd: "phpstan-widget-property-types phpstan widget property types"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./filament-user-creation-pty-error.md"
  - "./git-merge-conflict-inventory-1.md"
  - "./git-merge-conflict-inventory.md"
  - "./git-push-lfs-missing-objects.md"
  - "./phpstan-module-analysis-memory.md"
  - "./phpstan-widget-property-types-1.md"
  - "./spatie-permission-team-model-not-configured.md"
---

# PHPStan widget property types

## Contesto

Durante la scansione `./vendor/bin/phpstan analyse Modules`, diversi widget del modulo User fallivano per proprieta' Livewire non tipizzate e per valori dinamici restituiti da resource/action.

File coinvolti nel batch:

- `app/Filament/Clusters/Passport/Pages/PassportDashboard.php`
- `app/Filament/Widgets/EditUserWidget.php`
- `app/Filament/Widgets/RegistrationWidget.php`

## Regola operativa

- Le proprieta' pubbliche Livewire devono avere tipo nativo quando il valore e' stabile: `bool`, `string`, `array`, `Model`.
- Le proprieta' che contengono classi dinamiche devono usare `class-string` validato prima dell'assegnazione.
- Non inizializzare una proprieta' `class-string` con stringa vuota: lasciare la proprieta' non inizializzata e valorizzarla in `mount()` dopo `class_exists()`.
- Nei widget Xot evitare override locali di `$view` quando la vista puo' essere risolta da `XotBaseWidget::resolveView()`.
- Gli array restituiti dinamicamente da `getFormSchemaWidget()` devono passare da un helper di normalizzazione che verifica chiavi `int|string` e istanze `Filament\Schemas\Components\Component`.

## Anti-pattern

```php
/** @var class-string */
public string $resource = '';

/** @var view-string */
protected string $view = 'pub_theme::filament.widgets.registration';
```

Il primo caso viola `property.defaultValue`, il secondo puo' violare `view-string` quando PHPStan non puo' provare che la stringa sia una vista registrata.

## Verifiche

- `php -l` sui tre file modificati.
- `./vendor/bin/phpstan analyse` sui tre file modificati: nessun errore.
- `php tools/phpmd.phar ...`: eseguito; restano violazioni storiche/stilistiche non PHPStan.
- `./vendor/bin/phpinsights analyse ...`: exit code 0.

## Collegamenti

- `Modules/Xot/app/Filament/Widgets/XotBaseWidget.php`
- `Modules/User/docs/wiki/concepts/xotbasepage-inheritance-rules.md`
