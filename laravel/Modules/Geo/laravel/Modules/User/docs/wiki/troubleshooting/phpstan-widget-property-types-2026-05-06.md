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
